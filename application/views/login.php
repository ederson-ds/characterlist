<div class="container">
    <div class="row">
        <div class="col-md-4 mb-3" style="margin: auto;<?php echo (empty($msg)) ? "display:none;" : "" ?>">
            <div class="alert alert-danger" role="alert">
                <?php echo $msg; ?>
            </div>
        </div>
    </div>
    <form method="post">
        <div class="form-row">
            <div class="col-md-4 mb-3" style="margin: auto;">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email">
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3" style="margin: auto;">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3" style="margin: auto;">
                <button class="btn btn-primary" type="submit" style="margin: auto;">Login</button>
            </div>
        </div>
    </form>
</div>