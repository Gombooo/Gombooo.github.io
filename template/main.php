<section class="section">
    <div class="container text-center">
        <h1 class="display-1"><?php echo $config["title"]; ?></h1>
        <p class="lead"><?php echo $lang["homepage-slogan"]; ?></p>
    </div>
    <?php
    if ($theme["ads"] === true) {
        include("adcode.html");
    }
    ?>
    <div class="container text-center">
        <div class="card rounded">
            <div class="card-body">
                <form id="form" method="post" enctype="multipart/form-data">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-video-camera"></i></span>
                        <input id="url" name="url" type="url" class="form-control"
                               placeholder="<?php echo $lang["placeholder"]; ?>" required autocomplete="on" autofocus>
                    </div>
                    <br>
                    <button id="send" type="submit" class="btn btn-dark"><i
                                class="fas fa-download"></i> <?php echo $lang["download"]; ?></button>
                </form>
            </div>
        </div>
        <?php
        if($theme["services"] === true){
            include ("services.php");
        }
        ?>
    </div>
</section>
<div id="modal-container"></div>