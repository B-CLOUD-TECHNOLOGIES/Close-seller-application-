@extends('vendors.vendor-masters')

@section('vendor')
<link rel="stylesheet" href="{{ asset('vendors/assets/css/business-information.css') }}" />

 <!-- Header -->
  <div class="header">
    <a href="{{ route('vendor.settings') }}" class="back-button">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M15.7069 7.41L14.2969 6L8.29688 12L14.2969 18L15.7069 16.59L11.1269 12L15.7069 7.41Z" fill="#1C1C1C" />
      </svg>
    </a>
    <h1>Business Information</h1>
    <div class="header-spacer"></div>
  </div>

  <!-- Info Banner -->
  <div class="info-banner">
    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <p class="info-text">Complete your business profile to help customers learn more about your store and build trust with potential buyers.</p>
  </div>

  <!-- Form -->
  <form id="businessForm" enctype="multipart/form-data" method="POST" action="{{ route('vendor.update.business.information') }}">
    @csrf
    <!-- Company Details Section -->
    <div class="form-container">
      <div class="section-title">
        <div class="section-icon">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" fill="currentColor"/>
          </svg>
        </div>
        Company Details
      </div>

      <div class="form-group">
        <label for="businessName">Business Name *</label>
        <span class="helper-text">This is how your store will appear to customers</span>
        <input type="text" 
               id="businessName" 
               name="businessName" 
               class="form-input" 
               placeholder="e.g., TechGadgets Store" 
               value="{{ old('businessName', $businessInfo->name) }}"
               required />
        <span class="error-message" id="businessNameError">Business name is required</span>
      </div>

      <div class="form-group">
        <label for="description">About Your Business *</label>
        <span class="helper-text">Tell customers what makes your store unique</span>
        <textarea id="description" 
                  name="description" 
                  class="form-textarea" 
                  placeholder="Describe your business, products, and what sets you apart..."
                  required>{{ old('description', $businessInfo->description) }}</textarea>
        <div class="char-counter">
          <span id="charCount">237</span> / 500 characters
        </div>
      </div>

      <div class="form-group">
        <label for="website">Website or Social Media Link</label>
        <span class="helper-text">Share your website or social media presence (optional)</span>
        <input type="url" 
               id="website" 
               name="website" 
               class="form-input" 
               placeholder="https://www.yourwebsite.com" 
               value="{{ old('website', $businessInfo->web_url) }}" />
      </div>

      <div class="section-divider"></div>

      <!-- Store Location Section -->
      <div class="section-title">
        <div class="section-icon">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="currentColor"/>
          </svg>
        </div>
        Store Location
      </div>

      <div class="form-group">
        <label for="address">Store Address *</label>
        <span class="helper-text">Provide your physical store or business address</span>
        <textarea id="address" 
                  name="address" 
                  class="form-textarea" 
                  placeholder="Enter your complete business address including street, city, and state..."
                  required>{{ old('address', $businessInfo->address) }}</textarea>
        <span class="error-message" id="addressError">Store address is required</span>
      </div>
    </div>

    <!-- Save Button -->
    <div class="save-button-container">
      <button type="submit" class="save-btn">
        <span class="spinner"></span>
        Save Business Information
      </button>
    </div>
  </form>

  <!-- Toast Notification -->
  <div class="toaster_alert" id="toaster">
    <div class="toaster_content">
      <p class="toaster_message" id="toasterMessage"></p>
    </div>
    <button class="toaster_close" onclick="closeToast()">&times;</button>
  </div>

  <script>
    // Character counter for description
    const descriptionField = document.getElementById('description');
    const charCount = document.getElementById('charCount');

    descriptionField.addEventListener('input', function() {
      const length = this.value.length;
      charCount.textContent = length;
      
      if (length > 500) {
        this.value = this.value.substring(0, 500);
        charCount.textContent = 500;
      }
    });

    // Toast notification functions
    function showToast(type, message) {
      const toaster = document.getElementById('toaster');
      const toasterMessage = document.getElementById('toasterMessage');
      
      toaster.className = `toaster_alert ${type}`;
      toasterMessage.textContent = message;
      toaster.style.display = 'flex';

      setTimeout(() => {
        closeToast();
      }, 5000);
    }

    function closeToast() {
      const toaster = document.getElementById('toaster');
      toaster.style.display = 'none';
    }

    // Form validation
    function validateForm() {
      let isValid = true;
      const businessName = document.getElementById('businessName');
      const description = document.getElementById('description');
      const address = document.getElementById('address');

      // Reset error states
      document.querySelectorAll('.error-message').forEach(msg => msg.classList.remove('show'));
      document.querySelectorAll('.form-input, .form-textarea').forEach(input => {
        input.classList.remove('error', 'success');
      });

      // Validate business name
      if (businessName.value.trim() === '') {
        businessName.classList.add('error');
        document.getElementById('businessNameError').classList.add('show');
        isValid = false;
      } else {
        businessName.classList.add('success');
      }

      // Validate description
      if (description.value.trim() === '') {
        description.classList.add('error');
        isValid = false;
      } else {
        description.classList.add('success');
      }

      // Validate address
      if (address.value.trim() === '') {
        address.classList.add('error');
        document.getElementById('addressError').classList.add('show');
        isValid = false;
      } else {
        address.classList.add('success');
      }

      return isValid;
    }

    // Form submission
    document.getElementById('businessForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      if (!validateForm()) {
        showToast('error', 'Please fill in all required fields');
        return;
      }
    
        const form = this;
        const formData = new FormData(form);
        const submitBtn = this.querySelector('.save-btn');
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;

        fetch(form.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              showToast('success', data.message);
            } else {
              showToast('error', data.message || 'Something went wrong.');
            }
          })
          .catch(() => {
            showToast('error', 'An error occurred while updating your business information.');
          })
          .finally(() => {
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;
          });
    
    });

    // Entrance animations
    document.addEventListener('DOMContentLoaded', function() {
      const elements = ['.info-banner', '.form-container', '.save-button-container'];
      
      elements.forEach((selector, index) => {
        const element = document.querySelector(selector);
        if (element) {
          element.style.opacity = '0';
          element.style.transform = 'translateY(20px)';
          
          setTimeout(() => {
            element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
          }, index * 150);
        }
      });

      // Input focus animations
      const inputs = document.querySelectorAll('.form-input, .form-textarea');
      inputs.forEach(input => {
        input.addEventListener('focus', function() {
          this.style.transform = 'scale(1.01)';
        });
        
        input.addEventListener('blur', function() {
          this.style.transform = 'scale(1)';
        });
      });
    });

    // Real-time validation
    document.querySelectorAll('.form-input, .form-textarea').forEach(input => {
      input.addEventListener('blur', function() {
        if (this.hasAttribute('required') && this.value.trim() === '') {
          this.classList.add('error');
          this.classList.remove('success');
        } else if (this.value.trim() !== '') {
          this.classList.add('success');
          this.classList.remove('error');
        }
      });

      input.addEventListener('input', function() {
        if (this.classList.contains('error')) {
          this.classList.remove('error');
          const errorMsg = this.parentElement.querySelector('.error-message');
          if (errorMsg) errorMsg.classList.remove('show');
        }
      });
    });

    // Smooth scroll on header
    window.addEventListener('scroll', function() {
      const header = document.querySelector('.header');
      if (window.scrollY > 50) {
        header.style.boxShadow = '0 4px 30px rgba(112, 29, 157, 0.15)';
      } else {
        header.style.boxShadow = '0 2px 20px rgba(112, 29, 157, 0.08)';
      }
    });
  </script>
@endsection