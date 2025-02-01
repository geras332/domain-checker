<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;

class DomainCheckerService
{
    private string $apiUrl;
    private string $apiKey;
    private ?Client $httpClient = null;

    public function __construct(string $apiUrl, string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
    }

    public function checkDomains(array $domains): array
    {
        $promises = [];
        foreach ($domains as $domain) {
            $promises[] = $this->checkDomainAsync($domain);
        }

        $results = Promise\Utils::settle($promises)->wait();

        $domainResults = [];
        foreach ($results as $result) {
            if ($result['state'] === 'fulfilled') {
                $domainResults[] = $result['value'];
            }
            else {
                $domainResults[] = [
                    'error' => $result['reason']->getMessage(),
                ];
            }
        }

        return $domainResults;
    }

    private function checkDomainAsync(string $domain): Promise\PromiseInterface
    {
        return $this->getHttpClient()->requestAsync('GET', "{$this->apiUrl}/whoisserver/WhoisService", [
            'query' => [
                'apiKey' => $this->apiKey,
                'domainName' => $domain,
                'outputFormat' => 'JSON',
            ]
        ])->then(
            function ($response) use ($domain) {
                $data = json_decode($response->getBody()->getContents(), true);

                return [
                    'domain' => $domain,
                    'available' => isset($data['WhoisRecord']['domainAvailability']) && $data['WhoisRecord']['domainAvailability'] === 'AVAILABLE',
                    'expiresDate' => $data['WhoisRecord']['expiresDate'] ?? 'Unknown',
                ];
            },
            function (RequestException $e) use ($domain) {
                return [
                    'domain' => $domain,
                    'error' => $e->getMessage(),
                ];
            }
        );
    }

    private function getHttpClient(): Client
    {
        if ($this->httpClient) {
            return $this->httpClient;
        }

        return $this->httpClient = new Client();
    }

    public function setHttpClient(Client $httpClient): self
    {
        $this->httpClient = $httpClient;

        return $this;
    }
}
