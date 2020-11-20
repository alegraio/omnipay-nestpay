<?php


namespace Omnipay\NestPay\Messages;


class VoidRequest extends AbstractRequest
{

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $data['Type'] = $this->getProcessType();
        $data['OrderId'] = $this->getTransactionId();
        $data['Name'] = $this->getUserName();
        $data['Password'] = $this->getPassword();
        $data['ClientId'] = $this->getClientId();
        // $data['Currency'] = $this->getCurrencyNumeric();
        // $data['Total'] = $this->getAmount();

        $this->setRequestParams($data);
        return $data;
    }

    /**
     * @param $data
     * @return VoidResponse
     */
    protected function createResponse($data): VoidResponse
    {
        return new VoidResponse($this, $data);
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
        return 'Void';
    }

    /**
     * @inheritDoc
     */
    public function getProcessType(): string
    {
        return 'Void';
    }
}