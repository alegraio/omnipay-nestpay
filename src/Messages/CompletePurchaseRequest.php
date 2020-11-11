<?php
/**
 * NestPay Complete Purchase Request
 */

namespace Omnipay\NestPay\Messages;

use Exception;

class CompletePurchaseRequest extends AbstractRequest
{
    use ParametersTrait;

    /**
     * @return array|mixed
     * @throws Exception
     */
    public function getData()
    {
        return $this->getParameters();
    }

    public function sendData($data)
    {
        return $this->response = $this->createResponse($data);
    }

    /**
     * @param $data
     * @return CompletePurchaseResponse
     */
    protected function createResponse($data): CompletePurchaseResponse
    {
        return new CompletePurchaseResponse($this, $data);
    }
}
