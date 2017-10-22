<?php
    // Generate navigation bar
    echo '<hr />';

    // If user is logged in, display home, view profile, and logout. Otherwise, display home, login, and sign up.
    if (isset($_SESSION['user_id'])) {
        echo '<a href="index.php">Home</a> &#8226; ';
        echo '<a href="word-storage.php">My Writing</a> &#8226; ';
        echo '<a href="word-war.php">New War</a> &#8226; ';
        echo '<a href="word-sprint.php">New Sprint</a> &#8226; ';
        echo '<a href="word-crawl.php">New Crawl</a> &#8226; ';
        echo '<a href="my-account.php">Account</a> &#8226; ';
        echo '<a href="logout.php">Log Out</a>';
    }
    else {
      echo '<a href="index.php">Home</a> &#8226; ';
      echo '<a href="word-storage.php">Writing</a> &#8226; ';
      echo '<a href="word-war.php">New War</a> &#8226; ';
      echo '<a href="word-sprint.php">New Sprint</a> &#8226; ';
      echo '<a href="word-crawl.php">New Crawl</a> &#8226; ';
      echo '<a href="signup.php">Sign Up</a> &#8226; ';
      echo '<a href="login.php">Log In</a>';
    }

    echo '<hr />';
?>
