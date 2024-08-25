<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeatherRequest;
use App\Http\Resources\WeatherResource;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WeatherApiController extends Controller
{
    public function index()
    {
        return view('weather.index');
    }

    public function getWeather(WeatherRequest $request)
    {
        $city = $request->input('city');
        $apiKey = config('services.openweathermap.key');
        $apiUrl = config('services.openweathermap.url');

        $client = new Client([
            'timeout' => 60,
        ]);

        try {
            $response = $client->get($apiUrl, [
                'query' => [
                    'q' => $city,
                    'units' => 'metric',
                    'appid' => $apiKey,
                ],
            ]);

            $weatherData = json_decode($response->getBody(), true);
            $weatherResource = new WeatherResource($weatherData);

            return view('weather.index', $weatherResource->toArray($request));
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode === 404) {
                // City not found error
                return redirect()->route('home')->withErrors(['weather' => 'City not found. Please check spelling and try again.']);
            } else {
                // Other API errors
                return redirect()->route('home')->withErrors(['weather' => 'Weather data could not be fetched. Please try again later.']);
            }
        } catch (\Exception $e) {
            // Handle any unexpected errors
            Log::error($e->getMessage()); // Log the exception message for debugging
            return redirect()->route('home')->withErrors(['weather' => 'An unexpected error occurred. Please try again later.']);
        }
    }
}
