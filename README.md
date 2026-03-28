# kevin-website

## Video player mapping

- `video-player-2.html` — universal video player for all site sections. Loads videos from admin uploads and static libraries using `?video=<id>` or `?type=<category>&video=<id>` query.

All site sections now use the universal `video-player-2.html` player.

To test locally, run a simple static server (examples below) and place MP4s in the `videos/` folder matching the keys used in the HTML.

Start a quick local server (Python 3):

```powershell
python -m http.server 8000
```

Then open `http://localhost:8000/hack%20videos.html` (or the other pages) in your browser.

## Docker Setup (PHP + MySQL Backend)

To run the full backend with PHP and MySQL using Docker:

1. Ensure Docker and Docker Compose are installed.

2. Run the following command in the project root:

```bash
docker-compose up -d
```

This will start:
- MySQL database on port 3306
- PHP/Apache server on port 8080
- phpMyAdmin on port 8081

3. Access the website at `http://localhost:8080`

4. Access phpMyAdmin at `http://localhost:8081` (login with user: `kevin_user`, password: `kevin_password`)

5. The database will be initialized with the `kevin_website` database, user `kevin_user`, and password `kevin_password`.

6. Import the database schema from `db_schema.sql` into the MySQL database to create the required tables.

7. Test the database connection by visiting `http://localhost:8080/test_db.php`

6. To stop the services:

```bash
docker-compose down
```

Note: Update `api/config.php` environment variables if you change the Docker configuration.