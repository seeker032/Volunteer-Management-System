<?php

require '../db_connect.php'; //requires database connection, allows calling of function "addLog" for event logging

if (!isset($_SESSION['organiser_username'])) { //redirects user to login form if they're not logged in
    header('Location: ../login_form.php');
    exit;
}

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) { // If there is no "id" URL data or it isn't a number, user is redirected back to volunteer_time_slots.php
    header('Location: volunteer_time_slots.php');
    exit;
  }

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Allocate Task</title>
    <link rel="stylesheet" type="text/css" href="../styles/stylesheet.css" />
</head>
<body>
<div>
    Welcome, <strong><?php echo nl2br(htmlentities($_SESSION['organiser_FN']));?></strong>, <!-- Welcomes user and shows log out link-->
    <a href="../logout_form.php" onclick="return confirm('Are you sure you want to log out?')">log out</a>
</div>

<h3>Allocate Task:</h3>
<body>

<?php
$stmt = $db->prepare("SELECT vts.*, CONCAT(v.first_name, ' ', v.last_name) 
                        AS name, time_slot_name, task_name
                        FROM volunteer_time_slot AS vts 
                        INNER JOIN volunteer AS v ON vts.volunteer_email = v.volunteer_email
                        INNER JOIN time_slot AS ts ON vts.time_id = ts.time_slot_id
                        LEFT OUTER JOIN task AS t ON vts.task_id = t.task_id
                        WHERE vol_time_id = ?");
$stmt->execute( [$_GET['id']] );
$vol_time = $stmt->fetch();
?>

<form name="allocate_task_form" class="allocate_task" method="post" action="allocate_task_process.php">
    <input type="hidden" name="vol_time_id" value="<?php echo $_GET['id']; ?>"/>
    <b>Time Slot:</b> <?php echo nl2br(htmlentities($vol_time['time_slot_name']));?>
    <br>
    <br>

    <b>Volunteer Name:</b> <?php echo nl2br(htmlentities($vol_time['name']));?>
    <br>
    <br>

    <b>Task:</b>
    <br>

    <!--task drop down list-->
    <select name="task_id" style="width: 295px;">
        <option value="0">Select a task</option>
        <?php
        // Select details of all tasks
        $tasks = $db->query("SELECT * FROM task ORDER BY task_id");

        ?>
        <?php foreach ($tasks as $task):?>
            <option value="<?php echo $task['task_id'];?>" <?php echo $vol_time['task_id'] == $task['task_id'] ? 'selected': ''; ?>>
            <?php echo $task['only_18'] == 1 ? nl2br(htmlentities($task['task_name'])) . ' (18+)' : nl2br(htmlentities($task['task_name']));?></option>
        <?php endforeach;?>
    </select>
    <br>
    <br>

    <!--task drop down list ends here-->

    <b>Task Details:</b>
    <br>
    <textarea name="details" style="width: 400px; height: 60px"><?php echo nl2br(htmlentities($vol_time['details']));?></textarea>
    <br>
    <br>

    <div id="error" class="error"></div>

    <div>
        <input type="submit" name="allocate" value="Allocate" onclick="return validateForm()"/>
        <input type="submit" name="clear" value="Clear" onclick="return confirm('Are you sure you want to clear the task?')"  />
        <input type="button" name="cancel" value="Cancel" onclick="back()">
    </div>
</form>

<script>
    function validateForm() {
        // Create a variable to refer to the form
        var form = document.allocate_task_form;
        var error = document.getElementById('error');

        // Tests if the task_name options field is empty
        if (form.task_id.value == 0) {
            error.innerText = 'Task not specified.';
            return false;
        }

        // Tests if the task details textarea is empty
        if (form.details.value.trim() == '') {
            error.innerText = 'Task details not specified.';
            return false;
        }

        return true;
    }

    function back(){
        window.location.href="volunteer_time_slots.php";
    }

</script>
</body>
</html>
