 <?php
  ini_set('display_errors', 'On');
  $dsn = 'mysql:dbname=moodle;host=localhost';
  $user = 'root';
  $password = 'Anx1239!';

  try {   
    $db = new PDO($dsn, $user, $password);  
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
  } catch(Exception $e) {   
    echo 'Connection failed: ' . $e->getMessage();
    die();
  }
