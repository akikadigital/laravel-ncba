<?php

namespace Akika\LaravelNcba;

use Akika\LaravelNcba\Traits\NcbaConnect;

class Ncba
{
    use NcbaConnect;

    protected $environment;
    protected $debugMode;
    protected $url;

    protected $apiKey;

    protected $bankCode;
    protected $branchCode;
    protected $country;
    protected $currency;

    /**
     * Ncba constructor.
     * @param null $bankCode
     * @param null $branchCode
     * @param null $country
     * @param null $currency
     * 
     */

    public function __construct($bankCode = null, $branchCode = null, $country = null, $currency = null)
    {
        $this->environment = config('ncba.env');
        $this->debugMode = config('ncba.debug');
        $this->apiKey = config('ncba.' . $this->environment . '.api_key');
        $this->url = config('ncba.' . $this->environment . '.url');

        $this->bankCode = $bankCode;
        $this->branchCode = $branchCode;
        $this->country = $country;
        $this->currency = $currency;
    }

    /**
     * Allows sending money to a bank account via IFT
     * @param string $beneficiaryAccountName - the name of the account holder
     * @param string $reference - the reference number
     * @param string $account - the account number to send to
     * @param double $amount - the amount to send
     * @param string $narration - the narration or description or reason
     * 
     * @return mixed - The result of the request: \Illuminate\Http\Client\Response
     */

    public function ift($account, $beneficiaryAccountName, $amount, $narration, $reference)
    {
        /// prepare the data
        $data = [
            "TranType" => "Internal",
            "BankCode" => $this->bankCode,
            "BranchCode" => $this->branchCode,
            "Country" => $this->country, // "Kenya",
            "Currency" => $this->currency, // "KES",
            "Account" => $account,
            "BeneficiaryAccountName" => $beneficiaryAccountName,
            "Amount" => $amount,
            "Narration" => $narration,
            "Reference" => $reference
        ];

        /// make the request
        $result = $this->makeRequest($this->url . '/CreditTransfer', $data);

        /// log the request and response
        if ($this->debugMode) {
            info('ift request: ' . json_encode($data));
            info('ift response: ' . $result);
        }

        /// return the result
        return $result;
    }

    /**
     * Allows sending money to a bank account via EFT
     * @param string $beneficiaryAccountName - the name of the account holder
     * @param string $reference - the reference number
     * @param string $account - the account number to send to
     * @param double $amount - the amount to send
     * @param string $narration - the narration or description or reason
     * 
     * @return mixed - The result of the request: \Illuminate\Http\Client\Response
     */
    // ift($account, $beneficiaryAccountName, $amount, $narration, $reference)
    public function eft($account, $beneficiaryAccountName, $amount, $narration, $reference)
    {
        /// prepare the data
        $data = [
            "TranType" => "Eft",
            "BankCode" => $this->bankCode,
            "BranchCode" => $this->branchCode,
            "Country" => $this->country, // "Kenya",
            "Currency" => $this->currency, // "KES",
            "Account" => $account,
            "BeneficiaryAccountName" => $beneficiaryAccountName,
            "Amount" => $amount,
            "Narration" => $narration,
            "Reference" => $reference
        ];

        /// make the request
        $result = $this->makeRequest($this->url . '/CreditTransfer', $data);

        /// log the request and response
        if ($this->debugMode) {
            info('eft request: ' . json_encode($data));
            info('eft response: ' . $result);
        }

        /// return the result
        return $result;
    }

    /**
     * Allows sending money to a bank account via RTGS
     * @param string $beneficiaryAccountName - the name of the account holder
     * @param string $account - the account number to send to
     * @param double $amount - the amount to send
     * @param string $purposeCode - the purpose code
     * @param string $narration - the narration or description or reason
     * @param string $reference - the reference number
     * 
     * @return mixed - The result of the request: \Illuminate\Http\Client\Response
     */

    public function rtgs($account, $beneficiaryAccountName, $amount, $purposeCode, $narration, $reference)
    {
        /// prepare the data
        $data = [
            "TranType" => "RTGS",
            "BankCode" => $this->bankCode,
            "BranchCode" => $this->branchCode,
            "BankSwiftCode" => "EQBLKENA",
            "Country" => $this->country, // "Kenya",
            "Currency" => $this->currency, // "KES",
            "Account" => $account,
            "BeneficiaryAccountName" => $beneficiaryAccountName,
            "Amount" => $amount,
            "PurposeCode" => $purposeCode,
            "Narration" => $narration,
            "Reference" => $reference
        ];

        /// make the request
        $result = $this->makeRequest($this->url . '/CreditTransfer', $data);

        /// log the request and response
        if ($this->debugMode) {
            info('rtgs request: ' . json_encode($data));
            info('rtgs response: ' . $result);
        }

        /// return the result
        return $result;
    }

