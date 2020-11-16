<?php


namespace Messages;


use Exception;
use Omnipay\NestPay\Messages\AuthorizeRequest;
use Omnipay\NestPay\Messages\AuthorizeResponse;
use Omnipay\NestPay\Messages\CompletePurchaseRequest;
use Omnipay\NestPay\Messages\CompletePurchaseResponse;
use OmnipayTest\NestPay\Messages\NestPayTestCase;

class CompletePurchaseRequestTest extends NestPayTestCase
{
    /** @var $request CompletePurchaseRequest */
    private $request;

    public function setUp()
    {
        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setAction('3d');
        $this->request->initialize($this->getCompletePurchaseParams());
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
        self::assertSame('jGkoiZhEWbH0AREBQ3kcPM98klY=', $data['responseData']['cavv']);
        self::assertSame('vVTs+SYyFsA8U+tQmGDqg3cunXY=', $data['responseData']['HASH']);
    }

    public function testSendSuccess(): void
    {
        /** @var CompletePurchaseResponse $response */
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertSame('972997', $response->getCode());
    }

    public function testSendError(): void
    {
        // TODO
    }
}