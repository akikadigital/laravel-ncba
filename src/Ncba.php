<?php

namespace Akika\LaravelNcba;

use Akika\LaravelNcba\Traits\NcbaTrait;

class Ncba
{
    use NcbaTrait;

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
     */

    public function rtgs($beneficiaryAccountName, $account, $amount, $purposeCode, $reference, $narration)
    {
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

        if ($this->debugMode) {
            info('rtgs request: ' . compact('data'));
        }
    }

    /*
    * Allows sending money to a bank account via Pesalink
    * @param string $beneficiaryAccountName - the name of the account holder
    * @param string $reference - the reference number
    * @param string $account - the account number to send to
    * @param double $amount - the amount to send
    * @param string $narration - the narration or description or reason
    */

    public function pesalink($beneficiaryAccountName, $reference, $account, $amount, $narration)
    {
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

        if ($this->debugMode) {
            info('pesalink request: ' . compact('data'));
        }
    }

    /**
     * Allows sending money to a bank account via IFT
     * @param string $beneficiaryAccountName - the name of the account holder
     * @param string $reference - the reference number
     * @param string $account - the account number to send to
     * @param double $amount - the amount to send
     * @param string $narration - the narration or description or reason
     */

    public function ift($beneficiaryAccountName, $reference, $account, $amount, $narration)
    {
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

        if ($this->debugMode) {
            info('ift request: ' . compact('data'));
        }
    }

    /**
     * Allows sending money to a bank account via EFT
     * @param string $beneficiaryAccountName - the name of the account holder
     * @param string $reference - the reference number
     * @param string $account - the account number to send to
     * @param double $amount - the amount to send
     * @param string $narration - the narration or description or reason
     */

    public function eft($beneficiaryAccountName, $reference, $account, $amount, $narration)
    {
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

        if ($this->debugMode) {
            info('eft request: ' . compact('data'));
        }
    }

    public function mpesa($reference, $amount, $account, $narration, $transactionId)
    {
        $data = [
            "TranType" => "Mpesa",
            "BankCode" => $this->bankCode,
            "BranchCode" => $this->branchCode,
            "BeneficiaryAccountName" => "DAVID NGIGI WANYOIKE",
            "Country" => $this->country, // "Kenya",
            "Currency" => $this->currency, // "KES",
            "Reference" => $reference, // "SAMARA WANJIRU",
            "Account" => $account, // "254714527786",
            "Amount" => ceil($amount), // 12000,
            "Narration" => $narration, //"WATER BILL AND SANITATIONV00688",
            "Validation ID" => $transactionId, // "SFE0FNOXCI"
        ];

        if ($this->debugMode) {
            info('mpesa request: ' . compact('data'));
        }
    }

    public function checkApiHealth()
    {
        // send a get request
        $data = [
            "apiKey" => $this->apiKey
        ];

        $response = $this->makeRequest($this->url . '/health', $data, 'GET');

        if ($this->debugMode) {
            info('checkApiHealth request: ' . compact('data'));
            info('checkApiHealth response: ' . $response->json());
        }
    }
}
