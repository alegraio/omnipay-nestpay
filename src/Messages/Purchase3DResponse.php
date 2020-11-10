<?php
/**
 * NestPay Purchase 3D Response
 */

namespace Omnipay\NestPay\Messages;


use DOMDocument;

class Purchase3DResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return true;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return $this->data['redirectUrl'];
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        $redirectUrl = $this->data['redirectUrl'];
        $parameters = $this->data;
        $htmlContent = $this->getRedirectHtmlData();
        $data['redirectUrl'] = $redirectUrl;
        $data['parameters'] = $parameters;
        $data['htmlContent'] = $htmlContent;

        return $data;
    }

    private function getRedirectHtmlData()
    {
        $dom = new DOMDocument('1.0');
        $formData = $this->data;

        $html = $dom->createElement('html');
        $html->setAttribute('lang', 'en');
        $html->setAttribute('xmlns', 'http://www.w3.org/1999/xhtml');

        $body = $dom->createElement('body');
        $form = $dom->createElement('form');

        $form->setAttribute('method', 'post');
        $form->setAttribute('action', $formData['redirectUrl']);

        $clientId = $dom->createElement('input');
        $cardType = $dom->createElement('input');
        $storeType = $dom->createElement('input');
        $hash = $dom->createElement('input');
        $islemTipi = $dom->createElement('input');
        $amount = $dom->createElement('input');
        $currency = $dom->createElement('input');
        $oid = $dom->createElement('input');
        $encoding = $dom->createElement('input');
        $okUrl = $dom->createElement('input');
        $failUrl = $dom->createElement('input');
        $lang = $dom->createElement('input');
        $rnd = $dom->createElement('input');
        $pan = $dom->createElement('input');
        $ecomPaymentCardExpDateYear = $dom->createElement('input');
        $ecomPaymentCardExpDateMonth = $dom->createElement('input');

        $clientId->setAttribute('name', 'clientid');
        $clientId->setAttribute('type', 'hidden');
        $clientId->setAttribute('value', $formData['clientid']);

        $cardType->setAttribute('name', 'cardType');
        $cardType->setAttribute('type', 'hidden');
        $cardType->setAttribute('value', $formData['cardType']);

        $storeType->setAttribute('name', 'storetype');
        $storeType->setAttribute('type', 'hidden');
        $storeType->setAttribute('value', $formData['storetype']);

        $hash->setAttribute('name', 'hash');
        $hash->setAttribute('type', 'hidden');
        $hash->setAttribute('value', $formData['hash']);

        $islemTipi->setAttribute('name', 'islemtipi');
        $islemTipi->setAttribute('type', 'hidden');
        $islemTipi->setAttribute('value', $formData['islemtipi']);

        $amount->setAttribute('name', 'amount');
        $amount->setAttribute('type', 'hidden');
        $amount->setAttribute('value', $formData['amount']);

        $currency->setAttribute('name', 'currency');
        $currency->setAttribute('type', 'hidden');
        $currency->setAttribute('value', $formData['currency']);

        $oid->setAttribute('name', 'oid');
        $oid->setAttribute('type', 'hidden');
        $oid->setAttribute('value', $formData['oid']);


        $encoding->setAttribute('name', 'encoding');
        $encoding->setAttribute('type', 'hidden');
        $encoding->setAttribute('value', 'UTF-8');

        $lang->setAttribute('name', 'lang');
        $lang->setAttribute('type', 'hidden');
        $lang->setAttribute('value', $formData['lang']);

        $okUrl->setAttribute('name', 'okUrl');
        $okUrl->setAttribute('type', 'hidden');
        $okUrl->setAttribute('value', $formData['okUrl']);

        $failUrl->setAttribute('name', 'failUrl');
        $failUrl->setAttribute('type', 'hidden');
        $failUrl->setAttribute('value', $formData['failUrl']);

        $rnd->setAttribute('name', 'rnd');
        $rnd->setAttribute('type', 'hidden');
        $rnd->setAttribute('value', $formData['rnd']);

        $pan->setAttribute('name', 'pan');
        $pan->setAttribute('type', 'hidden');
        $pan->setAttribute('value', $formData['pan']);

        $ecomPaymentCardExpDateYear->setAttribute('name', 'Ecom_Payment_Card_ExpDate_Year');
        $ecomPaymentCardExpDateYear->setAttribute('type', 'hidden');
        $ecomPaymentCardExpDateYear->setAttribute('value', $formData['Ecom_Payment_Card_ExpDate_Year']);

        $ecomPaymentCardExpDateMonth->setAttribute('name', 'Ecom_Payment_Card_ExpDate_Month');
        $ecomPaymentCardExpDateMonth->setAttribute('type', 'hidden');
        $ecomPaymentCardExpDateMonth->setAttribute('value', $formData['Ecom_Payment_Card_ExpDate_Month']);

        $form->appendChild($clientId);
        $form->appendChild($cardType);
        $form->appendChild($storeType);
        $form->appendChild($hash);
        $form->appendChild($islemTipi);
        $form->appendChild($amount);
        $form->appendChild($currency);
        $form->appendChild($oid);
        $form->appendChild($encoding);
        $form->appendChild($okUrl);
        $form->appendChild($failUrl);
        $form->appendChild($lang);
        $form->appendChild($rnd);
        $form->appendChild($pan);
        $form->appendChild($ecomPaymentCardExpDateYear);
        $form->appendChild($ecomPaymentCardExpDateMonth);


        $button = $dom->createElement('input');
        $button->setAttribute('type', 'submit');
        $button->setAttribute('value', 'Send Me');
        $form->appendChild($button);

        $body->appendChild($form);
        $html->appendChild($body);

        $dom->appendChild($html);
        return $dom->saveHTML();

    }
}
