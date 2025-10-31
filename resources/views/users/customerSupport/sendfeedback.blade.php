@extends('vendors.vendor-masters')
@section('vendor')
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/send-feedback.css') }}" />
<div class="header">
    <a href="{{route ('user.customer.support')}}" class="back-button">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M15.7069 7.41L14.2969 6L8.29688 12L14.2969 18L15.7069 16.59L11.1269 12L15.7069 7.41Z" fill="#1C1C1C" />
      </svg>
    </a>
    <h1>Send Feedback</h1>
    <div class="header-spacer"></div>
  </div>

  <div class="info-banner">
    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
    </svg>
    <p class="info-text">Your feedback helps us improve CloseSeller. Share your thoughts, suggestions, or concerns with us.</p>
  </div>

 <form id="feedbackForm" action="{{ route('user.send.feedback') }}" method="POST">
    @csrf
    <div class="form-container">
      <div class="form-group">
        <label for="topic">Feedback Topic *</label>
        <span class="helper-text">Choose the category that best describes your feedback</span>
        <select id="topic" name="topic" class="form-select" required>
          <option value="" selected disabled>Select a topic</option>
          <option value="Products">Products</option>
          <option value="Payment">Payment</option>
          <option value="Delivery">Delivery</option>
          <option value="Cart">Cart</option>
          <option value="User Experience">User Experience</option>
          <option value="Customer Support">Customer Support</option>
          <option value="Others">Others</option>
        </select>
        <span class="error-message" id="topicError">Please select a topic</span>
      </div>

      <div class="form-group">
        <label for="description">Your Feedback *</label>
        <span class="helper-text">Please provide detailed feedback to help us understand your experience</span>
        <textarea id="description" 
                  name="description" 
                  class="form-textarea" 
                  placeholder="Share your thoughts, suggestions, or concerns here..."
                  required></textarea>
        <div class="char-counter">
          <span id="charCount">0</span> / 500 characters
        </div>
        <span class="error-message" id="descriptionError">Please provide your feedback</span>
      </div>
    </div>

    <div class="save-button-container">
      <button type="submit" class="save-btn">
        <span class="spinner"></span>
        Submit Feedback
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
    // Character counter
    const descriptionField = document.getElementById('description');
    const charCount = document.getElementById('charCount');

    descriptionField.addEventListener('input', function() {
      const length = this.value.length;
      charCount.textContent = length;
      
      if (length > 500) {
        this.value = this.value.substring(0, 500);
        charCount.textContent = 500;
      }

      // Remove error state when typing
      if (length > 0) {
        this.classList.remove('error');
        document.getElementById('descriptionError').classList.remove('show');
      }
    });

    // Toast notifications
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
      const topic = document.getElementById('topic');
      const description = document.getElementById('description');

      // Reset errors
      document.querySelectorAll('.error-message').forEach(msg => msg.classList.remove('show'));
      topic.classList.remove('error', 'success');
      description.classList.remove('error', 'success');

      // Validate topic
      if (!topic.value) {
        topic.classList.add('error');
        document.getElementById('topicError').classList.add('show');
        isValid = false;
      } else {
        topic.classList.add('success');
      }

      // Validate description
      if (description.value.trim() === '') {
        description.classList.add('error');
        document.getElementById('descriptionError').classList.add('show');
        isValid = false;
      } else {
        description.classList.add('success');
      }

      return isValid;
    }

   // Form submission
document.getElementById('feedbackForm').addEventListener('submit', async function(e) {
  e.preventDefault();

  if (!validateForm()) {
    showToast('error', 'Please fill in all required fields');
    return;
  }

  const submitBtn = this.querySelector('.save-btn');
  submitBtn.classList.add('loading');
  submitBtn.disabled = true;

  const formData = new FormData(this);

  try {
    const response = await fetch(this.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
        'Accept': 'application/json',
      },
      body: formData,
    });

    const result = await response.json();

    if (response.ok) {
      // Success
    //   showToast('success', result.message);
      toastr.success(result.message);
      document.getElementById('topic').value = '';
      document.getElementById('description').value = '';
      charCount.textContent = '0';
    } else {
    //   showToast('error', result.message || 'Failed to submit feedback');
      toastr.error(result.message || "Falied to submit message");
    }

  } catch (error) {
    // showToast('error', 'An error occurred. Please try again.');
      toastr.error(result.message || "An error occurred. Please try again.");
  } finally {
    submitBtn.classList.remove('loading');
    submitBtn.disabled = false;
  }
});
    // Topic select change handler
    document.getElementById('topic').addEventListener('change', function() {
      if (this.value) {
        this.classList.remove('error');
        this.classList.add('success');
        document.getElementById('topicError').classList.remove('show');
      }
    });

    // Real-time validation
    descriptionField.addEventListener('blur', function() {
      if (this.value.trim() === '') {
        this.classList.add('error');
        document.getElementById('descriptionError').classList.add('show');
      } else {
        this.classList.add('success');
        this.classList.remove('error');
        document.getElementById('descriptionError').classList.remove('show');
      }
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
      const inputs = document.querySelectorAll('.form-select, .form-textarea');
      inputs.forEach(input => {
        input.addEventListener('focus', function() {
          this.style.transform = 'scale(1.01)';
        });
        
        input.addEventListener('blur', function() {
          this.style.transform = 'scale(1)';
        });
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