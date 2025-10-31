@extends('vendors.vendor-masters')
@section('vendor')
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/send-feedback.css') }}" />

<div class="header">
    <a href="#" onclick="window.history.back()" class="back-button">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M15.7069 7.41L14.2969 6L8.29688 12L14.2969 18L15.7069 16.59L11.1269 12L15.7069 7.41Z" fill="#1C1C1C" />
      </svg>
    </a>
    <h1>Report an Issue</h1>
    <div class="header-spacer"></div>
  </div>

  <div class="info-banner">
    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
    </svg>
    <p class="info-text">If you're experiencing any problems with CloseSeller, please let us know. Our support team will review your report and get back to you as soon as possible.</p>
  </div>

  <form id="issueForm"  action="{{ route('user.send.report') }}" method="POST">
    @csrf>
    <div class="form-container">
      <div class="form-group">
        <label for="issue">Issue Type *</label>
        <span class="helper-text">Select the category that best describes your issue</span>
        <select id="issue" name="issue" class="form-select" required>
          <option value="" selected disabled>Select an issue type</option>
          <option value="Products">Products</option>
          <option value="Payment">Payment</option>
          <option value="Delivery">Delivery</option>
          <option value="Cart">Cart</option>
          <option value="User Experience">User Experience</option>
          <option value="Technical">Technical</option>
          <option value="Others">Others</option>
        </select>
        <span class="error-message" id="issueError">Please select an issue type</span>
      </div>

      <div class="form-group">
        <label for="description">Issue Description *</label>
        <span class="helper-text">Please provide detailed information about the issue you're experiencing</span>
        <textarea id="description" 
                  name="description" 
                  class="form-textarea" 
                  placeholder="Describe the issue you're facing in detail. Include any error messages, steps to reproduce, and what you were trying to accomplish..."
                  required></textarea>
        <div class="char-counter">
          <span id="charCount">0</span> / 500 characters
        </div>
        <span class="error-message" id="descriptionError">Please describe the issue</span>
      </div>
    </div>

    <div class="save-button-container">
      <button type="submit" class="save-btn">
        <span class="spinner"></span>
        Submit Issue Report
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
      const issue = document.getElementById('issue');
      const description = document.getElementById('description');

      // Reset errors
      document.querySelectorAll('.error-message').forEach(msg => msg.classList.remove('show'));
      issue.classList.remove('error', 'success');
      description.classList.remove('error', 'success');

      // Validate issue
      if (!issue.value) {
        issue.classList.add('error');
        document.getElementById('issueError').classList.add('show');
        isValid = false;
      } else {
        issue.classList.add('success');
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
    document.getElementById('issueForm').addEventListener('submit', async function(e) {
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

        let result;
        const contentType = response.headers.get('content-type');

        if (contentType && contentType.includes('application/json')) {
            result = await response.json();
        } else {
            // If not JSON, get text (for debugging)
            const text = await response.text();
            console.error('Non-JSON response:', text);
            throw new Error('Invalid JSON response');
        }

        if (response.ok) {
            showToast('success', result.message || 'Report submitted successfully');
            document.getElementById('issue').value = '';
            document.getElementById('description').value = '';
            charCount.textContent = '0';
        } else {
            showToast('error', result.message || 'Failed to submit report. Please try again.');
        }

        } catch (error) {
        console.error('Error submitting form:', error);
        showToast('error', 'An error occurred. Please try again.');
        } finally {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }
    });

    // Issue select change handler
    document.getElementById('issue').addEventListener('change', function() {
      if (this.value) {
        this.classList.remove('error');
        this.classList.add('success');
        document.getElementById('issueError').classList.remove('show');
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