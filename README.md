# Anagata Executive

<div align="center">
  <img src="public/assets/hero-sec.png" alt="Anagata Executive - Where Talent Thrives & Culture Elevates" width="600">
</div>

<p align="center">
  <strong>Where Talent Thrives & Culture Elevates</strong>
</p>

---

## Overview

Anagata Executive is a modern, data-driven Human Resources Recruitment Agency platform built with Laravel. We specialize in connecting exceptional talent with remarkable opportunities through cutting-edge technology, data-driven insights, and human expertise. Our platform delivers comprehensive recruitment solutions tailored to organizations' unique needs, from executive leadership placements to specialized talent pipelines.

## Features

### Core Functionality

- **Professional Landing Page**: Elegant, responsive design showcasing our services and value proposition
- **Contact Form Integration**: Secure contact form with Google Sheets integration for lead management
- **Data-Driven Approach**: Leverages analytics and insights for informed recruitment decisions
- **Security First**: Built-in XSS protection, honeypot spam prevention, and input validation
- **Modern UI/UX**: Clean, professional interface with smooth animations and intuitive navigation

### Services Highlighted

- **Executive Search & Leadership Placement**: Specialized recruitment for C-level and senior positions
- **Culture Fit Recruitment**: Matching talent with organizational culture for growing startups
- **Talent Pipeline Development**: Building specialized talent pools for niche roles

## Technology Stack

- **Framework**: Laravel 10.x
- **PHP**: 8.1+
- **Frontend**: Blade Templates, Vanilla JavaScript, Custom CSS
- **Integrations**: 
  - Google Sheets API (for contact form submissions)
  - Google API Client 2.18
- **Security**: Laravel Sanctum, CSRF Protection, Rate Limiting
- **HTTP Client**: Guzzle 7.2+

## Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM (for asset compilation)
- Google Cloud Service Account (for Google Sheets integration)
- Web server (Apache/Nginx) or PHP built-in server

## Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd anagatha-profile
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Configuration

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### 4. Configure Google Sheets Integration

To enable contact form submissions to Google Sheets, configure the following in your `.env` file:

```env
GOOGLE_CREDENTIALS_JSON={"type":"service_account",...}
# OR
GOOGLE_CREDENTIALS_BASE64=<base64-encoded-credentials>
# OR
GOOGLE_CREDENTIALS_PATH=/path/to/credentials.json

GOOGLE_SPREADSHEET_ID=your-spreadsheet-id
GOOGLE_SHEET_NAME=Sheet1
```

Place your Google Service Account credentials JSON file in `storage/app/google/credentials.json` or configure one of the environment variables above.

### 5. Database Setup (if applicable)

```bash
php artisan migrate
```

### 6. Build Assets

```bash
npm run build
# or for development
npm run dev
```

### 7. Start the Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Project Structure

```
anagatha-profile/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ContactController.php    # Handles contact form submissions
│   │   │   └── PageController.php       # Handles page routing
│   │   └── Middleware/                  # CSRF and security middleware
│   └── Services/
│       └── GoogleSheetService.php        # Google Sheets integration service
├── public/
│   ├── assets/
│   │   └── hero-sec.png                 # Hero section image
│   ├── js/
│   │   ├── contact-form.js              # Contact form JavaScript
│   │   └── navbar.js                    # Navigation JavaScript
│   └── styles/
│       └── style.css                    # Main stylesheet
├── resources/
│   └── views/
│       ├── home.blade.php               # Main landing page
│       └── layouts/
│           └── app.blade.php           # Main layout template
└── routes/
    └── web.php                          # Web routes
```

## Security Features

- **XSS Protection**: Comprehensive input sanitization and validation
- **CSRF Protection**: Laravel's built-in CSRF token validation
- **Honeypot Field**: Spam bot detection in contact forms
- **Rate Limiting**: Contact form submissions limited to 5 per minute
- **Input Validation**: Strict validation rules for all user inputs
- **SQL Injection Prevention**: Laravel's Eloquent ORM with parameter binding

## Contact Form

The contact form includes:

- First Name & Last Name validation
- Email validation
- Optional phone number
- Message field (10-2000 characters)
- Automatic submission to Google Sheets
- Toast notifications for user feedback
- Comprehensive error handling

## Deployment

This application is configured for deployment on:

- **Railway**: Includes `railway.json` configuration
- **Render**: Includes `render.yaml` configuration
- **Vercel**: Includes `vercel.json` configuration
- **Docker**: Includes `Dockerfile` and `docker-compose.yml`

### Environment Variables for Production

Ensure the following are set in your production environment:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY` (generated application key)
- Google Sheets credentials (as configured above)
- `GOOGLE_SPREADSHEET_ID`
- `GOOGLE_SHEET_NAME`

## Development

### Code Style

This project uses Laravel Pint for code formatting:

```bash
./vendor/bin/pint
```

### Testing

Run the test suite:

```bash
php artisan test
```

## Contributing

This is a private project for Anagata Executive. For internal contributions, please follow the existing code style and ensure all tests pass before submitting changes.

## License

This project is proprietary software. All rights reserved.

## Support

For technical support or inquiries, please contact the development team.

---

<div align="center">
  <p><strong>Anagata Executive</strong> - Excellence in Talent Acquisition</p>
  <p>Where Data Meet Talent</p>
</div>
