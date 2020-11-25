<?php
/**
 * NestPay Capture Request
 */

namespace Omnipay\NestPay\Messages;

use Omnipay\Common\Exception\InvalidRequestException;

class CaptureRequest extends AbstractRequest
{
    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $data = $this->getSalesRequestParams();
        $this->setRequestParams($data);
        return $data;
    }

    /**
     * @param $data
     * @return CaptureResponse
     * @throws \JsonException
     */
    protected function createResponse($data): CaptureResponse
    {
        $response = new CaptureResponse($this, $data);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }

    /**
     * @inheritDoc
     */
    public function getSensitiveData(): array
    {
        return ['Number', 'Expires', 'Password'];
    }

    /**
     * @inheritDoc
     */
    public function getProcessName(): string
    {
        return 'Capture';
    }

    /**
     * @inheritDoc
     */
    public function getProcessType(): string
    {
        return 'PostAuth';
    }
}

