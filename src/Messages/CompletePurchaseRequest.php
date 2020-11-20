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
        $data = $this->getCompletePurchaseParams($this->threeDResponse);
        $this->setRequestParams($data);
        return $data;
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
        $ipAddress = $responseData['clientIp'] ?? null;
        $installment = $responseData['taksit'] ?? null;
        $userId = $responseData['userId'] ?? null;
        $groupId = $responseData['groupId'] ?? null;
        $transId = $responseData['TRANID'] ?? null;
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
        if ($ipAddress !== null) {
            $threeDResponse->setIpAddress($ipAddress);
        }
        $threeDResponse->setInstallment($installment);
        $threeDResponse->setUserId($userId);
        $threeDResponse->setGroupId($groupId);
        $threeDResponse->setTransId($transId);
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
    /**
     * @inheritDoc
     */
    public function getSensitiveData(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getProcessName(): string
    {
        return 'CompletePurchase';
    }

    /**
     * @inheritDoc
     */
    public function getProcessType(): string
    {
        return 'Auth';
    }
}
