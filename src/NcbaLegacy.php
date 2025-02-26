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

        $result = $this->makeLegacyRequest($this->apiKey, $this->url . '/Auth/generate-token', $body);

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

        $result = $this->makeLegacyRequest($this->apiKey, $this->url . '/AccountDetails/accountdetails', $body);

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

        $result = $this->makeLegacyRequest($this->apiKey, $this->url . '/AccountMiniStatement/accountministatement', $body);

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

        $result = $this->makeLegacyRequest($this->apiKey, $this->url . '/AccountStatement/accountstatement', $body);

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

        $result = $this->makeLegacyRequest($this->apiKey, $this->url . '/IFTTransaction/ifttransaction', $body);

        if ($this->debugMode) {
            info('------------------- IFT -------------------');
            info('ift request: ' . json_encode($body));
            info('ift result: ' . $result);
        }

        return $result;
    }

    /**
     * Allows sending money to a bank account via EFT
     * @param $sender - the sender details
     * @param $beneficiary - the beneficiary details
     * @param $currency - the currency code e.g. KES
     * @param $amount - the amount to send
     * @param $narration - the narration
     * @param $transactionID - the transaction ID
     */

    public function eft($sender, $beneficiary, $currency, $amount, $narration, $transactionID)
    {
        $body = [
            'beneficiaryAccountNumber' => $beneficiary['accountNumber'],
            'beneficiaryAddress1' => $beneficiary['address1'],
            'beneficiaryAddress2' => $beneficiary['address2'],
            'beneficiaryAddress3' => $beneficiary['address3'],
            'beneficiaryAddress4' => $beneficiary['address4'],
            'beneficiaryBankBIC' => $beneficiary['bankBIC'],
            'beneficiaryBankName' => $beneficiary['bankName'],
            'beneficiaryBankSwiftCode' => $beneficiary['bankSwiftCode'],
            'beneficiaryCity' => $beneficiary['city'],
            'beneficiaryCountry' => $beneficiary['country'],
            'beneficiaryName' => $beneficiary['name'],
            'creditAccountNumber' => $beneficiary['accountNumber'],
            'debitAccountNumber' => $sender['accountNumber'],
            'senderAccountNumber' => $sender['accountNumber'],
            'senderAddress1' => $sender['address1'],
            'senderAddress2' => $sender['address2'],
            'senderAddress3' => $sender['address3'],
            'senderAddress4' => $sender['address4'],
            'senderCIF' => $sender['cif'],
            'senderCountry' => $sender['country'],
            'senderName' => $sender['name'],
            'amount' => $amount,
            'currency' => $currency,
            'narration' => $narration,
            'transactionID' => $transactionID
        ];

        $result = $this->makeLegacyRequest($this->apiKey, $this->url . '/EFTTransaction/efttransaction', $body);

        if ($this->debugMode) {
            info('------------------- EFT -------------------');
            info('eft request: ' . json_encode($body));
            info('eft result: ' . $result);
        }

        return $result;
    }

    /**
     * Allows sending money to a bank account via RTGS
     * @param $beneficiary - the beneficiary details
     * @param $sender - the sender details
     * @param $creditAmount - the amount to send
     * @param $creditCurrency - the currency code e.g. KES
     * @param $debitCurrency - the currency code e.g. KES
     * @param $narration - the narration
     * @param $transactionID - the transaction ID
     */

    public function rtgs($beneficiary, $sender, $creditAmount, $creditCurrency, $debitCurrency, $narration, $transactionID)
    {
        $body = [
            'beneficiaryAccountNumber' => $beneficiary['accountNumber'],
            'beneficiaryBankBIC' => $beneficiary['bankBIC'],
            'beneficiaryBankName' => $beneficiary['bankName'],
            'beneficiaryCountry' => $beneficiary['country'], // KE
            'beneficiaryName' => $beneficiary['name'],
            'creditAmount' => $creditAmount,
            'creditCurrency' => $creditCurrency,
            'debitCurrency' => $debitCurrency,
            'narration' => $narration,
            'senderAccountNumber' => $sender['accountNumber'],
            'senderCIF' => $sender['cif'],
            'senderCountry' => $sender['country'], // KE
            'senderName' => $sender['name'],
            'transactionID' => $transactionID
        ];

        $result = $this->makeLegacyRequest($this->apiKey, $this->url . '/RTGSPayment/RTGSPayment', $body);

        if ($this->debugMode) {
            info('------------------- RTGS -------------------');
            info('rtgs request: ' . json_encode($body));
            info('rtgs result: ' . $result);
        }

        return $result;
    }

    /**
     * Allows sending money to a bank account via PesaLink
     * @param $beneficiary - the beneficiary details
     * @param $sender - the sender details
     * @param $amount - the amount to send
     * @param $currency - the currency code e.g. KES
     * @param $narration - the narration
     * @param $transactionID - the transaction ID
     */

    public function pesalink($beneficiary, $sender, $amount, $currency, $narration, $transactionID)
    {
        $body = [
            'beneficiaryAccountNumber' => $beneficiary['accountNumber'],
            'beneficiaryAddress1' => $beneficiary['address1'],
            'beneficiaryAddress2' => $beneficiary['address2'],
            'beneficiaryAddress3' => $beneficiary['address3'],
            'beneficiaryAddress4' => $beneficiary['address4'],
            'beneficiaryBankBIC' => $beneficiary['bankBIC'],
            'beneficiaryBankName' => $beneficiary['bankName'],
            'beneficiaryCountry' => $beneficiary['country'],
            'beneficiaryName' => $beneficiary['name'],
            'senderAccountNumber' => $sender['accountNumber'],
            'senderAddress1' => $sender['address1'],
            'senderAddress2' => $sender['address2'],
            'senderAddress3' => $sender['address3'],
            'senderAddress4' => $sender['address4'],
            'senderCIF' => $sender['cif'],
            'senderCountry' => $sender['country'],
            'senderName' => $sender['name'],
            'transactionID' => $transactionID,
            'amount' => $amount,
            'currency' => $currency,
            'narration' => $narration,
        ];

        $result = $this->makeLegacyRequest($this->apiKey, $this->url . '/PesaLinkTransaction/pesaLinktransaction', $body);

        if ($this->debugMode) {
            info('------------------- PesaLink -------------------');
            info('pesalink request: ' . json_encode($body));
            info('pesalink result: ' . $result);
        }

        return $result;
    }

    public function mpesa() {}
}
