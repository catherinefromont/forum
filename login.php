<?php

require 'includes/config.php';

// if (loggedIn()) {
//   // redirect('index.php');
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // First validation
  if (empty($_POST['username']) || empty($_POST['password'])) {
    addMessage("error",  'Please enter both fields!');
    // redirect('login.php');
}

  // Next try to get the user from the database
$username = strtolower($_POST['username']);
$password = strtolower($_POST['password']);
$user = getUser($dbh, $username);

$passwordMatches = password_verify($password, $user['password']);

  // Test that the entered details match the login details
if (!empty($user) && ($username === strtolower($user['username']) || $username === strtolower($user['email'])) && $passwordMatches) {
    // Add data to the session
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['id'] = $user['id'];
   
    addMessage("success", 'Congratulations, You have are now logged in');
    // Redirect to the dashboard
    redirect('index.php');
}
else {
    addMessage("error", 'Username and password do not match our records');
}
}

$page['title'] = 'Login';

require 'partials/header.php';
require 'partials/navigation.php';

?>


<!-- Start of Navigation -->

<!-- End of Navigation -->

<!-- Start of Content -->
<div class="container">

    <div class="row">
        <div class="col-md-12"><?= showMessages() ?></div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="login.php">

                        <!-- Email Input -->
                        <div class="form-group">
                            <label for="username" class="col-md-4 control-label">User Name/Email Address</label>

                            <div class="col-md-6">
                                <input id="username" type="username" class="form-control" name="username" value="" required="" autofocus="">

                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required="">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Content -->
</div>

<!-- Scripts -->
<!-- Bootstrap JavaScript -->
<?php
require 'partials/footer.php';
?>
