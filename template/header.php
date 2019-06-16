<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="<?php echo $config["description"]; ?>">
    <meta name="author" content="<?php echo $config["author"]; ?>"/>
    <meta name="generator" content="MobGyan Video Downloader"/>
    <title><?php echo $config["title"]; ?></title>
    <meta itemprop="name" content="<?php echo $config["title"]; ?>">
    <meta itemprop="description" content="<?php echo $config["description"]; ?>">
    <meta itemprop="image" content="<?php echo $config["url"]; ?>/assets/social-media-banner.png">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?php echo $config["title"]; ?>">
    <meta name="twitter:description" content="<?php echo $config["description"]; ?>">
    <meta name="twitter:image:src" content="<?php echo $config["url"]; ?>/assets/social-media-banner.png">
    <meta property="og:title" content="<?php echo $config["title"]; ?>">
    <meta property="og:type" content="article">
    <meta property="og:image" content="<?php echo $config["url"]; ?>/assets/social-media-banner.png">
    <meta property="og:description" content="<?php echo $config["description"]; ?>">
    <meta property="og:site_name" content="<?php echo $config["title"]; ?>">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Permanent+Marker|Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/assets/style.css"/>
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo $config["url"]; ?>/assets/favicon.png"/>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top bg-primary navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $config["url"]; ?>">
            <?php echo $config["title"]; ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="<?php echo $config["url"]; ?>"><?php echo $lang["home"] ?></a></li>
                <?php
                if (isset($config["menu"]) != "") {
                    echo buildMenu($config["menu"]);
                }
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $lang["language"]; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php listLanguages(); ?>
                    </div>
                </li>
                <?php
                socialLinks($social);
                ?>
            </ul>
        </div>
    </div>
</nav>