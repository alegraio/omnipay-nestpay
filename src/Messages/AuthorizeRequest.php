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
        $data = $this->getRequestParams();
        $this->setRequestParams($data);
        return $data;
    }

    /**
     * @param $data
     * @return AuthorizeResponse
     */
    protected function createResponse($data): AuthorizeResponse
    {
        return new AuthorizeResponse($this, $data);
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

