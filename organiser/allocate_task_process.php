<?php

require '../db_connect.php'; //requires database connection, allows calling of function "addLog" for event logging

if (!isset($_SESSION['organiser_username'])) { // Welcome user and show log out link
    header('Location: ../login_form.php');
    exit;
}

$volTimeId = $_POST['vol_time_id']; //stores vol_time_id to a variable from hidden input field on allocate_task.php
// If the request includes form data...
if (isset($_POST['allocate'])) { // Validate and process the form
    $taskId = $_POST['task_id'];
    $details = $_POST['details'];

    if (!$taskId) {
        echo "<script>alert('Please select a task.');window.location.href='allocate_task.php?id={$volTimeId}'</script>";
        exit;
    }

    $stmt = $db->prepare('select * from task where task_id=?');
    $stmt->execute([$taskId]);
    $task = $stmt->fetch();

    $stmt = $db->prepare('select * from volunteer_time_slot vts inner join volunteer v on vts.volunteer_email = v.volunteer_email where vol_time_id=?');
    $stmt->execute([$volTimeId]);
    $volTimeSlot = $stmt->fetch();

    if ($task['only_18'] == 1) {
        if (strtotime('18 years ago') < strtotime($volTimeSlot['birthday'])) {
            echo "<script>alert('Volunteer is not 18+ years old.');window.location.href='allocate_task.php?id={$volTimeId}'</script>";
            exit;
        }
    }

    if (trim($details) === '') {
        echo "<script>alert('Task details not specified.');window.location.href='allocate_task.php?id={$volTimeId}'</script>";
        exit;
    }

    $stmt = $db->prepare("UPDATE volunteer_time_slot SET task_id = ?, details = ? WHERE vol_time_id = ?");
    $result = $stmt->execute([$taskId, $details, $volTimeId]);
    if (!$result) {
        echo "<script>alert('Error! Something's wrong. Please try again.');window.location.href='allocate_task.php?id={$volTimeId}'</script>";
        exit;
    }

    $stmt = $db->prepare("select * from time_slot WHERE time_slot_id = ?");
    $stmt->execute([$volTimeSlot['time_id']]);
    $timeSlot = $stmt->fetch();
    
    addLog('Allocate Task', "{$_SESSION['organiser_username']} allocated {$task['task_name']} to {$volTimeSlot['volunteer_email']} on {$timeSlot['time_slot_name']}"); //calls function for event logging, accepts values for log table in db
    echo "<script>alert('Task allocated.');window.location.href='volunteer_time_slots.php'</script>";

} else if (isset($_POST['clear'])) { //clears the volunteer time slot
    $stmt = $db->prepare('select * from volunteer_time_slot where vol_time_id=?'); //select statement for event logging
    $stmt->execute([$volTimeId]);
    $volTimeSlot = $stmt->fetch();

    $stmt = $db->prepare('select * from task where task_id=?'); //select statement for event logging
    $stmt->execute([$volTimeSlot['task_id']]);
    $task = $stmt->fetch();

    $stmt = $db->prepare("select * from time_slot WHERE time_slot_id = ?"); //select statement for event logging
    $stmt->execute([$volTimeSlot['time_id']]);
    $timeSlot = $stmt->fetch();

    $stmt = $db->prepare("UPDATE volunteer_time_slot SET task_id = NULL, details = NULL WHERE vol_time_id = ?");
    $result = $stmt->execute( [$_POST['vol_time_id']] );

    if (!$result) {
        echo "<script>alert('Error! Something's wrong. Please try again.');window.location.href='allocate_task.php?id={$volTimeId}'</script>";
        exit;
    }

    if ($volTimeSlot['task_id'] > 0) {
        addLog('Clear Task', "{$_SESSION['organiser_username']} cleared {$volTimeSlot['volunteer_email']}'s task called {$task['task_name']} on {$timeSlot['time_slot_name']}"); //calls function for event logging, accepts values for log table in db
    }

    echo "<script>alert('Tasked cleared.');window.location.href='volunteer_time_slots.php'</script>";

} else { //if no button is pressed, user is redirected to volunteer_time_slot.php
    header('Location: volunteer_time_slots.php');
}