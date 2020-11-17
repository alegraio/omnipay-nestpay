<?php

namespace OmnipayTest\NestPay\Messages;

use Omnipay\Tests\TestCase;

class NestPayTestCase extends TestCase
{
    protected function getPurchaseParams(): array
    {
        $params = [
            'card' => $this->getValidCard(),
            'transactionId' => '6-987654321',
            'amount' => '15.00',
            'currency' => 'TRY'
        ];

        return $this->provideMergedParams($params);
    }

    protected function getRefundParams(): array
    {
        $params = [
            'transactionId' => '5-987654321',
            'amount'        => '12.00'
        ];

        return $this->provideMergedParams($params);
    }

    protected function getVoidParams(): array
    {
        $params = [
            'transactionId' => '6-987654321'
        ];

        return $this->provideMergedParams($params);
    }

    protected function getStatusParams(): array
    {
        $params = [
            'transactionId' => '6-987654321'
        ];

        return $this->provideMergedParams($params);
    }

    protected function getAuthorizeParams(): array
    {
        $params = [
            'card' => $this->getValidCard(),
            'transactionId' => '789878987',
            'amount' => '25.00',
            'currency' => 'TRY'
        ];

        return $this->provideMergedParams($params);
    }

    protected function getPurchase3DParams(): array
    {
        $params = [
            'card' => $this->getValidCard(),
            'is3d' => true,
            'storetype' => '3d_pay',
            'companyName' => 'Test Firması',
            'transactionId' => '4-987654321',
            'amount' => '30.00',
            'installment' => 1,
            'currency' => 'TRY',
            'returnUrl' => 'http://test.domain.com/success',
            'cancelUrl' => 'http://test.domain.com/fail',
            'notifyUrl' => 'http://test.domain.com/success',
            'lang' => 'tr'
        ];
        return $this->provideMergedParams($params);
    }

    protected function getPreAuthorizeParams(): array
    {
        $params = [
            'card' => $this->getValidCard(),
            'transactionId' => '789878987',
            'amount' => '25.00',
            'currency' => 'TRY'
        ];

        return $this->provideMergedParams($params);
    }

    protected function getCompletePurchaseParams(): array
    {
        $params = [
            'responseData' => [
                'mdStatus' => '1',
                'clientid' => '100100000',
                'amount' => '30.00',
                'currency' => '949',
                'xid' => 'rHFcAoktaev3RkCzzwX4C/320dU=',
                'oid' => '24-987654321',
                'cavv' => 'jKUQfB68bPMgAREBRNJEd30P3k0=',
                'eci' => '02',
                'md' => '540667:86EE8AE6E962B9F4DCF774AFA4CE0849496A48739B1DE50372426957F688FB5A:4586:##100100000',
                'rnd' => 'SVYhyeGVjzKgVeodUWnk',
                'HASHPARAMS' => 'clientid:oid:mdStatus:cavv:eci:md:rnd:',
                'HASHPARAMSVAL' => '10010000024-9876543211jKUQfB68bPMgAREBRNJEd30P3k0=02540667:86EE8AE6E962B9F4DCF774AFA4CE0849496A48739B1DE50372426957F688FB5A:4586:##100100000SVYhyeGVjzKgVeodUWnk',
                'HASH' => 'iFARz7RQzdAfSBJXkVwo9RaaL5U='
            ]
        ];
        return $this->provideMergedParams($params);
    }

    private function getDefaultOptions(): array
    {
        return [
            'testMode' => true,
            'bank' => 'akbank',
            'username' => '101506890api',
            'clientId' => '100100000',
            'password' => 'TEST1010',
            'storeKey' => '123456'
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
        $params = array_merge($this->getDefaultOptions(), $params);
        return $params;
    }
}