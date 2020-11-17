<?php


namespace Omnipay\NestPay\Messages;


trait RequestTrait
{

    public $baseUrls = [
        'asseco' => ['baseUrl' => 'https://entegrasyon.asseco-see.com.tr'],
        'isbank' => ['baseUrl' => 'https://spos.isbank.com.tr'],
        'akbank' => ['baseUrl' => 'https://www.sanalakpos.com'],
        'finansbank' => ['baseUrl' => 'https://www.fbwebpos.com'],
        'denizbank' => ['baseUrl' => 'https://denizbank.est.com.tr'],
        'kuveytturk' => ['baseUrl' => 'https://kuveytturk.est.com.tr'],
        'halkbank' => ['baseUrl' => 'https://sanalpos.halkbank.com.tr'],
        'anadolubank' => ['baseUrl' => 'https://anadolusanalpos.est.com.tr'],
        'hsbc' => ['baseUrl' => 'https://vpos.advantage.com.tr'],
        'ziraatbank' => ['baseUrl' => 'https://sanalpos2.ziraatbank.com.tr'],
        'test' => [
            'purchase' => [
                'baseUrl' => 'https://testvpos.asseco-see.com.tr'
            ],
            '3d' => [
                'baseUrl' => 'https://entegrasyon.asseco-see.com.tr'
            ]
        ]
    ];

    protected $allowedCardBrands = [
        'visa' => 1,
        'mastercard' => 2
    ];

    public $url = [
        'test' => [
            'purchase' => '/fim/api',
            '3d' => '/fim/est3Dgate'
        ],
        "3d" => "/servlet/est3Dgate",
        "3dhsbc" => "/servlet/hsbc3Dgate",
        "list" => "/servlet/listapproved",
        "detail" => "/servlet/cc5ApiServer",
        "cancel" => "/servlet/cc5ApiServer",
        "return" => "/servlet/cc5ApiServer",
        "purchase" => "/servlet/cc5ApiServer"
    ];

    public function getEndpoint(): string
    {
        $baseUrl = $this->getBaseUrl();
        $action = $this->getAction();
        if ($this->getTestMode()) {
            return $baseUrl . $this->url['test'][$action];
        }

        return $baseUrl . $this->url[$action];
    }

    public function getBaseUrl(): string
    {
        $bank = $this->getBank();
        $action = $this->getAction();
        if ($this->getTestMode()) {
            return $this->baseUrls['test'][$action]['baseUrl'] ?? $this->baseUrls['test']['purchase']['baseUrl'];
        }
        return $this->baseUrls[$bank]['baseUrl'];
    }
}