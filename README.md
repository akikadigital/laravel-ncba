## Laravel NCBA Package by [Akika Digital](https://akika.digital)

The Laravel NCBA package allows you to transfer money through the NCBA Open Banking APIs. The package supports Laravel version 5 and above.

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

## Package Upgrade

To upgrade Laravel NCBA Package to the latest version, run the following command

```bash
composer update akika/laravel-ncba
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

#### Success Response

Below is a sample result for a successful transaction.

```php
{
    "Code": "000",
    "Description": "Success",
    "Transaction": {
        "Currency": "KES",
        "Amount": "100",
        "Date": "1/24/2025 12:37:21 PM",
        "AccountNumber": "7810710012",
        "Narrative": "Other",
        "CustomerReference": "250124093719",
        "CBSReference": "FTC250124JEQS",
        "ThirdPartyReference": null,
        "Status": "PASSED",
        "ThirdPartyStatus": null
    }
}
```

### MPesa Phone Number Validation

```php
$ncba = new Ncba();
$response = $ncba->mpesaNumberValidation($phoneNumber, $reference);
```

### Send Money to Another NCBA Customer (Internal Transfer)

```php
$ncba = new Ncba($bankCode, $branchCode, $country, $currency);

$response = $ncba->ift($account, $beneficiaryAccountName, $amount, $narration, $reference);
```

### Send Money to a Non-NCBA Customer (External Transfer)

```php
$ncba = new Ncba($bankCode, $branchCode, $country, $currency);

$response = $ncba->eft($account, $beneficiaryAccountName, $amount, $narration, $reference);
```

### Send Money via RTGS (External Transfer)

```php
$ncba = new Ncba($bankCode, $branchCode, $country, $currency);

$response = $ncba->rtgs($account, $beneficiaryAccountName, $amount, $purposeCode, $narration, $reference);
```

### Send Money via Pesalink (External Transfer)

```php
$ncba = new Ncba($bankCode, $branchCode, $country, $currency);

$response = $ncba->pesalink($account, $beneficiaryAccountName, $amount, $narration, $reference);
```

### Send Money To Mobile via M-Pesa

```php
$ncba = new Ncba($bankCode, $branchCode, $country, $currency);

$response = $ncba->mpesa($account, $beneficiaryAccountName, $amount, $transactionId, $narration, $reference);
```

## Sample Responses

### Successful Transaction Sample Response

```bash
{
   "Response Code":0,
   "Reference":"FTC250124JEQT",
   "Description":"Success"
}
```

### Unsuccessful Transaction Sample Response

```bash
{
    "Response Code":11,
    "Reference":"DUPLICATE | FTC210920APDH",
    "Description":"ERROR"
}
```

### Transaction Status API Response

```php
{
    "Code": "000",
    "Description": "Success",
    "Transaction": {
        "Currency": "KES",
        "Amount": "100",
        "Date": "1/24/2025 12:37:21 PM",
        "AccountNumber": "7810710012",
        "Narrative": "Other",
        "CustomerReference": "250124093719",
        "CBSReference": "FTC250124JEQS",
        "ThirdPartyReference": null,
        "Status": "PASSED",
        "ThirdPartyStatus": null
    }
}
```

## License

The Laravel NCBA package is open-sourced software licensed under the MIT license. See the LICENSE file for details.
