<?php

namespace OmnipayTest\NestPay\Messages;

use Omnipay\Tests\TestCase;

class NestPayTestCase extends TestCase
{
    protected function getPurchaseParams(): array
    {
        $params = [
        ];

        return $this->provideMergedParams($params);
    }

    protected function getRefundParams(): array
    {
        $params = [
        ];

        return $this->provideMergedParams($params);
    }

    protected function getAuthorizeParams(): array
    {
        $params = [
            'card' => $this->getValidCard(),
            'transactionId' => '435454535',
            'amount' => '15.00',
            'currency' => 'TRY'
        ];

        return $this->provideMergedParams($params);
    }

    protected function getCompletePurchaseParams(): array
    {
        $params = [
        ];

        return $this->provideMergedParams($params);
    }

    private function getDefaultOptions(): array
    {
        return [
            'testMode' => true,
            'bank' => 'isbank',
            'username' => 'api',
            'clientId' => '700658785',
            'password' => 'TEST1111'
        ];
    }

    public function getValidCard(): array
    {
        return [
            'number' => '5406675406675403',
            'expiryMonth' => '12',
            'expiryYear' => '2022',
            'cvv' => '000',
            'email' => 'test@gmail.com',
            'firstname' => 'Test',
            'lastname' => 'Testtt',
            'billingAddress1' => '123 Billing St',
            'billingAddress2' => 'Billsville',
            'billingCity' => 'Billstown',
            'billingPostcode' => '12345',
            'billingState' => 'CA',
            'billingCountry' => 'US',
            'billingPhone' => '(555) 123-4567',
            'shippingAddress1' => '123 Shipping St',
            'shippingAddress2' => 'Shipsville',
            'shippingCity' => 'Shipstown',
            'shippingPostcode' => '54321',
            'shippingState' => 'NY',
            'shippingCountry' => 'US',
            'shippingPhone' => '(555) 987-6543',
        ];
    }

    private function provideMergedParams($params): array
    {
        $params = array_merge($params, $this->getDefaultOptions());
        return $params;
    }
}