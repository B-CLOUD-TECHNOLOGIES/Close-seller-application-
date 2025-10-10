<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Verification - CloseSeller</title>
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/bootstrap.css') }}">
    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;700;800&family=Noto+Sans:wght@400;500;700;900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/706f90924a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/regvendor.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/verify-vendor.css') }}">
    {{-- toastr css --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

</head>

<body>
    <div class="container">
        <section class="selectionHeading">
            <a href="{{ url('/vendors/dashboard') }}">
                <figure>
                    <!-- SVG left arrow icon -->
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 18L9 12L15 6" stroke="#222" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </figure>
            </a>
            <h3>Create a CloseSeller<br />Account</h3>
        </section>

        <p class="headingText">Profile Verification</p>

        <h3 class="subHeading">
            You are expected to upload a link to a 30-second video introducing yourself as the CEO of your business
        </h3>

        <!-- Progress Indicator -->
        <div class="progress-indicator">
            <div class="progress-step completed"></div>
            <div class="progress-line completed"></div>
            <div class="progress-step active"></div>
            <div class="progress-line"></div>
            <div class="progress-step"></div>
        </div>

        <form action="{{ route('vendor.verify.docs') }}" id="signUpForm" class="verify_Section" method="POST"
            enctype="multipart/form-data">
            @csrf
            <!-- Video URL Input -->
            <div>
                <input class="inpsty" type="url" name="video_url"
                    placeholder="Add link to your introduction video here" required>
                @error('video_url')
                    <small class="text-danger d-block">{{ $message }}</small>
                @enderror
            </div>


            <!-- Business Registration Question -->
            <div class="select-container">
                <select name="question" required>
                    <option value="" selected disabled>Do you have a registered business?</option>
                    <option value="1">Yes, I have a registered business</option>
                    <option value="0">No, I don't have a registered business</option>
                </select>
                @error('question')
                    <small class="text-danger d-block">{{ $message }}</small>
                @enderror
            </div>

            <!-- CAC Upload Section -->
            <div class="upload-section" onclick="document.getElementById('cac').click()" id="cacUpload">
                <div class="upload-icon">
                    <i class="fas fa-file-alt" id="cacIcon"></i>
                </div>
                <h3 id="cacTitle"></h3>
                Upload a picture of your CAC<br />
                Registration <span>Browse</span>
                </h3>
                <p>Supported formats: JPEG, PNG, PDF, PSD, Word, PPT</p>
                <input type="file" name="cac" id="cac"
                    accept=".jpg,.jpeg,.png,.pdf,.psd,.doc,.docx,.ppt,.pptx">
            </div>

            <!-- NIN Upload Section -->
            <div class="upload-section" onclick="document.getElementById('nin').click()" id="ninUpload">
                <div class="upload-icon">
                    <i class="fas fa-id-card" id="ninIcon"></i>
                </div>
                <h3 id="ninTitle">
                    Add a picture of your National ID card<br />
                    here <span>Browse</span>
                </h3>
                <p>Supported formats: JPEG, PNG, PDF, PSD, Word, PPT</p>
                <input type="file" name="nin" id="nin"
                    accept=".jpg,.jpeg,.png,.pdf,.psd,.doc,.docx,.ppt,.pptx">
            </div>

            <button type="submit" name="verify" id="submitBtn">
                <div class="spinner" id="spinner"></div>
                <span id="btnText">Continue Verification</span>
            </button>
        </form>

        <div class="textEnd">
            <p>By continuing, you agree to the <span>CloseSeller<br />Agreement</span> and <span>Privacy Policy</span>
            </p>
        </div>
    </div>

    <!-- Modal -->
    <div class="overlay2 hide" id="modalOverlay">
        <div class="modal">
            <h4 class="removeModal" onclick="closeModal()">&times;</h4>
            <img src="../imgs/logo_details.svg" alt="verification icon" />
            <p>Please hold on a bit, we want to confirm<br />your documents.</p>
        </div>
    </div>

    <script src="{{ asset('vendors/assets/js/jquery.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        // File upload handling
        function handleFileUpload(inputId, uploadSectionId, iconId, titleId) {
            const input = document.getElementById(inputId);
            const uploadSection = document.getElementById(uploadSectionId);
            const icon = document.getElementById(iconId);
            const title = document.getElementById(titleId);

            input.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    // Add uploaded state
                    uploadSection.classList.add('uploaded');

                    // Change icon to checkmark
                    icon.className = 'fas fa-check';

                    // Update title text
                    const fileName = e.target.files[0].name;
                    title.innerHTML = `<span>✓ ${fileName}</span><br />File uploaded successfully`;
                }
            });
        }

        // Initialize file upload handlers
        handleFileUpload('cac', 'cacUpload', 'cacIcon', 'cacTitle');
        handleFileUpload('nin', 'ninUpload', 'ninIcon', 'ninTitle');

        // Form submission
        document.getElementById('signUpForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const spinner = document.getElementById('spinner');
            const btnText = document.getElementById('btnText');

            // Show loading state
            submitBtn.disabled = true;
            spinner.style.display = 'block';
            btnText.textContent = 'Verifying Documents...';
        });

        // Modal functions
        function closeModal() {
            document.getElementById('modalOverlay').classList.add('hide');
        }

        function showModal() {
            document.getElementById('modalOverlay').classList.remove('hide');
        }

        // Remove modal on click outside
        document.getElementById('modalOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Form validation
        const form = document.getElementById('signUpForm');
        const inputs = form.querySelectorAll('input[required], select[required]');

        inputs.forEach(input => {
            input.addEventListener('change', validateForm);
        });

        function validateForm() {
            const submitBtn = document.getElementById('submitBtn');
            const isValid = Array.from(inputs).every(input => {
                if (input.type === 'file') {
                    return input.files && input.files.length > 0;
                }
                return input.value.trim() !== '';
            });

            submitBtn.disabled = !isValid;
        }

        // Initialize form validation
        validateForm();

        // Progress animation
        function animateProgress() {
            const steps = document.querySelectorAll('.progress-step');
            const lines = document.querySelectorAll('.progress-line');

            setTimeout(() => {
                steps[1].classList.add('completed');
                steps[1].classList.remove('active');
                lines[1].classList.add('completed');
                steps[2].classList.add('active');
            }, 1000);
        }

        // Start progress animation when page loads
        window.addEventListener('load', animateProgress);
    </script>
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}")
            @endforeach
        </script>
    @endif
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="{{ asset('users/assets/js//code.js') }}"></script>
</body>

</html>
