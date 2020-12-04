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
     * @return ResponseInterface
     * @throws InvalidResponseException
     */
    public function sendData($data)
    {
        if ($this->getPaymentMethod() === self::PAYMENT_TYPE_3D) {
            return $this->response = $this->createResponse($data, Purchase3DResponse::class);
        }
        return parent::sendData($data);
    }

    /**
     * @param $responseClass
     * @param $data
     * @return ResponseInterface
     */
    protected function createResponse($data, $responseClass = null): ResponseInterface
    {
        $class = $responseClass ?? PurchaseResponse::class;

        $response = new $class($this, $data);
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
