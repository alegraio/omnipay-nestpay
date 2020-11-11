<?php


namespace Omnipay\NestPay\Messages;


trait ParametersTrait
{
    public function setResponseData($responseData): void
    {
        $this->setParameter('responseData', $responseData);
    }

    public function getResponseData()
    {
        return $this->getParameter('responseData');
    }

    public function getStoreKey()
    {
        return $this->getParameter('storekey');
    }

    public function setStoreKey($value)
    {
        return $this->setParameter('storekey', $value);
    }

    public function getMoneyPoints()
    {
        return $this->getParameter('moneypoints');
    }

    public function setMoneyPoints($value)
    {
        return $this->setParameter('moneypoints', $value);
    }

    public function getStoreType()
    {
        return $this->getParameter('storetype');
    }

    public function setStoreType($value)
    {
        return $this->setParameter('storetype', $value);
    }

    public function getLang()
    {
        return $this->getParameter('lang');
    }

    public function setLang($value)
    {
        return $this->setParameter('lang', $value);
    }

    public function getRefreshtime()
    {
        return $this->getParameter('refreshtime') ?: 30;
    }

    public function setRefreshtime($value)
    {
        return $this->setParameter('refreshtime', $value);
    }

    public function getCompanyName(): string
    {
        return $this->getParameter('companyName');
    }

    public function setCompanyName(string $companyName)
    {
        return $this->setParameter('companyName', $companyName);
    }
}