<?php
/**
 * NestPay Purchase Request
 */

namespace Omnipay\NestPay\Messages;

use Exception;

class PurchaseRequest extends AbstractRequest
{
    private const PAYMENT_TYPE_3D = "3d";

    /**
     * @return array|mixed
     * @throws Exception
     */
    public function getData()
    {
        if ($this->getPaymentMethod() === self::PAYMENT_TYPE_3D) {
            $this->setAction('3d');
            return $this->getPurchase3DData();
        }
        $data = $this->getRequestParams();
        $data['Type'] = 'Auth';

        return $data;
    }

    public function sendData($data)
    {
        if ($this->getPaymentMethod() === self::PAYMENT_TYPE_3D) {
            return $this->response = new Purchase3DResponse($this, $data);
        }
        return parent::sendData($data);
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
