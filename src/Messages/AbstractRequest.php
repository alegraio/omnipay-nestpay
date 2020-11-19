<?php
/**
 * NestPay Abstract Request
 */

namespace Omnipay\NestPay\Messages;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\NestPay\ThreeDResponse;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    use RequestTrait;

    private $root;

    /** @var \DOMDocument */
    private $document;

    private $action = "purchase";

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->getParameter('clientId');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setClientId(string $value): AbstractRequest
    {
        return $this->setParameter('clientId', $value);
    }

    /**
     * @return string
     */
    public function getAction(): ?string
    {
        return $this->action;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setAction(string $value): void
    {
        $this->action = $value;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->getParameter('username');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setUserName(string $value): AbstractRequest
    {
        return $this->setParameter('username', $value);
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->getParameter('password');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setPassword(string $value): AbstractRequest
    {
        return $this->setParameter('password', $value);
    }

    /**
     * @param mixed $data
     * @return ResponseInterface|AbstractResponse
     * @throws InvalidResponseException
     */
    public function sendData($data)
    {
        try {
            $shipInfo = isset($data['ship']) ? $data['ship'] : [];
            $billInfo = isset($data['bill']) ? $data['bill'] : [];
            unset($data['ship'], $data['bill']);

            $this->document = new \DOMDocument('1.0', 'UTF-8');
            $this->root = $this->document->createElement('CC5Request');

            foreach ($data as $id => $value) {
                $this->root->appendChild($this->document->createElement($id, $value));
            }

            $extra = $this->document->createElement('Extra');

            if (!empty($this->getStatus())) {
                $extra->appendChild($this->document->createElement('ORDERSTATUS', 'QUERY'));
                $this->root->appendChild($extra);
            }

            $this->document->appendChild($this->root);
            $this->addShipAndBillToXml($shipInfo, $billInfo);
            $httpRequest = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(),
                ['Content-Type' => 'application/x-www-form-urlencoded'], $this->document->saveXML());

            $response = (string)$httpRequest->getBody()->getContents();

            return $this->response = $this->createResponse($response);
        } catch (\Exception $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    /**
     * @return string
     */
    public function getInstallment(): ?string
    {
        return $this->getParameter('installment');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setInstallment(string $value): AbstractRequest
    {
        return $this->setParameter('installment', $value);
    }

    /**
     * @return string
     */
    public function getBank(): string
    {
        return $this->getParameter('bank');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setBank(string $value): AbstractRequest
    {
        return $this->setParameter('bank', $value);
    }

    /**
     * @return string
     */
    public function getStatus(): ?string
    {
        return $this->getParameter('status');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setStatus(string $value): AbstractRequest
    {
        return $this->setParameter('status', $value);
    }

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    protected function getHttpMethod(): string
    {
        return 'POST';
    }

    /**
     * @return array
     * @throws InvalidRequestException
     */
    protected function getRequestParams(): array
    {
        $gateway = $this->getBank();

        if (!array_key_exists($gateway, $this->baseUrls)) {
            throw new \InvalidArgumentException('Invalid Gateway');
        }

        $data['Mode'] = $this->getTestMode() ? 'T' : 'P';
        $data['Name'] = $this->getUserName();
        $data['ClientId'] = $this->getClientId();
        $data['Password'] = $this->getPassword();
        $data['Email'] = $this->getCard()->getEmail();
        $data['OrderId'] = $this->getTransactionId();
        $data['GroupId'] = '';
        $data['TransId'] = '';
        $data['UserId'] = '';
        $data['Currency'] = $this->getCurrencyNumeric();
        $data['Installment'] = $this->getInstallment();
        $data['Total'] = $this->getAmount();
        $data['Number'] = $this->getCard()->getNumber();
        $data['Expires'] = $this->getCard()->getExpiryDate('my');
        $data['Cvv2Val'] = $this->getCard()->getCvv();
        $data['IPAddress'] = $this->getClientIp();
        $data = $this->getShipAndBill($data);

        return $data;
    }

    /**
     * @param ThreeDResponse $threeDResponse
     * @return array
     */
    protected function getCompletePurchaseParams(ThreeDResponse $threeDResponse): array
    {
        $data['Name'] = $this->getUserName();
        $data['Password'] = $this->getPassword();
        $data['ClientId'] = $threeDResponse->getClientId();
        $data['IPAddress'] = $threeDResponse->getIpAddress();
        $data['Mode'] = ($this->getTestMode()) ? 'T' : 'P';
        $data['Number'] = $threeDResponse->getMd();
        $data['OrderId'] = $threeDResponse->getOid();
        $data['GroupId'] = $threeDResponse->getGroupId() ?? '';
        $data['TransId'] = $threeDResponse->getTransId() ?? '';
        $data['UserId'] = $threeDResponse->getUserId() ?? '';
        $data['Type'] = 'Auth';
        $data['Expires'] = '';
        $data['Cvv2Val'] = '';
        $data['Total'] = $threeDResponse->getAmount();
        $data['Currency'] = $threeDResponse->getCurrency();
        $installment = $threeDResponse->getInstallment();
        if (empty($installment) || (int)$installment < 2) {
            $installment = '';
        }
        $data['Taksit'] = $installment;
        $data['PayerTxnId'] = $threeDResponse->getXid();
        $data['PayerSecurityLevel'] = $threeDResponse->getEci();
        $data['PayerAuthenticationCode'] = $threeDResponse->getCavv();
        $data['CardholderPresentCode'] = 13;
        $data['bill'] = $this->getBillTo();
        $data['ship'] = $this->getShipTo();
        $data['Extra'] = '';
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    private function getShipAndBill(array &$data): array
    {
        if ($this->getCard() && !empty($this->getCard()->getFirstName())) {
            $data['ship'] = [
                'Name' => $this->getCard()->getFirstName() . ' ' . $this->getCard()->getLastName(),
                'Street1' => $this->getCard()->getShippingAddress1(),
                'Street2' => $this->getCard()->getShippingAddress2(),
                'Street3' => '',
                'City' => $this->getCard()->getShippingCity(),
                'StateProv' => $this->getCard()->getShippingState(),
                'PostalCode' => $this->getCard()->getShippingPostcode(),
                'Country' => $this->getCard()->getShippingCountry(),
                'Company' => $this->getCard()->getCompany(),
                'TelVoice' => $this->getCard()->getShippingPhone()
            ];
            $data['bill'] = [
                'Name' => $this->getCard()->getFirstName() . ' ' . $this->getCard()->getLastName(),
                'Street1' => $this->getCard()->getBillingAddress1(),
                'Street2' => $this->getCard()->getBillingAddress2(),
                'Street3' => '',
                'City' => $this->getCard()->getBillingCity(),
                'StateProv' => $this->getCard()->getBillingState(),
                'PostalCode' => $this->getCard()->getBillingPostcode(),
                'Country' => $this->getCard()->getBillingCountry(),
                'Company' => $this->getCard()->getCompany(),
                'TelVoice' => $this->getCard()->getBillingPhone()
            ];
        }

        return $data;
    }

    /**
     * @param array $ship
     * @param array $bill
     */
    private function addShipAndBillToXml(array $ship, array $bill): void
    {
        if (count($ship) > 0 && count($bill) > 0) {
            $shipTo = $this->document->createElement('ShipTo');
            foreach ($ship as $id => $value) {
                $shipTo->appendChild($this->document->createElement($id, $value));
            }

            $this->root->appendChild($shipTo);

            $billTo = $this->document->createElement('BillTo');
            foreach ($bill as $id => $value) {
                $billTo->appendChild($this->document->createElement($id, $value));
            }

            $this->root->appendChild($billTo);
        }
    }

    private function getBillTo(): array
    {
        return [
            'Name' => '',
            'Street1' => '',
            'Street2' => '',
            'Street3' => '',
            'City' => '',
            'StateProv' => '',
            'PostalCode' => '',
            'Country' => '',
            'Company' => '',
            'TelVoice' => '',
        ];
    }

    private function getShipTo(): array
    {
        return [
            'Name' => '',
            'Street1' => '',
            'Street2' => '',
            'Street3' => '',
            'City' => '',
            'StateProv' => '',
            'PostalCode' => '',
            'Country' => ''
        ];
    }
}
