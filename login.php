<?php
session_start();
include_once 'functions.php';
if (!isset($_SESSION['log'])) {
} else {
    header('location:dasboard.php');
}

if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    $queryuser = mysqli_query($conn, "SELECT * FROM login where username = '$user'");
    $cariuser = mysqli_fetch_assoc($queryuser);

    if ($cariuser) {

        if ((password_verify($pass, $cariuser['password']))) {
            $_SESSION['userid'] = $cariuser['id'];
            $_SESSION['username'] = $cariuser['username'];
            $_SESSION['log'] = 'login';

            header('location:dasboard.php');
        } else {
            echo '<script>alert("PW/Username salah !")</script>';
            //header('location:login.php');
        }
    } else {
        echo '<script>alert("User tidak ada !")</script>';
        //header('location:login.php');
    }
};
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    </style>

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Icon Boostrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <title>RW Management</title>
    <link rel="shortcut icon" href="img/people-fill.png">
</head>

<body>
    <!-- Section: Design Block -->
    <section class="jumbotron bg-light">
        <!-- Jumbotron -->
        <div class="text-center text-lg-start">
            <div class="container">
                <div class="row gx-lg-5 align-items-center vh-100">
                    <div class="col-lg-6">
                        <h1 class="my-3 display-3 fw-bold ls-tight">
                            RW Apps <br />
                            <span class="text-secondary">Management </span>
                        </h1>
                        <p style="color: hsl(217, 10%, 50.8%)">
                            <span>Copyright &copy; RW Management - 2023</span>
                        </p>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body py-5 px-md-5">
                                <form method="post">
                                    <!-- Email input -->
                                    <div class="input-group mb-3 pt-4">
                                        <input type="username" class="form-control" placeholder="Email or Username" name="username">
                                    </div>
                                    <!-- Password input -->
                                    <div class="input-group mb-3 pt-4">
                                        <input type="password" class="form-control" placeholder="Password" name="password">
                                    </div>


                                    <!-- 2 column grid layout for inline styling -->
                                    <div class="row mb-4 mt-5">
                                        <div class="col d-flex justify-content-center">
                                            <!-- Checkbox -->
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                                                <label class="form-check-label" for="form2Example31"> Remember me
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <!-- Simple link -->
                                            <a href="#!" style="text-decoration: none;">Forgot password?</a>
                                        </div>
                                    </div>

                                    <!-- Submit button -->
                                    <div class="d-grid gap-2 mb-3">
                                        <button class="btn btn-secondary" type="submit" name="login">Sign</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jumbotron -->
    </section>
    <!-- Section: Design Block -->
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="js/bootstrap.js"></script>
    <script src="js/popper.min.js"></script>
</body>

</html>