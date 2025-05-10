<?php
session_start();
require 'function.php';

// Cek apakah user sudah login
if (isset($_SESSION["log"]) && $_SESSION["log"] === true) {
    header("Location: index.php");
    exit;
}

// Cek apakah tombol login sudah ditekan atau belum
if (isset($_POST["login"])) {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    
    // menggunakan prepared statement
    $stmt = mysqli_prepare($conn, "SELECT * FROM login WHERE email = ? AND password = ?");
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $_SESSION["log"] = true; // Membuat session login
        header("Location: index.php");// Redirect ke halaman index.php
        exit;
    } else {
        echo "<script>alert('Email atau Password Salah!')</script>";    // Alert jika email atau password salah
    }

    if (isset($_POST["log"])) {
        session_destroy(); // Menghapus session
        header("Location: login.php"); // Redirect ke halaman login.php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link href="css/login.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card">
                                <div class="logo-container">
                                    <img src="assets/img/logobpbd.jpg" alt="Logo BPBD">
                                </div>
                               
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group">
                                            <label class="form-label" for="inputEmailAddress">
                                                <i class="fas fa-envelope login-icon"></i>Email
                                            </label>
                                            <input class="form-control" name="email" id="inputEmailAddress" 
                                                   type="email" placeholder="Enter your email" required />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="inputPassword">
                                                <i class="fas fa-lock login-icon"></i>Password
                                            </label>
                                            <input class="form-control" name="password" id="inputPassword" 
                                                   type="password" placeholder="Enter your password" required />
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary" name="login" type="submit">
                                                <i class="fas fa-sign-in-alt mr-2"></i>Login
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
