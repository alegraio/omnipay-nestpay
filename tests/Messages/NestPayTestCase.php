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
        return $this->provideMergedParams($params);
    }

    private function getDefaultOptions(): array
    {
        return [
            'testMode' => true,
            'bank' => 'akbank',
            'username' => '101506890api',
            'clientId' => '100100000',
            'password' => 'TEST2020',
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