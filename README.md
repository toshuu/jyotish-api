# Vedic Astrology API

A PHP-based REST API for Vedic astrology calculations, based on [kunjara/jyotish](https://github.com/kunjara/jyotish).
This API is updated, containerized, and provides vedic astrology (jyotish) calculations including planetary positions, Dashas, Yogas, and more.



## Features

### Chart Calculations

- **Varga (Divisional) Charts**: D1 to D60.
- **Planetary Positions**: Detailed positions of planets.
- **Lagna (Ascendant) Calculations**.
- **Nakshatra Positions**: Lunar mansions.

### Advanced Calculations

#### Basic Information

- **Astangata (Combustion)**: Analysis of planets combust due to proximity to the Sun.
- **Rashi Avastha (Planetary Dignity)**: Calculation of planetary dignity in different signs.
- **Vargottama**: Identification of planets occupying the same sign in both Rashi and Navamsa charts.
- **Planetary War (Yuddha)**: Detection of planetary wars when planets are within 1 degree of each other.

#### Panchanga Elements

- **Tithi**: Lunar day calculation.
- **Nakshatra**: Determination of the current lunar mansion.
- **Yoga**: Calculation of the Yoga formed by the positions of the Sun and Moon.
- **Karana**: Half of a Tithi, used in muhurta (electional astrology).
- **Vara**: Day of the week.

#### Strength Calculations

- **Ashtakavarga**: Point-based system to analyze planetary strengths.
- **Graha Bala (Planetary Strength)**: Comprehensive strength analysis of planets.
- **Rashi Bala (Sign Strength)**: Strength of the zodiac signs.

#### Yoga Calculations

- **Dhana Yoga**: Wealth-producing combinations.
- **Mahapurusha Yoga**: Great person yogas formed by certain planetary positions.
- **Nabhasha Yoga**: Yogas based on planetary patterns.
- **Parivarthana Yoga**: Mutual exchange of signs between planets.
- **Raja Yoga**: Combinations indicating power and authority.
- **Sannyasa Yoga**: Combinations indicating renunciation.

#### Additional Features

- **Automatic Timezone Detection**: Adjusts calculations based on the provided location.
- **DST Handling**: Accounts for Daylight Saving Time shifts.
- **Ayanamsha Calculations**: Adjustments for the precession of the equinoxes.
- **Dasha Calculations (Vimshottari)**: Planetary periods analysis.



## Installation

To install and run the Vedic Astrology API locally, follow these steps:

1. **Clone the repository**:

   ```bash
   git clone <repository-url>
   cd <repository-directory>
   ```

2. **Build and start the Docker container**:

   ```bash
   docker-compose up --build -d
   ```

3. **Compile the Swiss Ephemeris library inside the container**:

   ```bash
   docker-compose exec jyotish_api bash -c "cd swetest/src && make clean && make && chmod 777 swetest/src && chmod +x swetest/src/swetest"
   ```

4. **Verify the API is running**:

   Visit [http://localhost:9393/api/ping](http://localhost:9393/api/ping) to check if the API is up and running.

## API Documentation

The API documentation is available via Swagger UI:

- **Swagger UI**: [http://localhost:9393/api/doc](http://localhost:9393/api/doc)

## API Endpoints

### Calculate Chart (`POST /api/calculate`)

Calculates an astrological chart based on provided parameters.

#### Parameters

- `latitude` (float, required): Location latitude (e.g., `28.6139`).
- `longitude` (float, required): Location longitude (e.g., `77.2090`).
- `year` (integer, required): Year for calculation (e.g., `2023`).
- `month` (integer, required): Month for calculation (`1`-`12`).
- `day` (integer, required): Day for calculation (`1`-`31`).
- `hour` (integer, required): Hour for calculation (`0`-`23`).
- `min` (integer, required): Minute for calculation (`0`-`59`).
- `sec` (integer, required): Second for calculation (`0`-`59`).
- `time_zone` (string, optional): Timezone for the calculation (default: `'Asia/Tehran'`).
- `dst_hour` (integer, optional): Daylight Saving Time hours offset (default: `0`).
- `dst_min` (integer, optional): Daylight Saving Time minutes offset (default: `0`).
- `nesting` (integer, optional): Nesting level for calculations (default: `0`).
- `varga` (string, optional): Varga divisions to calculate (comma-separated, default: `'D1'`).
- `infolevel` (string, optional): Information levels to include (comma-separated).

#### Example Request

```json
{
  "latitude": 28.6139,
  "longitude": 77.2090,
  "year": 2023,
  "month": 10,
  "day": 14,
  "hour": 12,
  "min": 30,
  "sec": 0,
  "time_zone": "Asia/Kolkata",
  "dst_hour": 0,
  "dst_min": 0,
  "nesting": 0,
  "varga": "D1,D9",
  "infolevel": "graha,lagna,dasha,yogas"
}
```

#### Example Response

```json
{
  "chart": {
    "graha": { /* Planetary positions and attributes */ },
    "lagna": { /* Ascendant information */ },
    "dasha": { /* Dasha periods */ },
    "ashtakavarga": { /* Ashtakavarga calculations */ },
    "grahabala": { /* Planetary strength */ },
    "rashibala": { /* Sign strength */ },
    "yogas": { /* Yoga combinations */ },
    "panchanga": { /* Panchanga elements */ }
  },
  "duration_of_response": 0.123,
  "created_at": "2023-10-14T12:30:00Z"
}
```

### Current Chart (`GET /api/now`)

Calculates an astrological chart for the current moment.

#### Parameters

- `latitude` (float, optional): Location latitude (default: `35.7219`).
- `longitude` (float, optional): Location longitude (default: `51.3347`).

#### Example Request

```
GET /api/now?latitude=28.6139&longitude=77.2090
```

#### Example Response

```json
{
  "chart": {
    "graha": { /* Planetary positions and attributes */ },
    "lagna": { /* Ascendant information */ },
    "dasha": { /* Dasha periods */ },
    "ashtakavarga": { /* Ashtakavarga calculations */ },
    "grahabala": { /* Planetary strength */ },
    "rashibala": { /* Sign strength */ },
    "yogas": { /* Yoga combinations */ },
    "panchanga": { /* Panchanga elements */ }
  },
  "duration_of_response": 0.098,
  "created_at": "2023-10-14T12:30:00Z"
}
```

## Response Format

Responses from the API are in JSON format. The structure includes:

- **chart**: An object containing detailed astrological data.
  - **graha**: Planetary positions and attributes.
  - **lagna**: Ascendant information.
  - **dasha**: Dasha periods and sub-periods.
  - **ashtakavarga**: Ashtakavarga calculations.
  - **grahabala**: Planetary strength metrics.
  - **rashibala**: Zodiac sign strengths.
  - **yogas**: Identified Yogas and their descriptions.
  - **panchanga**: Panchanga elements like Tithi, Nakshatra, etc.
- **duration_of_response**: Time taken to generate the response (in seconds).
- **created_at**: Timestamp of when the response was generated.

## Error Handling

In case of errors, the API returns an appropriate HTTP status code along with an error message.

- **400 Bad Request**: Invalid input parameters.

  ```json
  {
    "error": "Invalid latitude value"
  }
  ```

- **500 Internal Server Error**: Internal processing error.

  ```json
  {
    "error": "An internal error occurred"
  }
  ```

## System Requirements

- **PHP 7.4** or higher.
- **Symfony Framework**.
- **Swiss Ephemeris library**: For astronomical calculations.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request on the repository's GitHub page for any improvements, bug fixes, or new features.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contact

For any inqueries, questions or support, please contact [support@example.com](mailto:support@example.com).

---

Feel free to suggest any improvements or additional features you'd like to see in the API.