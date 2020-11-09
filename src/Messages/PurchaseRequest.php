<?php
/**
 * NestPay Purchase Request
 */

namespace Omnipay\NestPay\Messages;

use Exception;

class PurchaseRequest extends AbstractRequest
{

    /**
     * @return array|mixed
     * @throws Exception
     */
    public function getData()
    {
        $data = $this->getRequestParams();
        $data['Type'] = 'Auth';

        return $data;
    }

    /**
     * @param $data
     * @return PurchaseResponse
     */
    protected function createResponse($data): PurchaseResponse
    {
        return new PurchaseResponse($this, $data);
    }
}
