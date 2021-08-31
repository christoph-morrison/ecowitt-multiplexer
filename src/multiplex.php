<?php

function get_raw_data() {
    $raw = file_get_contents('php://input');
    return $raw;
}

function log_data(array $manual) {
    $toLog['manual'] = $manual;
    $toLog['system'] = array(
        'POST' => $_POST,
        'SERVER' => $_SERVER,
        'GET' => $_GET,
        'RAW' => get_raw_data(),
    );

    $dumpfile = time() . '.ecowitt-mp-data.json';
    file_put_contents($dumpfile, json_encode($toLog), FILE_APPEND);;
}

function send_data_via_post(string $endpoint = '') {
    if ($endpoint === '') {
        return;
    }

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($_POST)
        )
    );

    $context  = stream_context_create($options);

    return file_get_contents($endpoint, false, $context);
}

$toLog = array();

$endpoints = array(
    'ecowitt' => 'http://cdnrtpdate.ecowitt.net/data/report/',
    'mqtt-gw' => 'http://ecowitt-gw.fritz.box/',
);

foreach ($endpoints as $name => $url) {
    $result = send_data_via_post($url);
    $toLog[] = array(
        'message' => "[$name] Multiplexed data to $url",
        'result'  => $result,
    );
}

# log_data($toLog);
