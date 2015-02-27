<?php
/**
 * @file
 * Tribe HR Api client.
 */

namespace Hussainweb\TribeHr;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Hussainweb\TribeHr\Message\Kudos;
use Hussainweb\TribeHr\Message\UserBasic;

class Client
{
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

    const API_VERSION = '2.0.0';

    /**
     * @param GuzzleClientInterface $http_client
     * @param string|null $subdomain
     * @param string|null $username
     * @param string|null $apikey
     */
    public function __construct(
      GuzzleClientInterface $http_client,
      $subdomain = null,
      $username = null,
      $apikey = null
    ) {
        $this->httpClient = $http_client;
        $this->setAccess($username, $apikey, $subdomain);
    }

    /**
     * Set the subdomain.
     *
     * @param string $subdomain
     */
    public function setSubdomain($subdomain)
    {
        $this->subdomain = $subdomain;
    }

    /**
     * Set the username.
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Set the API key.
     *
     * @param string $apikey
     */
    public function setApiKey($apikey)
    {
        $this->apikey = $apikey;
    }

    /**
     * Quickly set username and API key, and optionally, the subdomain.
     *
     * @param string $username
     * @param string $apikey
     * @param string|null $subdomain
     */
    public function setAccess($username, $apikey, $subdomain = null)
    {
        $this->setUsername($username);
        $this->setApiKey($apikey);
        if ($subdomain !== null) {
            $this->setSubdomain($subdomain);
        }
    }

    /**
     * Prepare a request for TribeHR API.
     *
     * @param $uri
     * @param string $method
     * @param array $options
     * @return \GuzzleHttp\Message\RequestInterface
     */
    public function createRequest($uri, $method = 'GET', $options = [])
    {
        if (empty($this->subdomain) || empty($this->username) || empty($this->apikey)) {
            throw new \InvalidArgumentException("Access details for API have not been completely specified.");
        }

        $url = sprintf("https://%s.mytribehr.com/%s", $this->subdomain,
          trim($uri, '/'));
        $options += [
            'auth' => [$this->username, $this->apikey],
        ];

        $request = $this->httpClient->createRequest($method, $url, $options);
        $request->addHeader('X-API-Version', static::API_VERSION);

        return $request;
    }

    /**
     * Prepare and send a request to TribeHR API.
     *
     * @param string $uri
     * @param string $method
     * @param array $options
     * @return string
     */
    public function request($uri, $method = 'GET', $options = [])
    {
        $request = $this->createRequest($uri, $method, $options);
        $response = $this->httpClient->send($request);

        return (string) $response->getBody();
    }

    /**
     * Send Kudos to another user.
     *
     * @param \Hussainweb\TribeHr\Message\Kudos $kudos
     *
     * @throws \Hussainweb\TribeHr\TribeHrException
     */
    public function sendKudos(Kudos $kudos)
    {
        $request = $this->createRequest('kudos.json', 'POST', [
            'body' => $kudos->getPostData(),
            'headers' => ['X-Source' => $kudos->getSource() ?: ''],
        ]);
        $response = $this->httpClient->send($request);

        // Check if we got an error.
        if ($response->getStatusCode() !== 200)
        {
            $response_json = json_decode($response->getBody(), true);
            $messages = $response_json['error']['messages'];
            throw new TribeHrException($messages, (string) $response_json['code']);
        }
    }

    /**
     * Get all the users keyed by their id.
     *
     * @return \Hussainweb\TribeHr\Message\UserBasic[]
     */
    public function getUsers()
    {
        $user_list = [];

        $response = $this->request('users.json');
        $response_json = json_decode($response, true);

        foreach ($response_json as $user_json) {
            $user = new UserBasic($user_json);
            $user_list[(string) $user->getId()] = $user;
        }

        return $user_list;
    }

    /**
     * Get all the email addresses of the users keyed by their id.
     *
     * @return array
     */
    public function getUserEmails()
    {
        $user_list = [];
        $users = $this->getUsers();
        foreach ($users as $id => $user) {
            $user_list[$id] = (string) $user->getEmail();
        }

        return $user_list;
    }
}
