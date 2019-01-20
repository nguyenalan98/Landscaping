<?php
include('includes/init.php');
$current_page = "logout";

log_out();
if (!$current_user) {
  record_message("You've been successfully logged out.");
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="style/shared.css" media="all" />
  <title>Logout</title>
</head>

<body>
  <?php include('includes/header.php'); ?>

  <div class="content">
    <h1>Log Out</h1>

    <?php
    print_messages();
    ?>
  </div>

  <footer>
  <?php
  include('includes/footer.php');
  ?>
  </footer>
</body>

</html>
