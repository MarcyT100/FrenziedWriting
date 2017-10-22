<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Frenzied Writing</title>
     <link rel="stylesheet" type="text/css" href="style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php
  session_start();

  if (!isset($_SESSION['user_id'])) {
    echo 'You must be <a href="login.php">logged in</a> to access this page.</p>';
    exit();
  }

    require_once("navbar.php");
    require_once("connectvars.php");

    ?>
    <p>
      Forgot to get your writing before you left a sprint? No worries! We store your words from the last five sprints here.
    </p>
    <br /><br />
    <hr />
    <?

    $user_id = $_SESSION['user_id'];

    // Find all words written by that author, LIMIT 5?
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $query = "SELECT word_content, date_created FROM user_words WHERE user_id = $user_id ORDER BY id DESC LIMIT 5";
    $data = mysqli_query($dbc, $query);

    foreach ($data as $row) {
      ?>
        <div>
          <!--Format date-->
          <p><?php echo $row['date_created']; ?></p>
          <p><?php echo $row['word_content']; ?></p>
        </div>
        <br />
        <hr />
        <br />
      <?php
    }

?>

</body>
</html>
