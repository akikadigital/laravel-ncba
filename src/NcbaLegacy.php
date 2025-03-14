<?php

namespace Akika\LaravelNcba;

use Akika\LaravelNcba\Traits\NcbaConnect;

class NcbaLegacy
{
    use NcbaConnect;

    public $environment;
    public $debugMode;
    public $url;

    public $apiKey;
    public $username;
    public $password;
    public $apiToken;

    /**
     * NcbaLegacy constructor.
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

    public function setApiToken($apiToken)
    {
        $this->apiToken = $apiToken;
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

        $result = $this->makeLegacyAuthRequest($this->apiKey, $this->url . '/Auth/generate-token', $body);

        if ($this->debugMode) {
            info('------------------- Authenticate -------------------');
            info('authenticate request: ' . json_encode($body));
            info('authenticate result: ' . $result);
        }

        return $result;
    }

    /**
     * Get account balance
     * @param $countryCode - the country code
     * @param $accountNo - the account number
     */

    public function accountDetails($countryCode, $accountNo)
    {
        $body = [
            'country' => $countryCode,
            'accountNo' =>  $accountNo
        ];

        $result = $this->makeLegacyRequest($this->apiKey, $this->apiToken, $this->url . '/AccountDetails/accountdetails', $body);

        if ($this->debugMode) {
            info('------------------- Get Account Details -------------------');
            info('getAccountDetails request: ' . json_encode($body));
            info('getAccountDetails result: ' . $result);
        }

        return $result;
    }

    /**
     * Get account mini statement
     * @param $countryCode - the country code
     * @param $accountNo - the account number
     */

    public function miniStatement($countryCode, $accountNo)
    {
        $body = [
            'country' => $countryCode,
            'accountNo' =>  $accountNo
        ];

        $result = $this->makeLegacyRequest($this->apiKey, $this->apiToken, $this->url . '/AccountMiniStatement/accountministatement', $body);

        if ($this->debugMode) {
            info('------------------- Mini Statement -------------------');
            info('miniStatement request: ' . json_encode($body));
            info('miniStatement result: ' . $result);
        }

        return $result;
    }

    /**
     * Get account statement for a given period
     * @param $countryCode - the country code
     * @param $accountNo - the account number
     * @param $fromDate - the start date
     * @param $toDate - the end date
     */

    public function accountStatement($countryCode, $accountNo, $fromDate, $toDate)
    {
        $body = [
            'country' => $countryCode,
            'accountNo' =>  $accountNo,
            'fromDate' => $fromDate,
            'toDate' => $toDate
        ];

        $result = $this->makeLegacyRequest($this->apiKey, $this->apiToken, $this->url . '/AccountStatement/accountstatement', $body);

        if ($this->debugMode) {
            info('------------------- Account Statement -------------------');
            info('accountStatement request: ' . json_encode($body));
            info('accountStatement result: ' . $result);
        }

        return $result;
    }

    /**
     * Allows sending money to a bank account via IFT
     * @param $country - the country code
     * @param $transactionID - the transaction ID
     * @param $beneficiaryAccountName - the beneficiary account name
     * @param $debitAccountNumber - the debit account number
     * @param $creditAccountNumber - the credit account number
     * @param $currency - the currency code e.g. KES
     * @param $amount - the amount to send
     * @param $narration - the narration
     */

    public function ift($country, $transactionID, $beneficiaryAccountName, $debitAccountNumber, $creditAccountNumber, $currency, $amount, $narration)
    {
        $body = [
            'country' => $country,
            'transactionID' => $transactionID,
            'beneficiaryAccountName' => $beneficiaryAccountName,
            'debitAccountNumber' => $debitAccountNumber,
            'creditAccountNumber' => $creditAccountNumber,
            'currency' => $currency,
            'amount' => $amount,
            'narration' => $narration
        ];

        $result = $this->makeLegacyRequest($this->apiKey, $this->apiToken, $this->url . '/IFTTransaction/ifttransaction', $body);

        if ($this->debugMode) {
            info('------------------- IFT -------------------');
            info('ift request: ' . json_encode($body));
            info('ift result: ' . $result);
        }

        return $result;
    }

    /**
     * Allows sending money to a bank account via EFT
     * @param $amount - the amount to send
     * @param $beneficiaryAccountNumber - the beneficiary account number
     * @param $beneficiaryBankBic - the beneficiary bank BIC
     * @param $beneficiaryName - the beneficiary name
     * @param $currency - the currency code e.g. KES
     * @param $debitAccountNumber - the debit account number
     * @param $narration - the narration
     * @param $senderCountry - the sender country code
     * @param $transactionID - the transaction ID
     * @param $senderCIF - the sender CIF
     */

