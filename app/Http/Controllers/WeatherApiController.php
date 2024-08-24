<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class WeatherApiController extends Controller
{
    public function index()
    {
        return view('weather.index');
    }

    public function getWeather(Request $request)
    {
        // Validate the city input
        $request->validate([
            'city' => 'required|string|max:255',
        ]);

        $city = $request->input('city');
        $apiKey = env('OPENWEATHERMAP_API_KEY');

        try {
            // Fetch weather data from OpenWeatherMap API
            $response = Http::timeout(30)->get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $city,
                'units' => 'metric',
                'appid' => $apiKey,
            ]);

            if ($response->successful()) {
                $weatherData = $response->json();

                return view('weather.index', [
                    'city' => $weatherData['name'],
                    'temperature' => $weatherData['main']['temp'],
                    'description' => $weatherData['weather'][0]['description'],
                    'dateTime' => Carbon::createFromTimestamp($weatherData['dt'])->toDateTimeString(),
                ]);
            } elseif ($response->status() === 404) {
                // City not found error
                return redirect('/')->withErrors(['weather' => 'City not found. Please check the spelling and try again.']);
            } else {
                // Other API errors
                $errorMessage = $response->json()['message'] ?? 'Weather data could not be fetched. Please try again later.';
                return redirect('/')->withErrors(['weather' => $errorMessage]);
            }

        } catch (\Exception $e) {
            // Handle any unexpected errors
            return redirect('/')->withErrors(['weather' => 'An unexpected error occurred. Please try again later.']);
        }
    }
}