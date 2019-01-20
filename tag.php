<?php
include('includes/init.php');
$current_page = "tag";

//Initializing tag
$tag_name = filter_input(INPUT_GET, "tag", FILTER_SANITIZE_STRING);

//Finding the tag_id from the tag name
$sql = "SELECT tag_id FROM tags WHERE tag = :tag_name;";
$params = array(':tag_name' => $tag_name);
$records = exec_sql_query($db, $sql, $params)->fetchAll(PDO::FETCH_COLUMN);

if($records){
  $single_tag = $records[0];

  //Actually query an image
  $img_search = true;
}
else{

  //Don't query image if nothing is returned from the query
  $img_search = false;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="style/shared.css" media="all" />
    <title>Selected Tag</title>
  </head>

  <body>
<?php include("includes/header.php");?>

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

    <div class = "content" id = "image_gallery">
      <fieldset id="gallery">
      <?php
      //Echo tag_name outside of only the address
      echo "<h3>All images for tag: ".$tag_name."</h3>";

      //Allow user to click on an image much like they can click on tags on the actual image
      echo "<h4> Click an image to view its detials and other tags or select 'Home' on the navigation bar to view all tags & images.</h4>";

        if($img_search){
          $sql = "SELECT * FROM projects INNER JOIN projects_tags ON projects.id = projects_tags.project_id WHERE projects_tags.tag_id = :requested_id;";

          $params = array(
            ':requested_id' => $single_tag
          );
          //Querying all images with the tag from GET
          $tagged_images = exec_sql_query($db, $sql, $params)->fetchAll();

          //If images exist
          if($tagged_images){
            foreach($tagged_images as $row){
              //Printing images as links so the user can click on each project once again
              echo "<a href = 'project.php?proj=".$row['project_id']."'><img class = 'single_image' src = 'uploads/projects/".$row['project_id'].".".$row['image_ext']."' alt = 'project".$row['project_id']."' />";
            }
          }
          //If image doesn't exit
          else{
            echo "<h3>Sorry, the tag you requested is invalid or does not exist.</h3>";
          }
        }
        //Invalid tag
        else{
          echo "<h3>Sorry, the tag you requested is invalid or does not exist.</h3>";
        }
      ?>
    </fieldset>
    </div>
  </body>
  <?php include('includes/footer.php');?>
</html>
