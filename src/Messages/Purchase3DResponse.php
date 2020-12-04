<?php
/**
 * NestPay Purchase 3D Response
 */

namespace Omnipay\NestPay\Messages;

class Purchase3DResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return true;
    }

    public function isRedirect(): bool
    {
        return true;
    }

    public function getRedirectUrl(): ?string
    {
        return $this->data['redirectUrl'];
    }

    public function getRedirectMethod(): string
    {
        return 'POST';
    }

    public function getRedirectData(): array
    {
        return $this->getData();
    }
}
