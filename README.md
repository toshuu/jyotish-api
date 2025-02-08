# Vedic Astrology API

A PHP-based API for Vedic astrology calculations, providing comprehensive astrological chart data including planetary positions, Dashas, Yogas, and more.

## API Endpoints

### Calculate Chart (`/api/calculate`)

Calculates an astrological chart based on provided parameters.

#### Parameters

- `latitude` (required): Location latitude (float, e.g., 28.6139)
- `longitude` (required): Location longitude (float, e.g., 77.2090)
- `year` (required): Year for calculation (integer)
- `month` (required): Month for calculation (1-12)
- `day` (required): Day for calculation (1-31)
- `hour` (required): Hour for calculation (0-23)
- `min` (required): Minute for calculation (0-59)
- `sec` (required): Second for calculation (0-59)
- `time_zone` (optional): Timezone for the calculation (default: 'Asia/Tehran')
- `dst_hour` (optional): Daylight Saving Time hours offset (default: 0)
- `dst_min` (optional): Daylight Saving Time minutes offset (default: 0)
- `nesting` (optional): Nesting level for calculations (default: 0)
- `varga` (optional): Varga divisions to calculate (comma-separated, default: 'D1')
- `infolevel` (optional): Information levels to include (comma-separated)

### Current Chart (`/api/now`)

Calculates an astrological chart for the current moment.

#### Parameters

- `latitude` (optional): Location latitude (default: 35.7219)
- `longitude` (optional): Location longitude (default: 51.3347)

## Features

### Chart Calculations
- Varga (Divisional) Charts: D1-D60
- Planetary Positions
- Lagna (Ascendant) Calculations
- Nakshatra Positions

### Advanced Calculations

#### Basic Information
- Astangata (Combustion)
- Rashi Avastha (Planetary Dignity)
- Vargottama
- Planetary War (Yuddha)

#### Panchanga Elements
- Tithi
- Nakshatra
- Yoga
- Karana
- Vara

#### Strength Calculations
- Ashtakavarga
- Graha Bala (Planetary Strength)
- Rashi Bala (Sign Strength)

#### Yoga Calculations
- Dhana Yoga
- Mahapurusha Yoga
- Nabhasha Yoga
- Parivarthana Yoga
- Raja Yoga
- Sannyasa Yoga

#### Additional Features
- Automatic Timezone Detection
- DST Handling
- Ayanamsha Calculations
- Dasha Calculations (Vimshottari)

## Response Format

```json
{
    "chart": {
        "graha": {},        // Planetary positions and attributes
        "lagna": {},        // Ascendant information
        "dasha": {},        // Dasha periods
        "ashtakavarga": {}, // Ashtakavarga calculations
        "grahabala": {},    // Planetary strength
        "rashibala": {},    // Sign strength
        "yogas": {},        // Yoga combinations
        "panchanga": {}     // Panchanga elements
    },
    "duration_of_response": 0.123,
    "created_at": "2023-12-25 12:00:00"
}
```

## Error Handling

In case of errors, the API returns a 500 status code with an error message:

```json
{
    "error": "An internal error occurred"
}
```

## System Requirements

- PHP 7.4 or higher
- Symfony Framework
- Swiss Ephemeris library