<?php


namespace Messages;


use Exception;
use Omnipay\NestPay\Messages\AuthorizeRequest;
use Omnipay\NestPay\Messages\AuthorizeResponse;
use OmnipayTest\NestPay\Messages\NestPayTestCase;

class AuthorizeRequestTest extends NestPayTestCase
{
    /** @var $request AuthorizeRequest */
    private $request;

    public function setUp()
    {
        $this->request = new AuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getAuthorizeParams());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://testvpos.asseco-see.com.tr/fim/api', $this->request->getEndpoint());
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
        $this->setMockHttpResponse('AuthorizeSuccess.txt');
        /** @var AuthorizeResponse $response */
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertSame('20321RkaD00131468', $response->getTransactionReference());
        self::assertSame('https://testvpos.asseco-see.com.tr', $this->request->getBaseUrl());
        self::assertSame('P42324', $response->getCode());
        self::assertSame('Approved', $response->getMessage());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('AuthorizeFailure.txt');
        /** @var AuthorizeResponse $response */
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertNull($response->getTransactionReference());
        self::assertSame('https://testvpos.asseco-see.com.tr', $this->request->getBaseUrl());
        self::assertNull($response->getCode());
        self::assertSame('PostAuth sadece iliskili bir PreAuth icin yapilabilir.', $response->getMessage());
    }
}