## Laravel NCBA Package by [Akika Digital](https://akika.digital)

## Installation

You can install the package via composer:

```bash
composer require akika/laravel-ncba
```

After installing the package, publish the configuration file using the following command:

```bash
php artisan ncba:install
```

This will import ncba.php config file in your project config directory where you can set your NCBA related parameters and other configuration options.

## .env file Setup

Add the following configurations into the .env file

```bash
NCBA_ENV=
NCBA_DEBUG=
NCBA_SANDBOX_API_KEY=
NCBA_API_KEY=
```

Note:

- `NCBA_ENV` - This value is either sandbox or production. This config variable - This is required to enable Laravel NCBA pick the required variables.
- `NCBA_DEBUG` - This value is true or false. If true, the app will write debug logs.
- `NCBA_SANDBOX_API_KEY` - The provided sandbox API Key. Contact NCBA for this key.
- `NCBA_API_KEY` - You will reveive this key after you are fully onboarded onto NCBA Online Banking API.

## Function Responses

All responses, except health checker API, return a json string. The health checker API returns a string.
