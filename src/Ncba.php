<?php

namespace Akika\LaravelNcba;

use Akika\LaravelNcba\Traits\NcbaConnect;

class Ncba
{
    use NcbaConnect;

    public $environment;
    public $debugMode;
    public $url;

    public $apiKey;
    public $username;
    public $password;

    /**
     * constructor.
     * @param $apiKey
     * @param $username
     * @param $password
     */

    public function __construct($apiKey, $username, $password)
    {
        $this->apiKey = $apiKey;
        $this->username = $username;
        $this->password = $password;

        $this->environment = config('ncba.env');
        $this->debugMode = config('ncba.debug');
        $this->url = config('ncba.' . $this->environment . '.legacy_url');
    }

    /**
     * Authenticate account
     * @return mixed
     */

    public function authenticate()
    {
        $body = [
            'userID' => $this->username,
            'password' => $this->password
        ];

        $result = $this->makeAuthRequest($this->apiKey, $this->url . '/Auth/generate-token', $body);

        if ($this->debugMode) {
            info('------------------- Authenticate -------------------');
            info('authenticate request: ' . json_encode($body));
            info('authenticate result: ' . $result);
        }

        return $result;
    }

    /**
     * Get account balance
     * @param $apiToken - the API token
     * @param $countryCode - the country code
     * @param $accountNo - the account number
     */

    public function accountDetails($apiToken, $countryCode, $accountNo)
    {
        $body = [
            'country' => $countryCode,
            'accountNo' =>  $accountNo
        ];

        $result = $this->makeRequest($this->apiKey, $apiToken, $this->url . '/AccountDetails/accountdetails', $body);

        if ($this->debugMode) {
            info('------------------- Get Account Details -------------------');
            info('getAccountDetails request: ' . json_encode($body));
            info('getAccountDetails result: ' . $result);
        }

        return $result;
    }

    /**
     * Get account balance
     * @param $apiToken - the API token
     * @param $countryCode - the country code
     * @param $accountNo - the account number
     */

    public function miniStatement($apiToken, $countryCode, $accountNo)
    {
        $body = [
            'Country' => $countryCode,
            'AccountNo' =>  $accountNo
        ];

        $result = $this->makeRequest($this->apiKey, $apiToken, $this->url . '/AccountMiniStatement/accountministatement', $body);

        if ($this->debugMode) {
            info('------------------- Mini Statement -------------------');
            info('miniStatement request: ' . json_encode($body));
            info('miniStatement result: ' . $result);
        }

        return $result;
    }

    /**
     * Get account statement for a given period
     * @param $apiToken - the API token
     * @param $countryCode - the country code
     * @param $accountNo - the account number
     * @param $fromDate - the start date
     * @param $toDate - the end date
     */

    public function accountStatement($apiToken, $countryCode, $accountNo, $fromDate, $toDate)
    {
        $body = [
            'Country' => $countryCode,
            'AccountNo' =>  $accountNo,
            'FromDate' => $fromDate,
            'ToDate' => $toDate
        ];

        $result = $this->makeRequest($this->apiKey, $apiToken, $this->url . '/AccountStatement/accountstatement', $body);

        if ($this->debugMode) {
            info('------------------- Account Statement -------------------');
            info('accountStatement request: ' . json_encode($body));
            info('accountStatement result: ' . $result);
        }

        return $result;
    }

    /**
     * Allows sending money to a bank account via IFT
     * @param $apiToken - the API token
     * @param $country - (Kenya/Uganda/Tanzania/Rwanda)
     * @param $transactionID - the transaction ID
     * @param $beneficiaryAccountNumber - the credit account number
     * @param $beneficiaryAccountName - the beneficiary account name
     * @param $senderAccountNumber - the debit account number
     * @param $currency - the currency code e.g. (KES/UGX/TZS/USD,GBP/EUR)
     * @param $amount - the amount to send
     * @param $narration - the narration
     */

