<?php
include('includes/init.php');
$current_page = "login";

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="style/shared.css" media="all" />

  <title>Admin</title>
</head>

<body>
  <?php include('includes/header.php'); ?>
<div class="content">
<h1>Welcome</h1>
<h3><?php print_messages();?></h3>

<form id="loginform" action="login.php" method="post">
    <label id = "fd" >Enter login details below:</label>
    <label id = "fd" >Username:</label>
    <input id = "fd" type="text" name="username" required/>
    <label id = "fd" >Password :</label>
    <input id = "fd" type="password" name="password" required/>
    <div id = "bn"><button class = "button" name="login" type="submit">Log In</button></div>
</form>
</div>
</body>
<?php include('includes/footer.php');?>
</html>
