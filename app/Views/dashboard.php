<?php
if (!isset($_SESSION['firstName'])) {
    echo "You need login to view this page";
    exit;
}
?>
<div class="container">
    <h1>Welcome <?php echo $_SESSION['firstName'] ?></h1>

    <h2>Pre Series</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Series image</th>
                <th>Series name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($preSeriesList as $preseries) { ?>
                <tr>
                    <td>
                        <img src="<?php echo $preseries->imageUrl; ?>" width="200">
                    </td>
                    <td>
                        <?php echo $preseries->name; ?>
                    </td>
                    <td>
                        <?php if ($_SESSION['accessLevel'] == 1) { ?>
                            <button class="btn btn-info approveBtn" value="<?php echo $preseries->id; ?>" data-toggle="modal" data-target="#exampleModal">Approve</button>
                        <?php } ?>
                        <a href="<?php echo base_url("/addseries/edit") . "/" . $preseries->id ?>">
                            <button class="btn btn-warning">Edit</button>
                        </a>
                        <button class="btn btn-danger deleteBtn" value="<?php echo $preseries->id; ?>" data-toggle="modal" data-target="#deleteModal">Delete</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <hr>
    <h2>Pre Char</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Char image</th>
                <th>Char name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($preCharList as $preChar) { ?>
                <tr>
                    <td>
                        <img src="<?php echo $preChar->imageUrl; ?>" width="200">
                    </td>
                    <td>
                        <?php echo $preChar->name; ?>
                    </td>
                    <td>
                        <?php if ($_SESSION['accessLevel'] == 1) { ?>
                            <button class="btn btn-info approveBtnChar" value="<?php echo $preChar->id; ?>" data-toggle="modal" data-target="#exampleModal">Approve</button>
                        <?php } ?>
                        <a href="<?php echo base_url("/addcharacter/edit") . "/" . $preChar->id ?>">
                            <button class="btn btn-warning">Edit</button>
                        </a>
                        <button class="btn btn-danger deleteBtnChar" value="<?php echo $preChar->id; ?>" data-toggle="modal" data-target="#deleteModal">Delete</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $(document).on("click", ".approveBtn", function() {
            var base_url = <?php echo '"' . base_url() . '"'; ?>;
            $("#approveYes").attr("href", base_url + "/approve/preseries/" + $(this).val());
        });

        $(document).on("click", ".approveBtnChar", function() {
            var base_url = <?php echo '"' . base_url() . '"'; ?>;
            $("#approveYes").attr("href", base_url + "/approve/prechar/" + $(this).val());
        });

        $(document).on("click", ".deleteBtn", function() {
            var base_url = <?php echo '"' . base_url() . '"'; ?>;
            $("#deleteYes").attr("href", base_url + "/addseries/delete/" + $(this).val());
        });

        $(document).on("click", ".deleteBtnChar", function() {
            var base_url = <?php echo '"' . base_url() . '"'; ?>;
            $("#deleteYes").attr("href", base_url + "/addcharacter/delete/" + $(this).val());
        });
    });
</script>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to approve?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#" id="approveYes">
                    <button type="button" class="btn btn-primary">Yes</button>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#" id="deleteYes">
                    <button type="button" class="btn btn-primary">Yes</button>
                </a>
            </div>
        </div>
    </div>
</div>