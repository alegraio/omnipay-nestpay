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
        $threeDParams = $this->get3DPayCredentials();

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
        $params = array_merge($threeDParams, $params);
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
        $threeDParams = $this->get3DPayCredentials();
        $params = [
            'responseData' => [
                'Response' => 'Approved',
                'ProcReturnCode' => '00',
                'mdStatus' => '1',
                'clientid' => '400000200',
                'oid' => '2-987654321',
                'AuthCode' => '972997',
                'cavv' => 'jGkoiZhEWbH0AREBQ3kcPM98klY=',
                'eci' => '02',
                'md' => '540667:7C0AB35D13DF263AE7B84426D4555BEFC5F474469B51BABAD82A3A5E17E32E89:3970:##400000200',
                'rnd' => 'IIZ5Vut6TgEbCjLDka9+',
                'HASHPARAMS' => 'clientid:oid:AuthCode:ProcReturnCode:Response:mdStatus:cavv:eci:md:rnd:',
                'HASHPARAMSVAL' => '4000002002-98765432197299700Approved1jGkoiZhEWbH0AREBQ3kcPM98klY=02540667:7C0AB35D13DF263AE7B84426D4555BEFC5F474469B51BABAD82A3A5E17E32E89:3970:##400000200IIZ5Vut6TgEbCjLDka9+',
                'HASH' => 'vVTs+SYyFsA8U+tQmGDqg3cunXY='
            ]
        ];
        $params = array_merge($threeDParams, $params);
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
        $params = array_merge($this->getDefaultOptions(), $params);
        return $params;
    }

    private function get3DPayCredentials(): array
    {
        return [
            'clientId' => '400000200',
            'storeKey' => 'TRPS0200'
        ];
    }
}