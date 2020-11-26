<?php

namespace Omnipay\NestPay\Messages;

trait RequestTrait
{

    public $baseUrls = [
        'isbank' => 'https://spos.isbank.com.tr',
        'akbank' => 'https://www.sanalakpos.com',
        'finansbank' => 'https://www.fbwebpos.com',
        'denizbank' => 'https://denizbank.est.com.tr',
        'kuveytturk' => 'https://kuveytturk.est.com.tr',
        'halkbank' => 'https://sanalpos.halkbank.com.tr',
        'anadolubank' => 'https://anadolusanalpos.est.com.tr',
        'hsbc' => 'https://vpos.advantage.com.tr',
        'ziraatbank' => 'https://sanalpos2.ziraatbank.com.tr',
        'test' => 'https://entegrasyon.asseco-see.com.tr'
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
        if ($this->getTestMode()) {
            return $this->baseUrls['test'];
        }
        return $this->baseUrls[$bank];
    }

    public function getRnd(): string
    {
        return (string)time();
    }
}