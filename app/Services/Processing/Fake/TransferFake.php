<?php

declare(strict_types=1);

namespace App\Services\Processing\Fake;

use App\Enums\Blockchain;
use App\Services\Processing\Contracts\TransferContract;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class TransferFake implements TransferContract
{
    /**
     * @throws GuzzleException
     */
    public function doTransfer(string $owner, Blockchain $blockchain, bool $isManual, string $contract = ''): ResponseInterface
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode(["error" => "cannot find owner wallet with cb2354c0-cb81-4128-9cfc-1018eb77e907 ownerId: record not found"])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        return $client->request('GET', '/test');
    }
}
