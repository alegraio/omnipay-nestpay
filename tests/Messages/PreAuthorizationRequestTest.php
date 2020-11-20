<?php


namespace Messages;


use Exception;
use Omnipay\NestPay\Messages\AuthorizeResponse;
use Omnipay\NestPay\Messages\PreAuthorizeRequest;
use Omnipay\NestPay\Messages\PurchaseRequest;
use Omnipay\NestPay\Messages\PurchaseResponse;
use OmnipayTest\NestPay\Messages\NestPayTestCase;

class PreAuthorizationRequestTest extends NestPayTestCase
{
    /** @var $request PreAuthorizeRequest */
    private $request;

    public function setUp()
    {
        $this->request = new PreAuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getPreAuthorizeParams());
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
        self::assertSame('25.00', $data['Total']);
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('PreAuthorizeSuccess.txt');
        /** @var AuthorizeResponse $response */
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertSame('20321RUGG00121315', $response->getTransactionReference());
        self::assertSame('https://entegrasyon.asseco-see.com.tr', $this->request->getBaseUrl());
        self::assertSame('P40241', $response->getCode());
        self::assertSame('Approved', $response->getMessage());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('PreAuthorizeFailure.txt');
        /** @var AuthorizeResponse $response */
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertNull($response->getTransactionReference());
        self::assertSame('https://entegrasyon.asseco-see.com.tr', $this->request->getBaseUrl());
        self::assertNull($response->getCode());
        self::assertSame('Bu siparis numarasi ile zaten basarili bir siparis var.', $response->getMessage());
    }
}