    public function eft($amount, $beneficiaryAccountNumber, $beneficiaryBankBic, $beneficiaryName, $currency, $debitAccountNumber, $narration, $senderCountry, $transactionID, $senderCIF)
    {
        $body = [
            "Amount" => $amount,
            "BeneficiaryAccountNumber" => $beneficiaryAccountNumber,
            "BeneficiaryBankBIC" => $beneficiaryBankBic,
            "BeneficiaryName" => $beneficiaryName,
            "Currency" => $currency,
            "DebitAccountNumber" => $debitAccountNumber,
            "Narration" => $narration,
            "SenderCountry" => $senderCountry,
            "TransactionID" => $transactionID,
            "SenderCIF" => $senderCIF
        ];

        $result = $this->makeLegacyRequest($this->apiKey, $this->apiToken, $this->url . '/EFTTransaction/efttransaction', $body);

        if ($this->debugMode) {
            info('------------------- EFT -------------------');
            info('eft request: ' . json_encode($body));
            info('eft result: ' . $result);
        }

        return $result;
    }

    /**
     * Allows sending money to a bank account via RTGS
     * @param $beneficiaryAccountNumber - the beneficiary account number
     * @param $beneficiaryBankBIC - the beneficiary bank BIC
     * @param $beneficiaryBankName - the beneficiary bank name
     * @param $beneficiaryCountry - the beneficiary country code
     * @param $beneficiaryName - the beneficiary name
     * @param $creditAmount - the amount to send
     * @param $creditCurrency - the currency code e.g. KES
     * @param $debitCurrency - the debit currency code e.g. KES
     * @param $narration - the narration
     * @param $senderAccountNumber - the sender account number
     * @param $senderCIF - the sender CIF
     * @param $senderCountry - the sender country code
     * @param $senderName - the sender name
     * @param $transactionID - the transaction ID
     */

    public function rtgs($beneficiaryAccountNumber, $beneficiaryBankBIC, $beneficiaryBankName, $beneficiaryCountry, $beneficiaryName, $creditAmount, $creditCurrency, $debitCurrency, $narration, $senderAccountNumber, $senderCIF, $senderCountry, $senderName, $transactionID)
    {
        $body = [
            'beneficiaryAccountNumber' => $beneficiaryAccountNumber,
            'beneficiaryBankBIC' => $beneficiaryBankBIC,
            'beneficiaryBankName' => $beneficiaryBankName,
            'beneficiaryCountry' => $beneficiaryCountry, // KE
            'beneficiaryName' => $beneficiaryName,
            'creditAmount' => $creditAmount,
            'creditCurrency' => $creditCurrency,
            'debitCurrency' => $debitCurrency,
            'narration' => $narration,
            'senderAccountNumber' => $senderAccountNumber,
            'senderCIF' => $senderCIF,
            'senderCountry' => $senderCountry, // KE
            'senderName' => $senderName,
            'transactionID' => $transactionID
        ];

        $result = $this->makeLegacyRequest($this->apiKey, $this->apiToken, $this->url . '/RTGSPayment/RTGSPayment', $body);

        if ($this->debugMode) {
            info('------------------- RTGS -------------------');
            info('rtgs request: ' . json_encode($body));
            info('rtgs result: ' . $result);
        }

        return $result;
    }

    /**
     * Allows sending money to a bank account via PesaLink
     * @param $beneficiaryAccountNumber - the beneficiary account number
     * @param $beneficiaryAddress1 - the beneficiary address
     * @param $beneficiaryBankBIC - the beneficiary bank BIC
     * @param $beneficiaryBankName - the beneficiary bank name
     * @param $beneficiaryName - the beneficiary name
     * @param $amount - the amount to send
     * @param $currency - the currency code e.g. KES
     * @param $narration - the narration
     * @param $senderAccountNumber - the sender account number
     * @param $senderAddress1 - the sender address
     * @param $senderCIF - the sender CIF
     * @param $senderCountry - the sender country code
     * @param $senderName - the sender name
     * @param $transactionID - the transaction ID
     */

    public function pesalink($beneficiaryAccountNumber, $beneficiaryAddress1, $beneficiaryBankBIC, $beneficiaryBankName, $beneficiaryName, $amount, $currency, $narration, $senderAccountNumber, $senderAddress1, $senderCIF, $senderCountry, $senderName, $transactionID)
    {
        $body = [
            'beneficiaryAccountNumber' => $beneficiaryAccountNumber,
            'beneficiaryAddress1' => $beneficiaryAddress1,
            'beneficiaryBankBIC' => $beneficiaryBankBIC,
            'beneficiaryBankName' => $beneficiaryBankName,
            'beneficiaryName' => $beneficiaryName,
            'amount' => $amount,
            'currency' => $currency,
            'narration' => $narration,
            'senderAccountNumber' => $senderAccountNumber,
            'senderAddress1' => $senderAddress1,
            'senderCIF' => $senderCIF,
            'senderCountry' => $senderCountry,
            'senderName' => $senderName,
            'transactionID' => $transactionID,
        ];

        $result = $this->makeLegacyRequest($this->apiKey, $this->apiToken, $this->url . '/PesaLinkTransaction/pesaLinktransaction', $body);

        if ($this->debugMode) {
            info('------------------- PesaLink -------------------');
            info('pesalink request: ' . json_encode($body));
            info('pesalink result: ' . $result);
        }

        return $result;
    }

    public function mpesa() {}
}
