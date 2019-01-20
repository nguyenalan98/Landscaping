<?php
include('includes/init.php');
$current_page = "quote";

$temp;
$totalprice = 0;
$plantprice = 0;
$serviceprice = 0;

$marigoldpr = 5;
$mondograsspr = 23;
$geraniumpr = 9;
$moccapr = 15;
$shrubspr = 30;
$treespr = 85;
$mulchpr = 0.2;
$weedingpr = 0.03;
$lawnmowingpr = 0.0375;

$temp = exec_sql_query($db,"SELECT price FROM prices WHERE name='marigoldpr' limit 1",$params)->fetchAll(PDO::FETCH_COLUMN);
$marigoldpr= (float)$temp[0];

$temp = exec_sql_query($db,"SELECT price FROM prices WHERE name='mondograsspr' limit 1",$params)->fetchAll(PDO::FETCH_COLUMN);
$mondograsspr = (float)$temp[0];

$temp = exec_sql_query($db,"SELECT price FROM prices WHERE name='geraniumpr' limit 1",$params)->fetchAll(PDO::FETCH_COLUMN);
$geraniumpr = (float)$temp[0];

$temp = exec_sql_query($db,"SELECT price FROM prices WHERE name='moccapr' limit 1",$params)->fetchAll(PDO::FETCH_COLUMN);
$moccapr = (float)$temp[0];

$temp = exec_sql_query($db,"SELECT price FROM prices WHERE name='shrubspr' limit 1",$params)->fetchAll(PDO::FETCH_COLUMN);
$shrubspr = (float)$temp[0];

$temp = exec_sql_query($db,"SELECT price FROM prices WHERE name='treespr' limit 1",$params)->fetchAll(PDO::FETCH_COLUMN);
$treespr = (float)$temp[0];

$temp = exec_sql_query($db,"SELECT price FROM prices WHERE name='mulchpr' limit 1",$params)->fetchAll(PDO::FETCH_COLUMN);
$mulchpr = (float)$temp[0];

$temp = exec_sql_query($db,"SELECT price FROM prices WHERE name='weedingpr' limit 1",$params)->fetchAll(PDO::FETCH_COLUMN);
$weedingpr = (float)$temp[0];

$temp = exec_sql_query($db,"SELECT price FROM prices WHERE name='lawnmowingpr' limit 1",$params)->fetchAll(PDO::FETCH_COLUMN);
$lawnmowingpr = (float)$temp[0];

function getPlantPrices($maris,$mondos,$geranis,$moccas,$shrubs,$trees){
  global $marigoldpr, $mondograsspr, $geraniumpr, $moccapr, $shrubspr, $treespr;

  $plantprice += ($maris * $marigoldpr);
  $plantprice += ($mondos * $mondograsspr);
  $plantprice += ($geranis * $geraniumpr);
  $plantprice += ($moccas * $moccapr);
  $plantprice += ($shrubs * $shrubspr);
  $plantprice += ($trees * $treespr);
  return $plantprice;
}

function getServicePrice($sqftarea,$mulching, $lawnmowing, $weeding){
  global $mulchpr, $weedingpr, $lawnmowingpr;

  if($sqftarea > 0){
    if($mulching == 1){
      $serviceprice += ($sqftarea * $mulchpr);
    }
    if($lawnmowing == 1){
      $serviceprice += ($sqftarea * $weedingpr);
    }
    if($weeding == 1){
      $serviceprice += ($sqftarea * $lawnmowingpr);
    }
  }
  else{
    if($mulching == 1){
      $serviceprice += 100;
    }
    if($lawnmowing == 1){
      $serviceprice += 30;
    }
    if($weeding == 1){
      $serviceprice += 30;
    }
  }
  return $serviceprice;
}
if (isset($_POST["pricecheck"])){
  $area = filter_input(INPUT_POST, 'area',FILTER_SANITIZE_STRING);
  $num_mari = filter_input(INPUT_POST, 'marigolds',FILTER_SANITIZE_STRING);
  $num_mondo = filter_input(INPUT_POST, 'mondograss',FILTER_SANITIZE_STRING);
  $num_geran = filter_input(INPUT_POST, 'geraniums',FILTER_SANITIZE_STRING);
  $num_mocca = filter_input(INPUT_POST, 'moccas',FILTER_SANITIZE_STRING);
  $num_shrubs = filter_input(INPUT_POST, 'shrubs',FILTER_SANITIZE_STRING);
  $num_trees = filter_input(INPUT_POST, 'trees',FILTER_SANITIZE_STRING);
  $mulchbool = filter_input(INPUT_POST, 'mulching',FILTER_SANITIZE_STRING);
  $lawnmowingbool = filter_input(INPUT_POST, 'lawnmowing',FILTER_SANITIZE_STRING);
  $weedbool = filter_input(INPUT_POST, 'weeding',FILTER_SANITIZE_STRING);
  $testresult = $area . $num_mari . $num_mondo . $num_geran . $num_mocca . $num_shrubs . $num_trees;
  $totalprice = getPlantPrices($num_mari,$num_mondo,$num_geran,$num_mocca,$num_shrubs,$num_trees) + getServicePrice($area, $mulchbool,$lawnmowingbool,$weedbool);
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="style/inputstyles.css" media="all" />
<title>Quote</title>
</head>

<body>
<?php include('includes/header.php'); ?>
<div id = "left-div">
  <form id="pricecheck" method="post" action="quote.php">
    <h2>Quote Form</h2>
          <fieldset>
            <legend>Please enter number of each plant and indicate area</legend>
            <ul>
              <li class="order">
                Square Feet:
                <input type="number" name="area" placeholder = "Enter lot area (leave empty for average lawn)"/>
              </li>
              <li class="order">
                Marigolds:
                <input type="number" name="marigolds" min="0" max="100" placeholder = "Please indicate number of marigolds" value="0"/>
              </li>
              <li class="order">
                Mondo Grass:
                <input type="number" name="mondograss" min="0" max="100" placeholder = "Please indicate number of mondo grass" value="0"/>
              </li>
              <li class="order">
                Geraniums:
                <input type="number" name="geraniums" min="0" max="100" placeholder = "Please indicate number of geraniums" value="0"/>
              </li>
              <li class="order">
                Mocca Whites:
                <input type="number" name="moccas" min="0" max="100" placeholder = "Please indicate number of mocca whites" value="0"/>
              </li>
              <li class="order">
                Shrubs:
                <input type="number" name="shrubs" min="0" max="100" placeholder = "Please indicate number of shrubs" value="0"/>
              </li>
              <li class="order">
                Trees:
                <input type="number" name="trees" min="0" max="100" placeholder = "Please indicate number of trees" value="0"/>
              </li>
            </ul>
          </fieldset>

          <p></p>

          <fieldset>
            <legend>Please select the services you would like</legend>
            <ul>
            <li class="order">
              Lawn Mowing:
              <input type="checkbox" name="lawnmowing" value = "1"/>
            </li>
            <li class="order">
              Weeding:
              <input type="checkbox" name="weeding" value="1"/>
            </li>
            <li class="order">
              Mulching:
              <input type="checkbox" name="mulching" value="1"/>
            </li>
          </ul>
          <input type="submit" class = "submit" name = "pricecheck" value="Get Quote"/>
          </fieldset>
  </form>
</div>

<div id = "right-div">
  <h2 id="displaymessage">The estimated price will be:</h2>
  <h2 id = "displaymessage"> <?php echo htmlspecialchars("$" . number_format($totalprice, 2));?> </h2>
</div>
<?php include('includes/footer.php'); ?>
</body>

</html>
