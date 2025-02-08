# Jyotish (Vedic Astrology) API 

A REST API for Jyotish (Vedic Astrology) calculations, built on top of the [kunjara/jyotish](https://github.com/kunjara/jyotish) library. Jyotish API  containerized and provides a wide range of Vedic astrology calculations, including planetary positions, Dashas, Yogas, and more.

## Features

### Chart Calculations

- **Varga (Divisional) Charts**: D1, D2, D3, D4, D7, D9, D10, D12, D16, D20, D24, D27, D30, D40, D45, D60
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

### Additional Features

- **Automatic Timezone Detection**: Adjusts calculations based on the provided location.
- **DST Handling**: Accounts for Daylight Saving Time shifts.
- **Ayanamsha Calculations**: Adjustments for the precession of the equinoxes.
- **Dasha Calculations (Vimshottari)**: Planetary periods analysis.

## Literature

Most of the calculations are based on the following classical texts:

- Maharishi Parashara. Brihat Parashara Hora Shastra.
- Maharishi Jaimini. Jaimini Upadesha Sutras.
- Varahamihira. Brihat Jataka.
- Varahamihira. Brihat Samhita.
- Kalyana Varma. Saravali.
- Satyacharya. Satya Jatakam.
- Kalidas. Uttara Kalamritam.
- Venkatesh Sharma. Sarvarth Chintamani.
- Mantreswara. Phaladeepika.
- Vaidyanatha Dikshita. Jataka Parijata.
- Srimad-Bhagavatam.
- Bhavishya Purana.
- Surya Siddhanta.
- Manu-Samhita.


## Installation

To install and run the Vedic Astrology API locally, follow these steps:

1. **Clone the repository**:

   ```bash
   git clone https://github.com/teal33t/jyotish-api.git
   cd jyotish-api
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

curl -X 'GET' \
  'http://localhost:9393/api/calculate?latitude=28.6139&longitude=77.209&year=2023&month=12&day=25&hour=12&min=0&sec=0&time_zone=Asia%2FTehran&dst_hour=0&dst_min=0&nesting=0&varga=D1%2CD9&infolevel=basic%2Cpanchanga%2Ctransit' \
  -H 'accept: application/json'


#### Example Response

```json
{
  "chart": {
    "user": {
      "datetime": "2023-12-25 12:00:00",
      "timezone": "+05:45",
      "longitude": 77.209,
      "latitude": 28.6139,
      "altitude": 0
    },
    "graha": { 
      "Sy": /* Surya (Sun) calculations */,
      "Ch": /* Chandra (Moon) calculations */,
      "Ma": /* Mangal (Mars) calculations */,
      "Bu": /* Buddha (Mercury) calculations */,
      "Gu": /* Guru (Jupiter) calculations */,
      "Sk": /* Shukra (Benus) calculations */,
      "Sa": /* Shani (Saturn) calculations */,
      "Ra": /* Rahu calculations */,
      "Ke": /* Ketu calculations */,
    },
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
curl -X 'GET' \
  'http://localhost:9393/api/now?latitude=35.708309&longitude=51.38073' \
  -H 'accept: application/json'```

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

## Dependencies

- **Jyotish Library**: [kunjara/jyotish](https://github.com/kunjara/jyotish) for Vedic astrology calculations.
- **Swiss Ephemeris**: [kunjara/swetest](https://github.com/kunjara/swetest) for astronomical data.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request on the repository's GitHub page for any improvements, bug fixes, or new features.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

The Jyotish library used in this project is licensed under the GNU General Public License version 2 or later. See the [Jyotish LICENSE](https://github.com/kunjara/jyotish/blob/master/LICENSE) for more details.

## Contact

For any inquiries, questions, or support, please contact [on Telegram](http://t.me/samanesmaeil).