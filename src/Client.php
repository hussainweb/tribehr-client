<?php
/**
 * @file
 * Tribe HR Api client.
 */

namespace Hussainweb\TribeHr;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Psr7\Request;
use Hussainweb\TribeHr\Message\Kudos;
use Hussainweb\TribeHr\Message\LeaveBasic;
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
     * @param string $subdomain
     * @param string $username
     * @param string $apikey
     */
    public function __construct(
        GuzzleClientInterface $http_client,
        $subdomain,
        $username,
        $apikey
    ) {
        $this->httpClient = $http_client;
        $this->setAccess($username, $apikey, $subdomain);
    }

    /**
     * Set username and API key, and optionally, the subdomain.
     *
     * @param string $username
     * @param string $apikey
     * @param string|null $subdomain
     */
    protected function setAccess($username, $apikey, $subdomain = null)
    {
        $this->username = $username;
        $this->apikey = $apikey;
        if ($subdomain !== null) {
            $this->subdomain = $subdomain;
        }
    }

    /**
     * Prepare a request for TribeHR API.
     *
     * @param $uri
     * @param string $method
     * @param array $headers
     * @param string $body
     * @return \Psr\Http\Message\RequestInterface
     */
    public function createRequest($uri, $method = 'GET', $headers = [], $body = null)
    {
        if (empty($this->subdomain) || empty($this->username) || empty($this->apikey)) {
            throw new \InvalidArgumentException("Access details for API have not been completely specified.");
        }

        $url = sprintf(
            "https://%s.mytribehr.com/%s",
            $this->subdomain,
            trim($uri, '/')
        );

        // We need to force the Content-type as otherwise Guzzle puts an empty
        // header, which TribeHR servers can't digest and spits out 400.
        $headers += [
            'Authorization' => 'Basic ' . base64_encode($this->username . ':' . $this->apikey),
            'Content-type' => 'application/x-www-form-urlencoded',
            'X-API-Version' => static::API_VERSION,
        ];

        $request = new Request(
            $method,
            $url,
            $headers,
            $body
        );
        return $request;
    }

    /**
     * Prepare and send a request to TribeHR API.
     *
     * @param string $uri
     * @param string $method
     * @param array $headers
     * @param string $body
     * @return string
     */
    public function request($uri, $method = 'GET', $headers = [], $body = null)
    {
        $request = $this->createRequest($uri, $method, $headers, $body);
        $response = $this->httpClient->send($request, [
            'http_errors' => false,
        ]);

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
            'X-Source' => $kudos->getSource() ?: '',
        ], $kudos->getPostData());
        $response = $this->httpClient->send($request, [
            'http_errors' => false,
        ]);

        // Check if we got an error.
        if ($response->getStatusCode() !== 200) {
            $response_json = json_decode($response->getBody(), true);
            $messages = $response_json['error']['messages'];
            throw new TribeHrException($messages, (string) $response_json['error']['code']);
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

    /**
     * Get all the leaves.
     *
     * @param string $status
     * @return \Hussainweb\TribeHr\Message\LeaveBasic[]
     */
    public function getLeaves($status = 'all')
    {
        $url = sprintf('leave_requests.json?status=%s', $status);
        $response = $this->request($url);
        $response_json = json_decode($response, true);

        $leaves = array_map(function ($value) {
            return new LeaveBasic($value);
        }, $response_json);

        return $leaves;
    }
}
