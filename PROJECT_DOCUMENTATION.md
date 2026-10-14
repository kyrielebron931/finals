# Folioform Project Documentation

## Project Title

Folioform: Portfolio Template Generator

## Project Description

Folioform is a web application for creating and publishing personal portfolios. Users register and sign in, enter contact and biography details, add education, skills, projects, work experience, and social links, then choose a design and preview a shareable portfolio. Portfolio owners can edit or delete their portfolios from a private dashboard.

## Technologies Used

| Area | Technology |
| --- | --- |
| Backend framework | Laravel 13 |
| Server language | PHP 8.4 |
| Front end | Blade templates, HTML, custom CSS, and browser JavaScript |
| Asset tooling | Vite |
| Web server | Nginx |
| PHP process manager | PHP-FPM, managed by Supervisor |
| Containerization | Docker |
| Source control | Git and GitHub |

## Database Platform

The production database is PostgreSQL, provided by Railway and connected to the Laravel service using `DB_CONNECTION=pgsql` and `DB_URL`. Local development and automated tests use SQLite.

## Hosting and Deployment

- Hosting platform: Railway
- Source repository: [github.com/kyrielebron931/finals](https://github.com/kyrielebron931/finals)
- Production app service: `finals`
- Production database service: `Postgres`
- Deployment method: Railway builds the repository's Dockerfile. The container runs Nginx and PHP-FPM; its startup script creates the public-storage link and runs database migrations.
- Public URL: [https://folioform.up.railway.app](https://folioform.up.railway.app)

The public URL returned HTTP 200 during the latest verification on October 14, 2026. Recheck the link when submitting this report because deployment status can change.

## Database Structure

### `users`

Stores account and authentication data.

| Column | Purpose |
| --- | --- |
| `id` | Primary key |
| `name` | Account holder's name |
| `email` | Unique login email |
| `email_verified_at` | Optional email-verification timestamp |
| `password` | Hashed account password |
| `remember_token` | Persistent login token |
| `created_at`, `updated_at` | Record timestamps |

### `portfolios`

Stores portfolio details. Each portfolio belongs to one user; deleting the owner cascades to their portfolios. The unique `slug` is used for the public share URL.

| Column | Type / purpose |
| --- | --- |
| `id` | Primary key |
| `user_id` | Foreign key to `users.id`, cascade on delete |
| `slug` | Unique public identifier |
| `full_name` | Display name |
| `profile_picture` | Nullable path to an uploaded image |
| `email` | Public contact email |
| `contact_number`, `address` | Optional contact details |
| `about` | Optional biography text |
| `education` | Nullable JSON array of education entries |
| `skills` | Nullable JSON array of skills |
| `projects` | Nullable JSON array of projects |
| `experience` | Nullable JSON array of work entries |
| `links` | Nullable JSON array of social or website links |
| `template` | Selected design: `simple`, `modern`, or `creative`; defaults to `simple` |
| `created_at`, `updated_at` | Record timestamps |

### Laravel support tables

The migrations also create `password_reset_tokens` for password reset, `sessions` for database-backed sessions, `cache` and `cache_locks` for database cache, and `jobs`, `job_batches`, and `failed_jobs` for queue processing.

## Portfolio Templates

1. **Simple**: A clean, minimal layout focused on biography and work history.
2. **Modern**: A structured, card-based layout with a prominent profile area and project sections.
3. **Creative**: A dark editorial layout with expressive typography and accent colors.

All templates use the same saved portfolio data; selecting another template changes the presentation, not the content.

## Main User Flow

1. Open the home page and create an account or sign in.
2. Create a portfolio and enter personal details, education, skills, projects, experience, and links.
3. Save the information to PostgreSQL.
4. Choose one of the three templates and preview the result.
5. Share the public `/p/{slug}` URL.
6. Return to the dashboard to edit or delete the portfolio.

Portfolio management routes require authentication and verify ownership. Public portfolio pages are viewable by anyone with the share URL.

## Screenshots for Submission

Add actual screenshots from the running site for each item below. Do not include account passwords, database URLs, application keys, or other secrets in screenshots.

| Suggested file name | Screen to capture |
| --- | --- |
| `home.png` | Home page with the create-portfolio button |
| `register.png` | Registration form |
| `login.png` | Login form |
| `dashboard.png` | Portfolio management page |
| `portfolio-form.png` | Information form with its sections |
| `template-selection.png` | Page showing all three template choices |
| `template-simple.png` | Generated portfolio using Simple |
| `template-modern.png` | Generated portfolio using Modern |
| `template-creative.png` | Generated portfolio using Creative |

## Verification

- Automated tests: `php artisan test` (6 tests pass).
- Production container: Docker build succeeds; Nginx and PHP-FPM start, and the Laravel `/up` health endpoint returns HTTP 200 with Railway's target port configuration.
- Live URL: verified at the time noted above.