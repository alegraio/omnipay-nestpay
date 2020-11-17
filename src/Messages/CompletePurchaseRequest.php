<?php
/**
 * NestPay Complete Purchase Request
 */

namespace Omnipay\NestPay\Messages;

use Exception;
use Omnipay\NestPay\ThreeDResponse;
use RuntimeException;

class CompletePurchaseRequest extends AbstractRequest
{
    use ParametersTrait;

    /** @var ThreeDResponse */
    private $threeDResponse;

    /**
     * @return array|mixed
     * @throws Exception
     */
    public function getData()
    {
        $this->threeDResponse = $this->getThreeDResponse();
        if (!in_array($this->threeDResponse->getMdStatus(), [1, 2, 3, 4], false)) {
            throw new RuntimeException('3DSecure verification error');
        }

        if (!$this->checkHash()) {
            throw new RuntimeException('Hash data invalid');
        }

        return $this->getCompletePurchaseParams($this->threeDResponse);
    }

    /**
     * @param $data
     * @return CompletePurchaseResponse
     */
    protected function createResponse($data): CompletePurchaseResponse
    {
        return new CompletePurchaseResponse($this, $data);
    }

    private function getThreeDResponse(): ThreeDResponse
    {
        $threeDResponse = new ThreeDResponse();
        $responseData = $this->getResponseData();
        $threeDResponse->setMdStatus($responseData['mdStatus']);
        $threeDResponse->setClientId($responseData['clientid']);
        $threeDResponse->setAmount($responseData['amount']);
        $threeDResponse->setCurrency($responseData['currency']);
        $threeDResponse->setXid($responseData['xid']);
        $threeDResponse->setOid($responseData['oid']);
        $threeDResponse->setCavv($responseData['cavv']);
        $threeDResponse->setEci($responseData['eci']);
        $threeDResponse->setMd($responseData['md']);
        $threeDResponse->setRnd($responseData['rnd']);
        $threeDResponse->setHashParams($responseData['HASHPARAMS']);
        $threeDResponse->setHashParamsVal($responseData['HASHPARAMSVAL']);
        $threeDResponse->setHash($responseData['HASH']);
        return $threeDResponse;
    }

    private function checkHash(): bool
    {
        $responseHash = $this->threeDResponse->getHash();
        $generatedHash = $this->getGeneratedHash();
        return ($responseHash === $generatedHash);
    }

    private function getGeneratedHash(): string
    {
        $hashParamsVal = $this->threeDResponse->getHashParamsVal();
        $storeKey = $this->getStoreKey();
        $signature = $hashParamsVal . $storeKey;
        return base64_encode(sha1($signature, true));
    }

    public function getEndpoint(): string
    {
        $bank = $this->getBank();
        if ($this->getTestMode()) {
            return $this->baseUrls['test']['3d']['baseUrl'] . $this->url['test']['purchase'];
        }
        return $this->baseUrls[$bank]['baseUrl'] . $this->url['purchase'];
    }
}
