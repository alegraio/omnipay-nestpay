<?php
/**
 * NestPay Class using API
 */

namespace Omnipay\NestPay;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\NestPay\Messages\CompletePurchaseRequest;
use Omnipay\NestPay\Messages\Purchase3DRequest;
use Omnipay\NestPay\Messages\PurchaseRequest;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\NestPay\Messages\AuthorizeRequest;
use Omnipay\NestPay\Messages\CaptureRequest;

/**
 * @method NotificationInterface acceptNotification(array $options = array())
 * @method RequestInterface completeAuthorize(array $options = array())
 * @method RequestInterface fetchTransaction(array $options = [])
 * @method RequestInterface createCard(array $options = array())
 * @method RequestInterface updateCard(array $options = array())
 * @method RequestInterface deleteCard(array $options = array())
 * @method RequestInterface refund(array $options = array())
 * @method RequestInterface void(array $options = array())
 */
class Gateway extends AbstractGateway
{
    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     * @return string
     */
    public function getName(): string
    {
        return 'NestPay';
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
     * @return Gateway
     */
    public function setBank(string $value): Gateway
    {
        return $this->setParameter('bank', $value);
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
     * @return Gateway
     */
    public function setUserName(string $value): Gateway
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
     * @return Gateway
     */
    public function setPassword(string $value): Gateway
    {
        return $this->setParameter('password', $value);
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->getParameter('clientId');
    }

    /**
     * @param string $value
     * @return Gateway
     */
    public function setClientId(string $value): Gateway
    {
        return $this->setParameter('clientId', $value);
    }

    /**
     * @param string $storekey
     * @return Gateway
     */
    public function setStoreKey(string $storekey): Gateway
    {
        return $this->setParameter('storekey', $storekey);
    }

    /**
     * @return Gateway
     */
    public function getStoreKey(): string
    {
        return $this->getParameter('storekey');
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function authorize(array $parameters = []): RequestInterface
    {
        return $this->createRequest(AuthorizeRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function capture(array $parameters = []): RequestInterface
    {
        return $this->createRequest(CaptureRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function purchase(array $parameters = []): RequestInterface
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function purchase3D(array $parameters = []): RequestInterface
    {
        return $this->createRequest(Purchase3DRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function completePurchase(array $parameters = []): RequestInterface
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }
}
