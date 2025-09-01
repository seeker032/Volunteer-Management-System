<?php
    require '../db_connect.php'; //requires database connection, allows calling of function "addLog" for event logging

    if (!isset($_SESSION['organiser_username'])) { //redirects user to login form if they're not logged in
        header('Location: ../login_form.php');
        exit;
    }

    if (!empty($_POST)) {
        $action = $_POST['action']; 
        $taskId = isset($_POST['task_id']) ? $_POST['task_id'] : 0; //if the add button is pressed in manage_tasks.php, $taskId is given the value of 0 to prevent an undeclared variable error.
        $taskName = trim($_POST['task_name']);
        $only18 = isset($_POST['only_18']) ? $_POST['only_18'] : 0; //if the add button is pressed in manage_tasks.php, $only18 is given the value of 0 to prevent an undeclared variable error.

        if ('' === $taskName) {
            echo "<script>alert('Task name not specified.');window.location.href='manage_tasks.php';</script>";
            exit;
        }

        if ($action === 'add') {
            //checks if a task with the same name has already been added
            $stmt = $db->prepare('select * from task where task_name=?');
            $stmt->execute([$taskName]);
            if ($stmt->fetch()) {
                echo "<script>alert('Error. The task has already been added.');window.location.href='manage_tasks.php';</script>";
                exit;
            }

            //inserts new task into database
            $stmt = $db->prepare('insert into task (task_name, only_18) value (?, ?)');
            $stmt->execute([$taskName, $only18]);
            if ($stmt->rowCount() > 0) {
                addLog('Add Task', $_SESSION['organiser_username'] . ' added task ' . $taskName); //calls function for event logging, accepts values for log table in db

                echo "<script>alert('Task successfully added.');window.location.href='manage_tasks.php';</script>";
            } else {
                echo "<script>alert('Error! Something\'s wrong. Please try again.');window.location.href='manage_tasks.php';</script>";
            }

        } else if ($action === 'edit') {
            //checks if an existing task matches the task name 
            $stmt = $db->prepare('select * from task where task_name = ? and task_id = ? and only_18 = ?');
            $stmt->execute([$taskName, $taskId, $only18]);
            $row = $stmt->fetch();
         
            if ($row) {
                echo "<script>alert('Please edit the task or make sure it doesn\'t match any other tasks.');window.location.href='edit_task.php?id={$taskId}';</script>";
                exit;
            }

            //select statement for event logging
            $stmt = $db->prepare('select * from task where task_id = ?');
            $stmt->execute([$taskId]);
            $task = $stmt->fetch();

            //update statement for the editing of the specified task
            $stmt = $db->prepare('update task set task_name=?, only_18=? where task_id=?');
            $result = $stmt->execute([$taskName, $only18, $taskId]);
            if ($result) {
                addLog('Edit Task', $_SESSION['organiser_username'] . ' changed task name from ' . $task['task_name'] . ' to ' . $taskName); //calls function for event logging, accepts values for log table in db

                echo "<script>alert('Task updated.');window.location.href='manage_tasks.php';</script>";
            } else {
                echo "<script>alert('Error! Something's wrong. Please try again.');window.location.href='edit_task.php?task_id={$taskId}';</script>";
            }
        } 
    } else { //redirects user to manage_tasks.php if no button was pressed
        header('Location: manage_tasks.php');
    }
?>