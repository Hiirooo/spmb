<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Geocoder
{
    public static function search(string $address): ?array
    {
        $key = 'geocode:'.md5($address);

        return Cache::remember($key, now()->addDays(30), function () use ($address) {
            try {
                $response = Http::timeout(8)
                    ->withHeaders(['User-Agent' => 'SPMB-Sumsel/1.0 (admin@spmb.rasyidabdulah.codes)'])
                    ->get('https://nominatim.openstreetmap.org/search', [
                        'q' => $address.', Sumatera Selatan, Indonesia',
                        'format' => 'json',
                        'limit' => 1,
                        'countrycodes' => 'id',
                    ]);

                if (! $response->ok()) {
                    return null;
                }

                $data = $response->json();
                if (empty($data) || ! isset($data[0]['lat'], $data[0]['lon'])) {
                    return null;
                }

                return [
                    'lat' => (float) $data[0]['lat'],
                    'lng' => (float) $data[0]['lon'],
                    'display_name' => $data[0]['display_name'] ?? null,
                ];
            } catch (\Throwable $e) {
                report($e);
                return null;
            }
        });
    }

    public static function distanceKm(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371.0;
        $latDelta = deg2rad($lat2 - $lat1);
        $lngDelta = deg2rad($lng2 - $lng1);

        $a = sin($latDelta / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($lngDelta / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earthRadius * $c, 2);
    }
}
