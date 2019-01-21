<?php
include('includes/init.php');
$current_page = "index";
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

    <?php include('includes/header.php'); ?>
    <div class="hero">
      <div class="hero-text">
      <p> We take pride in working hard to meet our customer's needs. From lawncare to special projects, we specialize in ensuring your lawn is in prime shape.</p>
      </div>
    </div>
  <div class="content1">
    <div id="services">
      <div class="content_title">
      <h1>Services</h1>
      <div class="services">
        <div class="service">
          <h3> Lawn Mowing </h3>
          <img src="/uploads/projects/21.JPG" alt="mow">
          <p class="service_info"> Starting with the company's roots, we provide a classic lawn mowing service which includes the mowing, lawn edge trimming, and grass clippings management.</p>
        </div>
        <div class="service">
          <h3>Trimming </h3>
          <img src="/uploads/projects/6.JPG" alt="trim">
          <p class="service_info"> Not only do we do lawn mowing; upon request, we can maintain your gardens' small trees, hedges, and bushes looking clean cut.</p>
        </div>
        <div class="service">
          <h3> Special Projects </h3>
          <img src="/uploads/projects/3.JPG" alt="special">
          <p class="service_info"> From making garden beds, to putting down sod, and even fertilizing our company can tackle those rough projects to make your lawn look sharp!</p>
        </div>
        <div class="service">
          <h3> And More! </h3>
          <img src="/uploads/projects/20.JPG" alt="misc">
          <p class="service_info"> If you have a lawn care need that hasn't already been specified, just ask! Chances are good that we can handle it!</p>
        </div>
      </div>
      </div>


    </div>
  </div>

    <?php include('includes/footer.php'); ?>
  </body>
</html>
