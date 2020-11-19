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
        $this->request->initialize($this->getCompletePurchaseParams());
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
        self::assertSame('E2o+KCaG1XbaltWgSBUrtbzq/o0=', $data['PayerTxnId']);
        self::assertSame('jKUQfB68bPMgAREBRY3EpeiTv8E=', $data['PayerAuthenticationCode']);
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('CompletePurchaseSuccess.txt');
        /** @var CompletePurchaseResponse $response */
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertSame('808739', $response->getCode());
        self::assertSame('20324QCoD16198', $response->getTransactionReference());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('CompletePurchaseFailure.txt');
        /** @var CompletePurchaseResponse $response */
        $response = $this->request->send();
        self::assertFalse($response->isSuccessful());
    }
}