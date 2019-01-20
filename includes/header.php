<!-- <header> -->
<header class="navbar">

  <div id="title"> <p> Miralrio Landscaping </p> </div>

  <nav id="nav">
    <ul>

      <?php
        foreach($pages as $fileName => $pageName){
          if($fileName == $current_page){
            $buttonStyle = "<li id = navBackground> <a id = 'currentPage'";
          }
          else{
            $buttonStyle = "<li> <a class = 'notCurrentPage'";
          }
          echo $buttonStyle." href = '".$fileName.".php'>$pageName</a></li>";
        }
      ?>

    </ul>
  </nav>
  <p id = "lgm">
    <?php
    if ($current_user) {
      echo "Logged in as $current_user";
    }
    ?>
  </p>


</header>
<!-- </header> -->
