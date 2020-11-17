<?php
/**
 * NestPay Abstract Response
 */

namespace Omnipay\NestPay\Messages;

use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse implements RedirectResponseInterface
{

    /**
     * AbstractResponse constructor.
     * @param RequestInterface $request
     * @param $data
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
        $this->data = (is_string($data)) ? (array)simplexml_load_string($data) : $data;
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
        $authCode = $this->data['AuthCode'] ?? $this->data['EXTRA']['AUTH_CODE'] ?? null;
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
}
