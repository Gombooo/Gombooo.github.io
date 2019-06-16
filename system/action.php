<?php
require_once("config.php");
if (!empty($_POST["url"])) {
    $domain = str_ireplace("www.", "", parse_url($_POST["url"], PHP_URL_HOST));
    switch ($domain) {
        case "instagram.com":
            $scrape = url_get_contents($_POST["url"]);
            preg_match_all('@<meta property="og:type" content="(.*?)" />@si', $scrape, $type);
            if (!empty($type[1][0])) {
                switch ($type[1][0]) {
                    case "video":
                        preg_match_all('@<meta property="og:video" content="(.*?)" />@si', $scrape, $videoURL);
                        preg_match_all('@on Instagram: “(.*?)”" name="description" />@si', $scrape, $postTitle);
                        $_SESSION["url"] = $videoURL[1][0];
                        $_SESSION["name"] = generateRandomString() . ".mp4";
                        createModal($lang["download-ready"], '<div class="embed-responsive embed-responsive-16by9"><video width="320" height="240" controls="controls" preload="metadata"><source src="' . $videoURL[1][0] . '#t=0.5" type="video/mp4"></video></div>', $lang["close"], $lang["download"]);
                        break;
                    case "instapp:photo":
                        preg_match_all('@<meta property="og:image" content="(.*?)" />@si', $scrape, $imageURL);
                        preg_match_all('@on Instagram: “(.*?)”" name="description" />@si', $scrape, $postTitle);
                        $_SESSION["url"] = $imageURL[1][0];
                        $_SESSION["name"] = generateRandomString() . ".jpg";
                        createModal($lang["download-ready"], '<div class="col-md-3" style="float:left"><img class="img-thumbnail" src="' . $imageURL[1][0] . '"></div><div class="col-md-9 text-center" style="margin-left:auto;margin-right:auto"><p>' . $postTitle[1][0] . '</p></div>', $lang["close"], $lang["download"]);
                        break;
                    default:
                        errorModal($lang["invalid-url"], $lang["instagram-error"], $lang["close"]);
                        die();
                        break;
                }
            } else {
                errorModal($lang["invalid-url"], $lang["instagram-error"], $lang["close"]);
                die();
            }
            break;
        case "facebook.com":
            $scrape = url_get_contents($_POST["url"]);
            $hdlink = hdLink($scrape);
            $sdlink = sdLink($scrape);
            if (!empty($hdlink)) {
                $_SESSION["url"] = $hdlink;
                $_SESSION["name"] = generateRandomString() . ".mp4";
                createModal($lang["download-ready"], '<div class="embed-responsive embed-responsive-16by9"><video width="320" height="240" controls="controls" preload="metadata"><source src="' . $hdlink . '#t=0.5" type="video/mp4"></video></div>', $lang["close"], $lang["download"]);
            } else if (!empty($sdlink)) {
                $_SESSION["url"] = $sdlink;
                $_SESSION["name"] = generateRandomString() . ".mp4";
                createModal($lang["download-ready"], '<div class="embed-responsive embed-responsive-16by9"><video width="320" height="240" controls="controls" preload="metadata"><source src="' . $sdlink . '#t=0.5" type="video/mp4"></video></div>', $lang["close"], $lang["download"]);
            } else {
                errorModal($lang["invalid-url"], $lang["facebook-error"], $lang["close"]);
                die();
            }
            break;
        case "m.facebook.com":
            $scrape = url_get_contents($_POST["url"]);
            $videoURL = convertUrl(mobilLink($scrape));
            if (!empty($videoURL)) {
                $_SESSION["url"] = $videoURL;
                $_SESSION["name"] = generateRandomString() . ".mp4";
                createModal($lang["download-ready"], '<div class="embed-responsive embed-responsive-16by9"><video width="320" height="240" controls="controls" preload="metadata"><source src="' . $_SESSION['url'] . '#t=0.5" type="video/mp4"></video></div>', $lang["close"], $lang["download"]);
            } else {
                errorModal($lang["invalid-url"], $lang["facebook-error"], $lang["close"]);
                die();
            }
            break;
        case "twitter.com":
            $scrape = url_get_contents($_POST["url"]);
            preg_match_all('@<meta  property="og:video:url" content="(.*?)">@si', $scrape, $videoURL);
            $scrape = url_get_contents($videoURL[1][0]);
            $scrape = convertUrl($scrape);
            preg_match_all('@https://video.twimg.com/amplify_video/(.*?).m3u8@si', $scrape, $streamURL);
            $scrape = url_get_contents($streamURL[0][0]);
            preg_match_all('@/amplify_video/(.*?).m3u8@si', $scrape, $tsList);
            $scrape = url_get_contents("https://video.twimg.com" . $tsList[0][2]);
            preg_match_all('@/amplify_video/(.*?).ts@si', $scrape, $tsVideo);
            $_SESSION['url'] = "https://video.twimg.com" . $tsVideo[0][0];
            $_SESSION["name"] = generateRandomString() . ".ts";
            createModal($lang["download-ready"], '<div class="embed-responsive embed-responsive-16by9"><video width="320" height="240" controls="controls" preload="metadata"><source src="' . $_SESSION['url'] . '#t=0.5" type="video/mp4"></video></div>', $lang["close"], $lang["download"]);
            break;
        case "video.twimg.com":
            $_SESSION['url'] = $_POST["url"];
            $_SESSION["name"] = generateRandomString() . ".mp4";
            createModal($lang["download-ready"], '<div class="embed-responsive embed-responsive-16by9"><video width="320" height="240" controls="controls" preload="metadata"><source src="' . $_SESSION['url'] . '#t=0.5" type="video/mp4"></video></div>', $lang["close"], $lang["download"]);
            break;
        case "dailymotion.com":
            $path = parse_url($_POST["url"], PHP_URL_PATH);
            $pathFragments = explode("/", $path);
            $lastPart = end($pathFragments);
            $scrape = url_get_contents("http://www.dailymotion.com/embed/video/" . $lastPart);
            $scrape = convertUrl($scrape);
            preg_match_all('@{"type":"video/mp4","url":"(.*?)"@si', $scrape, $videoURL);
            preg_match_all('@"poster_url":"(.*?)"@si', $scrape, $imageURL);
            switch (true) {
                case(!empty($videoURL[1][3])):
                    $_SESSION['url'] = $videoURL[1][3];
                    $_SESSION["name"] = generateRandomString() . ".mp4";
                    createModal($lang["download-ready"], '<div class="col-md-12"><img class="img-thumbnail" src="' . $imageURL[1][0] . '"></div>', $lang["close"], $lang["download"]);
                    break;
                case(!empty($videoURL[1][2])):
                    $_SESSION['url'] = $videoURL[1][2];
                    $_SESSION["name"] = generateRandomString() . ".mp4";
                    createModal($lang["download-ready"], '<div class="col-md-12"><img class="img-thumbnail" src="' . $imageURL[1][0] . '"></div>', $lang["close"], $lang["download"]);
                    break;
                case(!empty($videoURL[1][1])):
                    $_SESSION['url'] = $videoURL[1][1];
                    $_SESSION["name"] = generateRandomString() . ".mp4";
                    createModal($lang["download-ready"], '<div class="col-md-12"><img class="img-thumbnail" src="' . $imageURL[1][0] . '"></div>', $lang["close"], $lang["download"]);
                    break;
                case(!empty($videoURL[1][0])):
                    $_SESSION['url'] = $videoURL[1][0];
                    $_SESSION["name"] = generateRandomString() . ".mp4";
                    createModal($lang["download-ready"], '<div class="col-md-12"><img class="img-thumbnail" src="' . $imageURL[1][0] . '"></div>', $lang["close"], $lang["download"]);
                    break;
            }
            break;
        case "vimeo.com":
            $path = parse_url($_POST["url"], PHP_URL_PATH);
            $pathFragments = explode("/", $path);
            $lastPart = end($pathFragments);
            $scrape = url_get_contents("https://player.vimeo.com/video/" . $lastPart);
            preg_match_all('@"profile":(.*?),(.*?),"url":"(.*?)","cdn":"@si', $scrape, $videoLinks);
            $downloadButtons = array();
            $_SESSION["name"] = generateRandomString();
            for ($x = 0; $x <= 10; $x++) {
                if (!empty($videoLinks[1][$x])) {
                    switch ($videoLinks[1][$x]) {
                        case "164":
                            $html = '<a download="' . $_SESSION["name"] . '-360P.mp4" href="' . $videoLinks[3][$x] . '" class="btn btn-primary">360P</a>';
                            $downloadButtons["360P"] = $html;
                            $_SESSION['url'] = $videoLinks[3][$x];
                            break;
                        case "165":
                            $html = '<a download="' . $_SESSION["name"] . '-540P.mp4" href="' . $videoLinks[3][$x] . '" class="btn btn-primary">540P</a>';
                            $downloadButtons["540P"] = $html;
                            break;
                        case "174":
                            $html = '<a download="' . $_SESSION["name"] . '-720P.mp4" href="' . $videoLinks[3][$x] . '" class="btn btn-primary">720P</a>';
                            $downloadButtons["720P"] = $html;
                            break;
                        case "175":
                            $html = '<a download="' . $_SESSION["name"] . '-1080P.mp4" href="' . $videoLinks[3][$x] . '" class="btn btn-primary">1080P</a>';
                            $downloadButtons["1080P"] = $html;
                            break;
                        default:
                            break;
                    }
                }
            }
            sort($downloadButtons, SORT_REGULAR);
            $downloadButtons = implode("", $downloadButtons);
            createVMModal($lang["download-ready"], '<div class="embed-responsive embed-responsive-16by9"><video width="320" height="240" controls="controls" preload="metadata"><source src="' . $_SESSION['url'] . '#t=0.5" type="video/mp4"></video></div>', $lang["close"], $downloadButtons);
            break;
        default:
            $domain = explode('.', str_ireplace("www.", "", parse_url($_POST["url"], PHP_URL_HOST)))[1];
            if ($domain == "tumblr") {
                $username = explode('.', str_ireplace("www.", "", parse_url($_POST["url"], PHP_URL_HOST)))[0];
                preg_match_all('@/post/(.*?)/@si', $_POST["url"], $postID);
                $scrape = url_get_contents("https://www.tumblr.com/video/" . $username . "/" . $postID[1][0] . "/500/");
                preg_match_all('@src="https://' . $username . '.tumblr.com/video_file/(.*?)"@si', $scrape, $videoURL);
                $videoURL = str_replace("src=", "", $videoURL[0][0]);
                $videoURL = str_replace('"', "", $videoURL);
                $_SESSION['url'] = $videoURL;
                $_SESSION["name"] = generateRandomString() . ".mp4";
                createModal($lang["download-ready"], '<div class="embed-responsive embed-responsive-16by9"><video width="320" height="240" controls="controls" preload="metadata"><source src="' . $_SESSION['url'] . '#t=0.5" type="video/mp4"></video></div>', $lang["close"], $lang["download"]);
            } else {
                errorModal($lang["unknown-error"], $lang["try-again"], $lang["close"]);
                die();
            }
            break;
    }
} else {
    errorDialog($config["url"]);
    die();
}