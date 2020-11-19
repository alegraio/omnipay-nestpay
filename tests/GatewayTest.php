<?php

namespace Omnipay\Tests;

use Omnipay\NestPay\Messages\AuthorizeResponse;
use Omnipay\NestPay\Gateway;
use Omnipay\NestPay\Messages\CompletePurchaseResponse;
use Omnipay\NestPay\Messages\Purchase3DResponse;
use Omnipay\NestPay\Messages\PurchaseResponse;


class GatewayTest extends GatewayTestCase
{
    /** @var Gateway */
    public $gateway;

    /** @var array */
    public $options;

    public function setUp(): void
    {
        /** @var Gateway gateway */
        $this->gateway = new Gateway(null, $this->getHttpRequest());
        $this->gateway->setBank('halkbank');
        $this->gateway->setUserName('alegra');
        $this->gateway->setClientId('700655000100');
        $this->gateway->setPassword('ALG*3466');
        $this->gateway->setStoreKey('TRPS0100');
        $this->gateway->setTestMode(true);
    }

    public function testPurchase(): void
    {
        $this->options = [
            'card' => $this->getCardInfo(),
            'transactionId' => 'nrmltaksit',
            'installment' => 3,
            'amount' => '2.00',
            'currency' => 'TRY'
        ];

        /** @var PurchaseResponse $response */
        $response = $this->gateway->purchase($this->options)->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getMessage());
        var_dump($response->getTransactionReference());
        self::assertTrue($response->isSuccessful());

    }

    public function testPreAuthorize(): void
    {
        $this->options = [
            'card' => $this->getCardInfo(),
            'transactionId' => 'sip-121212',
            'amount' => '25.00',
            'currency' => 'TRY'
        ];

        /** @var AuthorizeResponse $response */
        $response = $this->gateway->preAuthorize($this->options)->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getMessage());
        self::assertTrue($response->isSuccessful());
    }

    public function testAuthorize(): void
    {
        $this->options = [
            'card' => $this->getCardInfo(),
            'transactionId' => 'sip-121212',
            'amount' => '25.00',
            'currency' => 'TRY'
        ];

        /** @var AuthorizeResponse $response */
        $response = $this->gateway->authorize($this->options)->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getMessage());
        self::assertTrue($response->isSuccessful());
    }

    public function testCapture(): void
    {
        $this->options = [
            'card' => $this->getCardInfo(),
            'transactionId' => 'sip-5557',
            'amount' => '25.00',
            'currency' => 'TRY'
        ];

        /** @var AuthorizeResponse $response */
        $response = $this->gateway->capture($this->options)->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getMessage());
        self::assertTrue($response->isSuccessful());
    }

    public function testPurchase3D(): void
    {
        $this->gateway->setPaymentMethod('3d');
        $this->options = [
            'card' => $this->getCardInfo(),
            'storetype' => '3d',
            'companyName' => 'Alegra',
            'transactionId' => 'isbank3dodeme',
            'installment' => 3,
            'amount' => '2.00',
            'currency' => 'TRY',
            'returnUrl' => 'http://test.domain.com/payment',
            'cancelUrl' => 'http://test.domain.com/failure',
            'notifyUrl' => 'http://test.domain.com/payment',
            'lang' => 'tr'
        ];

        /** @var Purchase3DResponse $response */
        $response = $this->gateway->purchase($this->options)->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getRedirectData());
        self::assertTrue($response->isSuccessful());

    }

    public function testCompletePurchase3D(): void
    {
        $this->options = [
            'responseData' => [
                'TRANID' => '',
                'lang' => 'tr',
                'merchantID' => '500100000',
                'amount' => '2.00',
                'Ecom_Payment_Card_ExpDate_Year' => '30',
                'clientIp' => '176.88.131.138',
                'md' => '492024:9B42DB0B145360AC1F31BE7E040D611B3EED6430323BA5E6D9DDDBBD2CCBC453:3682:##500100000',
                'taksit' => '3',
                'Ecom_Payment_Card_ExpDate_Month' => '12',
                'cavv' => 'AAABA4dEggAAAAAhM0SCAAAAAAA=',
                'xid' => '9r2O9zvu1uE3ZEF3QEfJ9s7XzuQ=',
                'currency' => '949',
                'oid' => '3dodemetaksit',
                'mdStatus' => '1',
                'eci' => '05',
                'clientid' => '500100000',
                'HASH' => 'NglzZxZNKI8/II9eQunYwqpuwQw=',
                'rnd' => 'NyKTZ0qrpVVsDeDptLbt',
                'HASHPARAMS' => 'clientid:oid:mdStatus:cavv:eci:md:rnd:',
                'HASHPARAMSVAL' => '5001000003dodemetaksit1AAABA4dEggAAAAAhM0SCAAAAAAA=05492024:9B42DB0B145360AC1F31BE7E040D611B3EED6430323BA5E6D9DDDBBD2CCBC453:3682:##500100000NyKTZ0qrpVVsDeDptLbt',
            ]
        ];
        /** @var CompletePurchaseResponse $response */
        $response = $this->gateway->completePurchase($this->options)->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getMessage());
        var_dump($response->getTransactionReference());
        self::assertTrue($response->isSuccessful());


    }

    public function testRefund(): void
    {
        $this->options = [
            'transactionId' => '3dodemepesin',
            'amount'        => '1.00',
            'currency'      => 'TRY'
        ];
        $response = $this->gateway->refund($this->options)->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getMessage());
        var_dump($response->getTransactionReference());
        self::assertTrue($response->isSuccessful());

    }

    public function testVoid(): void
    {
        $this->options = [
            'transactionId' => '3dodemepesin'
        ];
        $response = $this->gateway->void($this->options)->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getMessage());
        var_dump($response->getTransactionReference());
        self::assertTrue($response->isSuccessful());

    }

    public function testStatus(): void
    {
        $this->options = [
            'transactionId' => 'sip-5557'
        ];
        $response = $this->gateway->status($this->options)->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getData());
        self::assertTrue($response->isSuccessful());

    }

    private function getCardInfo(): array
    {
        return [
            'number' => '4920244920244921',
            'expiryMonth' => '12',
            'expiryYear' => '2030',
            'cvv' => '001',
            'email' => 'test@gmail.com',
            'firstname' => 'Test',
            'lastname' => 'Testtt'
        ];
    }
}
