<?php


namespace Omnipay\NestPay\Messages;


class VoidRequest extends AbstractRequest
{

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $data['OrderId'] = $this->getTransactionId();
        $this->setStatus(true);
        // $data['Currency'] = $this->getCurrencyNumeric();
        // $data['Total'] = $this->getAmount();

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
}