    public function ift($apiToken, $country, $transactionID, $beneficiaryAccountNumber, $beneficiaryAccountName, $senderAccountNumber, $currency, $amount, $narration)
    {
        $body = [
            "Country" => $country,
            "TransactionID" => $transactionID,
            "BeneficiaryAccountName" => $beneficiaryAccountName,
            "DebitAccountNumber" => $senderAccountNumber,
            "CreditAccountNumber" => $beneficiaryAccountNumber,
            "Currency" => $currency,
            "Amount" => $amount,
            "Narration" => $narration
        ];

        $result = $this->makeRequest($this->apiKey, $apiToken, $this->url . '/IFTTransaction/ifttransaction', $body);

        if ($this->debugMode) {
            info('------------------- IFT -------------------');
            info('ift request: ' . json_encode($body));
            info('ift result: ' . $result);
        }

        return $result;
    }

    /**
     * Allows sending money to a bank account via EFT
     * @param $apiToken - the API token
     * @param $amount - the amount to send
     * @param $beneficiaryAccountNumber - the beneficiary account number
     * @param $beneficiaryBankBic - the beneficiary bank BIC
     * @param $beneficiaryName - the beneficiary name
     * @param $currency - the currency code e.g. KES
     * @param $senderAccountNumber - the debit account number
     * @param $narration - the narration
     * @param $senderCountry - the sender country code
     * @param $transactionID - the transaction ID
     * @param $senderCIF - the sender CIF
     */

    public function eft($apiToken, $amount, $beneficiaryAccountNumber, $beneficiaryBankBic, $beneficiaryName, $currency, $senderAccountNumber, $narration, $senderCountry, $transactionID, $senderCIF)
    {
        $body = [
            "Amount" => $amount,
            "BeneficiaryAccountNumber" => $beneficiaryAccountNumber,
            "BeneficiaryBankBIC" => $beneficiaryBankBic, // "01096"
            "BeneficiaryName" => $beneficiaryName,
            "Currency" => $currency,
            "DebitAccountNumber" => $senderAccountNumber,
            "Narration" => $narration,
            "SenderCountry" => $senderCountry,
            "TransactionID" => $transactionID,
            "SenderCIF" => $senderCIF
        ];

        // $beneficiaryBankBic must be numeric and not more than 5 characters
        if (!is_numeric($beneficiaryBankBic) || strlen($beneficiaryBankBic) > 5) {
            return [
                'status' => 'error',
                'message' => 'Beneficiary Bank BIC must be numeric and not more than 5 characters'
            ];
        }

        // $senderCIF must be numeric and not more than 6 characters
        if (!is_numeric($senderCIF) || strlen($senderCIF) > 6) {
            return [
                'status' => 'error',
                'message' => 'Sender CIF must be numeric and not more than 6 characters'
            ];
        }

        $result = $this->makeRequest($this->apiKey, $apiToken, $this->url . '/EFTTransaction/efttransaction', $body);

        if ($this->debugMode) {
            info('------------------- EFT -------------------');
            info('eft request: ' . json_encode($body));
            info('eft result: ' . $result);
        }

        return $result;
    }

    /**
     * Allows sending money to a bank account via RTGS
     * @param $apiToken - the API token
     * @param $beneficiaryAccountNumber - the beneficiary account number
     * @param $beneficiaryBankBIC - the beneficiary bank BIC
     * @param $beneficiaryBankName - the beneficiary bank name
     * @param $beneficiaryCountry - the beneficiary country code - (Country- KE/UG/TZ/RW)
     * @param $beneficiaryName - the beneficiary name
     * @param $creditAmount - the amount to send - (Amount in whole numbers, no odd cents)
     * @param $creditCurrency - the currency code e.g. KES
     * @param $debitCurrency - the currency code e.g. KES
     * @param $narration - the narration
     * @param $senderAccountNumber - the sender account number
     * @param $senderCIF - the sender CIF - (Customer number – first 6 digits of the sender account number or any other assigned customer number as guided by NCBA)
     * @param $senderCountry - the sender country code - (Country- KE/UG/TZ/RW)
     * @param $senderName - the sender name
     * @param $purposeCode - the purpose of payment code - (Purpose of Payment Code – List to be provided by Bank)
     * @param $transactionID - the transaction ID - (Alphanumeric Unique Reference)
     */

