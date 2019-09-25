<?php
namespace App\Lnky;

use GuzzleHttp\Client;

class AdflyApi {
    private $client;
    private $userId;
    private $publicKey;

    const BASE_HOST = 'https://api.adf.ly';

    public function __construct() {
        $this->client = new Client(["verify" => false, "base_uri" => self::BASE_HOST]);
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void {
        $this->userId = $userId;
    }

    /**
     * @param mixed $publicKey
     */
    public function setPublicKey($publicKey): void {
        $this->publicKey = $publicKey;
    }

    public function shorten(array $urls, $domain=false, $advertType=false, $groupId=false, $title=false, $customName=false) {
        $params = array();
        if ($domain !== false) $params['domain'] = $domain;
        if ($advertType !== false) $params['advert_type'] = $advertType;
        if ($groupId !== false) $params['group_id'] = $groupId;
        if ($title !== false) $params['title'] = $title;
        if ($customName !== false) $params['custom_name'] = $customName;

        $i = 0;
        foreach ($urls as $url) {
            $params[sprintf('url[%d]', $i++)] = $url;
        }

        $response = $this->client->post('v1/shorten', ["form_params" => $this->getParams($params)]);
        $jsonResponse =  json_decode($response->getBody()->getContents());
        return $jsonResponse->data['0']->short_url;
    }

    /**
     * Populates query parameters with required parameters. Such as
     * _user_id, _api_key, etc.
     * @param array $params
     * @return array
     */
    private function getParams(array $params=array()) {
        $params['_user_id'] = $this->userId;
        $params['_api_key'] = $this->publicKey;

        return $params;
    }


}