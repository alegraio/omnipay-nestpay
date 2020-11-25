<?php
/**
 * NestPay Authorize Request
 */

namespace Omnipay\NestPay\Messages;

use Exception;

class AuthorizeRequest extends AbstractRequest
{

    /**
     * @return array
     * @throws Exception
     */
    public function getData(): array
    {
        $data = $this->getSalesRequestParams();
        $this->setRequestParams($data);
        return $data;
    }

    /**
     * @param $data
     * @return AuthorizeResponse
     * @throws \JsonException
     */
    protected function createResponse($data): AuthorizeResponse
    {
        $response = new AuthorizeResponse($this, $data);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }

    /**
     * @return array
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
        return 'Authorize';
    }

    /**
     * @inheritDoc
     */
    public function getProcessType(): string
    {
        return 'PreAuth';
    }
}

