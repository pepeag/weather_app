<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #cdd1d5;
            padding-top: 50px;
        }
        .weather-container {
            max-width: 500px;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .error-messages {
            color: #ff0000;
            margin-top: 20px;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="weather-container">
        <h1>Weather App</h1>
        <form action="{{ route('weather') }}" method="GET">
            <div class="form-group mt-3">
                <label for="city">City Name:</label>
                <input class="form-control mt-2 @error('city') is-invalid @enderror" type="text" id="city" name="city" placeholder="Enter city name" value="{{ old('city') }}">
                @error('city')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">Get Weather</button>
            </div>
        </form>

        @if ($errors->has('weather'))
            <div class="error-messages">
                <ul>
                    @foreach ($errors->get('weather') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (isset($city) && !$errors->has('weather'))
            <div class="result" id="result">
                <h2>Weather Result</h2>
                <p>City: <span class="highlight">{{ $city }}</span></p>
                <p>Temperature: <span class="highlight">{{ $temperature }}°C</span></p>
                <p>Weather: <span class="highlight">{{ $description }}</span></p>
                <p>Date and Time: <span class="highlight">{{ $dateTime }}</span></p>
            </div>
        @endif
    </div>
</body>
</html>
