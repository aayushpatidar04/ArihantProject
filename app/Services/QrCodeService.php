<?php

namespace App\Services;

use App\Models\EventRegistration;
use App\Models\FinbridgeRegistration;
use App\Models\QrCode as QrCodeModel;
use App\Models\FinbridgeQrCode;
use App\Models\Stall;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Style\EyeStyle;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;

class QrCodeService
{
    public function generateEntryQr(EventRegistration $registration): QrCodeModel
    {
        $code = hash('sha256', $registration->id . '|' . $registration->registration_number . '|entry');
        $shortCode = substr($code, 0, 32);

        $path = "qrcodes/{$registration->id}_entry.png";

        $existing = QrCodeModel::where('event_registration_id', $registration->id)
            ->where('purpose', 'entry')
            ->first();

        // If record exists but file missing, regenerate image
        if ($existing) {
            if (!Storage::disk('public')->exists($existing->image_path)) {
                $qrImage = $this->generateImage($shortCode);
                Storage::disk('public')->put($existing->image_path, $qrImage);
            }
            return $existing;
        }

        // Normal case: create new record + image
        $qrImage = $this->generateImage($shortCode);
        Storage::disk('public')->put($path, $qrImage);

        return QrCodeModel::create([
            'event_registration_id' => $registration->id,
            'code' => $shortCode,
            'image_path' => $path,
            'purpose' => 'entry',
        ]);
    }

    public function generateGoodiesQr(FinbridgeRegistration $registration): FinbridgeQrCode
    {
        $code = hash('sha256', $registration->id . '|' . $registration->registration_number . '|goodies');
        $shortCode = substr($code, 0, 32);

        $path = "qrcodes/{$registration->id}_goodies.png";

        $existing = FinbridgeQrCode::where('finbridge_registration_id', $registration->id)
            ->where('purpose', 'goodies')
            ->first();

        // If record exists but file missing, regenerate image
        if ($existing) {
            if (!Storage::disk('public')->exists($existing->image_path)) {
                $qrImage = $this->generateImage($shortCode);
                Storage::disk('public')->put($existing->image_path, $qrImage);
            }
            return $existing;
        }

        // Normal case: create new record + image
        $qrImage = $this->generateImage($shortCode);
        Storage::disk('public')->put($path, $qrImage);

        return FinbridgeQrCode::create([
            'finbridge_registration_id' => $registration->id,
            'code' => $shortCode,
            'image_path' => $path,
            'purpose' => 'goodies',
        ]);
    }


    public function generateStallQr(Stall $stall): Stall
    {
        if ($stall->qr_token && $stall->qr_image_path) {
            return $stall;
        }

        $qrToken = $stall->qr_token ?: bin2hex(random_bytes(32));

        $qrImage = $this->generateImage($qrToken);

        $path = "qrcodes/stall_{$stall->id}.png";

        Storage::disk('public')->put($path, $qrImage);

        $stall->update([
            'qr_token' => $qrToken,
            'qr_image_path' => $path,
        ]);

        return $stall->fresh();
    }

    protected function generateImage(string $data): string
    {
        // Create QR code instance
        $qrCode = new QrCode($data);
        $qrCode->setSize(600);
        $qrCode->setMargin(20);

        // REQUIRED when placing a logo in the center — high error correction (~30% redundancy)
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::High);

        // Set colors using Color objects (not arrays)
        $qrCode->setForegroundColor(new Color(255, 255, 255)); // white
        $qrCode->setBackgroundColor(new Color(6, 2, 8));       // dark background

        // Optional visual polish — rounded modules + rounded eyes
        $qrCode->setRoundBlockSizeMode(RoundBlockSizeMode::Margin);

        // Company logo in the center
        // punchoutBackground removes the logo's own background so it blends with the dark QR
        $logo = new Logo(
            public_path('assets/images/favicon-circle-bg.png'), // adjust path to your logo
            150,                                // width in px (keep ~20-25% of QR size)
            null,                               // height (null = keep aspect ratio)
            true                                // punchoutBackground
        );

        // Render with PNG writer + logo
        $writer = new PngWriter();
        $result = $writer->write($qrCode, logo: $logo);

        // Return raw image string (binary PNG data)
        return $result->getString();
    }

    public function validateQr(string $code): ?QrCodeModel
    {
        return QrCodeModel::where('code', $code)->where('is_used', false)->first();
    }
}