@extends('vendors.vendor-masters')

@section('vendor')
<link rel="stylesheet" href="{{ asset('vendors/assets/css/personal-data.css') }}" />

<div class="header">
  <a href="{{ route('vendor.settings') }}" class="back-button">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
      xmlns="http://www.w3.org/2000/svg">
      <path d="M15.7069 7.41L14.2969 6L8.29688 12L14.2969 18L15.7069 16.59L11.1269 12L15.7069 7.41Z"
        fill="#1C1C1C" />
    </svg>
  </a>
  <h1>Personal Details</h1>
  <div class="header-spacer"></div>
</div>

<div class="info-banner">
  <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
    xmlns="http://www.w3.org/2000/svg">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 
      9 0 11-18 0 9 9 0 0118 0z"></path>
  </svg>
  <p class="info-text">
    Keep your personal information up to date to ensure smooth transactions and better customer communication.
  </p>
</div>

<form id="personalDataForm" enctype="multipart/form-data" method="POST" action="{{ route('vendor.update.personal.data') }}">
  @csrf

  <div class="profile-section">
    <label for="image" style="cursor: pointer;">
      <div class="profile-image-container">
        <img 
          src="{{ $vendor->image ? asset($vendor->image) : 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face' }}"
          class="profile-img" id="showImage" alt="Profile" />
        <div class="edit-badge">
          <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M11.05 3L13.47 5.42L5.42 13.47L3 13.97L3.5 11.55L11.05 3ZM14.7 4.2L12.3 1.8L13.5 0.6C13.89 0.21 14.53 0.21 14.92 0.6L17.4 3.08C17.79 3.47 17.79 4.11 17.4 4.5L16.2 5.7L14.7 4.2Z"
              fill="white" />
          </svg>
        </div>
      </div>
      <span class="edit-label">Click to change photo</span>
      <input type="file" name="image" id="image" accept="image/jpeg, image/png, image/webp">
    </label>
  </div>

  <div class="form-container">
    <div class="form-group">
      <label for="firstname">First Name</label>
      <div class="input-wrapper">
        <input type="text" id="firstname" name="firstname" class="form-input"
          placeholder="Enter your first name" value="{{ old('firstname', $vendor->firstname) }}" required />
      </div>
    </div>

    <div class="form-group">
      <label for="lastname">Last Name</label>
      <div class="input-wrapper">
        <input type="text" id="lastname" name="lastname" class="form-input"
          placeholder="Enter your last name" value="{{ old('lastname', $vendor->lastname) }}" required />
      </div>
    </div>

    <div class="form-group">
      <label for="phone">Phone Number</label>
      <div class="input-wrapper">
        <input type="tel" id="phone" name="phone" class="form-input"
          placeholder="+234 800 000 0000" value="{{ old('phone', $vendor->phone) }}" required />
      </div>
    </div>

    <div class="form-group">
      <label for="gender">Gender</label>
      <div class="input-wrapper">
        <select id="gender" name="gender" class="form-input" required>
          <option value="" disabled {{ !$vendor->gender ? 'selected' : '' }}>Select your gender</option>
          <option value="male" {{ $vendor->gender === 'male' ? 'selected' : '' }}>Male</option>
          <option value="female" {{ $vendor->gender === 'female' ? 'selected' : '' }}>Female</option>
          <option value="other" {{ $vendor->gender === 'other' ? 'selected' : '' }}>Other</option>
          <option value="prefer-not-to-say" {{ $vendor->gender === 'prefer-not-to-say' ? 'selected' : '' }}>Prefer not to say</option>
        </select>
      </div>
    </div>
  </div>

  <div class="save-button-container">
    <button type="submit" class="save-btn">
      <span class="spinner"></span>
      Save Changes
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
  document.getElementById('image').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (event) {
        document.getElementById('showImage').src = event.target.result;
      };
      reader.readAsDataURL(file);
    }
  });

  document.getElementById('phone').addEventListener('input', function (event) {
    let value = event.target.value;
    let newValue = value.replace(/[^+0-9]/g, '');

    if (newValue.indexOf('+') !== -1) {
      newValue = newValue.replace(/\+/g, '');
      newValue = '+' + newValue;
    }

    if (newValue.length > 14) {
      newValue = newValue.substring(0, 14);
    }

    event.target.value = newValue;
  });

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

  document.getElementById('personalDataForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = this;
    const submitBtn = form.querySelector('.save-btn');
    const formData = new FormData(form);

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
        showToast('error', 'An error occurred while updating your details.');
      })
      .finally(() => {
        submitBtn.classList.remove('loading');
        submitBtn.disabled = false;
      });
  });

  document.addEventListener('DOMContentLoaded', function () {
    const elements = ['.profile-section', '.form-container', '.save-button-container'];

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

    const inputs = document.querySelectorAll('.form-input');
    inputs.forEach(input => {
      input.addEventListener('focus', function () {
        this.parentElement.style.transform = 'scale(1.01)';
      });

      input.addEventListener('blur', function () {
        this.parentElement.style.transform = 'scale(1)';
      });
    });

    const profileContainer = document.querySelector('.profile-image-container');
    if (profileContainer) {
      profileContainer.addEventListener('mouseenter', function () {
        this.querySelector('.edit-badge').style.transform = 'scale(1.1) rotate(15deg)';
      });

      profileContainer.addEventListener('mouseleave', function () {
        this.querySelector('.edit-badge').style.transform = 'scale(1) rotate(0deg)';
      });
    }
  });

  document.querySelectorAll('.form-input').forEach(input => {
    input.addEventListener('blur', function () {
      if (this.value.trim() === '' && this.hasAttribute('required')) {
        this.style.borderColor = 'var(--danger-color)';
        setTimeout(() => {
          this.style.borderColor = '';
        }, 2000);
      }
    });

    input.addEventListener('input', function () {
      if (this.style.borderColor === 'rgb(220, 53, 69)') {
        this.style.borderColor = '';
      }
    });
  });

  window.addEventListener('scroll', function () {
    const header = document.querySelector('.header');
    if (window.scrollY > 50) {
      header.style.boxShadow = '0 4px 30px rgba(112, 29, 157, 0.15)';
    } else {
      header.style.boxShadow = '0 2px 20px rgba(112, 29, 157, 0.08)';
    }
  });
</script>
@endsection
