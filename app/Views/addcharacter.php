<?php
if (!isset($_SESSION['firstName'])) {
    echo "You need login to view this page";
    exit;
}
if (!empty($successMsg)) {
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
                <label for="name">Character name</label>
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
                <label for="rarity">Rarity</label>
                <select class="form-control" name="rarity" id="rarity">
                    <?php foreach ($rarities as $i => $rarity) { ?>
                        <option value="<?php echo $i; ?>"><?php echo $rarity; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3" style="margin: auto;">
                <label for="gender">Gender</label>
                <select class="form-control" name="gender" id="gender">
                    <?php foreach ($genders as $i => $gender) { ?>
                        <option value="<?php echo $i; ?>"><?php echo $gender; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3" style="margin: auto;">
                <label for="series">Series</label>
                <select class="form-control" name="series" id="series">
                    <optgroup label="PreSeries">
                        <?php foreach ($preSeriesList as $preSeries) { ?>
                            <option <?php echo ("preSeries," . $preSeries->id == $seriesId) ? "selected" : "" ?> value="preSeries,<?php echo $preSeries->id ?>"><?php echo $preSeries->name ?></option>
                        <?php } ?>
                    </optgroup>
                    <optgroup label="Series">
                        <?php foreach ($seriesList as $series) { ?>
                            <option <?php echo ("series," . $series->id == $seriesId) ? "selected" : "" ?> value="series,<?php echo $series->id ?>"><?php echo $series->name ?></option>
                        <?php } ?>
                    </optgroup>
                </select>
                <div class="invalid-feedback">
                    <?php echo $errorImageUrl ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3" style="margin: auto;">
                <button class="btn btn-primary" type="submit" style="margin: auto;"><?php echo $action; ?> Character</button>
            </div>
        </div>
    </form>
</div>