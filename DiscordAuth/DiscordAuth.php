<?php



require_once(realpath(dirname(__FILE__) . '/MainConfig.php'));

use LvckyWorld\Config\MainConfig;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)

error_reporting(E_ALL);

$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
define("OAUTH2_CLIENT_ID", MainConfig::$OAUTH2_CLIENT_ID);
define("OAUTH2_CLIENT_SECRET", MainConfig::$OAUTH2_CLIENT_SECRET);

$authorizeURL = 'https://discord.com/api/oauth2/authorize';
$tokenURL = 'https://discord.com/api/oauth2/token';
$apiURLBase = 'https://discord.com/api/users/@me';
$revokeURL = 'https://discord.com/api/oauth2/token/revoke';

switch (get('action')) {
    case 'login': // if the query-param = login
        $params = array(
            'client_id' => OAUTH2_CLIENT_ID,
            'redirect_uri' => $redirect_uri,
            'response_type' => 'code',
            'scope' => 'identify guilds email'
        );

        // Redirect the user to Discord's authorization page
        header('Location: https://discord.com/api/oauth2/authorize' . '?' . http_build_query($params));
        die();
    case 'logout': // if the query-param = logout
        // This should log out you
        logout($revokeURL, array(
            'token' => session('access_token'),
            'token_type_hint' => 'access_token',
            'client_id' => OAUTH2_CLIENT_ID,
            'client_secret' => OAUTH2_CLIENT_SECRET,
        ));
        unset($_SESSION['access_token']);
        header('Location: ' . $_SERVER['PHP_SELF']);
        session_destroy();
        die();
    default:
        break;
}

// When Discord redirects the user back here, there will be a "code" and "state" parameter in the query string
if (get('code')) {
    // Exchange the auth code for a token
    $token = apiRequest($tokenURL, array(
        "grant_type" => "authorization_code",
        'client_id' => OAUTH2_CLIENT_ID,
        'client_secret' => OAUTH2_CLIENT_SECRET,
        'redirect_uri' => $redirect_uri,
        'code' => get('code')
    ));
    $logout_token = $token->access_token;
    $_SESSION['access_token'] = $token->access_token;

    header('Location: ' . $_SERVER['PHP_SELF']);
}

function apiRequest($url, $post = FALSE, $headers = array())
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($ch);

    if ($post)
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

    $headers[] = 'Accept: application/json';

    if (session('access_token'))
        $headers[] = 'Authorization: Bearer ' . session('access_token');

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    return json_decode($response);
}

function logout($url, $data = array())
{
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
        CURLOPT_POSTFIELDS => http_build_query($data),
    ));
    $response = curl_exec($ch);
    return json_decode($response);
}

function get($key, $default = NULL)
{
    return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

function session($key, $default = NULL)
{
    return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}

