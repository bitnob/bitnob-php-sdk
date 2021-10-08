<?php

declare(strict_types=1);

namespace Bitnob\Client;

use Bitnob\Client\Endpoint\Customers;
use Bitnob\Client\Endpoint\Transactions;
use Bitnob\Client\Endpoint\Addresses;
use Bitnob\Client\Endpoint\Wallets;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;

final class BitnobSdk
{
    private ClientBuilder $clientBuilder;

    public function __construct(string $apikey, Options $options = null)
    {
        $options = $options ?? new Options();

        $this->clientBuilder = $options->getClientBuilder();
        $this->clientBuilder->addPlugin(new BaseUriPlugin($options->getUri()));
        $this->clientBuilder->addPlugin(
            new HeaderDefaultsPlugin(
                [
                    'Authorization' => 'Bearer '.$apikey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]
            )
        );
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->clientBuilder->getHttpClient();
    }


    // Register Customers API
    public function customers(): Customers
    {
        return new Endpoint\Customers($this);
    }

    // Register Transactions API
    public function transactions(): Transactions
    {
        return new Endpoint\Transactions($this);
    }

    // Register Wallets API
    public function wallets(): Wallets
    {
        return new Endpoint\Wallets($this);
    }

    // Register Addresses API
    public function addresses(): Addresses
    {
        return new Endpoint\Addresses($this);
    }
}