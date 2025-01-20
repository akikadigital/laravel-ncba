<?php

namespace Akika\LaravelNCBA;

use Akika\LaravelNCBA\Traits\NcbaTrait;

class Ncba
{
    use NcbaTrait;

    protected $environment;
    protected $debugMode;
    protected $url;

    protected $apiKey;

    public function __construct()
    {
        $this->environment = config('ncba.env');
        $this->debugMode = config('ncba.debug');
        $this->apiKey = config('ncba.' . $this->environment . '.api_key');
        $this->url = config('ncba.' . $this->environment . '.url');
    }

    public function rtgs()
    {
        $data = [
            "Account" => "34456344",
            "Amount" => 455,
            "BankCode" => "68",
            "BankSwiftCode" => "EQBLKENA",
            "BeneficiaryAccountName" => "sims tiida",
            "BranchCode" => "000",
            "Country" => "Kenya",
            "Currency" => "KES",
            "Narration" => "DDF434",
            "PurposeCode" => 1002,
            "Reference" => "TRIM009s234dds",
            "TranType" => "RTGS"
        ];

        if ($this->debugMode) {
            info('rtgs request: ' . compact('data'));
        }
    }

    public function pesalink()
    {
        $data = [
            "BankCode" => "404",
            "BranchCode" => "11000",
            "BeneficiaryAccountName" => "JANE DOE",
            "Country" => "Kenya",
            "TranType" => "Pesalink",
            "Reference" => "GENERIC",
            "Currency" => "KES",
            "Account" => "1234567890",
            "Amount" => 2300,
            "Narration" => "GENERIC"
        ];

        if ($this->debugMode) {
            info('pesalink request: ' . compact('data'));
        }
    }

    public function ift()
    {
        $data = [
            "BankCode" => "07",
            "BranchCode" => "000",
            "BeneficiaryAccountName" => "STRING",
            "Country" => "Kenya",
            "TranType" => "Internal",
            "Reference" => "STRING",
            "Currency" => "STRING",
            "Account" => "4376410044",
            "Amount" => "STRING",
            "Narration" => "STRING",
        ];

        if ($this->debugMode) {
            info('ift request: ' . compact('data'));
        }
    }

    public function eft()
    {
        $data = [
            "BankCode" => "XX",
            "BranchCode" => "XXX",
            "BeneficiaryAccountName" => "STRING",
            "Country" => "Kenya",
            "TranType" => "Eft",
            "Reference" => "STRING",
            "Currency" => "KES",
            "Account" => "STRING",
            "Amount" => "XXX",
            "Narration" => "STRING",
        ];

        if ($this->debugMode) {
            info('eft request: ' . compact('data'));
        }
    }

    public function mpesa()
    {
        $data = [
            "BankCode" => "99",
            "BranchCode" => "002",
            "BeneficiaryAccountName" => "DAVID NGIGI WANYOIKE",
            "Country" => "Kenya",
            "TranType" => "Mpesa",
            "Reference" => "SAMARA WANJIRU",
            "Currency" => "KES",
            "Account" => "254714527786",
            "Amount" => 12000,
            "Narration" => "WATER BILL AND SANITATIONV00688",
            "Validation ID" => "SFE0FNOXCI"
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
