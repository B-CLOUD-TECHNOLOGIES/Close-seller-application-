@extends('vendors.vendor-masters')

@section('vendor')
<link rel="stylesheet" href="{{ asset('vendors/assets/css/accountInfo.css') }}" />
<style>
.spinner {
  width: 16px;
  height: 16px;
  border: 2px solid rgba(112, 29, 157, 0.3);
  border-top-color: #701d9d;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
  display: inline-block;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
.custom-toast {
  position: fixed;
  top: 1.5rem;
  right: 1.5rem;
  padding: 1rem 1.5rem;
  background: #333;
  color: #fff;
  border-radius: 6px;
  font-size: 14px;
  opacity: 0;
  transform: translateY(-20px);
  transition: all 0.4s ease;
  z-index: 9999;
}
.custom-toast.show {
  opacity: 1;
  transform: translateY(0);
}
.custom-toast.success {
  background: #28a745;
}
.custom-toast.error {
  background: #dc3545;
}
.custom-toast.info {
  background: #17a2b8;
}
</style>
<div class="header">
    <a href="{{ route('vendor.settings') }}" class="back-button">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M15.7069 7.41L14.2969 6L8.29688 12L14.2969 18L15.7069 16.59L11.1269 12L15.7069 7.41Z" fill="#1C1C1C" />
      </svg>
    </a>
    <h1>Account Details</h1>
    <div class="header-spacer"></div>
  </div>

  <div class="info-banner">
    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
    </svg>
    <p class="info-text">Your banking information is encrypted and secure. We use this information to process your earnings and transfers.</p>
  </div>

    <form id="accountForm">
        @csrf
        <div class="form-container">

            <div class="form-group">
                <label for="acctNo">Account Number *</label>
                <span class="helper-text">Enter your 10-digit account number</span>
                <input type="text" 
                    id="acctNo" 
                    name="acctNo" 
                    class="form-input" 
                    placeholder="0123456789" 
                    maxlength="10"
                    value="{{ $bankDetails->acctNo ?? '' }}"
                    required />
                <span class="error-message" id="accountNumberError">Please enter a valid 10-digit account number</span>
            </div>

            <div class="form-group">
                <label for="bankName">Bank Name *</label>
                <span class="helper-text">Select your bank from the list</span>

                <div class="searchable-dropdown">
                    <div class="dropdown-trigger" id="bankDropdown">
                        <span id="selectedBank">{{ $bankDetails->bankName ?? 'Select Bank' }}</span>
                        <svg class="dropdown-arrow" width="12" height="8" viewBox="0 0 12 8" fill="none">
                            <path d="M1 1L6 6L11 1" stroke="#701d9d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div class="dropdown-menu" id="bankMenu">
                        <input type="text" class="dropdown-search" id="bankSearch" placeholder="Search banks..." onclick="event.stopPropagation()" />
                        <div class="dropdown-options" id="bankOptions">
                            <!-- Banks will be loaded here -->
                        </div>
                    </div>
                </div>

                <input type="hidden" id="bankCode" name="bankCode" value="{{ $bankDetails->bankCode ?? '' }}" />
                <input type="hidden" id="bankNameHidden" name="bankName" value="{{ $bankDetails->bankName ?? '' }}" />
                <span class="error-message" id="bankError">Please select a bank</span>
            </div>

            <div class="form-group">
                <label for="acctName">Account Name</label>
                <span class="helper-text">This will be auto-filled after verification</span>
                <input type="text" 
                    id="acctName" 
                    name="acctName" 
                    class="form-input" 
                    placeholder="Account name will appear here" 
                    value="{{ $bankDetails->acctName ?? '' }}"
                    readonly />
            </div>
            <div id="verificationStatus" class="verification-status" style="display:none;">
                <span>Verifying account...</span>
            </div>

        </div>

        <div class="save-button-container">
            <button type="submit" class="save-btn">
                <span class="spinner"></span>
                Save Bank Details
            </button>
        </div>
    </form>

  <div class="toaster_alert" id="toaster">
    <div class="toaster_content">
      <p class="toaster_message" id="toasterMessage"></p>
    </div>
    <button class="toaster_close" onclick="closeToast()">&times;</button>
  </div>

 
  <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('accountForm');
            const bankDropdown = document.getElementById('bankDropdown');
            const bankMenu = document.getElementById('bankMenu');
            const bankOptions = document.getElementById('bankOptions');
            const bankSearch = document.getElementById('bankSearch');
            const selectedBank = document.getElementById('selectedBank');
            const bankCodeInput = document.getElementById('bankCode');
            const accountNumberInput = document.getElementById('acctNo');
            const accountNameInput = document.getElementById('acctName');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const verificationStatus = document.getElementById('verificationStatus');

            let banks = [];
            let selectedBankCode = '';

            // === Fetch banks ===
            async function fetchBanks() {
                try {
                    const response = await fetch(`{{ route('vendor.get.banks') }}`);
                    const data = await response.json();

                    if (data.status && data.data) {
                        banks = data.data.map(b => ({ name: b.name, code: b.code }));
                        populateBankOptions(banks);
                    } else {
                        showToast('error', 'Failed to load banks.');
                    }
                } catch (error) {
                    console.error('Error fetching banks:', error);
                    showToast('error', 'Could not load banks from server.');
                }
            }

            // === Populate banks ===
            function populateBankOptions(banks) {
                bankOptions.innerHTML = '';
                banks.forEach(bank => {
                    const div = document.createElement('div');
                    div.classList.add('dropdown-option');
                    div.textContent = bank.name;
                    div.addEventListener('click', () => selectBank(bank));
                    bankOptions.appendChild(div);
                });
            }

            // === Select bank ===
            function selectBank(bank) {
                selectedBank.textContent = bank.name;
                selectedBankCode = bank.code;
                bankCodeInput.value = bank.code;
                document.getElementById('bankNameHidden').value = bank.name;
                bankMenu.classList.remove('active');
                bankDropdown.classList.remove('active');

                // 🔁 Re-trigger verification if account number already filled
                const accountNumber = accountNumberInput.value.trim();
                if (accountNumber.length === 10 && selectedBankCode) {
                    console.log("Re-triggering verification after bank selection...");
                    accountNumberInput.dispatchEvent(new Event('input')); // simulate recheck
                }
            }

            // === Toggle dropdown ===
            bankDropdown.addEventListener('click', function () {
                bankMenu.classList.toggle('active');
                bankDropdown.classList.toggle('active');
                bankSearch.focus();
            });

            // === Search banks ===
            bankSearch.addEventListener('input', function () {
                const query = this.value.toLowerCase();
                const filtered = banks.filter(bank => bank.name.toLowerCase().includes(query));
                populateBankOptions(filtered);
            });

            // === Close dropdown when clicking outside ===
            document.addEventListener('click', function (e) {
                if (!bankDropdown.contains(e.target) && !bankMenu.contains(e.target)) {
                    bankMenu.classList.remove('active');
                    bankDropdown.classList.remove('active');
                }
            });

            // === Verify account ===
            accountNumberInput.addEventListener('input', async function () {
                console.log("number input changed")
                const accountNumber = this.value.trim();
                console.log("Account Number:", accountNumber);
                console.log("Selected Bank Code:", selectedBankCode);

                if (accountNumber.length === 10 && selectedBankCode) {
                    console.log("Starting verification for account number:", accountNumber, "and bank code:", selectedBankCode);
                    verificationStatus.style.display = 'inline-flex';
                    verificationStatus.classList.remove('verified');
                    verificationStatus.innerHTML = `
                        <div class="spinner"></div>
                        <span>Verifying account...</span>
                    `;
                    showToast('info', 'Verifying account...');

                    try {
                        const res = await fetch(`{{ route('vendor.verify.account') }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                account_number: accountNumber,
                                bank_code: selectedBankCode
                            })
                        });

                        const data = await res.json();

                        if (data.status && data.data) {
                            accountNameInput.value = data.data.account_name;
                            verificationStatus.classList.add('verified');
                            verificationStatus.innerHTML = `<span>✅ Verified: ${data.data.account_name}</span>`;
                            showToast('success', 'Account verified successfully!');
                        } else {
                            verificationStatus.style.display = 'none';
                            showToast('error', data.message || 'Verification failed.');
                        }
                    } catch (err) {
                        console.error(err);
                        verificationStatus.style.display = 'none';
                        showToast('error', 'Error verifying account.');
                    }
                }
            });

            // === Submit form ===
            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                const formData = new FormData(form);

                try {
                    const res = await fetch(`{{ route('vendor.save.bank.details') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    });

                    const data = await res.json();

                    if (data.status) {
                        showToast('success', 'Bank details saved!');
                    } else {
                        showToast('error', data.message || 'Save failed.');
                    }
                } catch (err) {
                    console.error(err);
                    showToast('error', 'Error saving bank details.');
                }
            });

            // === Toast Function ===
            function showToast(type, message) {
                const alert = document.createElement('div');
                alert.className = `custom-toast ${type}`;
                alert.textContent = message;
                document.body.appendChild(alert);

                setTimeout(() => alert.classList.add('show'), 100);
                setTimeout(() => {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 500);
                }, 4000);
            }

            fetchBanks();
        });
    </script>


@endsection
