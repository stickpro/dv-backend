<?php
declare(strict_types=1);

namespace App\Services\Processing;

use App\Enums\Blockchain;
use App\Enums\HttpMethod;
use App\Exceptions\ProcessingException;
use App\Exceptions\ProcessingResultException;
use App\Services\Processing\Contracts\Client;
use App\Services\Processing\Contracts\MnemonicContract;
use App\Services\Processing\Contracts\OwnerContract;
use App\Services\Processing\Contracts\TransferContract;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * ProcessingService
 */
class ProcessingService implements MnemonicContract, OwnerContract, TransferContract
{
    /**
     * @param Client $client
     */
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * @param int $size
     *
     * @return string
     */
    public function generate(int $size = self::SIZE): string
    {
        $res = $this->client->request(HttpMethod::GET, '/mnemonic', ['size' => (string)$size]);

        if ($res->getStatusCode() != Response::HTTP_OK) {
            throw new ProcessingException(__('Cannot get a mnemonic phrase'), $res);
        }

        $json = json_decode((string)$res->getBody(), true);

        $result = $json['result'] ?? null;
        if (!$result) {
            throw new ProcessingResultException(__('Mnemonic is empty'));
        }

        return $result;
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public function createOwner(string $id): string
    {
        $res = $this->client->request(HttpMethod::POST, '/owners', ['id' => $id]);

        if ($res->getStatusCode() != Response::HTTP_CREATED) {
            throw new ProcessingException(__('Cannot create owner'), $res);
        }

        $json = json_decode((string)$res->getBody(), true);

        $result = $json['result']['id'] ?? null;
        if (!$result) {
            throw new ProcessingResultException(__('Owner id is empty'));
        }

        return $result;
    }

    /**
     * @param Blockchain $blockchain
     * @param string $owner
     * @param string $address
     *
     * @return string
     */
    public function attachColdWalletWithAddress(Blockchain $blockchain, string $owner, string $address): string
    {
        return $this->attachWallet($blockchain, $owner, address: $address);
    }

    /**
     * @param Blockchain $blockchain
     * @param string $owner
     * @param string $mnemonic
     * @param string $passphrase
     *
     * @return string
     */
    public function attachHotWalletWithMnemonic(Blockchain $blockchain, string $owner, string $mnemonic, string $passphrase): string
    {
        return $this->attachWallet($blockchain, $owner, mnemonic: $mnemonic, passphrase: $passphrase);
    }

    /**
     * @param Blockchain $blockchain
     * @param string $owner
     * @param string $privateKey
     *
     * @return string
     */
    public function attachHotWalletWithPrivateKey(Blockchain $blockchain, string $owner, string $privateKey): string
    {
        return $this->attachWallet($blockchain, $owner, privateKey: $privateKey);
    }

    /**
     * @param Blockchain $blockchain
     * @param string $owner
     * @param string $address
     * @param string $mnemonic
     * @param string $passphrase
     * @param string $privateKey
     *
     * @return string
     */
    private function attachWallet(
        Blockchain $blockchain,
        string     $owner,
        string     $address = '',
        string     $mnemonic = '',
        string     $passphrase = '',
        string     $privateKey = '',
    ): string
    {
        $res = $this->client->request(
            HttpMethod::POST,
            sprintf('/owners/%s/wallets', $owner),
            [
                'blockchain' => $blockchain->value,
                'address'    => $address,
                'mnemonic'   => $mnemonic,
                'passPhrase' => $passphrase,
                'privateKey' => $privateKey,
            ]
        );

        if ($res->getStatusCode() !== Response::HTTP_ACCEPTED) {
            throw new ProcessingException(__('Cannot attach cold wallet to owner'), $res);
        }

        $json = json_decode((string)$res->getBody(), true);
        $address = $json['result']['address'] ?? null;
        if (!$address) {
            throw new ProcessingResultException(__('Wallet address is empty'));
        }

        return $address;
    }

    /**
     * @param string $owner
     * @param Blockchain $blockchain
     * @param bool $isManual
     * @param string $contract
     *
     */
    public function doTransfer(string $owner, Blockchain $blockchain, bool $isManual, string $contract = ''): ResponseInterface
    {
        return $this->client->request(HttpMethod::POST, "/owners/$owner/transfer", [
            'owner'      => $owner,
            'blockchain' => $blockchain,
            'contract'   => $contract,
            'isManual'   => $isManual,
        ]);
    }

    /**
     * @return ResponseInterface
     * @throws Exception
     */
    public function getStatusService(): ResponseInterface
    {
        $response = $this->client->request(HttpMethod::GET, '/status', []);

        if ($response->getStatusCode() != Response::HTTP_OK) {
            throw new Exception('Processing API response with status code: ' . $response->getStatusCode());
        }

        return $response;
    }

    /**
     * Transfers funds from invoice address to owner wallet.
     *
     * @param string $addressFrom
     * @param Blockchain $blockchain
     * @param string $ownerId
     * @param string $contract
     *
     * @return bool
     * @throws Exception
     */
    public function transferFromAddress(string $addressFrom, Blockchain $blockchain, string $ownerId, string $contract = ''): bool
    {
        $response = $this->client->request(HttpMethod::POST, "owners/$ownerId/transfer", [
            'wallet'     => $addressFrom,
            'blockchain' => $blockchain->value,
            'owner'      => $ownerId,
            'isManual'   => true,
            'contract'   => $contract,
        ]);

        if ($response->getStatusCode() != Response::HTTP_OK) {
            throw new Exception('Processing API response with status code: ' . $response->getStatusCode());
        }

        return true;
    }
}
