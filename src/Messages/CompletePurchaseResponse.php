<?php
/**
 * NestPay Complete Purchase Response
 */

namespace Omnipay\NestPay\Messages;

class CompletePurchaseResponse extends AbstractResponse
{
    use RequestTrait;

    public function isSuccessful(): bool
    {
        return $this->checkResponse() && $this->checkHash();
    }

    private function checkResponse(): bool
    {
        $data = $this->getData();
        $responseData = $data['responseData'];
        $response = $responseData['Response'];
        $procReturnCode = $responseData['ProcReturnCode'];
        $mdStatus = $responseData['mdStatus'];
        return ($response === 'Approved') && ($procReturnCode === '00') && ((string)$mdStatus === '1');
    }

    private function checkHash(): bool
    {
        $data = $this->getData();
        $responseData = $data['responseData'];
        $responseHash = $responseData['HASH'];
        $generatedHash = $this->getGeneratedHash();
        return ($responseHash === $generatedHash);
    }

    private function getGeneratedHash(): string
    {
        $data = $this->getData();
        $responseData = $data['responseData'];
        $hashParamsVal = $responseData['HASHPARAMSVAL'];
        $storeKey = $data['storekey'];
        $signature = $hashParamsVal . $storeKey;
        return base64_encode(sha1($signature, true));
    }
}
