<?php


namespace Messages;


use Exception;
use Omnipay\NestPay\Messages\AuthorizeResponse;
use Omnipay\NestPay\Messages\PurchaseRequest;
use Omnipay\NestPay\Messages\PurchaseResponse;
use OmnipayTest\NestPay\Messages\NestPayTestCase;

class PurchaseRequestTest extends NestPayTestCase
{
    /** @var $request PurchaseRequest */
    private $request;

    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getPurchaseParams());
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
        self::assertSame('15.00', $data['Total']);
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        /** @var PurchaseResponse $response */
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertSame('20321RKJB00131211', $response->getTransactionReference());
        self::assertSame('https://entegrasyon.asseco-see.com.tr', $this->request->getBaseUrl());
        self::assertSame('P33807', $response->getCode());
        self::assertSame('Approved', $response->getMessage());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('PurchaseFailure.txt');
        /** @var AuthorizeResponse $response */
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertNull($response->getTransactionReference());
        self::assertSame('https://entegrasyon.asseco-see.com.tr', $this->request->getBaseUrl());
        self::assertNull($response->getCode());
        self::assertSame('Bu siparis numarasi ile zaten basarili bir siparis var.', $response->getMessage());
    }
}