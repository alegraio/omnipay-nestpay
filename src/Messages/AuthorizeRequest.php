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
        $data['Type'] = 'PostAuth';

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

