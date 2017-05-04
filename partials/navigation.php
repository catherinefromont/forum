<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            
           <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
               <span class="sr-only">Toggle Navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
           </button>

            <a class="navbar-brand" href="index.php">
                The Forum
            </a>
        </div>

        <div class="collapse navbar-collapse">
            
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php if(loggedIn()): ?>
                    <li class="dropdown">
                        
                     <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle">
                         <img class="nav-profile-photo" src="<?= get_gravatar($_SESSION['email']) ?>" width="20px" height="20px">
                         <?= $_SESSION['username'] ?>
                         
                         <span class="caret"></span>
                     </a>
                     <ul role="menu" class="dropdown-menu panel">

                        <li>
                            <a href="index.php" class="item">Home</a>
                        </li>
                        <li>
                            <a href="dashboard.php" class="item">Dashboard</a>
                        </li>
                        <li>
                            <a href="logout.php" class="item">Logout</a>
                        </li>
                    </ul>
                </li>
            <?php else: ?>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>

        </ul>
    </div>
</div>
</nav>
               