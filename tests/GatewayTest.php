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
        $this->gateway->setBank('isbank');
        $this->gateway->setUserName('api');
        $this->gateway->setClientId('700658785');
        $this->gateway->setPassword('TEST1111');
        $this->gateway->setStoreKey('123456');
        $this->gateway->setTestMode(true);
    }

    public function testPurchase(): void
    {
        $this->options = [
            'card' => $this->getCardInfo(),
            'transactionId' => '4567898765',
            'amount' => '12.00',
            'currency' => 'TRY'
        ];

        /** @var PurchaseResponse $response */
        $response = $this->gateway->purchase($this->options)->send();
        var_dump($response->getMessage());
        self::assertTrue($response->isSuccessful());

    }

    public function testPreAuthorize(): void
    {
        $this->options = [
            'card' => $this->getCardInfo(),
            'transactionId' => '789878987',
            'amount' => '25.00',
            'currency' => 'TRY'
        ];

        /** @var AuthorizeResponse $response */
        $response = $this->gateway->preAuthorize($this->options)->send();
        self::assertTrue($response->isSuccessful());
    }

    public function testAuthorize(): void
    {
        $this->options = [
            'card' => $this->getCardInfo(),
            'transactionId' => '789878987',
            'amount' => '25.00',
            'currency' => 'TRY'
        ];

        /** @var AuthorizeResponse $response */
        $response = $this->gateway->authorize($this->options)->send();
        self::assertTrue($response->isSuccessful());
    }

    public function testCapture(): void
    {
        $this->options = [
            'card' => $this->getCardInfo(),
            'transactionId' => '435454535',
            'amount' => '15.00',
            'currency' => 'TRY'
        ];

        /** @var AuthorizeResponse $response */
        $response = $this->gateway->capture($this->options)->send();
        self::assertTrue($response->isSuccessful());
    }

    public function testPurchase3D(): void
    {
        $this->options = [
            'card' => $this->getCardInfo(),
            'is3d' => true,
            'storetype' => '3d',
            'companyName' => 'Test Firması',
            'transactionId' => '2023',
            'amount' => '19.00',
            'installment' => 1,
            'currency' => 'TRY',
            'returnUrl' => 'http://test.domain.com/payment',
            'cancelUrl' => 'http://test.domain.com/payment',
            'notifyUrl' => 'http://test.domain.com/payment',
            'lang' => 'tr'
        ];

        /** @var Purchase3DResponse $response */
        $response = $this->gateway->purchase($this->options)->send();
        self::assertTrue($response->isSuccessful());
        var_dump($response->getRedirectData());
    }

    public function testCompletePurchase3D(): void
    {
        $this->options = [
            'responseData' => [
                'mdStatus' => '1',
                'clientid' => '100100000',
                'amount' => '19.00',
                'currency' => '949',
                'xid' => 'ZFK9bDfhtUBMvm0FBPbP//8tDoc=',
                'oid' => '2023',
                'cavv' => 'AAABA2VhggAAAAAhKWGCAAAAAAA=',
                'eci' => '05',
                'md' => '402277:1A0386BDEDBD1343CFA9D58F3336303EC458D476F32DE35BDE22B07D7DC079BD:4215:##100100000',
                'rnd' => 'JIYTqRFBVBpE7qbx7TnK',
                'HASHPARAMS' => 'clientid:oid:mdStatus:cavv:eci:md:rnd:',
                'HASHPARAMSVAL' => '10010000020231AAABA2VhggAAAAAhKWGCAAAAAAA=05402277:1A0386BDEDBD1343CFA9D58F3336303EC458D476F32DE35BDE22B07D7DC079BD:4215:##100100000JIYTqRFBVBpE7qbx7TnK',
                'HASH' => '3tsyTBrSUJlqp+vzdtMPXxJoxKI='
            ]
        ];
        /** @var CompletePurchaseResponse $response */
        $response = $this->gateway->completePurchase($this->options)->send();
        self::assertTrue($response->isSuccessful());


    }

    public function testRefund(): void
    {
        $this->options = [
            'transactionId' => '989998899',
            'amount'        => '24.00'
        ];
        $response = $this->gateway->refund($this->options)->send();
        var_dump($response->getData());
        self::assertTrue($response->isSuccessful());

    }

    public function testVoid(): void
    {
        $this->options = [
            'transactionId' => '989998899'
        ];
        $response = $this->gateway->void($this->options)->send();
        var_dump($response->getData());
        self::assertTrue($response->isSuccessful());

    }

    public function testStatus(): void
    {
        $this->options = [
            'transactionId' => '25-987654321'
        ];
        $response = $this->gateway->status($this->options)->send();
        var_dump($response->getData());
        self::assertTrue($response->isSuccessful());

    }

    private function getCardInfo(): array
    {
        return [
            'number' => '4022774022774026',
            'expiryMonth' => '12',
            'expiryYear' => '2030',
            'cvv' => '000',
            'email' => 'test@gmail.com',
            'firstname' => 'Test',
            'lastname' => 'Testtt'
        ];
    }
}
