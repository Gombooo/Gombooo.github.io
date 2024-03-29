<?php
function errorModal($title, $text, $close)
{
    echo '<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="modal-label">' . $title . '</h4><button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button></div><div class="modal-body"> ' . $text . ' </div><div class="modal-footer"><button id="close" type="button" class="btn btn-default" data-dismiss="modal">' . $close . '</button></div></div></div></div>';
}

function createModal($title, $text, $close, $download)
{
    echo '<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="modal-label">' . $title . '</h4><button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button></div><div class="modal-body"> ' . $text . ' </div><div class="modal-footer"><a href="' . $_SESSION["url"] . '" class="btn btn-primary" download>' . $download . '</a><button type="button" class="btn btn-default" data-dismiss="modal">' . $close . '</button></div></div></div></div>';
}

function createVMModal($title, $text, $close, $buttons)
{
    echo '<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="modal-label">' . $title . '</h4><button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button></div><div class="modal-body"> ' . $text . ' </div><div class="modal-footer" style="display:inline">' . $buttons . '<br><br><button type="button" class="btn btn-block btn-default" data-dismiss="modal">' . $close . '</button></div></div></div></div>';
}

function validateBase64($string)
{
    $decoded = base64_decode($string, true);
    if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string)) return false;
    if (!base64_decode($string, true)) return false;
    if (base64_encode($decoded) != $string) return false;
    return true;
}

function cleanStr($str)
{
    return html_entity_decode(strip_tags($str), ENT_QUOTES, 'UTF-8');
}

function convertUrl($url)
{
    $url = str_replace("\\", "", $url);
    $url = str_replace("&amp", "&", $url);
    $url = str_replace("&;", "&", $url);
    $url = "https:" . $url;
    return $url;
}

function mobilLink($curl_content)
{
    $regex = '@&quot;https:(.*?)&quot;,&quot;@si';
    if (preg_match_all($regex, $curl_content, $match)) {
        return $match[1][0];
    }
}

function hdLink($curl_content)
{
    $regex = '/hd_src_no_ratelimit:"([^"]+)"/';
    if (preg_match($regex, $curl_content, $match)) {
        return $match[1];
    }
}

function sdLink($curl_content)
{
    $regex = '/sd_src_no_ratelimit:"([^"]+)"/';
    if (preg_match($regex, $curl_content, $match1)) {
        return $match1[1];
    }
}

function getTitle($curl_content)
{
    $title = null;
    if (preg_match('/h2 class="uiHeaderTitle"?[^>]+>(.+?)<\/h2>/', $curl_content, $matches)) {
        $title = $matches[1];
    } elseif (preg_match('/title id="pageTitle">(.+?)<\/title>/', $curl_content, $matches)) {
        $title = $matches[1];
    }
    return cleanStr($title);
}

function socialLinks($social)
{
    foreach ($social as $link => $key) {
        if (!empty($key)) {
            switch ($link) {
                case 'facebook':
                    echo '<li class="nav-item"><a class="nav-link" href="https://facebook.com/' . $key . '"><i class="fab fa-facebook fa-fw fa-2x"></i></a></li>';
                    break;
                case 'twitter':
                    echo '<li class="nav-item"><a class="nav-link" href="https://twitter.com/' . $key . '"><i class="fab fa-twitter-square fa-fw fa-2x"></i></a></li>';
                    break;
                case 'youtube':
                    echo '<li class="nav-item"><a class="nav-link" href="https://youtube.com/' . $key . '"><i class="fab fa-youtube-square fa-fw fa-2x"></i></a></li>';
                    break;
                case 'google':
                    echo '<li class="nav-item"><a class="nav-link" href="https://google.com/' . $key . '"><i class="fab fa-google-plus-square fa-fw fa-2x"></i></a></li>';
                    break;
            }
        }
    }
}

function getDomain($url)
{
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : '';
    if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
    }
    return false;
}

function customError($websiteUrl, $errorText)
{
    echo '<script type="text/javascript">';
    echo 'alert("' . $errorText . '");';
    echo 'window.location.href = "' . $websiteUrl . '";';
    echo '</script>';
}

function errorDialog($websiteUrl)
{
    echo '<script type="text/javascript">';
    echo 'alert("Invalid request. Please try again.");';
    echo 'window.location.href = "' . $websiteUrl . '";';
    echo '</script>';
}

function forceDownload($fileUrl, $fileName)
{
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private', false);
    header("Content-Type: application/octet-stream");
    header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
    header('Content-Transfer-Encoding: binary');
    header('Connection: close');
    readfile($fileUrl);
    exit();
}

function generateRandomString($length = 8)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function redirect($url)
{
    header('Location: ' . $url);
}

function curl_get_contents($url, $userAgent)
{
    if (!function_exists('curl_init')) {
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function sanitize($string, $forceLowercase = false, $anal = false)
{
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
    return ($forceLowercase) ?
        (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean) :
        $clean;
}

function buildMenu($menuArray)
{
    foreach ($menuArray as $node) {
        $getMenu = isset($_GET['menu']) ? $_GET['menu'] : '';
        $checkParent = (isset($node['children']) && !empty($node['children'])) ? checkInChildArray($getMenu, $node['children']) : '';
        $parentSelected = ($checkParent) ? $selected = 'style="color: red;"' : null;
        echo "<li class='nav-item' " . $parentSelected . "><a class='nav-link' href='" . $node['link'] . "'>" . $node['title'] . "</a></li>";
    }
}

function checkInChildArray($needle, $haystack, $strict = false)
{
    foreach ($haystack as $item) {
        if (($strict ? $item['link'] === $needle : $item == $needle) || (is_array($item) && checkInChildArray($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}

function checkUrl($url)
{
    if (!$fp = curl_init($url)) return false;
    return true;
}

function url_get_contents($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.10240');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function getfileSize($url)
{
    $headers = get_headers($url, 1);
    return formatsizeUnits($headers["Content-Length"][1]);
}

function formatsizeUnits($bytes)
{
    switch ($bytes) {
        case $bytes < 1024:
            $size = $bytes . ' B';
            break;
        case $bytes < 1048576:
            $size = round($bytes / 1024, 2) . ' KB';
            break;
        case $bytes < 1073741824:
            $size = round($bytes / 1048576, 2) . ' MB';
            break;
        case $bytes < 1099511627776:
            $size = round($bytes / 1073741824, 2) . ' GB';
            break;
    }
    return $size;
}

function listLanguages()
{
    foreach (glob(__DIR__ . "/../language/*.php") as $filename) {
        if (basename($filename) != "index.php") {
            $language = str_replace(".php", null, basename($filename));
            echo '<a style="text-transform:uppercase;" class="dropdown-item language" href="?lang=' . $language . '">' . $language . '</a>';
        }
    }
}

function languageExists($language)
{
    if (file_exists(__DIR__ . "/../language/" . $language . ".php")) {
        return true;
    }
}