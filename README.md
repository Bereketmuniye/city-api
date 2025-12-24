# City API

A basic Laravel CRUD REST API for managing City resources using in-memory storage (no database required).

## Features

- ✅ Full CRUD operations (Create, Read, Update, Delete)
- ✅ In-memory storage (no database setup needed)
- ✅ RESTful API endpoints
- ✅ Input validation
- ✅ JSON responses
- ✅ Pre-populated with sample data

## Requirements

- PHP >= 8.2
- Composer
- Laravel 12.x

## Publishing to GitHub

The repository is already initialized with Git. To publish it to GitHub:

1. Create a new repository on GitHub (do not initialize with README, .gitignore, or license)

2. Add the remote and push:
```bash
git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO_NAME.git
git branch -M main
git push -u origin main
```

Replace `YOUR_USERNAME` and `YOUR_REPO_NAME` with your actual GitHub username and repository name.

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd city-api
```

2. Install dependencies:
```bash
composer install
```

3. Generate application key:
```bash
php artisan key:generate
```

4. Start the development server:
```bash
php artisan serve
```

## Base URL

**Base URL:** `http://localhost:8000/api` (default)

The base URL is configured in the following places:

1. **`.env` file** - Set `APP_URL=http://localhost:8001` (or your desired port)
2. **`config/app.php`** (line 55) - Reads `APP_URL` from environment
3. **`config/api.php`** - API-specific configuration that combines `APP_URL` + `/api`

**To change the port:**
- Start server with custom port: `php artisan serve --port=8001`
- Update `.env` file: `APP_URL=http://localhost:8001`
- Base URL will be: `http://localhost:8001/api`

All API endpoints are prefixed with `/api`.

## API Endpoints

### 1. Get All Cities
**GET** `/api/cities`

Returns a list of all cities.

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "New York",
      "country": "USA",
      "population": 8336817,
      "description": "The most populous city in the United States"
    },
    ...
  ]
}
```

### 2. Get Single City
**GET** `/api/cities/{id}`

Returns a specific city by ID.

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "New York",
    "country": "USA",
    "population": 8336817,
    "description": "The most populous city in the United States"
  }
}
```

**Error Response (404):**
```json
{
  "success": false,
  "message": "City not found"
}
```

### 3. Create City
**POST** `/api/cities`

Creates a new city.

**Request Body:**
```json
{
  "name": "Paris",
  "country": "France",
  "population": 2161000,
  "description": "Capital city of France"
}
```

**Required Fields:**
- `name` (string, max 255 characters)
- `country` (string, max 255 characters)

**Optional Fields:**
- `population` (integer, min 0)
- `description` (string)

**Response (201):**
```json
{
  "success": true,
  "message": "City created successfully",
  "data": {
    "id": 4,
    "name": "Paris",
    "country": "France",
    "population": 2161000,
    "description": "Capital city of France"
  }
}
```

**Error Response (422):**
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "name": ["The name field is required."]
  }
}
```

### 4. Update City
**PUT/PATCH** `/api/cities/{id}`

Updates an existing city. All fields are optional (partial update supported).

**Request Body:**
```json
{
  "name": "New York City",
  "population": 8500000
}
```

**Response:**
```json
{
  "success": true,
  "message": "City updated successfully",
  "data": {
    "id": 1,
    "name": "New York City",
    "country": "USA",
    "population": 8500000,
    "description": "The most populous city in the United States"
  }
}
```

**Error Response (404):**
```json
{
  "success": false,
  "message": "City not found"
}
```

### 5. Delete City
**DELETE** `/api/cities/{id}`

Deletes a city by ID.

**Response:**
```json
{
  "success": true,
  "message": "City deleted successfully"
}
```

**Error Response (404):**
```json
{
  "success": false,
  "message": "City not found"
}
```

## Example Usage

### Using cURL

**Get all cities:**
```bash
curl http://localhost:8000/api/cities
```

**Create a city:**
```bash
curl -X POST http://localhost:8000/api/cities \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Berlin",
    "country": "Germany",
    "population": 3677472,
    "description": "Capital city of Germany"
  }'
```

**Get a specific city:**
```bash
curl http://localhost:8000/api/cities/1
```

**Update a city:**
```bash
curl -X PUT http://localhost:8000/api/cities/1 \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Updated City Name",
    "population": 9000000
  }'
```

**Delete a city:**
```bash
curl -X DELETE http://localhost:8000/api/cities/1
```

## Storage

This API uses **in-memory storage**, which means:
- Data is stored in a static array within the controller
- Data persists only during the application's runtime
- Data is lost when the server restarts
- No database configuration or migrations are required

The API comes pre-populated with 3 sample cities:
1. New York, USA
2. London, United Kingdom
3. Tokyo, Japan

## Project Structure

```
app/
├── Http/
│   └── Controllers/
│       └── CityController.php    # Main CRUD controller
└── Models/
    └── City.php                   # City model class

routes/
└── api.php                        # API routes

bootstrap/
└── app.php                        # Application configuration
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
