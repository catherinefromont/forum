<?php

require 'includes/config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (empty($_POST['username']) || empty($_POST['password'])) {
    addMessage("error",  'Please enter both fields!');

}


$username = strtolower($_POST['username']);
$password = strtolower($_POST['password']);
$user = getUser($dbh, $username);

$passwordMatches = password_verify($password, $user['password']);


if (!empty($user) && ($username === strtolower($user['username']) || $username === strtolower($user['email'])) && $passwordMatches) {

    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['id'] = $user['id'];
    $_SESSION['admin'] = $user['admin'];
   
    addMessage("success", 'Congratulations, You are now logged in');

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


<!-- start of login form -->
<div class="container">

    
        <div class="col-md-12"><?= showMessages() ?></div>
   
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-danger">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="login.php">

                        <div class="form-group">
                            <label for="username" class="col-md-4 control-label">User Name/Email Address</label>

                            <div class="col-md-6">
                                <input id="username" type="username" class="form-control" name="username" value=""  autofocus="">

                            </div>
                        </div>


                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-info">
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

</div>


<?php
require 'partials/footer.php';
?>
