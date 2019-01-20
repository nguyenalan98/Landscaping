<?php
include('includes/init.php');
$current_page = "admin";

function setPlantPrices($maris,$mondos,$geranis,$moccas,$shrubs,$trees){
global $db, $params;

  if($maris != 0){
    $sql = "UPDATE prices SET price=:val WHERE(name =:plant)";
    $params = array(
          'val' => $maris,
          'plant' => "marigoldpr"
        );
    exec_sql_query($db,$sql,$params);
  }
  if($mondos != 0){
    $sql = "UPDATE prices SET price=:val WHERE(name = :plant)";
    $params = array(
          'val' => $mondos,
          'plant' => "mondograsspr"
        );
    exec_sql_query($db,$sql,$params);
  }
  if($geranis != 0){
    $sql = "UPDATE prices SET price=:val WHERE(name = :plant)";
    $params = array(
          'val' => $geranis,
          'plant' => "geraniumpr"
        );
    exec_sql_query($db,$sql,$params);
  }
  if($moccas != 0){
    $sql = "UPDATE prices SET price=:val WHERE(name = :plant)";
    $params = array(
          'val' => $moccas,
          'plant' => "moccapr"
        );
    exec_sql_query($db,$sql,$params);
  }
  if($shrubs != 0){
    $sql = "UPDATE prices SET price=:val WHERE(name = :plant)";
    $params = array(
          'val' => $shrubs,
          'plant' => "shrubspr"
        );
    exec_sql_query($db,$sql,$params);
  }
  if($trees != 0){
    $sql = "UPDATE prices SET price=:val WHERE(name = :plant)";
    $params = array(
          'val' => $trees,
          'plant' => "treespr"
        );
    exec_sql_query($db,$sql,$params);
  }
}

function setServicePrices($mulching, $lawnmowing, $weeding){
global $db, $params;
  if($mulching != 0){
    $sql = "UPDATE prices SET price=:val WHERE(name = :plant)";
    $params = array(
          'val' => $mulching,
          'plant' => "mulchpr"
        );
    exec_sql_query($db,$sql,$params);
  }
  if($lawnmowing != 0){
    $sql = "UPDATE prices SET price=:val WHERE(name = :plant)";
    $params = array(
          'val' => $lawnmowing,
          'plant' => "lawnmowingpr"
        );
    exec_sql_query($db,$sql,$params);
  }
  if($weeding != 0){
    $sql = "UPDATE prices SET price=:val WHERE(name = :plant)";
    $params = array(
          'val' => $weeding,
          'plant' => "weedingpr"
        );
    exec_sql_query($db,$sql,$params);
  }
}

if (isset($_POST["priceset"])){
  $mariset = filter_input(INPUT_POST, 'marigolds',FILTER_SANITIZE_STRING);
  $mondoset = filter_input(INPUT_POST, 'mondograss',FILTER_SANITIZE_STRING);
  $geranset = filter_input(INPUT_POST, 'geraniums',FILTER_SANITIZE_STRING);
  $moccaset = filter_input(INPUT_POST, 'moccas',FILTER_SANITIZE_STRING);
  $shrubset = filter_input(INPUT_POST, 'shrubs',FILTER_SANITIZE_STRING);
  $treeset = filter_input(INPUT_POST, 'trees',FILTER_SANITIZE_STRING);
  $mulchset = filter_input(INPUT_POST, 'mulching',FILTER_SANITIZE_STRING);
  $lawnmowingset = filter_input(INPUT_POST, 'lawnmowing',FILTER_SANITIZE_STRING);
  $weedset = filter_input(INPUT_POST, 'weeding',FILTER_SANITIZE_STRING);

  setPlantPrices($mariset,$mondoset,$geranset,$moccaset,$shrubset,$treeset);
  setServicePrices($mulchset, $lawnmowingset, $weedset);
}

//FILE UPLOAD START
const MAX_FILE_SIZE = 2500000;
const IMAGE_UPLOADS_PATH = "uploads/projects/";

