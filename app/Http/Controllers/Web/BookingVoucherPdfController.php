<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingVoucherPdfController extends Controller
{
    public function __invoke(Booking $booking)
    {
        $this->authorize('view', $booking);

        abort_unless(
            $booking->status->value === 'CONFIRMED',
            403,
            'O voucher só fica disponível após a confirmação do pagamento.'
        );

        $booking->load('tourDate.tour', 'customer');

        $qrCodeBase64 = $this->generateQrCode($booking);

        $pdf = Pdf::loadView('pdf.booking-voucher', [
            'booking'      => $booking,
            'qrCodeBase64' => $qrCodeBase64,
        ])->setPaper('a4', 'portrait');

        $filename = 'voucher-'.strtoupper(substr($booking->uuid, 0, 8)).'.pdf';

        return $pdf->download($filename);
    }

    protected function generateQrCode(Booking $booking): ?string
    {
        try {
            $png = QrCode::format('png')
                ->size(200)
                ->margin(1)
                ->generate($booking->uuid);

            return base64_encode($png);
        } catch (\Throwable $e) {
            return null; // se falhar, o voucher segue sem QR
        }
    }
}