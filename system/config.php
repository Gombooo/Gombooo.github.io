<?php
/*
 * Enter your website title.
 */
$config["title"] = "Gombooo Video Downloader";
/*
 * Enter your website description for SEO. (Used for meta description)
 */
$config["description"] = "Gombooo All In One Video Downloader";
/*
 * Enter your language file name. Language files in "language" folder.
 */
$config["language"] = "en";
/*
 * Enter your website author name (person, company etc.)
 */
$config["author"] = "Mir Rahed Uddin";
/*
 * Enter your website URL with http or https.
 */
$config["url"] = "https://gombooo.github.io/";
/*
 * Enter social media user names (If you don't use leave blank)
 */
$social["facebook"] = "";
$social["twitter"] = "";
$social["google"] = "";
$social["youtube"] = "";
/*
 * You can add your ads code to "/template/adcode.html" file.
 */
$theme["ads"] = false;
$theme["services"] = false; // If you don't want show supported services change to "false".
/*
 * Don't change below lines
 */
session_start();
if (isset($_SESSION["currentLanguage"]) != "") {
    require_once(__DIR__ . "/../language/" . $_SESSION["currentLanguage"] . ".php");
} else {
    require_once(__DIR__ . "/../language/" . $config["language"] . ".php");
}
require_once("functions.php");
/*
 * Change, add or delete menu links.
 * These links are shown in the main menu
 * Uncomment if you want use
 */
$config["menu"] = array(
    array(
        'title' => $lang["terms-of-service"],
        'link' => '?tos=1'
    )
);
