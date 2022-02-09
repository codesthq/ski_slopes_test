# Ski Slopes Manager Demo

Requirements:
PHP 8.1
PostgreSQL 13

This is a Back-end demo including only basic views without any styling.

Administration panel is accessible from /admin url. It requires you to be logged in.

To create account with admin privileges use this command:

    php bin/console app:create-user <username> <password>

Project uses Google reCAPTCHA v3. Make sure to include your sitekey in .env file.

    RECAPTCHA_SITEKEY=your_sitekey

results.txt file contains additional SQL Queries.