    /*
    * Allows sending money to a bank account via Pesalink
    * @param string $beneficiaryAccountName - the name of the account holder
    * @param string $reference - the reference number
    * @param string $account - the account number to send to
    * @param double $amount - the amount to send
    * @param string $narration - the narration or description or reason
    * 
    * @return mixed - The result of the request: \Illuminate\Http\Client\Response
    */

    public function pesalink($account, $beneficiaryAccountName, $amount, $narration, $reference)
    {
        /// prepare the data
        $data = [
            "TranType" => "Pesalink",
            "BankCode" => $this->bankCode,
            "BranchCode" => $this->branchCode,
            "Country" => $this->country, // "Kenya",
            "Currency" => $this->currency, // "KES",
            "Account" => $account,
            "BeneficiaryAccountName" => $beneficiaryAccountName,
            "Amount" => $amount,
            "Narration" => $narration,
            "Reference" => $reference
        ];

        /// make the request
        $result = $this->makeRequest($this->url . '/CreditTransfer', $data);

        /// log the request and response
        if ($this->debugMode) {
            info('pesalink request: ' . json_encode($data));
            info('pesalink response: ' . $result);
        }

        /// return the result
        return $result;
    }

    /**
     * Allows sending money to a bank account via MPESA
     * @param string $beneficiaryAccountName - the name of the account holder
     * @param string $reference - the reference number
     * @param string $account - the account number to send to
     * @param double $amount - the amount to send
     * @param string $narration - the narration or description or reason
     * @param string $transactionId - the transaction ID
     * 
     * @return mixed - The result of the request: \Illuminate\Http\Client\Response
     */

    public function mpesa($account, $beneficiaryAccountName, $amount, $transactionId, $narration, $reference)
    {
        /// prepare the data
        $data = [
            "TranType" => "Mpesa",
            "BankCode" => $this->bankCode,
            "BranchCode" => $this->branchCode,
            "Country" => $this->country, // "Kenya",
            "Currency" => $this->currency, // "KES",
            "Account" => $account, // "2547XXXXXXXX",
            "BeneficiaryAccountName" => $beneficiaryAccountName,
            "Amount" => ceil($amount), // 12000,
            "Validation ID" => $transactionId, // "SFE0FNOXCI"
            "Narration" => $narration, //"WATER BILL AND SANITATIONV00688",
            "Reference" => $reference, // "John Doe",
        ];

        /// make the request
        $result = $this->makeRequest($this->url . '/CreditTransfer', $data);

        /// log the request and response
        if ($this->debugMode) {
            info('mpesa request: ' . json_encode($data));
            info('mpesa response: ' . $result);
        }

        /// return the result
        return $result;
    }

    /**
     * Checks the health of the API
     * 
     * @return mixed - The result of the request: \Illuminate\Http\Client\Response
     */

    public function checkApiHealth()
    {
        /// prepare the data
        $data = [
            "apiKey" => $this->apiKey
        ];

        info($this->url . '/health');

        /// make the request
        $result = $this->makeRequest($this->url . '/health', $data, 'GET');

        /// log the request and response
        if ($this->debugMode) {
            info('checkApiHealth request: ' . json_encode($data));
            info('checkApiHealth response: ' . $result);
        }

        /// return the result
        return $result; // Healthy
    }

    /**
     * Checks the status of a transaction
     * @param string $referenceNumber - the reference number
     * 
     * @return mixed - The result of the request: \Illuminate\Http\Client\Response
     */

    public function checkTransactionStatus($referenceNumber)
    {

        /// prepare the data
        $data = [
            "country" => $this->country,
            "referenceNumber" => $referenceNumber
        ];

        /// make the request
        $result = $this->makeRequest($this->url . '/TransactionQuery', $data, 'GET');

        /// log the request and response
        if ($this->debugMode) {
            info('checkTransactionStatus request: ' . json_encode($data));
            info('checkTransactionStatus response: ' . $result);
        }

        /// return the result
        return $result;
    }

    /**
     * Validates phone numbr through Mpesa
     * @param string $phoneNumber - the phone number
     * @param string $reference - the reference number
     * 
     * @return mixed - The result of the request: \Illuminate\Http\Client\Response
     */

    public function mpesaNumberValidation($phoneNumber, $reference)
    {

        /// prepare the data
        $data = [
            "Mobile Number" => $phoneNumber,
            "Reference" => $reference
        ];

        /// make the request
        $result = $this->makeRequest($this->url . '/MpesaPhoneNumberValidation', $data, 'GET');

        /// log the request and response
        if ($this->debugMode) {
            info('mpesaNumberValidation request: ' . json_encode($data));
            info('mpesaNumberValidation response: ' . $result);
        }

        /// return the result
        return $result;
    }
}
