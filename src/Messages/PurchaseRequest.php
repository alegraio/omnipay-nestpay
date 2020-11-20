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
            $data = $this->getPurchase3DData();
            $this->setRequestParams($data);
            return $data;
        }
        $data = $this->getRequestParams();
        $this->setRequestParams($data);
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


    /**
     * @return array
     */
    public function getSensitiveData(): array
    {
        return ['Number', 'ExpireDate'];
    }

    /**
     * @inheritDoc
     */
    public function getProcessName(): string
    {
        if ($this->getPaymentMethod() === self::PAYMENT_TYPE_3D) {
            return 'Purchase3D';
        }
        return 'Purchase';
    }

    /**
     * @inheritDoc
     */
    public function getProcessType(): string
    {
        return 'Auth';
    }
}
