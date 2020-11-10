<?php


namespace Omnipay\NestPay\Messages;


trait RequestTrait
{
    /** @var array */
    public $endpoints = [
        'asseco' => 'https://entegrasyon.asseco-see.com.tr/fim/api',
        'isbank' => 'https://spos.isbank.com.tr',
        'akbank' => 'https://www.sanalakpos.com',
        'finansbank' => 'https://www.fbwebpos.com',
        'denizbank' => 'https://denizbank.est.com.tr',
        'kuveytturk' => 'https://kuveytturk.est.com.tr',
        'halkbank' => 'https://sanalpos.halkbank.com.tr',
        'anadolubank' => 'https://anadolusanalpos.est.com.tr',
        'hsbc' => 'https://vpos.advantage.com.tr',
        'ziraatbank' => 'https://sanalpos2.ziraatbank.com.tr'
    ];

    public $testEndpoints = [
        'purchase' => 'https://testvpos.asseco-see.com.tr/fim/api',
        '3d' => 'https://entegrasyon.asseco-see.com.tr/fim/est3Dgate'
    ];

    protected $allowedCardBrands = [
        'visa' => 1,
        'mastercard' => 2
    ];

    public $url = [
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
        $bank = $this->getBank();
        $action = $this->getAction();
        if ($this->getTestMode()) {
            return $this->testEndpoints[$action] ?? $this->testEndpoints['purchase'];
        }
        return $this->endpoints[$bank] . $this->url[$action];
    }
}