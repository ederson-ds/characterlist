<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo base_url("/public/css/styles.css"); ?>?ts=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo base_url("/public/js/main.js"); ?>?ts=<?php echo time(); ?>"></script>
    <title>CharacterList</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="<?php echo base_url("/") ?>">CharacterList</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php if (isset($_SESSION['firstName'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url("/dashboard") ?>">Dashboard</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url("/addcharacter") ?>">Add Character</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url("/addseries") ?>">Add Series</a>
                </li>
                <?php if (!isset($_SESSION['firstName'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url("/signup") ?>">Sign Up</a>
                    </li>
                <?php } ?>
                <?php if (!isset($_SESSION['firstName'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url("/login") ?>">Login</a>
                    </li>
                <?php } ?>
                <?php if (isset($_SESSION['firstName'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url("/logout") ?>">Logout</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>