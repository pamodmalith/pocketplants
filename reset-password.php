<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="bootstrap.css">
</head>

<body>

    <section class="bg-light p-3 p-md-4 p-xl-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
                    <div class="card border border-light-subtle rounded-4">
                        <div class="card-body p-3 p-md-4 p-xl-5" id="emailsend">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="text-center mb-3">
                                            <img src="assets/img/logo.png" alt="BootstrapBrain Logo" class="img-fluid">
                                        </div>
                                        <h2 class="h4 text-center">Enter new password</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row gy-3 overflow-hidden">
                                <div class="col-12">
                                    <div class="form-floating mb-2">
                                        <input type="email" class="form-control" name="email" value="<?php if (isset($_GET["email"])) echo $_GET["email"]; ?>" id="email" placeholder="name@example.com" disabled>
                                        <label for="email" class="form-label">Email</label>
                                    </div>
                                </div>
                                <div class="col-12 d-none">
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" name="vcode" value="<?php if (isset($_GET["code"])) echo $_GET["code"]; ?>" id="vcode" placeholder="123456789" required>
                                        <label for="vcode" class="form-label">Code</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating mb-2">
                                        <input type="password" class="form-control" name="password" id="pw" placeholder="Password" required>
                                        <label for="pw" class="form-label">Password</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-2">
                                        <input type="password" class="form-control" name="cpassword" id="cpw" placeholder="Password" required>
                                        <label for="cpw" class="form-label">Confirm Password</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn btn-lg btn-success" onclick="resetPassword();">Reset</button>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>