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
    <title>Volunteer Time Slots</title>
    <link rel="stylesheet" type="text/css" href="../styles/stylesheet.css" />
</head>
<body>
<div>
    Welcome, <strong><?php echo nl2br(htmlentities($_SESSION['organiser_FN']));?></strong>, <!-- Welcomes user and shows log out link-->
    <a href="../logout_form.php" onclick="return confirm('Are you sure you want to log out?')">log out</a>
</div>

<p>
    <b>Volunteer Time Slots</b> |   <!--Navigation bar-->                   
    <a href="manage_tasks.php">Manage Tasks</a> |
    <a href="change_duration.php">Change Event Duration</a> |
    <a href="event_log.php">Event Log</a>
</p>

<h3>Current Volunteer Time Slots:</h3>

<?php
$sql = 'select * from volunteer_time_slot vts
        inner join time_slot ts on vts.time_id = ts.time_slot_id
        inner join volunteer v on vts.volunteer_email = v.volunteer_email
        left join task t on vts.task_id = t.task_id order by vts.time_id asc';

$stmt = $db->prepare($sql); //prepares SQL query to prevent SQL injection attacks
$stmt->execute();
$list = $stmt->fetchAll(); //places results of sql query into an array 
?>

<!--Table for volunteer time slots starts here-->
<table>
    <tr>
        <th>Time Slot</th>
        <th>Volunteer Name</th>
        <th>Allocated Task</th>
        <th>Details</th>
        <th>Edit</th>
    </tr>
    <?php if (!empty($list)) :?> <!--checks if there is no data in the array-->
    <?php foreach ($list as $v):?> <!--loops through the array, to display table data-->
        <tr>
    <td><?php echo $v['time_slot_name'];?></td>
    <td><?php echo $v['first_name'] . ' ' . $v['last_name'];?></td>
    <td><?php echo null !== $v['task_name'] ? nl2br(htmlentities($v['task_name'])) : '<i>No task Allocated</i>';?></td> <!--conditional statement. displays allocated task, if there is none, no task is displayed -->
    <td><?php echo $v['details'];?></td>
    <td><a href="allocate_task.php?id=<?php echo $v['vol_time_id'];?>">Edit</a></td>
        </tr>
        <?php endforeach;?>
    <?php else:?>
        <tr>
            <td colspan="5">No data!</td> <!--table shows this output if there is no data in the array-->
        </tr>
    <?php endif;?>
</table>

<!--Table for volunteer time slots ends here-->

</body>
</html>