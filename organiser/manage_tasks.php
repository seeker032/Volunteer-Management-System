<?php

require '../db_connect.php'; //requires database connection, allows calling of function "addLog" for event logging

if (!isset($_SESSION['organiser_username'])) { //redirects user to login form if they're not logged in
    header('Location: ../login_form.php');
    exit;
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Manage Tasks</title>
    <link rel="stylesheet" type="text/css" href="../styles/stylesheet.css" />
</head>
<body>
<div>
    Welcome, <strong><?php echo nl2br(htmlentities($_SESSION['organiser_FN']));?></strong>, <!-- Welcomes user and shows log out link-->
    <a href="../logout_form.php" onclick="return confirm('Are you sure you want to log out?')">log out</a>
</div>
<p>
    <a href="volunteer_time_slots.php">Volunteer Time Slots</a> | <!-- navigation bar -->
    <b>Manage Tasks</b> |
    <a href="change_duration.php">Change Event Duration</a> |
    <a href="event_log.php">Event Log</a>
</p>

 <!--table for current tasks starts here.-->
<h3>Current Tasks:</h3>
<table>
    <tr>
        <th>Task Name</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>

    <?php //gets details of all tasks then places results to an array
    $stmt = $db->prepare("SELECT * FROM task"); //prepares SQL statement to prevent SQL injection
    $stmt->execute(); //runs the prepared statement
    $list = $stmt->fetchAll(); //stores the result of the sql query to an array
    ?>

   
    <?php if (!empty($list)):?> <!--checks if the tasks table in the database isn't empty-->
    <?php foreach($list as $v):?> <!--table is populated by looping through the array-->
    <tr>
        <td><?php echo $v['only_18'] == 1 ? nl2br(htmlentities($v['task_name'])) . ' (18+)' : nl2br(htmlentities($v['task_name']));?></td> <!--conditional statement. checks if tasks are 18+. 
                                                                                                                                            If it is, (18+) is added after the task name in the table data-->
        <td><a href="edit_task.php?id=<?php echo $v['task_id'];?>">Edit</a></td>
        <td><a href="delete_task.php?id=<?php echo $v['task_id'];?>" onclick="return confirm('Do you want to delete the task?')">Delete</a></td>
    </tr>
    <?php endforeach;?>
    <?php else:?>
    <tr>
        <td colspan="3">No data.</td> <!--If there are no tasks, the table shows that there is no data-->
    </tr>
    <?php endif;?>
</table>
  <!--current tasks table ends here-->

<br><br>

<form name="add_task_form" method="post" action="manage_task_process.php" onsubmit="return validateForm()">
    <input type="hidden" name="action" value="add">
    <b>Add New Task:</b><br><br>
    Task Name: <input type="text" name="task_name" />
    <input type="submit" value="Add" />
    <input type="checkbox" name="only_18" value="1">18+

    <br><br>
    <div class="error" id="error"></div>
</form>

<script>

    function validateForm() {
        // Creates a variable to refer to the form
        var form = document.add_task_form;
        var error = document.getElementById('error')

        // Tests if the task name textbox is empty
        if (form.task_name.value.trim() == '') {
            error.innerText = 'Task not specified.';
            return false;
        }

        return true;
    }
</script>
</body>
</html>