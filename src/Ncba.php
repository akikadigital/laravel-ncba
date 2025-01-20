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
     * Allows sending money to a bank account via RTGS
     * @param string $beneficiaryAccountName - the name of the account holder
     * @param string $account - the account number to send to
     * @param double $amount - the amount to send
     * @param string $purposeCode - the purpose code
     * @param string $reference - the reference number
     * @param string $narration - the narration or description or reason
     * 
     * @return mixed - The result of the request: \Illuminate\Http\Client\Response
     */

    public function rtgs($beneficiaryAccountName, $account, $amount, $purposeCode, $reference, $narration)
    {
        /// prepare the data
        $data = [
            "TranType" => "RTGS",
            "Account" => $account,
            "Amount" => $amount,
            "BankCode" => $this->bankCode,
            "BranchCode" => $this->branchCode,
            "BankSwiftCode" => "EQBLKENA",
            "BeneficiaryAccountName" => $beneficiaryAccountName,
            "Country" => $this->country, // "Kenya",
            "Currency" => $this->currency, // "KES",
            "PurposeCode" => $purposeCode,
            "Reference" => $reference,
            "Narration" => $narration,
        ];

        /// make the request
        $result = $this->makeRequest($this->url . '/rtgs', $data);

        /// log the request and response
        if ($this->debugMode) {
            info('rtgs request: ' . json_encode($data));
            info('rtgs response: ' . $result->json());
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

    public function pesalink($beneficiaryAccountName, $reference, $account, $amount, $narration)
    {
        /// prepare the data
        $data = [
            "TranType" => "Pesalink",
            "BankCode" => $this->bankCode,
            "BranchCode" => $this->branchCode,
            "BeneficiaryAccountName" => $beneficiaryAccountName,
            "Country" => $this->country, // "Kenya",
            "Currency" => $this->currency, // "KES",
            "Reference" => $reference,
            "Account" => $account,
            "Amount" => $amount,
            "Narration" => $narration
        ];

        /// make the request
        $result = $this->makeRequest($this->url . '/pesalink', $data);

        /// log the request and response
        if ($this->debugMode) {
            info('pesalink request: ' . json_encode($data));
            info('pesalink response: ' . $result->json());
        }

        /// return the result
        return $result;
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

    public function ift($beneficiaryAccountName, $reference, $account, $amount, $narration)
    {
        /// prepare the data
        $data = [
            "TranType" => "Internal",
            "BankCode" => $this->bankCode,
            "BranchCode" => $this->branchCode,
            "BeneficiaryAccountName" => $beneficiaryAccountName,
            "Country" => $this->country, // "Kenya",
            "Currency" => $this->currency, // "KES",
            "Reference" => $reference,
            "Account" => $account,
            "Amount" => $amount,
            "Narration" => $narration,
        ];

        /// make the request
        $result = $this->makeRequest($this->url . '/ift', $data);

        /// log the request and response
        if ($this->debugMode) {
            info('ift request: ' . json_encode($data));
            info('ift response: ' . $result->json());
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

    public function eft($beneficiaryAccountName, $reference, $account, $amount, $narration)
    {
        /// prepare the data
        $data = [
            "TranType" => "Eft",
            "BankCode" => $this->bankCode,
            "BranchCode" => $this->branchCode,
            "BeneficiaryAccountName" => $beneficiaryAccountName,
            "Country" => $this->country, // "Kenya",
            "Currency" => $this->currency, // "KES",
            "Reference" => $reference,
            "Account" => $account,
            "Amount" => $amount,
            "Narration" => $narration,
        ];

        /// make the request
        $result = $this->makeRequest($this->url . '/eft', $data);

        /// log the request and response
        if ($this->debugMode) {
            info('eft request: ' . json_encode($data));
            info('eft response: ' . $result->json());
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

    public function mpesa($beneficiaryAccountName, $reference, $amount, $account, $narration, $transactionId)
    {
        /// prepare the data
        $data = [
            "TranType" => "Mpesa",
            "BankCode" => $this->bankCode,
            "BranchCode" => $this->branchCode,
            "BeneficiaryAccountName" => $beneficiaryAccountName,
            "Country" => $this->country, // "Kenya",
            "Currency" => $this->currency, // "KES",
            "Reference" => $reference, // "John Doe",
            "Account" => $account, // "254712345678",
            "Amount" => ceil($amount), // 12000,
            "Narration" => $narration, //"WATER BILL AND SANITATIONV00688",
            "Validation ID" => $transactionId, // "SFE0FNOXCI"
        ];

        /// make the request
        $result = $this->makeRequest($this->url . '/mpesa', $data);

        /// log the request and response
        if ($this->debugMode) {
            info('mpesa request: ' . json_encode($data));
            info('mpesa response: ' . $result->json());
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
            info('checkTransactionStatus response: ' . $result->json());
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
            info('mpesaNumberValidation response: ' . $result->json());
        }

        /// return the result
        return $result;
    }
}
