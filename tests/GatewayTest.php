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
        $this->gateway->setBank('akbank');
        $this->gateway->setUserName('101506890api');
        $this->gateway->setClientId('100100000');
        $this->gateway->setPassword('TEST2020');
        $this->gateway->setStoreKey('123456');
        $this->gateway->setTestMode(true);
    }

    public function testPurchase(): void
    {
        $this->options = [
            'card' => $this->getCardInfo(),
            'transactionId' => '1235678906546',
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
            'transactionId' => 'order1',
            'amount' => '10.00',
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
                'clientid' => '100658785',
                'amount' => '10.00',
                'currency' => '949',
                'xid' => 'zlpI9xXp1drmK694emAXVrFxi5U=',
                'oid' => 'order1',
                'cavv' => 'AAABAGaDQgAAAAAhKYNCAAAAAAA=',
                'eci' => '05',
                'md' => '402277:3E3ABE49860E79A1DCBE4660E5B46B30CD1C3376E8BFA262C97EC1380AA24904:3863:##100658785',
                'rnd' => 'o3GDXyLh+vt2n19It5Om',
                'HASHPARAMS' => 'clientid:oid:mdStatus:cavv:eci:md:rnd:',
                'HASHPARAMSVAL' => '100658785order11AAABAGaDQgAAAAAhKYNCAAAAAAA=05402277:3E3ABE49860E79A1DCBE4660E5B46B30CD1C3376E8BFA262C97EC1380AA24904:3863:##100658785o3GDXyLh+vt2n19It5Om',
                'HASH' => 'fP6W8vv9FuGRS42GkUo+oS/kHJs='
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
