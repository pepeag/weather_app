<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'city' => $this->resource['name'] ?? null,
            'temperature' => $this->resource['main']['temp'] ?? null,
            'description' => $this->resource['weather'][0]['description'] ?? null,
            'dateTime' => isset($this->resource['dt']) 
                ? Carbon::createFromTimestamp($this->resource['dt'])->setTimezone('Asia/Yangon')->toDateTimeString() 
                : null,
        ];
    }
}
