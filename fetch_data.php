<?php

header('Content-Type: application/json');

$config = include 'config/config.php';

$accessToken = null;

if (is_null($accessToken)) {
    $accessToken = getAccessToken($config);
} else {
    echo "Error authenticating.";
}
getTasks($config, $accessToken);


function getAccessToken($config)
{
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $config['login_endpoint'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            "username" => $config['username'],
            "password" => $config['password']
        ]),
        CURLOPT_HTTPHEADER => [
            "Authorization: Basic " . $config['auth_header'],
            "Content-Type: application/json"
        ],
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return false;
    } else {
        $data = json_decode($response, true);
        return isset($data["oauth"]["access_token"]) ? $data["oauth"]["access_token"] : false;
    }
}

// Fetch the tasks data using the access token
function getTasks($config, $accessToken)
{
    if (!$accessToken) {
        echo json_encode(["error" => "No valid access token."]);
        exit;
    }
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $config['tasks_endpoint'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $accessToken"
        ],
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo json_encode(["error" => "Error fetching tasks: $err"]);
        exit;
    } else {
        $data = json_decode($response, true);
        echo json_encode($data);
        exit;
    }
}
?>
