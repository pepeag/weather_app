<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherApiControllerTest extends TestCase
{
    /** @test */
    public function test_weather_information_valid_city(): void
    {
        //Weather API response
        Http::fake([
            'api.openweathermap.org/*' => Http::response([
                'name' => 'London',
                'main' => [
                    'temp' => 30,
                ],
                'weather' => [
                    ['description' => 'clear sky'],
                ],
                'dt' => now()->timestamp,
            ], 200),
        ]);

        // request weather with city
        $response = $this->get(route('weather', ['city' => 'London']));

        // response is successful and contains weather data
        $response->assertStatus(200);
        $response->assertViewIs('weather.index');
        $response->assertViewHas('city', 'London');
        $response->assertViewHas('temperature', 30);
        $response->assertViewHas('description', 'clear sky');
        $response->assertViewHas('dateTime');
    }

    /** @test */
    public function test_city_not_found(): void
    {
        // response city not found 404
        Http::fake([
            'api.openweathermap.org/*' => Http::response([
                'message' => 'city not found'
            ], 404),
        ]);

        // request weather with incorrect city
        $response = $this->get(route('weather', ['city' => 'Abcdefg']));

        // response redirects back with error
        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['weather' => 'City not found. Please check the spelling and try again.']);
    }

    /** @test */
    public function test_validate_city(): void
    {
        // request with empty city field
        $response = $this->get(route('weather', ['city' => '']));

        // response with validation required error
        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['city']);
    }

    /** @test */
    public function test_handles_api_errors(): void
    {
        // response with 500 error
        Http::fake([
            'api.openweathermap.org/*' => Http::response(null, 500),
        ]);

        // request weather by city
        $response = $this->get(route('weather', ['city' => 'London']));

        // response redirects back with error
        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['weather' => 'Weather data could not be fetched. Please try again later.']);
    }
}