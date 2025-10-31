@extends('vendors.vendor-masters')

@section('vendor')
<link rel="stylesheet" href="{{ asset('vendors/assets/css/customer-support.css') }}" />
<div class="header align-items-end">
    <a href="{{ route('user.dashboard') }}" class="back-button">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M15.7069 7.41L14.2969 6L8.29688 12L14.2969 18L15.7069 16.59L11.1269 12L15.7069 7.41Z" fill="#1C1C1C" />
      </svg>
    </a>
    <h1>Customer Support</h1>
    <div class="header-spacer"></div>
  </div>

  <div class="hero-section">
    <div class="hero-icon">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 19H11V17H13V19ZM15.07 11.25L14.17 12.17C13.45 12.9 13 13.5 13 15H11V14.5C11 13.4 11.45 12.4 12.17 11.67L13.41 10.41C13.78 10.05 14 9.55 14 9C14 7.9 13.1 7 12 7C10.9 7 10 7.9 10 9H8C8 6.79 9.79 5 12 5C14.21 5 16 6.79 16 9C16 9.88 15.64 10.68 15.07 11.25Z" fill="white" />
      </svg>
    </div>
    <h2 class="hero-title">How can we help you?</h2>
    <p class="hero-description">Our support team is here to assist you with any questions or issues you may have</p>
  </div>

  <div class="support-container" style="margin-bottom: 150px;">
    <div class="support-section">
      <a href="{{ route('user.sendFeedback') }}" class="support-item">
        <div class="support-icon">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 2H4C2.9 2 2.01 2.9 2.01 4L2 22L6 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2ZM6 9H18V11H6V9ZM14 14H6V12H14V14ZM18 8H6V6H18V8Z" fill="currentColor"/>
          </svg>
        </div>
        <div class="support-text">
          <div class="support-title">Send Feedback</div>
          <div class="support-description">Share your thoughts and help us improve</div>
        </div>
        <svg class="support-arrow" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M8.29313 16.59L9.70312 18L15.7031 12L9.70313 6L8.29313 7.41L12.8731 12L8.29313 16.59Z" fill="currentColor" />
        </svg>
      </a>

      <a href="{{ route('user.faqs') }}" class="support-item">
        <div class="support-icon">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14 2H6C4.9 2 4.01 2.9 4.01 4L4 20C4 21.1 4.89 22 5.99 22H18C19.1 22 20 21.1 20 20V8L14 2ZM16 18H8V16H16V18ZM16 14H8V12H16V14ZM13 9V3.5L18.5 9H13Z" fill="currentColor"/>
          </svg>
        </div>
        <div class="support-text">
          <div class="support-title">FAQs</div>
          <div class="support-description">Find answers to commonly asked questions</div>
        </div>
        <svg class="support-arrow" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M8.29313 16.59L9.70312 18L15.7031 12L9.70313 6L8.29313 7.41L12.8731 12L8.29313 16.59Z" fill="currentColor" />
        </svg>
      </a>

      <a href="{{ route ('user.gethelp') }}" class="support-item">
        <div class="support-icon">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 18H13V16H11V18ZM12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20ZM12 6C9.79 6 8 7.79 8 10H10C10 8.9 10.9 8 12 8C13.1 8 14 8.9 14 10C14 12 11 11.75 11 15H13C13 12.75 16 12.5 16 10C16 7.79 14.21 6 12 6Z" fill="currentColor"/>
          </svg>
        </div>
        <div class="support-text">
          <div class="support-title">Get Help</div>
          <div class="support-description">Contact our support team for assistance</div>
        </div>
        <svg class="support-arrow" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M8.29313 16.59L9.70312 18L15.7031 12L9.70313 6L8.29313 7.41L12.8731 12L8.29313 16.59Z" fill="currentColor" />
        </svg>
      </a>

      <a href="{{ route('user.sendReport') }}" class="support-item">
        <div class="support-icon">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 21H23L12 2L1 21ZM13 18H11V16H13V18ZM13 14H11V10H13V14Z" fill="currentColor"/>
          </svg>
        </div>
        <div class="support-text">
          <div class="support-title">Report an Issue</div>
          <div class="support-description">Let us know about any problems you're experiencing</div>
        </div>
        <svg class="support-arrow" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M8.29313 16.59L9.70312 18L15.7031 12L9.70313 6L8.29313 7.41L12.8731 12L8.29313 16.59Z" fill="currentColor" />
        </svg>
      </a>

      <div class="section-divider"></div>

      <a href="./policy.html" class="support-item">
        <div class="support-icon">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14.4 6L14 4H5V21H7V14H12.6L13 16H20V6H14.4Z" fill="currentColor"/>
          </svg>
        </div>
        <div class="support-text">
          <div class="support-title">Policy</div>
          <div class="support-description">Review our terms of service and privacy policy</div>
        </div>
        <svg class="support-arrow" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M8.29313 16.59L9.70312 18L15.7031 12L9.70313 6L8.29313 7.41L12.8731 12L8.29313 16.59Z" fill="currentColor" />
        </svg>
      </a>
    </div>
  </div>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const supportItems = document.querySelectorAll('.support-item');
      
      supportItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
          item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
          item.style.opacity = '1';
          item.style.transform = 'translateY(0)';
        }, index * 100);
      });

      supportItems.forEach(item => {
        item.addEventListener('click', function() {
          this.style.transform = 'translateX(8px) scale(0.98)';
          setTimeout(() => {
            this.style.transform = 'translateX(8px) scale(1)';
          }, 150);
        });
      });
    });

    window.addEventListener('scroll', function() {
      const header = document.querySelector('.header');
      if (window.scrollY > 50) {
        header.style.boxShadow = '0 4px 30px rgba(112, 29, 157, 0.15)';
      } else {
        header.style.boxShadow = '0 2px 20px rgba(112, 29, 157, 0.08)';
      }
    });
  </script>