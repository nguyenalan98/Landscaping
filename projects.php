<?php
include('includes/init.php');
$current_page = "projects";
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
    <?php include("includes/header.php");?>

  <div class = "tag_gallery" id="tag_gallery">
        <h2> Tags: </h2>
        <h3> Select a tag to view the projects associated with that tag. </h3>

        <table class = "tag_table" id = "tag_table">
          <tr>
            <?php
              $sql = "SELECT tag FROM tags";
              $allTags = exec_sql_query($db, $sql, NULL)->fetchAll(PDO::FETCH_COLUMN);

              foreach($allTags as $tag){
                echo "<td class = 'tag_list'><a href = 'tag.php?tag=".htmlspecialchars($tag)."'>".htmlspecialchars($tag)."</td>";
              }
             ?>
          </tr>
        </table>
      </div>

<div class="content">
    <fieldset id="gallery">
      <div class = "project_gallery">
        <h2> Projects: </h2>
        <h3> Currently viewing all projects. </h3>
        <h3> Click on a project image to view its details. </h3>
        <?php
          $sql = "SELECT * FROM projects";
          $params = array();
          $result = exec_sql_query($db, $sql, $params);

          foreach($result as $row){
            echo "<a href = 'project.php?proj=".$row['id']."'><img class = 'single_image' src = 'uploads/projects/".$row['id'].".".$row['image_ext']."' alt = 'image".$row['id']."' />";
          }
        ?>
      </div>
    </fieldset>

    </div>

    <?php include("includes/footer.php");?>
  </body>
</html>
