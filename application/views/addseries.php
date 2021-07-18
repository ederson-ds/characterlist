<?php
if (!isset($_SESSION['firstName'])) {
    echo "You need login to view this page";
    exit;
}
if(!empty($successMsg)) {
    $name = "";
    $imageUrl = "";
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-4 mb-3" style="margin: auto;<?php echo (empty($successMsg)) ? "display:none;" : "" ?>">
            <div class="alert alert-success" role="alert">
                <?php echo $successMsg; ?>
            </div>
        </div>
    </div>
    <form method="post">
        <div class="form-row">
            <div class="col-md-4 mb-3" style="margin: auto;">
                <label for="name">Series name</label>
                <input type="text" class="form-control <?php echo (!empty($errorName)) ? " is-invalid" : "" ?>" id="name" name="name" value="<?php echo (isset($name)) ? $name : ""; ?>">
                <div class="invalid-feedback">
                    <?php echo $errorName ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3" style="margin: auto;">
                <label for="imageUrl">Image Url</label>
                <input type="imageUrl" class="form-control <?php echo (!empty($errorImageUrl)) ? " is-invalid" : "" ?>" id="imageUrl" name="imageUrl" value="<?php echo (isset($imageUrl)) ? $imageUrl : ""; ?>">
                <div class="invalid-feedback">
                    <?php echo $errorImageUrl ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3" style="margin: auto;">
                <button class="btn btn-primary" type="submit" style="margin: auto;"><?php echo $action; ?> Series</button>
            </div>
        </div>
    </form>
</div>