    public function rtgs($apiToken, $beneficiaryAccountNumber, $beneficiaryBankBIC, $beneficiaryBankName, $beneficiaryCountry, $beneficiaryName, $creditAmount, $creditCurrency, $debitCurrency, $narration, $senderAccountNumber, $senderCIF, $senderCountry, $senderName, $purposeCode, $transactionID)
    {
        $body = [
            "BeneficiaryAccountNumber" => $beneficiaryAccountNumber,
            "BeneficiaryBankBIC" => $beneficiaryBankBIC,
            "BeneficiaryBankName" => $beneficiaryBankName,
            "BeneficiaryCountry" => $beneficiaryCountry,
            "BeneficiaryName" => $beneficiaryName,
            "CreditAmount" => $creditAmount,
            "DebitCurrency" => $debitCurrency,
            "CreditCurrency" => $creditCurrency,
            "Narration" => $narration,
            "SenderAccountNumber" => $senderAccountNumber,
            "SenderCIF" => $senderCIF,
            "SenderCountry" => $senderCountry,
            "SenderName" => $senderName,
            "PurposeCode" => $purposeCode,
            "TransactionID" => $transactionID
        ];

        // amount must be > 50
        if ($creditAmount < 50) {
            return [
                'status' => 'error',
                'message' => 'Amount must be greater than 50'
            ];
        }

        $result = $this->makeRequest($this->apiKey, $apiToken, $this->url . '/RTGSPayment/RTGSPayment', $body);

        if ($this->debugMode) {
            info('------------------- RTGS -------------------');
            info('rtgs request: ' . json_encode($body));
            info('rtgs result: ' . $result);
        }

        return $result;
    }

    /**
     * Allows sending money to a bank account via PesaLink
     * @param $apiToken - the API token
     * @param $beneficiaryAccountNumber - the beneficiary account number
     * @param $beneficiaryBankBIC - the beneficiary bank BIC
     * @param $beneficiaryName - the beneficiary name
     * @param $amount - the amount to send
     * @param $currency - the currency code e.g. KES
     * @param $narration - the narration
     * @param $senderAccountNumber - the sender account number
     * @param $senderCIF - the sender CIF
     * @param $senderCountry - the sender country code
     * @param $transactionID - the transaction ID
     */

    public function pesalink($apiToken, $beneficiaryAccountNumber, $beneficiaryBankBIC, $beneficiaryName, $amount, $currency, $narration, $senderAccountNumber, $senderCIF, $senderCountry, $transactionID)
    {
        $body = [
            "BeneficiaryAccountNumber" => $beneficiaryAccountNumber,
            "BeneficiaryBankBIC" => $beneficiaryBankBIC,
            "BeneficiaryName" => $beneficiaryName,
            "Amount" => $amount,
            "Currency" => $currency,
            "Narration" => $narration,
            "SenderAccountNumber" => $senderAccountNumber,
            "SenderCIF" => $senderCIF,
            "SenderCountry" => $senderCountry,
            "TransactionID" => $transactionID
        ];

        // amount must be > 50
        if ($amount < 100) {
            return [
                'status' => 'error',
                'message' => 'Amount must be greater than 50'
            ];
        }

        $result = $this->makeRequest($this->apiKey, $apiToken, $this->url . '/PesaLinkTransaction/pesaLinktransaction', $body);

        if ($this->debugMode) {
            info('------------------- PesaLink -------------------');
            info('pesalink request: ' . json_encode($body));
            info('pesalink result: ' . $result);
        }

        return $result;
    }

    public function mpesa() {}
}
