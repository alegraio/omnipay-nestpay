<?php


namespace Omnipay\NestPay\Messages;


use Omnipay\Common\Exception\InvalidRequestException;

class RefundRequest extends AbstractRequest
{

    /**
     * @inheritDoc
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('amount');

        $data['Type'] = $this->getProcessType();
        $data['Name'] = $this->getUserName();
        $data['Password'] = $this->getPassword();
        $data['ClientId'] = $this->getClientId();
        $data['OrderId'] = $this->getTransactionId();
        $data['Total'] = $this->getAmount();
        $data['Currency'] = $this->getCurrencyNumeric();

        $this->setRequestParams($data);
        return $data;
    }

    /**
     * @param $data
     * @return RefundResponse
     */
    protected function createResponse($data): RefundResponse
    {
        return new RefundResponse($this, $data);
    }

    /**
     * @return array
     */
    public function getSensitiveData(): array
    {
        return ['Password'];
    }

    /**
     * @inheritDoc
     */
    public function getProcessName(): string
    {
        return 'Refund';
    }

    /**
     * @inheritDoc
     */
    public function getProcessType(): string
    {
        return 'Credit';
    }
}