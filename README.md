# Movie App Laravel

A Laravel-based movie management API with full CRUD operations.

## Features

- **Movie Management**: Create, read, update, and delete movies
- **Search Functionality**: Search movies by title, description, genre, or director
- **Pagination**: Built-in pagination for movie listings
- **RESTful API**: Clean REST API endpoints

## Database Configuration

The application is configured to use your MySQL database:
- **Host**: 34.41.129.155
- **Database**: movie-app
- **Username**: onkarko
- **Password**: Onkar8087@

## API Endpoints

### Movies

- `GET /api/movies` - Get all movies (with pagination and search)
- `GET /api/movies/{id}` - Get a specific movie
- `POST /api/movies` - Create a new movie
- `PUT /api/movies/{id}` - Update a movie
- `DELETE /api/movies/{id}` - Delete a movie

### Query Parameters

- `search` - Search movies by title, description, genre, or director
- `per_page` - Number of movies per page (default: 10)

## Movie Data Structure

```json
{
  "title": "Movie Title",
  "description": "Movie description",
  "genre": "Action",
  "release_year": 2024,
  "rating": 8.5,
  "director": "Director Name",
  "poster_url": "https://example.com/poster.jpg"
}
```

## Running the Application

1. **Install Dependencies**:
   ```bash
   composer install
   ```

2. **Configure Environment**:
   The `.env` file is already configured with your database settings.

3. **Run Migrations**:
   ```bash
   php artisan migrate
   ```

4. **Start the Server**:
   ```bash
   php artisan serve --host=127.0.0.1 --port=8000
   ```

5. **Access the API**:
   - Base URL: `http://127.0.0.1:8000/api`
   - Example: `http://127.0.0.1:8000/api/movies`

## Example API Calls

### Get all movies
```bash
curl http://127.0.0.1:8000/api/movies
```

### Search movies
```bash
curl "http://127.0.0.1:8000/api/movies?search=action"
```

### Create a movie
```bash
curl -X POST http://127.0.0.1:8000/api/movies \
  -H "Content-Type: application/json" \
  -d '{
    "title": "The Matrix",
    "description": "A computer hacker learns from mysterious rebels about the true nature of his reality.",
    "genre": "Sci-Fi",
    "release_year": 1999,
    "rating": 8.7,
    "director": "Lana Wachowski",
    "poster_url": "https://example.com/matrix.jpg"
  }'
```

### Update a movie
```bash
curl -X PUT http://127.0.0.1:8000/api/movies/1 \
  -H "Content-Type: application/json" \
  -d '{
    "title": "The Matrix Reloaded",
    "description": "Neo and the rebel leaders estimate they have 72 hours until 250,000 probes discover Zion.",
    "genre": "Sci-Fi",
    "release_year": 2003,
    "rating": 7.2,
    "director": "Lana Wachowski"
  }'
```

### Delete a movie
```bash
curl -X DELETE http://127.0.0.1:8000/api/movies/1
```

## Response Format

All API responses follow this format:

```json
{
  "success": true,
  "data": [...],
  "pagination": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 10,
    "total": 50
  }
}
```

## Error Responses

```json
{
  "success": false,
  "message": "Error message",
  "errors": {
    "field": ["Validation error message"]
  }
}
```

## Technologies Used

- **Laravel 12** - PHP framework
- **MySQL** - Database
- **JWT Auth** - Authentication (configured but not used in current version)
- **Eloquent ORM** - Database operations
