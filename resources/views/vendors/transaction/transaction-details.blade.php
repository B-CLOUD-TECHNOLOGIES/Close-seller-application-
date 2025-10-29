@extends('vendors.vendor-masters')

@section('vendor')
<link rel="stylesheet" href="{{ asset('vendors/assets/css/receipt.css') }}" />

<div class="receipt-container">
    <!-- Header -->
    <div class="receipt-head">
        <a class="arrow-back-a" href="{{ route('vendor.transactions') }}">
            <svg class="arrow-back" width="20" height="20" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#460475" />
            </svg>
        </a>
        <div class="receipt-title">
            <span>Transaction Receipt</span>
        </div>
        <div style="width: 44px;"></div>
    </div>

    <div class="receipt">
        <!-- Amount Card -->
        <div class="amount-card">
            <div class="merchant-name">CloseSeller</div>
            <div class="transaction-purpose">Transfer to {{ $recipientName }}</div>
            <div class="amount-display">₦{{ number_format($grossAmount, 2) }}</div>
            <div class="status-badge {{ strtolower($status) === 'success' ? 'text-success' : 'text-danger' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" fill="currentColor" />
                </svg>
                {{ ucfirst($status) }}
            </div>
        </div>

        <!-- Details Card -->
        <div class="details-card">
            <div class="detail-row">
                <div class="detail-label">Transaction ID</div>
                <div class="detail-value">{{ $transactionId }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Date & Time</div>
                <div class="detail-value">{{ $createdAt }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Payment Reference</div>
                <div class="detail-value">{{ $reference }}</div>
            </div>

            <div class="section-divider"></div>

            <div class="detail-row">
                <div class="detail-label">Transaction Type</div>
                <div class="detail-value">Bank Account Transfer</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Net Amount</div>
                <div class="detail-value amount">₦{{ number_format($netAmount, 2) }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Fee</div>
                <div class="detail-value fee">₦{{ number_format($feeAmount, 2) }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Total Gross</div>
                <div class="detail-value total">₦{{ number_format($grossAmount, 2) }}</div>
            </div>

            <div class="section-divider"></div>

            <div class="detail-row">
                <div class="detail-label">Recipient</div>
                <div class="detail-value">
                    {{ $recipientName }}
                    {{-- <span class="recipient-badge">Original</span> --}}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Bank Details</div>
                <div class="detail-value">{{ $bankName }} | {{ substr($accountNumber, 0, 3) . '****' . substr($accountNumber, -3) }}</div>
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <button class="action-btn report-btn" id="reportIssueBtn" >
            <i class="fas fa-flag"></i>
            Report Issue
        </button>
        <button class="action-btn share-btn" id="shareReceiptBtn">
            <i class="fas fa-share-alt"></i>
            Share Receipt
        </button>
    </div>
    <!-- Share Modal -->
   <!-- Share Modal -->
    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
        <div class="modal-header border-0">
            <h5 class="modal-title" id="shareModalLabel">Share or Download Receipt</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
            <p class="text-muted mb-4">Choose an option below to share your transaction receipt.</p>
            <div class="d-flex flex-column gap-3">
            <button id="downloadPdfBtn" class="btn btn-outline-danger rounded-pill">
                <i class="fas fa-file-pdf me-2"></i> Download as PDF
            </button>
            <button id="shareImageBtn" class="btn btn-primary rounded-pill" style="background-color:#460475;">
                <i class="fas fa-image me-2"></i> Share as Image
            </button>
            </div>
        </div>
        </div>
    </div>
    </div>
   

</div>
 <!-- Action Buttons -->
    


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const reportBtn = document.getElementById('reportIssueBtn');
    const shareBtn = document.getElementById('shareReceiptBtn');
    const downloadPdfBtn = document.getElementById('downloadPdfBtn');
    const shareImageBtn = document.getElementById('shareImageBtn');
    const shareModalInstance = new bootstrap.Modal(document.getElementById('shareModal'));

    // ✅ Report Issue
    reportBtn.addEventListener('click', () => {
        window.location.href = "{{ route('vendor.sendReport') }}";
    });

    // ✅ Show Share Modal
    shareBtn.addEventListener('click', () => {
        shareModalInstance.show();
    });

    // ✅ Download PDF
   // ✅ Download PDF (handles full height)
downloadPdfBtn.addEventListener('click', async () => {
    const receiptArea = document.querySelector('.receipt');

    // Capture the receipt as a high-resolution image
    const canvas = await html2canvas(receiptArea, {
        scale: 2,
        useCORS: true,
        scrollY: -window.scrollY,
        backgroundColor: '#ffffff'
    });

    const imgData = canvas.toDataURL('image/png');
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'mm', 'a4');

    const pdfWidth = pdf.internal.pageSize.getWidth();
    const pdfHeight = pdf.internal.pageSize.getHeight();

    // Set margins
    const marginTop = 0;  // header spacing
    const marginBottom = 10;
    const marginX = 10; // left/right

    const imgProps = pdf.getImageProperties(imgData);
    const imgHeight = (imgProps.height * (pdfWidth - 2 * marginX)) / imgProps.width;

    let heightLeft = imgHeight;
    let position = marginTop;

    // ✅ Add custom header (Logo + Title)
    const logoUrl = "{{ asset('onboard/closesellerlogo.png') }}"; // update with your actual logo path
    const title = "Transaction Receipt";

    const logo = new Image();
    logo.src = logoUrl;

    logo.onload = () => {
        pdf.addImage(logo, 'PNG', marginX, 10, 25, 10); // logo at top left
        pdf.setFontSize(14);
        pdf.setTextColor(70, 4, 117); // purple tone
        pdf.text(title, pdfWidth / 2, 17, { align: 'center' });

        // ✅ Add first image (receipt content)
        pdf.addImage(imgData, 'PNG', marginX, position, pdfWidth - 2 * marginX, imgHeight);
        heightLeft -= (pdfHeight - marginTop - marginBottom);

        // ✅ Handle additional pages neatly
        while (heightLeft > 0) {
            position = heightLeft - imgHeight + marginTop;
            pdf.addPage();
            pdf.addImage(logo, 'PNG', marginX, 10, 25, 10);
            pdf.setFontSize(14);
            pdf.setTextColor(70, 4, 117);
            pdf.text(title, pdfWidth / 2, 17, { align: 'center' });
            pdf.addImage(imgData, 'PNG', marginX, position, pdfWidth - 2 * marginX, imgHeight);
            heightLeft -= (pdfHeight - marginTop - marginBottom);
        }

        pdf.save('Transaction_Receipt.pdf');
        shareModalInstance.hide();
    };
});

    // ✅ Share as Image
    shareImageBtn.addEventListener('click', async () => {
        const receiptArea = document.querySelector('.receipt');
        const canvas = await html2canvas(receiptArea, { scale: 2 });

        canvas.toBlob(async (blob) => {
            const file = new File([blob], "receipt.png", { type: "image/png" });

            if (navigator.canShare && navigator.canShare({ files: [file] })) {
                try {
                    await navigator.share({
                        files: [file],
                        title: "Transaction Receipt",
                        text: "Here’s my transaction receipt from CloseSeller.",
                    });
                } catch (err) {
                    console.log('Sharing canceled or not supported');
                }
            } else {
                // WhatsApp fallback (for web users)
                const encodedMsg = encodeURIComponent("Here’s my transaction receipt from CloseSeller.\n" + window.location.href);
                window.open(`https://wa.me/?text=${encodedMsg}`, "_blank");
            }
        });

        shareModalInstance.hide();
    });
});
</script>

@endsection
