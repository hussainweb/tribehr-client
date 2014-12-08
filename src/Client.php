<?php
/**
 * @file
 * Tribe HR Api client.
 */

namespace Hussainweb\TribeHr;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;

class Client {
    /**
     * The Guzzle client to use for actual transfers.
     *
     * @var GuzzleClientInterface
     */
    protected $httpClient;

    /**
     * Subdomain of the company.
     *
     * @var string
     */
    protected $subdomain;

    /**
     * Username used to access the API.
     *
     * @var string
     */
    protected $username;

    /**
     * API Key used to access the API.
     * @var string
     */
    protected $apikey;

    /**
     * @param GuzzleClientInterface $http_client
     * @param string|null $subdomain
     * @param string|null $username
     * @param string|null $apikey
     */
    public function __construct(GuzzleClientInterface $http_client, $subdomain = NULL, $username = NULL, $apikey = NULL) {
        $this->httpClient = $http_client;
        $this->setAccess($username, $apikey, $subdomain);
    }

    /**
     * Set the subdomain.
     *
     * @param string $subdomain
     */
    public function setSubdomain($subdomain) {
        $this->subdomain = $subdomain;
    }

    /**
     * Set the username.
     *
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * Set the API key.
     *
     * @param string $apikey
     */
    public function setApiKey($apikey) {
        $this->apikey = $apikey;
    }

    /**
     * Quickly set username and API key, and optionally, the subdomain.
     *
     * @param string $username
     * @param string $apikey
     * @param string|null $subdomain
     */
    public function setAccess($username, $apikey, $subdomain = NULL) {
        $this->setUsername($username);
        $this->setApiKey($apikey);
        if ($subdomain !== NULL) {
            $this->setSubdomain($subdomain);
        }
    }

    /**
     * Prepare and send a request to TribeHR API.
     *
     * @param $uri
     * @param string $method
     * @param array $options
     * @return string
     */
    protected function call($uri, $method = 'GET', $options = []) {
        if (empty($this->subdomain) || empty($this->username) || empty($this->apikey)) {
            throw new \InvalidArgumentException("Access details for API have not been completely specified.");
        }

        $options += [
            'auth' => [$this->username, $this->apikey],
        ];

        $url = sprintf("https://%s.mytribehr.com/%s", $this->subdomain, trim($uri, '/'));
        $request = $this->httpClient->createRequest($method, $url, $options);
        $response = $this->httpClient->send($request);
        return (string) $response->getBody();
    }
}
