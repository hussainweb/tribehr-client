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
     * @param string $uri
     * @param string $method
     * @param array $options
     * @return string
     */
    public function request($uri, $method = 'GET', $options = []) {
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

    /**
     * Send Kudos to another user.
     *
     * @param string|int $receiver_id
     * @param string $kudos_note
     * @param array $values
     */
    public function sendKudos($receiver_id, $kudos_note, $values = []) {
        if (!is_numeric($receiver_id)) {
            $users = array_flip($this->getUserEmails());
            $receiver_id = $users[$receiver_id];
        }

        $data = array(
          'note' => $kudos_note,
          'user_id' => [$receiver_id],
          'value_id' => $values,
        );
        $this->request('kudos.xml', 'POST', ['body' => $data]);
    }

    /**
     * Get all the users keyed by their id.
     *
     * @return array
     */
    public function getUsers() {
        $user_list = [];

        $response = $this->request('users.xml');
        $users = new \SimpleXMLElement($response);
        foreach ($users->user as $user) {
            $user_list[(string) $user['id']] = $user;
        }

        return $user_list;
    }

    /**
     * Get all the email addresses of the users keyed by their id.
     * @return array
     */
    public function getUserEmails() {
        $user_list = [];
        $users = $this->getUsers();
        foreach ($users as $user) {
            $user_list[(string) $user['id']] = (string) $user['email'];
        }

        return $user_list;
    }
}
