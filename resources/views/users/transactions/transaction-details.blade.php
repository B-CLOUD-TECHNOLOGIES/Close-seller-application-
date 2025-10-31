@extends('vendors.vendor-masters')

@section('vendor')
    <title>User Transaction Reciept</title>
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/receipt.css') }}" />
    <style>
        .text-green{
            color:#0cf90c !important;
        }
    </style>

    <div class="receipt-container">
        <!-- Header -->
        <div class="receipt-head">
            <a class="arrow-back-a" href="{{ route('user.transactions') }}">
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
                <div class="transaction-purpose">Order Receipt for Order {{ $order->order_no }}</div>
                <div class="amount-display">₦{{ number_format($total, 2) }}</div>
                <div class="status-badge {{ strtolower($order->status) == 3 ? 'text-green' : 'text-danger' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" fill="currentColor" />
                    </svg>
                    {{ ucfirst($order->status == 3 ? 'Successful' : 'Failed') }}
                </div>
            </div>

            <!-- Details Card -->
            <div class="details-card">
                <div class="detail-row">
                    <div class="detail-label">Transaction ID</div>
                    <div class="detail-value">{{ $order->transaction_id }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Date & Time</div>
                    <div class="detail-value">{{ $createdAt }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Payment Reference</div>
                    <div class="detail-value">{{ $order->reference }}</div>
                </div>


                {{-- <div class="detail-row">
                    <div class="detail-label">Transaction Type</div>
                    <div class="detail-value">Bank Account Transfer</div>
                </div> --}}

                <div class="detail-row">
                    <div class="detail-label">Net Amount</div>
                    <div class="detail-value amount">₦{{ number_format($netAmount, 2) }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Fee</div>
                    <div class="detail-value fee">₦{{ number_format($charges, 2) }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Total Gross</div>
                    <div class="detail-value total">₦{{ number_format($total, 2) }}</div>
                </div>

            </div>
        </div>

        <div class="action-buttons">
            <button class="action-btn report-btn" id="reportIssueBtn">
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
                            <button id="shareImageBtn" class="btn btn-primary rounded-pill"
                                style="background-color:#460475;">
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
        window.location.href = "{{ route('user.sendReport') }}";
    });

    // ✅ Show Share Modal
    shareBtn.addEventListener('click', () => {
        shareModalInstance.show();
    });

    // Helper function to capture receipt with better quality
    async function captureReceipt() {
        const receiptContainer = document.querySelector('.receipt-container');
        const receiptArea = document.querySelector('.receipt');
        
        // Temporarily hide action buttons during capture
        const actionButtons = document.querySelector('.action-buttons');
        const receiptHead = document.querySelector('.receipt-head');
        
        if (actionButtons) actionButtons.style.display = 'none';
        if (receiptHead) receiptHead.style.display = 'none';

        // Wait a moment for CSS changes to apply
        await new Promise(resolve => setTimeout(resolve, 100));

        const canvas = await html2canvas(receiptArea, {
            scale: 4, // Very high quality
            useCORS: true,
            allowTaint: false,
            backgroundColor: '#ffffff',
            logging: false,
            width: receiptArea.offsetWidth,
            height: receiptArea.offsetHeight,
            windowWidth: receiptArea.scrollWidth,
            windowHeight: receiptArea.scrollHeight,
            x: 0,
            y: 0,
            scrollY: 0,
            scrollX: 0,
            imageTimeout: 0,
            removeContainer: true
        });

        // Restore hidden elements
        if (actionButtons) actionButtons.style.display = '';
        if (receiptHead) receiptHead.style.display = '';

        return canvas;
    }

    // ✅ Download PDF (improved version)
    downloadPdfBtn.addEventListener('click', async () => {
        try {
            // Show loading state
            downloadPdfBtn.disabled = true;
            downloadPdfBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Generating PDF...';

            // Capture the receipt
            const canvas = await captureReceipt();
            const imgData = canvas.toDataURL('image/png', 1.0);
            
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF('p', 'mm', 'a4');

            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = pdf.internal.pageSize.getHeight();

            // Set margins
            const marginTop = 30; // Space for header
            const marginBottom = 15;
            const marginX = 15;

            const imgProps = pdf.getImageProperties(imgData);
            const contentWidth = pdfWidth - 2 * marginX;
            const imgHeight = (imgProps.height * contentWidth) / imgProps.width;

            // Load and add logo
            const logoUrl = "{{ asset('onboard/closesellerlogo.png') }}";
            const logo = new Image();
            logo.crossOrigin = 'Anonymous';
            
            logo.onload = () => {
                // Add header to first page
                pdf.addImage(logo, 'PNG', marginX, 10, 30, 12);
                pdf.setFontSize(18);
                pdf.setFont('helvetica', 'bold');
                pdf.setTextColor(70, 4, 117);
                pdf.text('Transaction Receipt', pdfWidth / 2, 18, { align: 'center' });
                
                // Add thin line separator
                pdf.setDrawColor(200, 200, 200);
                pdf.setLineWidth(0.5);
                pdf.line(marginX, 25, pdfWidth - marginX, 25);

                // Add receipt content
                let heightLeft = imgHeight;
                let position = marginTop;

                // First page
                pdf.addImage(imgData, 'PNG', marginX, position, contentWidth, imgHeight);
                heightLeft -= (pdfHeight - marginTop - marginBottom);

                // Additional pages if needed
                while (heightLeft > 0) {
                    pdf.addPage();
                    position = -(imgHeight - heightLeft) + marginTop;
                    
                    // Add header to new page
                    pdf.addImage(logo, 'PNG', marginX, 10, 30, 12);
                    pdf.setFontSize(18);
                    pdf.setFont('helvetica', 'bold');
                    pdf.setTextColor(70, 4, 117);
                    pdf.text('Transaction Receipt (cont.)', pdfWidth / 2, 18, { align: 'center' });
                    pdf.setDrawColor(200, 200, 200);
                    pdf.line(marginX, 25, pdfWidth - marginX, 25);
                    
                    pdf.addImage(imgData, 'PNG', marginX, position, contentWidth, imgHeight);
                    heightLeft -= (pdfHeight - marginTop - marginBottom);
                }

                // Save PDF
                const timestamp = new Date().toISOString().slice(0, 10);
                pdf.save(`CloseSeller_Receipt_${timestamp}.pdf`);
                
                // Reset button and close modal
                downloadPdfBtn.disabled = false;
                downloadPdfBtn.innerHTML = '<i class="fas fa-file-pdf me-2"></i> Download as PDF';
                shareModalInstance.hide();
            };

            logo.onerror = () => {
                // If logo fails to load, proceed without it
                console.warn('Logo failed to load, generating PDF without logo');
                
                pdf.setFontSize(18);
                pdf.setFont('helvetica', 'bold');
                pdf.setTextColor(70, 4, 117);
                pdf.text('Transaction Receipt', pdfWidth / 2, 18, { align: 'center' });
                pdf.setDrawColor(200, 200, 200);
                pdf.line(marginX, 25, pdfWidth - marginX, 25);

                let heightLeft = imgHeight;
                let position = marginTop;

                pdf.addImage(imgData, 'PNG', marginX, position, contentWidth, imgHeight);
                heightLeft -= (pdfHeight - marginTop - marginBottom);

                while (heightLeft > 0) {
                    pdf.addPage();
                    position = -(imgHeight - heightLeft) + marginTop;
                    pdf.setFontSize(18);
                    pdf.text('Transaction Receipt (cont.)', pdfWidth / 2, 18, { align: 'center' });
                    pdf.line(marginX, 25, pdfWidth - marginX, 25);
                    pdf.addImage(imgData, 'PNG', marginX, position, contentWidth, imgHeight);
                    heightLeft -= (pdfHeight - marginTop - marginBottom);
                }

                const timestamp = new Date().toISOString().slice(0, 10);
                pdf.save(`CloseSeller_Receipt_${timestamp}.pdf`);
                
                downloadPdfBtn.disabled = false;
                downloadPdfBtn.innerHTML = '<i class="fas fa-file-pdf me-2"></i> Download as PDF';
                shareModalInstance.hide();
            };

            logo.src = logoUrl;

        } catch (error) {
            console.error('PDF generation error:', error);
            alert('Failed to generate PDF. Please try again.');
            downloadPdfBtn.disabled = false;
            downloadPdfBtn.innerHTML = '<i class="fas fa-file-pdf me-2"></i> Download as PDF';
        }
    });

    // ✅ Share as Image (improved version)
    shareImageBtn.addEventListener('click', async () => {
        try {
            // Show loading state
            shareImageBtn.disabled = true;
            shareImageBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Generating Image...';

            // Capture the receipt
            const canvas = await captureReceipt();

            // Convert to blob with maximum quality
            canvas.toBlob(async (blob) => {
                if (!blob) {
                    throw new Error('Failed to generate image');
                }

                const timestamp = new Date().toISOString().slice(0, 10);
                const file = new File([blob], `CloseSeller_Receipt_${timestamp}.png`, {
                    type: "image/png"
                });

                // Check if Web Share API is supported
                if (navigator.canShare && navigator.canShare({ files: [file] })) {
                    try {
                        await navigator.share({
                            files: [file],
                            title: "Transaction Receipt",
                            text: "Here's my transaction receipt from CloseSeller.",
                        });
                        console.log('Receipt shared successfully');
                    } catch (err) {
                        if (err.name !== 'AbortError') {
                            console.error('Share failed:', err);
                            // Fallback: download the image
                            downloadImage(canvas, `CloseSeller_Receipt_${timestamp}.png`);
                        }
                    }
                } else {
                    // Fallback: download the image directly
                    downloadImage(canvas, `CloseSeller_Receipt_${timestamp}.png`);
                }

                // Reset button and close modal
                shareImageBtn.disabled = false;
                shareImageBtn.innerHTML = '<i class="fas fa-image me-2"></i> Share as Image';
                shareModalInstance.hide();
            }, 'image/png', 1.0); // Maximum quality

        } catch (error) {
            console.error('Image generation error:', error);
            alert('Failed to generate image. Please try again.');
            shareImageBtn.disabled = false;
            shareImageBtn.innerHTML = '<i class="fas fa-image me-2"></i> Share as Image';
        }
    });

    // Helper function to download image
    function downloadImage(canvas, filename) {
        const link = document.createElement('a');
        link.download = filename;
        link.href = canvas.toDataURL('image/png', 1.0);
        link.click();
        console.log('Receipt downloaded as image');
    }
});
    </script>
@endsection
