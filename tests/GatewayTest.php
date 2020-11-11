<?php

namespace Omnipay\Tests;

use Omnipay\NestPay\Messages\AuthorizeResponse;
use Omnipay\NestPay\Gateway;
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
        $this->gateway->setTestMode(true);
    }

    public function testPurchase(): void
    {
        $this->options = [
            'card' => $this->getCardInfo(),
            'transactionId' => '987654321',
            'amount' => '12.00',
            'currency' => 'TRY'
        ];

        /** @var PurchaseResponse $response */
        $response = $this->gateway->purchase($this->options)->send();
        self::assertTrue($response->isSuccessful());
    }

    public function testAuthorize(): void
    {
        $this->options = [
            'card' => $this->getCardInfo(),
            'transactionId' => '435454535',
            'amount' => '15.00',
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
        $this->gateway->setClientId('400000200');
        $this->gateway->setStoreKey('TRPS0200');

        $this->options = [
            'card' => $this->getCardInfo(),
            'storetype' => '3d_pay',
            'companyName' => 'Test Firması',
            'transactionId' => '2-987654321',
            'amount' => '12.00',
            'installment' => 1,
            'currency' => 'TRY',
            'returnUrl' => 'http://test.domain.com/basarili',
            'cancelUrl' => 'http://test.domain.com/basarisiz',
            'notifyUrl' => 'http://test.domain.com/basarili',
            'lang' => 'tr'
        ];

        /** @var Purchase3DResponse $response */
        $response = $this->gateway->purchase3D($this->options)->send();
        self::assertTrue($response->isSuccessful());
        var_dump($response->getRedirectData());
    }

    private function getCardInfo(): array
    {
        return [
            'number' => '5406675406675403',
            'expiryMonth' => '12',
            'expiryYear' => '2022',
            'cvv' => '000',
            'email' => 'test@gmail.com',
            'firstname' => 'Test',
            'lastname' => 'Testtt'
        ];
    }
}