if(isset($_POST["submit_upload"])){
  $upload_image = $_FILES["upload_file"];

  if($upload_image['error'] == UPLOAD_ERR_OK){
    $image_name = basename($upload_image["name"]);
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

    $sql = "INSERT INTO projects (image_name, image_ext) VALUES (:filename, :extension)";
    $params = array(
      ':filename' => $image_name,
      ':extension' => $image_ext,
    );

    $upimage_result = exec_sql_query($db, $sql, $params);

    if($upimage_result){
      //Get last ID entered and move that file to the uploads/images folder defined above
      $file_id = $db->lastInsertID("id");
      if(move_uploaded_file($upload_image["tmp_name"], IMAGE_UPLOADS_PATH."$file_id.$image_ext")){
        array_push($messages, "Image has been uploaded sucessfully. Thank you.");
      }
    }
    else{
      array_push($messages, "Failed to upload image. Please check file
      size/type and try again.");
    }
  }
  else{
    array_push($messages,  "Failed to upload image. Please check file
    size/type and try again.");
  }
}
//FILE UPLOAD END
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="style/inputstyles.css" media="all" />

  <title>Admin</title>
</head>

<body>
  <?php
  if (!$current_user) {
    include('includes/header.php');
    ?>
    <div id = 'logbut'>
    <h1 id = 'lmg'>Please Log In to Access Administrator Functions</h1>
    <a href = 'login.php'><button type = 'submit' class='submit' id = 'logsubmit'>Login</button>
    </div>
    <?php
  }
  else{
  ?>
  <?php include('includes/header.php'); ?>

<div class="content">
<h1>Administrator Functions</h1>
</div>

<div id = "left-div">
  <form id="priceset" method="post" action="admin.php">
    <h2>Admin Form</h2>
          <fieldset>
            <legend>Please enter new prices for each plant</legend>
            <ul>
              <li class="order">
                Marigolds:
                <input type="number" name="marigolds" min="0" max="100" placeholder = "Please indicate price per marigold" value="0"/>
              </li>
              <li class="order">
                Mondo Grass:
                <input type="number" name="mondograss" min="0" max="100" placeholder = "Please indicate price per mondo grass" value="0"/>
              </li>
              <li class="order">
                Geraniums:
                <input type="number" name="geraniums" min="0" max="100" placeholder = "Please indicate price per geranium" value="0"/>
              </li>
              <li class="order">
                Mocca Whites:
                <input type="number" name="moccas" min="0" max="100" placeholder = "Please indicate price per mocca white" value="0"/>
              </li>
              <li class="order">
                Shrubs:
                <input type="number" name="shrubs" min="0" max="100" placeholder = "Please indicate price per shrub" value="0"/>
              </li>
              <li class="order">
                Trees:
                <input type="number" name="trees" min="0" max="100" placeholder = "Please indicate price per tree" value="0"/>
              </li>
            </ul>
          </fieldset>

          <p></p>

          <fieldset>
            <legend>Please enter new prices for each service</legend>
            <ul>
            <li class="order">
              Lawn Mowing:
              <input type="number" name="area" placeholder = "Enter price per square feet" value="0"/>
            </li>
            <li class="order">
              Weeding:
              <input type="number" name="area" placeholder = "Enter price per square feet" value="0"/>
            </li>
            <li class="order">
              Mulching:
              <input type="number" name="area" placeholder = "Enter price per square feet" value="0"/>
            </li>
          </ul>
          <input type="submit" class = "submit" name = "priceset" value="Set new values" value="0"/>
          </fieldset>
  </form>
</div>

<div id = "right-div">

  <h2>Please set a new announcement</h2>
  <form id="adminform2" action="admin.php" method="post">
    <input id = "announce" input type="text" name="announcement" placeholder = "Set new announcement..." required/>
    <button type = "submit" class="submit">Set new announcement</button>
  </form>

  <?php //record_announcement($_POST["announcement"]); ?>
  <h2>Upload new image to projects</h2>

  <h5> <?php print_messages(); ?> </h5>

  <form id="adminform3" action="admin.php" method="post" enctype="multipart/form-data">
    <input type = "hidden" name = "MAX_FILE_SIZE" value = "<?php echo MAX_FILE_SIZE; ?>" />
    <input id = "file_button" type = "file" name = "upload_file" required>
    <button type = "submit" name = "submit_upload" class="submit">Upload new image</button>
  </form>

  <h4>To add/remove tags to your project please visit the project's page through the gallery while logged in.</h4>
  <h4 id = "delete_notif">To delete a project please visit that project's page while logged in.</h4>

  <p></p>
  <a href = "logout.php"><button type = "submit" class="submit">Logout</button>
</div>

<?php
}
?>
</body>
</html>
