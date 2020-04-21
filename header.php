<!-- DEVELOPER: Michael Pavlovic -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="index.php"><&#129437;> Curious Raccoons <&#129437;></a>
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php#get-started">Get Started</a>
        </li>
        <?php if(isset($_SESSION['userID']) && isset($_SESSION['username']) && isset($_SESSION['userType'])){ ?>
        <li class="nav-item">
            <a class="nav-link" href="<?php if($_SESSION['userType'] == 0){ echo 'userDashboard.php'; } else{ echo 'adminDashboard.php'; } ?>">Dashboard</a>
        </li>
        <?php } ?>
    </ul>
    <?php if(!isset($_SESSION['userID']) && !isset($_SESSION['username']) && !isset($_SESSION['userType'])){ ?>
        <a style="margin-left:1em" class="login btn btn-primary" href="signin.php">Log In</a>
        <a style="margin-left:1em" class="register btn btn-primary button" href="signup.php">Register Now</a>
    <?php } else { ?>
        <li class="nav-link active">Welcome back, <?= $_SESSION['username']; ?></li>
        <a class="btn btn-danger float-right" href="logout.php">Logout</a>
    <?php } ?>
</nav>
