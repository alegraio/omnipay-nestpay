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
            'amount' => '12.00',
            'currency' => 'TRY'
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

    protected function getCaptureParams(): array
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
            'paymentMethod' => '3d',
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

    protected function getCompletePurchaseParams(): array
    {
        $params = [
            'responseData' => [
                'TRANID' => '',
                'lang' => 'tr',
                'merchantID' => '100100000',
                'amount' => '2.00',
                'Ecom_Payment_Card_ExpDate_Year' => '22',
                'clientIp' => '176.88.131.138',
                'md' => '540667:6207CFAF58C2875B561ED97E8A3C3F7CD352312D93390E110636ACF5EC869CFF:3719:##100100000',
                'taksit' => '3',
                'Ecom_Payment_Card_ExpDate_Month' => '12',
                'cavv' => 'jKUQfB68bPMgAREBRY3EpeiTv8E=',
                'xid' => 'E2o+KCaG1XbaltWgSBUrtbzq/o0=',
                'currency' => '949',
                'oid' => '3dtaksitmock',
                'mdStatus' => '1',
                'eci' => '02',
                'clientid' => '100100000',
                'HASH' => '6lzjddl4otG8RShuyQYY+grYROY=',
                'rnd' => 'e7QViooIzT6u+4MuFIci',
                'HASHPARAMS' => 'clientid:oid:mdStatus:cavv:eci:md:rnd:',
                'HASHPARAMSVAL' => '1001000003dtaksitmock1jKUQfB68bPMgAREBRY3EpeiTv8E=02540667:6207CFAF58C2875B561ED97E8A3C3F7CD352312D93390E110636ACF5EC869CFF:3719:##100100000e7QViooIzT6u+4MuFIci',
            ]
        ];
        return $this->provideMergedParams($params);
    }

    private function getDefaultOptions(): array
    {
        return [
            'testMode' => true,
            'bank' => 'akbank',
            'username' => 'akalegra',
            'clientId' => '100100000',
            'password' => 'ALG*3466',
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