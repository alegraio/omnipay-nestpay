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
        $this->gateway->setUserName('akalegra');
        $this->gateway->setClientId('100100000');
        $this->gateway->setPassword('ALG*3466');
        $this->gateway->setStoreKey('123456');
        $this->gateway->setTestMode(true);
    }

    public function testPurchase(): void
    {
        $this->options = [
            'card' => $this->getCardInfo(),
            'transactionId' => '19ksm-13',
            'installment' => 2,
            'amount' => '12.00',
            'currency' => 'TRY'
        ];

        /** @var PurchaseResponse $response */
        $response = $this->gateway->purchase($this->options)->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getMessage());
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
            'is3d' => true,
            'storetype' => '3d',
            'companyName' => 'Test Firması',
            'transactionId' => 'sip-test13',
            'amount' => '10.00',
            'installment' => 2,
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
                'mdStatus' => '1',
                'clientid' => '100100000',
                'amount' => '10.00',
                'currency' => '949',
                'xid' => 'I9I4S9Tap/uPTeVlmNa4VJ66VO4=',
                'oid' => 'sip-test13',
                'cavv' => 'AAABB3UHUgAAAAAhMgdSAAAAAAA=',
                'eci' => '05',
                'md' => '453144:B24161B70F76FDDB97B9C0612AD2A054C12C54C05559922C92618ED2DF972FA5:4307:##100100000',
                'rnd' => '6nM7MBCnFVV0bYwZe2Rm',
                'HASHPARAMS' => 'clientid:oid:mdStatus:cavv:eci:md:rnd:',
                'HASHPARAMSVAL' => '100100000sip-test131AAABB3UHUgAAAAAhMgdSAAAAAAA=05453144:B24161B70F76FDDB97B9C0612AD2A054C12C54C05559922C92618ED2DF972FA5:4307:##1001000006nM7MBCnFVV0bYwZe2Rm',
                'HASH' => 'yN8FJaXMvvrTrztneS4jLoGEa6s='
            ]
        ];
        /** @var CompletePurchaseResponse $response */
        $response = $this->gateway->completePurchase($this->options)->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getMessage());
        self::assertTrue($response->isSuccessful());


    }

    public function testRefund(): void
    {
        $this->options = [
            'transactionId' => 'sip-5557',
            'amount'        => '15.00'
        ];
        $response = $this->gateway->refund($this->options)->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getMessage());
        self::assertTrue($response->isSuccessful());

    }

    public function testVoid(): void
    {
        $this->options = [
            'transactionId' => 'sip-5557'
        ];
        $response = $this->gateway->void($this->options)->send();
        var_dump($response->getRequest()->getEndPoint());
        var_dump($response->getMessage());
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
            'number' => '4531444531442283',
            'expiryMonth' => '12',
            'expiryYear' => '2026',
            'cvv' => '001',
            'email' => 'test@gmail.com',
            'firstname' => 'Test',
            'lastname' => 'Testtt'
        ];
    }
}
