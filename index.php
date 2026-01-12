<?php
session_start();

$login_status = isset($_SESSION['status']) ? $_SESSION['status'] : '';
$alert_type = isset($_SESSION['alert_type']) ? $_SESSION['alert_type'] : '';

unset($_SESSION['status']);
unset($_SESSION['alert_type']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Travel Planner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.min.css">
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="container">
        <?php if ($login_status): ?>
            <div class="alert alert-<?php echo $alert_type; ?> alert-dismissible fade show mt-5" role="alert">
                <?php echo $login_status; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="row justify-content-center align-items-center" style="height:100vh;">
            <div class="col-4">
                <!---------- LOGIN POPUP ---------->
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">Login</h3>

                        <form action="login/login.php" method="POST">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100k">Login</button>
                        </form>

                        <div class="text-center mt-3">
                            <div class="login-register">
                                <p>Don't have an account? <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#registerModal">Register</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="logo-container text-center">
            <h2>Online Travel Planner</h2>
            <img src="img/logo1.png" alt="Online Travel Planner Logo">
        </div>
    </div>

    <!-- Registration Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="register/register.php" method="POST">
                        <div class="form-group">
                            <label for="reg-username">Username</label>
                            <input type="text" class="form-control" id="reg-username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="reg-name">Name</label>
                            <input type="text" class="form-control" id="reg-name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="reg-email">Email</label>
                            <input type="email" class="form-control" id="reg-email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="reg-dob">Date of Birth</label>
                            <input type="date" class="form-control" id="reg-dob" name="dob" required>
                        </div>
                        <div class="form-group">
                            <label for="reg-password">Password</label>
                            <input type="password" class="form-control" id="reg-password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </form>
                    <div class="text-center mt-3">
                        <div class="login-register">
                            <p>Already have an account? <a href="#" data-bs-dismiss="modal"> Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>