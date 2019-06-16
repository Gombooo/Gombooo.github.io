<?php
require_once(__DIR__ . "/system/config.php");
switch (true) {
    case(!empty($_SESSION["url"]) && isset($_GET["dl"])):
        forceDownload($_SESSION["url"], $_SESSION["name"]);
        break;
    case(!empty($_GET["yt"])):
        forceDownload(base64_decode($_GET["yt"]), $_SESSION["name"]);
        break;
    case(!empty($_GET["vm"])):
        forceDownload(base64_decode($_GET["vm"]), generateRandomString() . ".mp4");
        break;
    case(isset($_GET["lang"]) != ""):
        if (languageExists(strip_tags($_GET["lang"])) === true) {
            $_SESSION["currentLanguage"] = strip_tags($_GET["lang"]);
            redirect($config["url"]);
        } else {
            redirect($config["url"]);
        }
        break;
    case(isset($_GET["tos"]) == "1"):
        $_SESSION["tos"] = true;
        include(__DIR__ . "/template/header.php");
        include(__DIR__ . "/template/tos.php");
        include(__DIR__ . "/template/footer.php");
        break;
    default:
        include(__DIR__ . "/template/header.php");
        include(__DIR__ . "/template/main.php");
        include(__DIR__ . "/template/footer.php");
        break;
}