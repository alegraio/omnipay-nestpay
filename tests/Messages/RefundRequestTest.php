<?php


namespace Messages;


use Exception;
use Omnipay\NestPay\Messages\RefundRequest;
use Omnipay\NestPay\Messages\RefundResponse;
use OmnipayTest\NestPay\Messages\NestPayTestCase;

class RefundRequestTest extends NestPayTestCase
{
    /** @var $request RefundRequest */
    private $request;

    public function setUp()
    {
        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getRefundParams());
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
        self::assertSame('5-987654321', $data['OrderId']);
        self::assertSame('12.00', $data['Total']);
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('RefundSuccess.txt');
        /** @var RefundResponse $response */
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertSame('20322JqxE00101847', $response->getTransactionReference());
        self::assertSame('https://testvpos.asseco-see.com.tr', $this->request->getBaseUrl());
        self::assertSame('P25203', $response->getCode());
        self::assertSame('Approved', $response->getMessage());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('RefundFailure.txt');
        /** @var RefundResponse $response */
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertNull($response->getTransactionReference());
        self::assertSame('https://testvpos.asseco-see.com.tr', $this->request->getBaseUrl());
        self::assertNull($response->getCode());
        self::assertSame('Iade yapilamaz, siparis gunsonuna girmemis.', $response->getMessage());
    }
}