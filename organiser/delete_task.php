<?php
  require '../db_connect.php';

  if (!isset($_SESSION['organiser_username'])) { //redirects user to login form if they're not logged in
    header('Location: ../login_form.php');
    exit;

  }

  if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) { // If there is no "id" URL data or it isn't a number, user is redirected back to manage_tasks
    header('Location: manage_tasks.php');
    exit;

  }

  $stmt = $db->prepare('select * from task where task_id = ?'); //select statement for event logging
  $stmt->execute([$_GET['id']]);
  $task = $stmt->fetch();

  // Delete details of specified tasks
  // Since the user could tamper with the URL data, a prepared statement is used
  $stmt = $db->prepare("DELETE FROM task WHERE task_id = ?");
  $result = $stmt->execute( [$_GET['id']] );

  if ($result) {

    addLog('Remove Task', $_SESSION['organiser_username'] . ' removed task ' . $task['task_name']); //calls function for event logging, accepts values for log table in db
    echo '<script>alert("Task deleted!");window.location.href="manage_tasks.php"</script>';

  }

  else {

    echo '<script>alert("Error. The task is currently assigned to a volunteer. Please remove the task from the volunteer first, and try again.");window.location.href="manage_tasks.php"</script>';
    exit;
  }

?>