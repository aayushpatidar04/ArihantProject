<?php

namespace App\Services;

use App\Models\EventRegistration;
use App\Models\QrCode as QrCodeModel;
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

    public function generateStallQr(EventRegistration $registration, int $stallId): QrCodeModel
    {
        $code = hash('sha256', $registration->id . '|stall|' . $stallId . '|checkin');
        $shortCode = substr($code, 0, 32);

        $existing = QrCodeModel::where('event_registration_id', $registration->id)
            ->where('purpose', 'stall')
            ->first();

        if ($existing) {
            return $existing;
        }

        $qrImage = $this->generateImage($shortCode);
        $path = "qrcodes/{$registration->id}_stall_{$stallId}.png";
        Storage::disk('public')->put($path, $qrImage);

        return QrCodeModel::create([
            'event_registration_id' => $registration->id,
            'code' => $shortCode,
            'image_path' => $path,
            'purpose' => 'stall',
        ]);
    }

    protected function generateImage(string $data): string
    {
        $builder = new Builder(writer: new PngWriter());

        $result = $builder->build(
            data: $data,
            size: 400,
            margin: 10,
            foregroundColor: new Color(255, 255, 255),
            backgroundColor: new Color(6, 2, 8),
        );

        return $result->getString();
    }

    public function validateQr(string $code): ?QrCodeModel
    {
        return QrCodeModel::where('code', $code)->where('is_used', false)->first();
    }
}