@extends('vendors.vendor-masters')

@section('vendor')
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/changePassword.css') }}" />

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow border-0 p-4 custom-card">
            <!-- Back -->
            <a href="{{ route('user.dashboard') }}" id="backBtn" class="mb-3 text-decoration-none back-link">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            <!-- Title -->
            <h3 class="text-center fw-bold mb-4 title-text">
                Change Password
            </h3>

            <!-- Alert -->
            <div id="alertBox" class="alert d-none"></div>

            <!-- Form -->
            <form id="passwordForm">
                <div class="mb-3">
                    <label class="form-label">Old Password</label>
                    <input type="password" id="oldPass" class="form-control" required placeholder="Enter old password" />
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" id="newPass" class="form-control" required placeholder="Enter new password" />
                </div>
                <div class="mb-4">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" id="confirmPass" class="form-control" required
                        placeholder="Confirm new password" />
                </div>
                <button type="submit" class="btn w-100 text-white fw-bold py-2 save-btn">
                    <i class="fas fa-save me-2"></i> Save Changes
                </button>
            </form>
        </div>
    </div>

    <script>
        const form = document.getElementById("passwordForm"),
            oldPass = document.getElementById("oldPass"),
            newPass = document.getElementById("newPass"),
            confirmPass = document.getElementById("confirmPass"),
            alertBox = document.getElementById("alertBox");

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            if (!oldPass.value) return showAlert("Old password required", "danger");
            if (newPass.value.length < 8)
                return showAlert("Password must be at least 8 characters", "danger");
            if (newPass.value !== confirmPass.value)
                return showAlert("Passwords do not match", "danger");

            try {
                const res = await fetch(`{{ route('user.update.password') }}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({
                        old_password: oldPass.value,
                        new_password: newPass.value,
                        new_password_confirmation: confirmPass.value,
                    }),
                });

                const data = await res.json();

                if (data.status) {
                    // showAlert(data.message, "success");
                    toastr.success(data.message);
                    form.reset();
                } else {
                    // showAlert(data.message, "danger");
                    toastr.error(data.message);
                }
            } catch (err) {
                console.error(err);
                showAlert("An error occurred while changing password.", "danger");
                toastr.error("An error occurred while changing password.");
            }
        });

        function showAlert(msg, type) {
            alertBox.className = "alert alert-" + type;
            alertBox.textContent = msg;
            alertBox.classList.remove("d-none");
            setTimeout(() => alertBox.classList.add("d-none"), 3000);
        }
    </script>
@endsection
