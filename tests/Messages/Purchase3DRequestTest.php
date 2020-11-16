<?php


namespace Messages;


use Exception;
use Omnipay\NestPay\Messages\AuthorizeRequest;
use Omnipay\NestPay\Messages\AuthorizeResponse;
use Omnipay\NestPay\Messages\CompletePurchaseRequest;
use Omnipay\NestPay\Messages\CompletePurchaseResponse;
use Omnipay\NestPay\Messages\Purchase3DRequest;
use Omnipay\NestPay\Messages\Purchase3DResponse;
use OmnipayTest\NestPay\Messages\NestPayTestCase;

class Purchase3DRequestTest extends NestPayTestCase
{
    /** @var $request Purchase3DRequest */
    private $request;

    public function setUp()
    {
        $this->request = new Purchase3DRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setAction('3d');
        $this->request->initialize($this->getPurchase3DParams());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://entegrasyon.asseco-see.com.tr/fim/est3Dgate', $this->request->getEndpoint());
    }

    /**
     * @throws Exception
     */
    public function testData(): void
    {
        $data = $this->request->getData();
        self::assertSame('3d_pay', $data['storetype']);
        self::assertSame('http://test.domain.com/success', $data['okUrl']);
    }

    public function testSendSuccess(): void
    {
        // $this->setMockHttpResponse('Purchase3DSuccess.txt');
        /** @var Purchase3DResponse $response */
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertTrue($response->isRedirect());
        self::assertSame('https://entegrasyon.asseco-see.com.tr/fim/est3Dgate', $response->getRedirectUrl());
    }
}