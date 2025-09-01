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
        Welcome, <strong><?php echo nl2br(htmlentities($_SESSION['organiser_FN']));?></strong>,   <!-- Welcomes user and shows log out link-->
        <a href="../logout_form.php" onclick="return confirm('Are you sure you want to log out?')">log out</a>
    </div>


    <?php //gets details of selected task and places results in an array
        $stmt = $db->prepare("SELECT * FROM task WHERE task_id = ?"); //prepares SQL statement to prevent SQL injection
        $stmt->execute( [$_GET['id']] ); //runs the prepared statement, inserts the value for the placeholder "?" on the sql query
        $task = $stmt->fetch(); //results inserted into array

        if (!$task)
        { // If no data (no task with that ID in the database)
            echo 'Invalid task ID.';
            echo "<script>alert('Invalid task ID.');window.location.href='manage_tasks.php'</script>";
            exit;
        }
    ?>

    <br>
    <form name="edit_task_form" method="post" action="manage_task_process.php" onsubmit="return validateForm()">

        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>"/>
        <b>Edit Task:</b><br><br>
        Task Name: <input type="text" name="task_name" value="<?php echo nl2br(htmlentities($task['task_name']));?>"/>
        <input type="submit" value="Edit" />
        <?php echo $task['only_18'] == 1 ? '18+<br><br><small>To remove the 18+ requirement, delete the task and re-add it.</small>' 
                                         : '<input type="checkbox" name="only_18" value="1">18+'; ?> <!--//checks if the task is 18+ in the database. 
                                                                                                    if it's an 18+ task, the checkbox is not displayed on page load-->
        <br>
        <br>
        <input type="button" value="Cancel" onclick="back()">

        <div id="error" class="error"></div>
    </form>
    <script>
        function validateForm() {
            // Create a variable to refer to the form
            var form = document.edit_task_form;
            var error = document.getElementById('error');

            // Tests if the task name textbox is empty
            if (form.task_name.value.trim() == '') {
                error.innerText = 'Task not specified.';
                return false;
            }

            return true;
        }

        function back(){
            window.location.href="manage_tasks.php";
        }
    </script>
</body>
</html>