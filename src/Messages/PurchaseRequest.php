<?php
/**
 * NestPay Purchase Request
 */

namespace Omnipay\NestPay\Messages;

use Exception;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;

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
        } else {
            $data = $this->getSalesRequestParams();
        }

        $this->setRequestParams($data);
        return $data;
    }

    /**
     * @param mixed $data
     * @return ResponseInterface|AbstractResponse|Purchase3DResponse
     * @throws \JsonException
     * @throws InvalidResponseException
     */
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
     * @throws \JsonException
     */
    protected function createResponse($data): PurchaseResponse
    {
        $response = new PurchaseResponse($this, $data);
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
