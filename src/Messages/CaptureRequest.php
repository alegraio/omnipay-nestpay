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
        $data = $this->getRequestParams();
        $this->setRequestParams($data);
        return $data;
    }

    /**
     * @param $data
     * @return CaptureResponse
     */
    protected function createResponse($data): CaptureResponse
    {
        return new CaptureResponse($this, $data);
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

