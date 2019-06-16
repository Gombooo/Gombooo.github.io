<?php
$url = base64_decode($_GET["dl"]);
echo $url;
?>
<section class="section">
    <div class="container text-center">
        <h1 class="display-1"><?php echo $config["title"]; ?></h1>
        <p class="lead"><?php echo $lang["homepage-slogan"]; ?></p>
    </div>
    <?php include("adcode.html"); ?>
    <div class="container text-center" style="margin-top:4%">
        <div class="row">
            <div class="col-md-8">
                <p class="lead"><?php echo $lang["preview"]; ?></p>
                <div class="embed-responsive embed-responsive-16by9" style="margin-top:-10%;">
                    <iframe class="embed-responsive-item"
                            src="https://www.youtube.com/embed/<?php echo $_SESSION["id"]; ?>?rel=0"
                            allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card rounded">
                    <div class="card-body" id="download">
                        <?php
                        getvideoUrl($_SESSION["id"], getvideoTitle($_SESSION["id"]));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>