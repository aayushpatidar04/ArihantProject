<?php

namespace App\Services;

use App\Models\EventRegistration;
use App\Models\QrCode as QrCodeModel;
use App\Models\Stall;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;

class QrCodeService
{
    public function generateEntryQr(EventRegistration $registration): QrCodeModel
    {
        $code = hash('sha256', $registration->id . '|' . $registration->registration_number . '|entry');
        $shortCode = substr($code, 0, 32);

        $existing = QrCodeModel::where('event_registration_id', $registration->id)
            ->where('purpose', 'entry')
            ->first();

        if ($existing) {
            return $existing;
        }

        $qrImage = $this->generateImage($shortCode);
        $path = "qrcodes/{$registration->id}_entry.png";
        Storage::disk('public')->put($path, $qrImage);

        return QrCodeModel::create([
            'event_registration_id' => $registration->id,
            'code' => $shortCode,
            'image_path' => $path,
            'purpose' => 'entry',
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
        $qrCode->setSize(400);
        $qrCode->setMargin(10);

        // Set colors using Color objects (not arrays)
        $qrCode->setForegroundColor(new Color(255, 255, 255)); // white
        $qrCode->setBackgroundColor(new Color(6, 2, 8));       // dark background

        // Render with PNG writer
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Return raw image string (binary PNG data)
        return $result->getString();
    }


    public function validateQr(string $code): ?QrCodeModel
    {
        return QrCodeModel::where('code', $code)->where('is_used', false)->first();
    }
}