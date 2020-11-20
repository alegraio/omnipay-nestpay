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
        $this->gateway->setClientId('500100000');
        $this->gateway->setPassword('ALG*3466');
        $this->gateway->setStoreKey('123456');
        $this->gateway->setTestMode(true);
    }

    public function testPurchase(): void
    {
        $this->options = [
            'card' => $this->getCardInfo(),
            'transactionId' => 'nrmlpesin3',
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
        $this->options = [
            'card' => $this->getCardInfo(),
            'paymentMethod' => '3d',
            'storetype' => '3d',
            'companyName' => 'Alegra',
            'transactionId' => 'testtaksit1058',
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
                'md' => '492024:F59E81638F068A2869788387E89CF72A4AC686D11FD748699486CE48CC02F805:4183:##500100000',
                'taksit' => '3',
                'Ecom_Payment_Card_ExpDate_Month' => '12',
                'cavv' => 'AAABAmdUcgAAAAAhNFRyAAAAAAA=',
                'xid' => 'i4l/igsdjPHlsugxdS64yuPcenk=',
                'currency' => '949',
                'oid' => 'testtaksit1058',
                'mdStatus' => '1',
                'eci' => '05',
                'clientid' => '500100000',
                'HASH' => 'omQ9En0BqGRLt1hskdLO76nHHuM=',
                'rnd' => 'B1oKmHKc5cVlnP66CpWs',
                'HASHPARAMS' => 'clientid:oid:mdStatus:cavv:eci:md:rnd:',
                'HASHPARAMSVAL' => '500100000testtaksit10581AAABAmdUcgAAAAAhNFRyAAAAAAA=05492024:F59E81638F068A2869788387E89CF72A4AC686D11FD748699486CE48CC02F805:4183:##500100000B1oKmHKc5cVlnP66CpWs',
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
            'transactionId' => 'nrmlpesin3',
            'amount'        => '2.00',
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
            'transactionId' => 'testpesin'
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
