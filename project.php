<?php
include('includes/init.php');
$current_page = "picture";

//Initializing project_id
$project_num = filter_input(INPUT_GET, "proj", FILTER_SANITIZE_STRING);

//Query for image
$sql = "SELECT * FROM projects WHERE id = :project_num;";
$params = array(':project_num' => $project_num);
$records = exec_sql_query($db, $sql, $params)->fetchAll();

if($records){
  $myProject = $records[0];
}

//Querying for project tags so user can look at similar images
$sql = "SELECT tags.tag FROM projects_tags INNER JOIN tags ON tags.tag_id = projects_tags.tag_id WHERE projects_tags.project_id = :image_num;";
$params = array(':image_num' => $project_num);
$project_tags = exec_sql_query($db, $sql, $params)->fetchAll(PDO::FETCH_COLUMN);


//////////////ALL ADMIN FUNCTIONS BEGIN/////////////////
//NOTE: Referencing project 3 code for tag addition/deletion NOTE//
////////////////////////////////////////////////////////////////////////////////

//BEGIN INSERTING TAG
////////////////////////////////////////////////////////////////////////////////
if (isset($_POST["add_tag"])) {
  $tag_name = filter_input(INPUT_POST, 'tag_name', FILTER_SANITIZE_STRING);

  //Array to check if tag already exists (cant add a duplicate tag)
  $compareArray = array_map('strtolower', $project_tags);

  //NOTE: Only using lowercase tags to compare if tag exists, un-modified tag is eventually entered
  $lower_tag_name = strtolower($tag_name);

  //Checking to see if tag already exists on image
  if (in_array($lower_tag_name, $compareArray)){
    array_push($messages, "Failed to add tag.
    Please check if tag already exists on this project (tags are not case-senstive).");
  } //End

  else{

    //Checking to see if tag exists in tags table
    $sql = "SELECT tag FROM tags";
    //Single tag
    $all_tags = exec_sql_query($db, $sql, NULL)->fetchAll(PDO::FETCH_COLUMN);

    $sql = "SELECT * FROM tags";
    //All tags
    $all_tags_full = exec_sql_query($db, $sql, NULL)->fetchAll();

    //If tag exists on other photos just add it to images_tags
    if (in_array($tag_name, $all_tags)){
      $index = array_search($tag_name, $all_tags);

      //Finding the tag id of the tag if it exists
      $tag_num = $all_tags_full[$index]["tag_id"];

      $sql = "INSERT INTO projects_tags (project_id, tag_id) VALUES (:project_id, :tag_id)";
      $params = array(
        ':project_id' => $project_num,
        ':tag_id' => $tag_num,
      );
      $added_tag_existing = exec_sql_query($db, $sql, $params);

      if($added_tag_existing){
        array_push($messages, "Sucessfully added tag to project.");
      }
      else{
        array_push($messages, "Failed to add tag. Please check for special
        characters and try again");
      }
    }
    //Otherwise add it to tags AND images_tags
    else{
      $sql = "INSERT INTO tags (tag) VALUES (:tag_name)";
      $params = array(
        ':tag_name' => $tag_name,
      );
      $added_tag_new = exec_sql_query($db, $sql, $params);

      //If adding new tag to tags database worked
      if($added_tag_new){
        //Magic here
        $lastid = $db->lastInsertId("id");

        $sql = "INSERT INTO projects_tags (project_id, tag_id) VALUES (:project_id, :tag_id)";
        $params = array(
          ':project_id' => $project_num,
          ':tag_id' => $lastid,
        );

        //Add tag+image combination to projects_tags
        $added_tag_both = exec_sql_query($db, $sql, $params);

        if($added_tag_both){
          array_push($messages, "Sucessfully added tag.");
        }
        else{
          array_push($messages, "Failed to add tag. Please check input
          and try again.");
        }
      }
      else{
        array_push($messages, "Failed to add tag. Please check input
        and try again.");
      }
    }

  //Added new tag, so query again to update page in case more operations are done

  //TURN THIS INTO A FUNCTION IF HAVE TIME**************************************

  $sql = "SELECT tags.tag FROM projects_tags INNER JOIN tags ON tags.tag_id = projects_tags.tag_id WHERE projects_tags.project_id = :image_num;";
  $params = array(':image_num' => $project_num);
  $project_tags = exec_sql_query($db, $sql, $params)->fetchAll(PDO::FETCH_COLUMN);
  }
}
////////////////////////////////////////////////////////////////////////////////
//END INSERTING TAG


//BEGIN DELETING TAG
////////////////////////////////////////////////////////////////////////////////
if (isset($_POST["delete_tag"])) {
  $delete_name = filter_input(INPUT_POST, 'delete_name', FILTER_SANITIZE_STRING);

  //Checking to see if tag even exists
  //NOTE: Shouldn't be the case ever because tags are given in a drop down menu
  if (!in_array($delete_name, $project_tags)){
    array_push($messages, "Failed to delete tag. Please check still exists or
    was already deleted");
  }

  //Tag exists
  else{
    //Deleting tag from images_tags database first where image_id is this one

    //IMPORTANT: if tag still exists in images_id then dont delete from tags DB
    //because another image may have that tag
    $sql = "SELECT tag_id FROM tags WHERE tag = :delete_name";
    $params = array(
      ':delete_name' => $delete_name,
    );
    $result = exec_sql_query($db, $sql, $params)->fetchAll(PDO::FETCH_COLUMN);

    //Getting autoincrement id of tag
    $delete_tag_id = $result[0];

    $sql = "DELETE FROM projects_tags WHERE tag_id = :delete_tag_id AND project_id = :project_num";
    $params = array(
      ':delete_tag_id' => $delete_tag_id,
      ':project_num' => $project_num,
    );
    $result = exec_sql_query($db, $sql, $params);

    //Deleted tag from many-to-many table
    //Now check if tag no longer exists in table and if so delete from tags table
    if ($result) {
      array_push($messages, "Sucessfully removed tag from project.");

      //Deleted tag, so update tags table for new admin operations
      $sql = "SELECT tags.tag FROM projects_tags INNER JOIN tags ON tags.tag_id = projects_tags.tag_id WHERE projects_tags.project_id = :image_num;";
      $params = array(':image_num' => $project_num);
      $project_tags = exec_sql_query($db, $sql, $params)->fetchAll(PDO::FETCH_COLUMN);

      //Check if no other images have the deleted tag
      $sql = "SELECT project_id FROM projects_tags WHERE tag_id = :delete_tag_id;";
      $params = array(
        ':delete_tag_id' => $delete_tag_id
      );
      $tag_exists = exec_sql_query($db, $sql, $params)->fetchAll(PDO::FETCH_COLUMN);


      //No images with tag = delete tag completely
      if(!$tag_exists){
        $sql = "DELETE FROM tags WHERE tag_id = :delete_tag_id";

        $params = array(
          ':delete_tag_id' => $delete_tag_id,
        );

        $remove_tag_completely = exec_sql_query($db, $sql, $params);
        //No need for confirmation message here as we already presented one
      }
    }
    else{
      array_push($messages, "Error removing tag. Please check if tag exists on
      project, refresh page and try agian.");
    }
  }
}
////////////////////////////////////////////////////////////////////////////////
//END DELETING TAG

//START DELETING IMAGE
////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['delete_image'])){

  //Querying project number again, was messed up from earlier code
  $project_num = filter_input(INPUT_GET, "proj", FILTER_SANITIZE_STRING);

  //Should only be one result
  $sql = "SELECT * FROM projects WHERE id = :project_num;";
  $params = array(':project_num' => $project_num);
  $unlink_image = exec_sql_query($db, $sql, $params);

  if($unlink_image){
    $delete_img = $records[0];
  }

  //Deleting from disk
  $unlinked_image = unlink("uploads/projects/".$delete_img["id"].".".$delete_img["image_ext"]);

  $sql = "DELETE FROM projects WHERE id = :project_num;";
  $params = array(':project_num' => $project_num);

  //Deleting from database
  $deleted_image = exec_sql_query($db, $sql, $params);

  //If deleted from database AND disk sucessfully
  if($unlinked_image && $deleted_image){
    record_message("Sucessfully deleted project from website and disk folder");

    //Records is false because image no longer exists
    $records = FALSE;
    //Ensures that page no longer runs

    //Deleting tags that were associated with image
    //****IF HAVE TIME: turn tag deletion into functions and use here*******

    $sql = "DELETE FROM projects_tags WHERE project_id = :project_num";
    $params = array(
      ':project_num' => $project_num,
    );
    exec_sql_query($db, $sql, $params);

    //Once agian, clear all tags from tags DB that no longer exist in projects_tags

    //****Can use this code above when deleting tags****
    $sql = "SELECT tags.tag_id FROM tags LEFT OUTER JOIN projects_tags ON projects_tags.tag_id = tags.tag_id WHERE projects_tags.tag_id IS NULL";
    $null_tags = exec_sql_query($db, $sql, NULL)->fetchAll(PDO::FETCH_COLUMN);

    //Removing null tags
    foreach($null_tags as $tag){
      $sql = "DELETE FROM tags WHERE tag_id = :tag_num";
      $params = array(
        ':tag_num' => $tag,
      );
      exec_sql_query($db, $sql, $params);
    }
  }
  else{
    record_message("There was an error deleting your image. Please check if image
    exists, refresh page, and try again.");
  }
}
////////////////////////////////////////////////////////////////////////////////
//END DELETING IMAGE

////////////////////////////////////////////////////////////////////////////////
//ADMIN FUNCTIONS END
////////////////////////////////////////////////////////////////////////////////

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="style/shared.css" media="all" />
    <title>Selected Project</title>
  </head>

  <body>
    <?php include("includes/header.php");?>

<div id = "display_project">
  <h2> Viewing Project</h2>

      <?php
        //UNCOMMENT THIS AFTER IMPLEMENTED
        //print_messages();
      ?>

    <fieldset id = "image_box">
      <div id = "image_wrap">
        <?php
        if($records){
          echo "<img id = 'selected_project' src = 'uploads/projects/".$myProject['id'].".".$myProject['image_ext']."' alt = 'image".$myProject['id']."' height = 500px />";
        }
        ?>
      </div>

      <div id = "project_details">
        <?php

        if($records){

          ?>
          <h2>Project Details</h2>
          <?php

          // Might want to use a conditional statement here and only echo categories that exist in the database
          echo "<p>
          Project Name: ".htmlspecialchars($myProject['project_name'])."<br>
          Image Name: ".htmlspecialchars($myProject['image_name'])." <br>
          File Type: ".htmlspecialchars($myProject['image_ext'])."<br>
          </p>";
        }
      ?>
      </div>
    </fieldset>

    <div class = "tag_gallery" id = "tag_gallery">
      <h3>Click on the tags below to change tag filters</h3>
      <table class = "tag_table" id ="tag_table">
        <tr>
          <?php
            $sql = "SELECT tag FROM tags";
            $allTags = exec_sql_query($db, $sql, NULL)->fetchAll(PDO::FETCH_COLUMN);

            echo "<td class = 'tag'><a href = 'projects.php"."'>"."View All"."</td>";
            foreach($allTags as $tag){
              echo "<td class = 'tag'><a href = 'tag.php?tag=".htmlspecialchars($tag)."'>".htmlspecialchars($tag)."</td>";
            }
           ?>
        </tr>
      </table>
    </div>
    </div>

    <!-- Displaying admin functions ONLY if admin is logged in-->
    <?php if($current_user){ ?>

      <div id="admin_functions">

        <!-- Printing confirmation messages or errors-->
        <h5><?php print_messages() ?> </h5>

        <!-- ADD TAG FORM  -->
        <div id="add_tag">
          <form class = "add_delete" action = "project.php?proj=<?php echo $project_num ?>" method= "post">
            <ul>
              <li class="tags_admin">
            <label>Add a tag:</label>
            <input id = "input_id" type = "text" name = "tag_name" maxlength = "30" required/>
            <button name = "add_tag" type = "submit">Submit</button>
            </li>
          </ul>
          </form>
        </div>
        <!-- ADD TAG FORM  -->

        <!-- DELETE TAG FORM  -->
        <div id="delete_tag">
          <form class = "add_delete" action = "project.php?proj=<?php echo $project_num ?>" method= "post">
            <ul>
              <li class="tags_admin">
            <label>Delete a tag:</label>
            <select id = "select_box" name = "delete_name" required>
              <option value = "" selected disabled >Choose Tag</option>

              <?php
              foreach($allTags as $tag) {
                echo "<option value=\"" .htmlspecialchars($tag). "\">".htmlspecialchars($tag)."</option>";
              }
              ?>

            </select>
            <button name = "delete_tag" type = "submit">Delete</button>
          </li>
        </ul>
          </form>
        </div>
        <!-- DELETE TAG FORM  -->

        <!-- DELETE IMAGE FORM  -->
        <div id="delete_image">
          <form class = "add_delete" action = "project.php?proj= <?php echo $project_num ?>" method= "post">
            <ul>
              <li class="tags_admin">
              <label>Delete this image:</label>
              <button id = "delete_button" name = "delete_image" type = "submit" >Delete Image</button>
            </li>
          </ul>
          </form>
        </div>
        <!-- DELETE IMAGE FORM  -->



    <?php } ?>
  </div>

    <?php include("includes/footer.php");?>
  </body>
</html>
