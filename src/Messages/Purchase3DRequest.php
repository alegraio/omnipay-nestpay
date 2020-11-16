<?php
/**
 * NestPay Purchase Request
 */

namespace Omnipay\NestPay\Messages;

use Exception;
use Omnipay\Common\Exception\InvalidCreditCardException;

class Purchase3DRequest extends AbstractRequest
{
    use ParametersTrait;

    /**
     * @return array|mixed
     * @throws Exception
     */
    public function getData()
    {
        $this->setAction("3d");
        $redirectUrl = $this->getBaseUrl();
        $this->validate('amount', 'card');

        $cardBrand = $this->getCard()->getBrand();
        if (!array_key_exists($cardBrand, $this->allowedCardBrands)) {
            throw new InvalidCreditCardException('Card is not valid, just only Visa or MasterCard can be usable');
        }

        $data = array();
        $data['pan'] = $this->getCard()->getNumber();
        $data['cv2'] = $this->getCard()->getCvv();
        $data['Ecom_Payment_Card_ExpDate_Year'] = $this->getCard()->getExpiryDate('y');
        $data['Ecom_Payment_Card_ExpDate_Month'] = $this->getCard()->getExpiryDate('m');
        $data['cardType'] = $this->allowedCardBrands[$cardBrand];

        $data['clientid'] = $this->getClientId();
        $data['oid'] = $this->getTransactionId();
        $data['amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrencyNumeric();
        $data['lang'] = $this->getLang();
        $data['okUrl'] = $this->getReturnUrl();
        $data['failUrl'] = $this->getCancelUrl();
        $data['storetype'] = '3d_pay';
        $data['rnd'] = $this->getRnd();
        $data['firmaadi'] = $this->getCompanyName();
        $data['islemtipi'] = 'Auth';

        $data['taksit'] = null;
        if ($installment = $this->getInstallment()) {
            $data['taksit'] = $installment;
        }

        $signature = $data['clientid'] .
            $data['oid'] .
            $data['amount'] .
            $data['okUrl'] .
            $data['failUrl'] .
            $data['islemtipi'] .
            $this->getRnd() .
            $this->getStoreKey();

        $data['hash'] = base64_encode(sha1($signature, true));
        $data['redirectUrl'] = $redirectUrl;
        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new Purchase3DResponse($this, $data);
    }

    /**
     * @param $data
     * @return PurchaseResponse
     */
    protected function createResponse($data): PurchaseResponse
    {
        return new PurchaseResponse($this, $data);
    }


    public function getRnd(): string
    {
        return (string)time();
    }



}
