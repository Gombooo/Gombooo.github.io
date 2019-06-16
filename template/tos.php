<section class="section">
    <div class="container text-center">
        <h1 class="display-1"><?php echo $config["title"]; ?></h1>
        <p class="lead"><?php echo $lang["terms-of-service"]; ?></p>
    </div>
    <?php
    if ($theme["ads"] === true) {
        include("adcode.html");
    }
    ?>
    <div class="container text-center">
        <div class="card rounded">
            <div class="card-body">
                You can enter here you ToS content.
            </div>
        </div>
        <?php
        if($theme["services"] === true){
            include ("services.php");
        }
        ?>
    </div>
</section>