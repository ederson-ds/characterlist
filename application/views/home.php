<div class="container">
    <?php foreach ($seriesList as $series) { ?>
        <div class="row">
            <div style="margin: auto;">
                <a href="<?php echo base_url("/addseries/editseries") . "/" . $series->id ?>">
                    <span><?php echo $series->name; ?></span>
                    <img src="<?php echo $series->imageUrl; ?>" width="200">
                    <span><?php echo $series->name; ?></span>
                </a>
            </div>
        </div>
        <?php foreach ($series->chars as $s) { ?>
            <div class="row">
                <a href="<?php echo base_url("/character") . "/wiki/" . str_replace(" ", "_", $s->name) ?>" style="margin: auto;">
                    <div style="border: 1px solid black;width: 100px;font-weight: bold;" class="<?php echo str_replace(" ", "-", strtolower($rarities[$s->rarity])) ?>">
                        <div>
                            <img src="<?php echo $s->imageUrl ?>" width="100">
                        </div>
                        <div style="font-size: 14px;text-align: center;border-top: 1px solid black;">
                            <?php echo $s->name ?>
                        </div>
                        <div style="font-size: 14px;text-align: center;border-top: 1px solid black;">
                            <?php echo $rarities[$s->rarity] ?>
                        </div>
                        <div style="font-size: 14px;text-align: center;border-top: 1px solid black;">
                            <?php echo $genders[$s->gender] ?>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>
    <?php } ?>

</div>