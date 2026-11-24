<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $data = $request->validate([
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lon' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $response = Http::timeout(10)->get(
            'https://api.openweathermap.org/data/2.5/weather',
            [
                'lat' => $data['lat'],
                'lon' => $data['lon'],
                'units' => 'metric',
                'appid' => config('services.openweather.key'),
            ]
        );

        if ($response->failed()) {
            return response()->json([
                'message' => 'Weather is currently unavailable.',
            ], 503);
        }

        $weather = $response->json();

        return response()->json([
            'place' => $weather['name'] ?? 'Selected location',
            'temperature' => $weather['main']['temp'] ?? null,
            'description' => $weather['weather'][0]['description'] ?? null,
            'humidity' => $weather['main']['humidity'] ?? null,
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $data = $request->validate([
            'q' => ['required', 'string', 'min:3', 'max:150'],
        ]);

        $response = Http::timeout(10)
            ->acceptJson()
            ->withHeaders([
                'User-Agent' => 'TRAIL Membership System/1.0 (+https://trail-membership.up.railway.app)',
                'Referer' => config('app.url'),
            ])
            ->get('https://nominatim.openstreetmap.org/search', [
                'q' => $data['q'],
                'format' => 'jsonv2',
                'limit' => 5,
                'addressdetails' => 1,
                'countrycodes' => 'ph',
            ]);

        if ($response->failed()) {
            logger()->warning('Nominatim location search failed.', [
                'status' => $response->status(),
            ]);

            return response()->json([
                'message' => 'Location search is currently unavailable.',
            ], 503);
        }

        return response()->json(
            collect($response->json())->map(function ($location) {
                return [
                    'name' => $location['display_name'],
                    'latitude' => (float) $location['lat'],
                    'longitude' => (float) $location['lon'],
                ];
            })->values()
        );
    }
}