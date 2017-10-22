<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  echo 'You must be <a href="login.php">logged in</a> to access this page.</p>';
  exit();
}

  require_once('connectvars.php');

?>

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
  // Display navigation bar
  require_once('navbar.php');

    if (isset($_GET['sprint'])) {
      $user = $_SESSION['user_id'];
      $sprint = $_GET['sprint'];
      $storedWords;

      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      $sql = "SELECT word_content FROM USER_WORDS WHERE user_id = $user AND sprint_id = $sprint ORDER BY id DESC LIMIT 1";
      $data = mysqli_query($dbc, $sql);
      if (mysqli_num_rows($data) == 1) {
        $row = mysqli_fetch_array($data);
        $storedWords = $row['word_content'];
      }

      ?>

      <p>Link to share sprint: http://localhost:8888/FrenziedWriting/word-sprint.php?sprint=<?php echo $_GET['sprint']; ?></p>

      <br /><br />

      <!-- <h1 class="progressBar"></h1>

      <br /><br />
      <form action="" method="POST">
      <div class="form-group">
        <textarea class="form-control" rows="5" id="userWords" name="userWords"><?php if($_POST['userWords'] != '') { echo $_POST['userWords']; } else if ($storedWords != '') { echo $storedWords; }?></textarea>
      </div>
    </form>
      <br /><br /> -->

      <?php

    //   echo "<script>var data = $('#userWords').val();
    // $('#userWords').focus().val('').val(data);</script>";

        // IF joinButton has been clicked, add record
        if (isset($_POST['joinButton'])) {

        $userConnection;
        $sprintId = $_GET['sprint'];
        $userId = $_SESSION['user_id'];
        if (isset($_POST['userWords'])) {
            $userWords = $_POST['userWords'];

        $userWordCount;

        $string = preg_replace('/\s+/', ' ', trim($userWords));
        $words = explode(" ", $string);
        $userWordCount = count($words);

        }


          $currentUsername = $_SESSION['username'];

          $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
          $query = "INSERT INTO USER_WORDS (user_id, sprint_id, date_created, username) VALUES ($userId, $sprintId, NOW(), '$currentUsername')";
          mysqli_query($dbc, $query);

        }

        $userId = $_SESSION['user_id'];
        $sprintId = $_GET['sprint'];
        $userConnection;

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = "SELECT id FROM USER_WORDS WHERE user_id = $userId AND sprint_id = $sprintId ORDER BY id DESC LIMIT 1";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
            $row = mysqli_fetch_array($data);
            $userConnection = $row['id'];
        }

        // If there is a record
        if ($userConnection != null && $userConnection != '') {
              $currentSprint = $_GET['sprint'];
              $currenWordGoal;

              $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
              $query = "UPDATE user_words SET word_content = '$userWords', word_count = '$userWordCount' WHERE id = $userConnection";
              mysqli_query($dbc, $query);

              $query = "SELECT word_goal FROM WORD_SPRINT WHERE id = $currentSprint";
              $data = mysqli_query($dbc, $query);

              if (mysqli_num_rows($data) == 1) {
                  $row = mysqli_fetch_array($data);
                  $currentWordGoal = $row['word_goal'];
              }

              ?>
              <hr />
              <?php

              $query = "SELECT user_id, word_count, username FROM USER_WORDS WHERE sprint_id = $currentSprint ORDER BY word_count DESC";
              $data = mysqli_query($dbc, $query);

              foreach ($data as $row) {
                  // If this wordcount is equal to or greater than wordGoal
                  if ($row['word_count'] > $currentWordGoal) {
                    if ($row['user_id'] == $_SESSION['user_id']) {
                      echo "<script>alert('Congrats! You won the sprint!');</script>";
                    } else {
                      echo "<script>alert('I\'m sorry. You lost.');</script>";
                    }

                  } else {
                    $wordCount = (int) $row['word_count'] - 1;
                    $wordCountPercentage = ($wordCount * 100) / $currentWordGoal;
                    $wordCountPercentageToGo = 100 - $wordCountPercentage;
                    $currentUser = $row['username'];

                    ?>

                    <p class='progressBar'>
                      <span class='barUsername'><?php echo $currentUser; ?></span>
                      <span class='barPercentage'><?php echo $wordCountPercentage; ?>%</span>
                      <br />

                    <?php

                    for ($i=0; $i < $wordCountPercentage; $i++) {
                      echo "<span style='color: #154360; font-size: 180%; letter-spacing: -3.8px;'>&#9632;</span>";
                    }

                    for ($ii=0; $ii < $wordCountPercentageToGo; $ii++) {
                      echo "<span style='color: #659ec7; font-size: 180%; letter-spacing: -3.8px;'>&#9632;</span>";
                    }

              }

                ?>
                  <hr />
                <?php

            }

            ?>

            <br /><br />
            <form action="" method="POST">
            <div class="form-group">
              <textarea class="form-control" rows="20" id="userWords" name="userWords"><?php if($_POST['userWords'] != '') { echo $_POST['userWords']; } else if ($storedWords != '') { echo $storedWords; }?></textarea>
            </div>
          </form>
            <br /><br />
        </p>

            <?php

            echo "<script>var data = $('#userWords').val();
          $('#userWords').focus().val('').val(data);</script>";

            ?>

            <?php

          set_time_limit(0);

          ob_start();

          $size = ob_get_length();
          header("Content-Length: $size");
          header('Connection: close');
          ob_end_flush();
          ob_flush();
          flush();
          if (session_id()) session_write_close();

          // Happening in the background now

          usleep(1000000); // do some stuff (this is 10 seconds?)

          echo "<script>document.formId.submit(); return true; } return false;</script>";

          echo "<script>document.forms[0].submit();</script>";


?>



<?php


        } else {
          ?>

          <form action="" method="POST">
          <div class="form-group">
          <input class="form-control btn btn-primary" name="joinButton" type="submit" value="Join the Sprint" />
          </div>
          </form>

          <?php
        }

        ?>

        <?php

    } else if (isset($_POST['submit'])) {

          $sprintId;

          // Check to make sure it's a number

          $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
          $wordGoal = mysqli_real_escape_string($dbc, trim($_POST['wordGoal']));
          $sprintOwner = $_SESSION['user_id'];
          $query = "INSERT INTO WORD_SPRINT (creation_date, word_goal, sprint_owner) VALUES (NOW(), '$wordGoal', '$sprintOwner')";
          mysqli_query($dbc, $query);

          $query = "SELECT id FROM WORD_SPRINT WHERE word_goal = '$wordGoal' AND sprint_owner = '$sprintOwner' ORDER BY id DESC LIMIT 1";
          $data = mysqli_query($dbc, $query);

          if (mysqli_num_rows($data) == 1) {
              $row = mysqli_fetch_array($data);
              $sprintId = $row['id'];
          }

          echo '<script>window.location="http://localhost:8888/FrenziedWriting/word-sprint.php?sprint=' . $sprintId . '"</script>';

        } else {

      ?>
      <form action="" method="POST">
      <div class="form-group">
      <label for="wordGoal" class="form-label">Word Count Goal: </label>
      <input type="text" name="wordGoal" class="form-control" id="wordGoal" />
      <div class="form-group">
      <br />
      <div class="form-group">
      <input class="form-control btn btn-primary" name="submit" type="submit" />
      </div>
      </form>
      <br /><br /><br />

      <?php


    }

   ?>

</body>
</html>
