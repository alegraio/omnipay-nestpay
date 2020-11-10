<?php
/**
 * NestPay Authorize Request
 */

namespace Omnipay\NestPay\Messages;

class AuthorizePostRequest extends AbstractRequest
{

    /**
     * @return array
     * @throws \Exception
     */
    public function getData(): array
    {
        $this->setAction("3d");
        $data = $this->getRequestParams();
        $data['Type'] = 'PreAuth';

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
}

