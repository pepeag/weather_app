# Weather App

This Laravel application fetches weather data from the OpenWeatherMap API. The application displays the current weather, temperature, and description for a specified city.

## Requirements

- PHP Version 8.1 or higher
- Composer
- Laravel Version 10
- OpenWeatherMap API Key

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/pepeag/weather_app.git
   cd weather_app
   ```

2. **Install dependencies:**

   ```bash
   composer install
   ```

3. **Copy the `.env.example` file to `.env`:**

   ```bash
   cp .env.example .env
   ```

4. **Generate an application key:**

   ```bash
   php artisan key:generate
   ```
5. **Configure your environment variables in the `.env` file:**

   Open the `.env` file and add the following line:

   ```plaintext
   OPENWEATHERMAP_API_KEY=045f61724aef9085e0bf2ed6a19da4d0
   OPENWEATHERMAP_API_URL=https://api.openweathermap.org/data/2.5/weather
   ```

6. **Run the application:**

   Start the local development server:

   ```bash
   php artisan serve
   ```

   The application will be accessible at `http://localhost:8000`.

## Testing

To run the test suite:

```bash
php artisan test
```