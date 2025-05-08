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
    $email = $_POST["email"];
    $password = $_POST["password"];

    $ressult = mysqli_query($conn, "SELECT * FROM login WHERE email = '$email' and password = '$password'");// Query untuk mencari data yang sesuai
    $count = mysqli_num_rows($ressult);// Menghitung jumlah data yang ditemukan

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
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4" name="email" id="inputEmailAddress" type="email" placeholder="Enter email address" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="Enter password" />
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary" name="login" href="index.html">Login</button>
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
