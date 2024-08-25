@extends('layouts.app')

@section('title', 'Weather App')

@section('content')
    <h1 class="text-center mb-4 text-white">Weather App</h1>

    <form action="{{ route('weather') }}" method="GET" class="mb-4">
        <div class="form-group">
            <label for="city" class="text-white">City Name:</label>
            <input class="form-control mt-2 @error('city') is-invalid @enderror" type="text" name="city" id="city" placeholder="Enter city name">
            @error('city')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary">Get Weather</button>
        </div>
    </form>

    @if ($errors->has('weather'))
        <div class="alert alert-danger">
            @foreach ($errors->get('weather') as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if (isset($city) && !$errors->has('weather'))
        <div class="weather-card mx-auto mb-4 {{ strtolower($description) }}">
            <div class="weather-icon text-center">
                @if (str_contains(strtolower($description), 'clear'))
                    <i class="fas fa-sun"></i>
                @elseif (str_contains(strtolower($description), 'cloud'))
                    <i class="fas fa-cloud"></i>
                @elseif (str_contains(strtolower($description), 'rain'))
                    <i class="fas fa-cloud-showers-heavy"></i>
                @elseif (str_contains(strtolower($description), 'snow'))
                    <i class="fas fa-snowflake"></i>
                @else
                    <i class="fas fa-smog"></i>
                @endif
            </div>
            <div class="weather-details">
                <h2 class="weather-title">{{ $city }}</h2>
                <p class="temperature">{{ $temperature }}°C</p>
                <p class="description">{{ ucfirst($description) }}</p>
                <p class="datetime">{{ $dateTime }}</p>
            </div>
        </div>
    @endif
@endsection
