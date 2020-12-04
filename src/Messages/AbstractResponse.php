<?php
/**
 * NestPay Abstract Response
 */

namespace Omnipay\NestPay\Messages;

use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse implements RedirectResponseInterface
{
    /** @var array */
    public $serviceRequestParams;

    /**
     * AbstractResponse constructor.
     * @param RequestInterface $request
     * @param $data
     * @throws \JsonException
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
        $this->data = (is_string($data)) ? json_decode(json_encode((array)simplexml_load_string($data),
            JSON_THROW_ON_ERROR), 1, 512,
            JSON_THROW_ON_ERROR) : $data;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->isSuccessful() ? $this->data['Response'] : $this->data['ErrMsg'];
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        $authCode = $this->data['AuthCode'] ?? $this->data['Extra']['AUTH_CODE'] ?? null;
        return $this->isSuccessful() ? $authCode : parent::getCode();
    }

    /**
     * @return boolean
     */
    public function isSuccessful(): bool
    {
        if (isset($this->data['ProcReturnCode'])) {
            return (string)$this->data["ProcReturnCode"] === '00' || $this->data["Response"] === 'Approved';
        }

        return false;
    }

    public function getTransactionReference(): ?string
    {
        return $this->isSuccessful() ? $this->data['TransId'] : parent::getTransactionReference();
    }

    /**
     * @return array
     */
    public function getServiceRequestParams(): array
    {
        return $this->serviceRequestParams;
    }

    /**
     * @param array $serviceRequestParams
     */
    public function setServiceRequestParams(array $serviceRequestParams): void
    {
        $this->serviceRequestParams = $serviceRequestParams;
    }
}
