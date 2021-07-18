<div class="container">
    <form method="post">
        <div class="form-row">
            <div class="col-md-4 mb-3" style="margin: auto;">
                <label for="firstName">First name</label>
                <input type="text" class="form-control<?php echo (!empty($errorFirstName)) ? " is-invalid" : "" ?>" id="firstName" name="firstName" value="<?php echo (isset($firstName)) ? $firstName : ""; ?>">
                <div class="invalid-feedback">
                    <?php echo $errorFirstName ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3" style="margin: auto;">
                <label for="email">Email</label>
                <input type="text" class="form-control<?php echo (!empty($errorEmail)) ? " is-invalid" : "" ?>" id="email" name="email" value="<?php echo (isset($email)) ? $email : ""; ?>">
                <div class="invalid-feedback">
                    <?php echo $errorEmail ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3" style="margin: auto;">
                <label for="password">Password</label>
                <input type="password" class="form-control<?php echo (!empty($errorPassword)) ? " is-invalid" : "" ?>" id="password" name="password">
                <div class="invalid-feedback">
                    <?php echo $errorPassword ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3" style="margin: auto;">
                <button class="btn btn-primary" type="submit" style="margin: auto;">Sign Up</button>
            </div>
        </div>
    </form>
</div>