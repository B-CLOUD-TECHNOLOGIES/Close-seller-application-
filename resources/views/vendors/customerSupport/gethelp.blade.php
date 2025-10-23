@extends('vendors.vendor-masters')

@section('vendor')
<link rel="stylesheet" href="{{ asset('vendors/assets/css/gethelp.css') }}" />

<div class="header">
    <a onclick="window.history.back()">
        <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTE1LjA0MDQgOS41SDMuOTU3MDMiIHN0cm9rZT0iIzg4ODc4NyIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPHBhdGggZD0iTTkuNDk4NyAxNS4wNDIzTDMuOTU3MDMgOS41MDA2NUw5LjQ5ODcgMy45NTg5OCIgc3Ryb2tlPSIjODg4Nzg3IiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K" alt="Back" />
    </a>
    <h3>Get Help</h3>
</div>

<main>
    <div>
        <a href="{{ url('chat/chat.html') }}">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect width="20" height="20" rx="6" fill="#8AFDA3" />
                <path
                    d="M3.33268 3.33366H16.666V13.3337H4.30768L3.33268 14.3087V3.33366ZM3.33268 1.66699C2.41602 1.66699 1.67435 2.41699 1.67435 3.33366L1.66602 18.3337L4.99935 15.0003H16.666C17.5827 15.0003 18.3327 14.2503 18.3327 13.3337V3.33366C18.3327 2.41699 17.5827 1.66699 16.666 1.66699H3.33268ZM4.99935 10.0003H11.666V11.667H4.99935V10.0003ZM4.99935 7.50033H14.9993V9.16699H4.99935V7.50033ZM4.99935 5.00033H14.9993V6.66699H4.99935V5.00033Z"
                    fill="#1C1C1C" />
            </svg>
            <p>Chat with us</p>
        </a>
    </div>

    <div>
        <a href="mailto:{{ $settings->email }}">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect width="20" height="20" rx="6" fill="#F5FF85" />
                <path
                    d="M18.3327 4.99967C18.3327 4.08301 17.5827 3.33301 16.666 3.33301H3.33268C2.41602 3.33301 1.66602 4.08301 1.66602 4.99967V14.9997C1.66602 15.9163 2.41602 16.6663 3.33268 16.6663H16.666C17.5827 16.6663 18.3327 15.9163 18.3327 14.9997V4.99967ZM16.666 4.99967L9.99935 9.16634L3.33268 4.99967H16.666ZM16.666 14.9997H3.33268V6.66634L9.99935 10.833L16.666 6.66634V14.9997Z"
                    fill="#1C1C1C" />
            </svg>
            <p>Email us</p>
        </a>
    </div>

    <div>
        <a href="tel:{{ $settings->phone }}">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect width="20" height="20" rx="8" fill="#92EBFF" />
                <path
                    d="M5.45 4.16667C5.5 4.90833 5.625 5.63333 5.825 6.325L4.825 7.325C4.48333 6.325 4.26667 5.26667 4.19167 4.16667H5.45ZM13.6667 14.1833C14.375 14.3833 15.1 14.5083 15.8333 14.5583V15.8C14.7333 15.725 13.675 15.5083 12.6667 15.175L13.6667 14.1833ZM6.25 2.5H3.33333C2.875 2.5 2.5 2.875 2.5 3.33333C2.5 11.1583 8.84167 17.5 16.6667 17.5C17.125 17.5 17.5 17.125 17.5 16.6667V13.7583C17.5 13.3 17.125 12.925 16.6667 12.925C15.6333 12.925 14.625 12.7583 13.6917 12.45C13.6083 12.4167 13.5167 12.4083 13.4333 12.4083C13.2167 12.4083 13.0083 12.4917 12.8417 12.65L11.0083 14.4833C8.65 13.275 6.71667 11.35 5.51667 8.99167L7.35 7.15833C7.58333 6.925 7.65 6.6 7.55833 6.30833C7.25 5.375 7.08333 4.375 7.08333 3.33333C7.08333 2.875 6.70833 2.5 6.25 2.5Z"
                    fill="#1C1C1C" />
            </svg>
            <p>Call us</p>
        </a>
    </div>

    {{-- Dropdown --}}
    <div class="dropdown-container">
        <div class="dropdown-button">
            <div class="globe">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <rect width="20" height="20" rx="6" fill="#F886F3" />
                    <path
                        d="M9.99102 1.66699C5.39102 1.66699 1.66602 5.40033 1.66602 10.0003C1.66602 14.6003 5.39102 18.3337 9.99102 18.3337C14.5993 18.3337 18.3327 14.6003 18.3327 10.0003C18.3327 5.40033 14.5993 1.66699 9.99102 1.66699ZM15.766 6.66699H13.3077C13.041 5.62533 12.6577 4.62533 12.1577 3.70033C13.691 4.22533 14.966 5.29199 15.766 6.66699ZM9.99935 3.36699C10.691 4.36699 11.2327 5.47533 11.591 6.66699H8.40768C8.76602 5.47533 9.30768 4.36699 9.99935 3.36699ZM3.54935 11.667C3.41602 11.1337 3.33268 10.5753 3.33268 10.0003C3.33268 9.42533 3.41602 8.86699 3.54935 8.33366H6.36602C6.29935 8.88366 6.24935 9.43366 6.24935 10.0003C6.24935 10.567 6.29935 11.117 6.36602 11.667H3.54935ZM4.23268 13.3337H6.69102C6.95768 14.3753 7.34102 15.3753 7.84102 16.3003C6.30768 15.7753 5.03268 14.717 4.23268 13.3337ZM6.69102 6.66699H4.23268C5.03268 5.28366 6.30768 4.22533 7.84102 3.70033C7.34102 4.62533 6.95768 5.62533 6.69102 6.66699ZM9.99935 16.6337C9.30768 15.6337 8.76602 14.5253 8.40768 13.3337H11.591C11.2327 14.5253 10.691 15.6337 9.99935 16.6337ZM11.9493 11.667H8.04935C7.97435 11.117 7.91602 10.567 7.91602 10.0003C7.91602 9.43366 7.97435 8.87533 8.04935 8.33366H11.9493C12.0243 8.87533 12.0827 9.43366 12.0827 10.0003C12.0827 10.567 12.0243 11.117 11.9493 11.667ZM12.1577 16.3003C12.6577 15.3753 13.041 14.3753 13.3077 13.3337H15.766C14.966 14.7087 13.691 15.7753 12.1577 16.3003ZM13.6327 11.667C13.6994 11.117 13.7493 10.567 13.7493 10.0003C13.7493 9.43366 13.6994 8.88366 13.6327 8.33366H16.4493C16.5827 8.86699 16.666 9.42533 16.666 10.0003C16.666 10.5753 16.5827 11.1337 16.4493 11.667H13.6327Z"
                        fill="#4A4646" />
                </svg>
                &nbsp; Select a Social Media
            </div>
            <div>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M16.59 15.7049L18 14.2949L12 8.29492L6 14.2949L7.41 15.7049L12 11.1249L16.59 15.7049Z"
                        fill="#2A2A2A" />
                </svg>
            </div>
        </div>

        <div class="dropdown-options">
            <a href="https://facebook.com/CloseSeller" class="dropdown-option" data-value="facebook" target="_blank" rel="noopener">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="#1877F2" d="M22,12A10,10 0 1,0 10,22V14H7V10H10V7.5C10,5.01 11.79,3 14.5,3H17V7H15C14.17,7 14,7.5 14,8V10H17V14H14V22A10,10 0 0,0 22,12Z" />
                </svg>
                Facebook
            </a>

            <a href="https://twitter.com/CloseSeller" class="dropdown-option" data-value="twitter" target="_blank" rel="noopener">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="#1DA1F2" d="M22.46,6c-.77.35-1.5.57-2.32.68a4.11,4.11,0,0,0,1.82-2.27,8.16,8.16,0,0,1-2.6,1,4.09,4.09,0,0,0-7,3.72A11.6,11.6,0,0,1,3,5a4.12,4.12,0,0,0,1.27,5.47,4.07,4.07,0,0,1-1.86-.52v.05A4.11,4.11,0,0,0,4,13.81a4.08,4.08,0,0,1-1.85.07,4.1,4.1,0,0,0,3.83,2.85A8.25,8.25,0,0,1,2,18.58,11.56,11.56,0,0,0,9.29,21c7.56,0,11.8-6.27,11.8-11.72,0-.18,0-.35,0-.52A8.3,8.3,0,0,0,22.46,6Z" />
                </svg>
                Twitter
            </a>

            <a href="https://instagram.com/CloseSeller" class="dropdown-option" data-value="instagram" target="_blank" rel="noopener">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="#E1306C" d="M7.5,2h9A5.5,5.5,0,0,1,22,7.5v9A5.5,5.5,0,0,1,16.5,22h-9A5.5,5.5,0,0,1,2,16.5v-9A5.5,5.5,0,0,1,7.5,2ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.5,5.5,0,0,0,12,6.5ZM12,16a4,4,0,1,1,4-4A4,4,0,0,1,12,16ZM18,7a1,1,0,1,1-1-1A1,1,0,0,1,18,7Z" />
                </svg>
                Instagram
            </a>
        </div>
    </div>
    
</main>
@include('vendors.body.footer')
  

   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    

  <script>
  const dropdownButton = document.querySelector('.dropdown-button');
  const dropdownContainer = document.querySelector('.dropdown-container');
  const dropdownOptions = document.querySelectorAll('.dropdown-option');

  // Toggle dropdown visibility
  dropdownButton.addEventListener('click', (e) => {
    e.stopPropagation(); // Prevent clicks from bubbling
    dropdownContainer.classList.toggle('open');
  });

  // Close dropdown when an option is clicked
  dropdownOptions.forEach(option => {
    option.addEventListener('click', () => {
      dropdownContainer.classList.remove('open');
    });
  });

  // Close dropdown if user clicks outside
  document.addEventListener('click', (e) => {
    if (!dropdownContainer.contains(e.target)) {
      dropdownContainer.classList.remove('open');
    }
  });
</script>