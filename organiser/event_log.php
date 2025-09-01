<?php

require '../db_connect.php'; //requires database connection, allows calling of function "addLog" for event logging

//redirects user to login form if they're not logged in
if (!isset($_SESSION['organiser_username'])) {
    header('Location: ../login_form.php');
    exit;
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Event Logs</title>
    <link rel="stylesheet" type="text/css" href="../styles/stylesheet.css" />
</head>
<body>
<div>
    Welcome, <strong><?php echo nl2br(htmlentities($_SESSION['organiser_FN']));?></strong>, <!-- Welcomes user and shows log out link-->
    <a href="../logout_form.php" onclick="return confirm('Are you sure you want to log out?')">log out</a>
</div>

<p>
    <a href="volunteer_time_slots.php">Volunteer Time Slots</a> |
    <a href="manage_tasks.php">Manage Tasks</a> |
    <a href="change_duration.php">Change Event Duration</a> |
    <b>Event Log</b>
</p>

<h3>Event Log:</h3>

<?php
$stmt = $db->prepare('select * from log order by log_date desc'); //select statement to fill the table with data
$stmt->execute();
$list = $stmt->fetchAll();
?>
<table>
    <tr>
        <th>Log Date</th>
        <th>IP Address</th>
        <th>Event Type</th>
        <th>Event Details</th>
    </tr>
    <?php if (!empty($list)) :?>
        <?php foreach ($list as $v):?> <!--loops through array until no data is left-->
            <tr>
                <td><?php echo $v['log_date'];?></td>
                <td><?php echo $v['ip_address'];?></td>
                <td><?php echo nl2br(htmlentities($v['event_type']));?></td>
                <td><?php echo nl2br(htmlentities($v['event_details']));?></td>
            </tr>
        <?php endforeach;?>
    <?php else:?>
        <tr>
            <td colspan="4">No data!</td> 
        </tr>
    <?php endif;?>
</table>

</body>
</html>