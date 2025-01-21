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

Add the following configurations into your .env file

```bash
NCBA_ENV= # This value is either sandbox or production. This config variable - This is required to enable Laravel NCBA pick the required variables.
NCBA_DEBUG= # This value is true or false. If true, the app will write debug logs.
NCBA_SANDBOX_API_KEY= #The provided sandbox API Key. Contact NCBA for this key.
NCBA_API_KEY= # You will reveive this key after you are fully onboarded onto NCBA Online Banking API.
```

## Function Responses

[Check API Health](#check-api-health) returns a String while all the others return a JSON String.

## Usage

### Initialize NCBA

```php
use Akika\LaravelNcba\Ncba;

$ncba = new Ncba();
$ncba = new Ncba($bankCode, $branchCode, $country, $currency);
```

NCBA class can be initialized in either of the 2 ways shown above. However, to perform a transaction, use the second initialization formula.

```php
$bankCode # Bank specific code
$branchCode # Branch specific code
$country # Country name in full e.g. Kenya
$currency # Currency code e.g. KES
```

### Check API Health

```php
$ncba = new Ncba();
$ncba->checkApiHealth();
```

#### Response

Returns a String response, either `Healthy` or `Not Healthy`.

### Check Transaction Status

```php
$ncba = new Ncba();
$response = $ncba->checkTransactionStatus($referenceNumber);
```

### MPesa Phone Number Validation

```php
$ncba = new Ncba();
$response = $ncba->mpesaNumberValidation($phoneNumber, $reference);
```

### Send Money to Another NCBA Customer

```php
$ncba = new Ncba($bankCode, $branchCode, $country, $currency);
$response = $ncba->ift($beneficiaryAccountName, $reference, $account, $amount, $narration);
```

### Send Money to a Non-NCBA Customer

```php
$ncba = new Ncba($bankCode, $branchCode, $country, $currency);
$response = $ncba->eft($beneficiaryAccountName, $reference, $account, $amount, $narration);
```

### Send Money via RTGS

```php
$ncba = new Ncba($bankCode, $branchCode, $country, $currency);
$response = $ncba->rtgs($beneficiaryAccountName, $account, $amount, $purposeCode, $reference, $narration);
```

### Send Money via Pesalink

```php
$ncba = new Ncba($bankCode, $branchCode, $country, $currency);
$response = $ncba->pesalink($beneficiaryAccountName, $reference, $account, $amount, $narration);
```

## License

The Laravel NCBA package is open-sourced software licensed under the MIT license. See the LICENSE file for details.
