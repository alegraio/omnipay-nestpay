<?php

namespace OmnipayTest\NestPay\Messages;

use Exception;
use Omnipay\NestPay\Messages\CaptureRequest;
use Omnipay\NestPay\Messages\CaptureResponse;

class CaptureRequestTest extends NestPayTestCase
{
    /** @var $request CaptureRequest */
    private $request;

    public function setUp()
    {
        $this->request = new CaptureRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getCaptureParams());
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
        self::assertSame('789878987', $data['OrderId']);
        self::assertSame('949', $data['Currency']);
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('CaptureSuccess.txt');
        /** @var CaptureResponse $response */
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertSame('20325OWDB16817', $response->getTransactionReference());
        self::assertSame('https://entegrasyon.asseco-see.com.tr', $this->request->getBaseUrl());
        self::assertSame('175923', $response->getCode());
        self::assertSame('Approved', $response->getMessage());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('CaptureFailure.txt');
        /** @var CaptureResponse $response */
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertNull($response->getTransactionReference());
        self::assertSame('https://entegrasyon.asseco-see.com.tr', $this->request->getBaseUrl());
        self::assertNull($response->getCode());
        self::assertSame('PostAuth yapilamaz, uyusan PreAuth yok.', $response->getMessage());
    }
}