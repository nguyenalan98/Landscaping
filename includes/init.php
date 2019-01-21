<?php
$messages = array();

$announcements = array(
"Our Quotes page allows our customers to get an estimated price for the services they wish to have.
  This calculator includes specific plants, square footage of planting, and services such as mowing, weeding, and mulching.",
"Check out our projects page, which features Miralrio's Lawncare's past projects
  including mulching, planting flowers, trimming; just a few of the services we offer!",
"There are big updates coming to our site.  We are adding new pages such as
  a Quotes page where you can estimate the price based on services and square footage. Stay
  tuned for these changes!",
"With springtime nearly here, it's time to prepare your lawn so it can look its
  best by summertime! Now is the time for fertilizing, trimming and any planting you have in mind!"
);

// Record a message to display to the user.
function record_message($message) {
  global $messages;
  array_push($messages, $message);
}

// Write out any messages to the user.
function print_messages() {
  global $messages;
  foreach ($messages as $message) {
    echo "<p><strong>" . htmlspecialchars($message) . "</strong></p>\n";
  }
}

function exec_sql_query($db, $sql, $params = array()) {
  $query = $db->prepare($sql);
  if ($query and $query->execute($params)) {
    return $query;
  }
  return NULL;
}

// YOU MAY COPY & PASTE THIS FUNCTION WITHOUT ATTRIBUTION.
// open connection to database
function open_or_init_sqlite_db($db_filename, $init_sql_filename) {
  if (!file_exists($db_filename)) {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db_init_sql = file_get_contents($init_sql_filename);
    if ($db_init_sql) {
      try {
        $result = $db->exec($db_init_sql);
        if ($result) {
          return $db;
        }
      } catch (PDOException $exception) {
        // If we had an error, then the DB did not initialize properly,
        // so let's delete it!
        unlink($db_filename);
        throw $exception;
      }
    }
  } else {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
  return NULL;
}

// open connection to database
$db = open_or_init_sqlite_db("website.sqlite", "init/init.sql");

function check_login() {
  if (isset($_SESSION['current_user'])) {
    return $_SESSION['current_user'];
  }
  return NULL;
}

function log_in($username, $password) {
  global $db;

  if ($username && $password) {
    $sql = "SELECT * FROM users WHERE username = :username;";
    $params = array(
      ':username' => $username
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($records) {
      // Username is UNIQUE, so there should only be 1 record.
      $account = $records[0];

      // Check password against hash in DB
      if (password_verify($password, $account['password'])) {
        // generate new session
        session_regenerate_id();
        $_SESSION['current_user'] = $username;

        record_message("Logged in as $username.");
        header("Refresh:0; url=admin.php");
        return $username;

      }
      else {
        record_message("Invalid username or password.");
      }
    }
    else {
      record_message("Invalid username or password.");
    }
  }
  else {
    record_message("No username or password given.");
  }
  return NULL;
}

function log_out() {
  global $current_user;
  $current_user = NULL;
  // destroy PHP session
  unset($_SESSION['current_user']);
  session_destroy();
}

// Check if we should login the user
session_start();
if (isset($_POST['login'])) {
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $username = trim($username);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

  $current_user = log_in($username, $password);
}
else {
  // check if logged in
  $current_user = check_login();
}

if($current_user == NULL){
  $pages = array(
    "index"=>"Home",
    "announcements"=>"Announcements",
    "projects"=>"Projects",
    "quote"=>"Quotes",
  );
}
else{
  $pages = array(
    "index"=>"Home",
    "announcements"=>"Announcements",
    "projects"=>"Projects",
    "quote"=>"Quotes",
  );
}

?>
