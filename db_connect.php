<?php
  // This file will be included at the start of all other files in the site
  // It includes code to connect to the database server, but could be expanded
  // to include other things that are needed across multiple files in the site!

  session_start(); //creates a session

  try
  { 
    $db = new PDO('mysql:host=localhost;port=6033;dbname=manage_volunteers', 'root', '');  // Connects to database server

    function addLog($eventType, $eventDetails){ //creates function for event logging
      global $db;

      $stmt = $db->prepare('insert into log (ip_address, event_type, event_details) value (?, ?, ?)'); //insert statement for event logging
      $stmt->execute([$_SERVER['REMOTE_ADDR'], $eventType, $eventDetails]);
    }
  }
  catch (PDOException $e) 
  {
    echo 'Error connecting to database server:<br />';
    echo $e->getMessage();
    exit;
  } 

  
?>