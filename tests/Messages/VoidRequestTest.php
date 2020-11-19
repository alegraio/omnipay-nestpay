<?php


namespace Messages;


use Exception;
use Omnipay\NestPay\Messages\VoidRequest;
use Omnipay\NestPay\Messages\VoidResponse;
use OmnipayTest\NestPay\Messages\NestPayTestCase;

class VoidRequestTest extends NestPayTestCase
{
    /** @var $request VoidRequest */
    private $request;

    public function setUp()
    {
        $this->request = new VoidRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getVoidParams());
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
        $this->setMockHttpResponse('VoidSuccess.txt');
        /** @var VoidResponse $response */
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertSame('20322JqxE00101847', $response->getTransactionReference());
        self::assertSame('https://entegrasyon.asseco-see.com.tr', $this->request->getBaseUrl());
        self::assertSame('P25203', $response->getCode());
        self::assertSame('Approved', $response->getMessage());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('VoidFailure.txt');
        /** @var VoidResponse $response */
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertNull($response->getTransactionReference());
        self::assertSame('https://entegrasyon.asseco-see.com.tr', $this->request->getBaseUrl());
        self::assertNull($response->getCode());
        self::assertSame('ï¿½ptal edilmeye uygun satï¿½ï¿½ iï¿½lemi bulunamadï¿½.', $response->getMessage());
    }
}