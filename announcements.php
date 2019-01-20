<?php
include('includes/init.php');
$current_page = "announcements";

include('includes/header.php');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="style/shared.css" media="all" />

  <title>Home</title>
</head>

<body>
  <div class="content">
  <h1>Announcements</h1>
  <div class = "row">
    <div class="column">
      <?php echo "<p>$announcements[0]</p>"; ?>
        <br>
        <hr>
    </div>
    <div class = "column">
      <?php echo "<p>$announcements[1]</p>"; ?>
        <br>
        <hr>
    </div>
  </div>
  <div class = "row">
    <div class="column">
      <?php echo "<p>$announcements[2]</p>"; ?>
    </div>
    <div class = "column">
      <?php echo "<p>$announcements[3]</p>"; ?>
      </div>
    </div>
</body>

<?php include('includes/footer.php');?>
</html>
