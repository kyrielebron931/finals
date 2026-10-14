# Folioform Project Documentation

## Project Title

Folioform: Online Portfolio Generator

## Project Description

Folioform is a web application that lets users register, create, edit, and share personal portfolios. Users add contact information, a profile photo, biography, education, skills, projects, work experience, and social or website links. They select one of three designs (Simple, Modern, or Creative), preview the portfolio, and share its public link. Owners can manage their portfolios from a private dashboard.

## Technologies Used

1. PHP 8.4
2. Laravel 13
3. Blade templates
4. HTML, CSS, and JavaScript
5. Vite for frontend asset tooling; Tailwind CSS is included in the asset setup, while the portfolio screens primarily use custom CSS.
6. PostgreSQL for the production database; SQLite for local development and automated tests.
7. Git and GitHub for source control.
8. Docker, Nginx, PHP-FPM, and Supervisor for the production web container.
9. Railway for hosting, deployment, and managed PostgreSQL.

## Database Platform

PostgreSQL, hosted as a Railway Postgres service. The Laravel application connects using `DB_CONNECTION=pgsql` and `DB_URL`.

## Hosting/Deployment Platform

Railway hosts the Laravel web application and PostgreSQL database. Railway builds the repository's Dockerfile. The container runs Nginx and PHP-FPM, creates Laravel's public-storage link, and runs database migrations during startup.

GitHub repository: [github.com/kyrielebron931/finals](https://github.com/kyrielebron931/finals)

## Database Structure

1. **`users`**: Registered accounts with an auto-incrementing numeric `id`, name, unique email, hashed password, optional email verification timestamp, remember token, and timestamps.
2. **`portfolios`**: Portfolio owner (`user_id` foreign key), unique public `slug`, full name, profile-photo file path, email, contact number, address, biography, selected template, and timestamps. The portfolio primary key is an auto-incrementing numeric `id`, not a UUID.
3. **Portfolio content fields**: `education`, `skills`, `projects`, `experience`, and `links` are JSON columns containing their respective entries.
4. **`sessions`**: Session records used to maintain signed-in users.
5. **Supporting tables**: `password_reset_tokens`, `cache`, `cache_locks`, `jobs`, `job_batches`, and `failed_jobs` are created by Laravel's migrations.

Profile photos are stored as files on Laravel's public storage disk. The `portfolios.profile_picture` column stores the file path, not the image data. A Railway volume mounted at `/var/www/html/storage/app/public` keeps uploaded images across deploys and restarts.

## Screenshots of the System

Insert screenshots captured from the running website:

- Home page
- Registration and login pages
- Portfolio dashboard/manage page
- Portfolio information form
- Template selection page
- Portfolio preview and public portfolio page

## Screenshots of the 3 Templates

Insert one generated-portfolio screenshot for each design:

1. Simple: clean, minimal, professional layout.
2. Modern: structured layout with card-like sections and visual emphasis.
3. Creative: dark editorial styling with expressive typography and accent colors.

## Published Website URL

https://folioform.up.railway.app/