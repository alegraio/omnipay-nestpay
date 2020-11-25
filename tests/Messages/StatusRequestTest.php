<?php

namespace OmnipayTest\NestPay\Messages;

use Exception;
use Omnipay\NestPay\Messages\StatusRequest;
use Omnipay\NestPay\Messages\StatusResponse;

class StatusRequestTest extends NestPayTestCase
{
    /** @var $request StatusRequest */
    private $request;

    public function setUp()
    {
        $this->request = new StatusRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getStatusParams());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://entegrasyon.asseco-see.com.tr/fim/api', $this->request->getEndpoint());
    }

    /**
     * @throws Exception
     */
    public function testData(): void
    {
        $data = $this->request->getData();
        self::assertSame('6-987654321', $data['OrderId']);
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('StatusSuccess.txt');
        /** @var StatusResponse $response */
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertSame('20316QdoH00120068', $response->getTransactionReference());
        self::assertSame('https://entegrasyon.asseco-see.com.tr', $this->request->getBaseUrl());
        self::assertSame('P11271', $response->getCode());
        self::assertSame('Approved', $response->getMessage());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('StatusFailure.txt');
        /** @var StatusResponse $response */
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertNull($response->getTransactionReference());
        self::assertSame('https://entegrasyon.asseco-see.com.tr', $this->request->getBaseUrl());
        self::assertNull($response->getCode());
        self::assertSame('No record found for 25-987654321', $response->getMessage());
    }
}