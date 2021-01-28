<?php

use League\OAuth2\Client\Token\AccessToken;

define('TOKEN_FILE','tmp/token_info.json');

/**
 * @param array $accessToken
 */
function saveToken($accessToken)
{
    if (
        isset($accessToken)
        && isset($accessToken['access_token'])
        && isset($accessToken['refresh_token'])
        && isset($accessToken['expires_in'])
    ) {
        $data = [
            'accessToken' => $accessToken['access_token'],
            'expires' => $accessToken['expires_in'],
            'refreshToken' => $accessToken['refresh_token'],
            'baseDomain' => 'kazinterservice.amocrm.ru',
        ];

        file_put_contents(TOKEN_FILE, json_encode($data));
    } else {
        exit('Invalid access token ' . var_export($accessToken, true));
    }
}

/**
 * @return AccessToken
 */
function getToken()
{
    if (!file_exists(TOKEN_FILE)) {
        exit('Access token file not found');
    }

    $accessToken = json_decode(file_get_contents(TOKEN_FILE), true);

    if (
        isset($accessToken)
        && isset($accessToken['accessToken'])
        && isset($accessToken['refreshToken'])
        && isset($accessToken['expires'])
        && isset($accessToken['baseDomain'])
    ) {
        return new AccessToken([
            'access_token' => $accessToken['accessToken'],
            'refresh_token' => $accessToken['refreshToken'],
            'expires' => $accessToken['expires'],
            'baseDomain' => $accessToken['baseDomain'],
        ]);
    } else {
        exit('Invalid access token ' . var_export($accessToken, true));
    }
}
