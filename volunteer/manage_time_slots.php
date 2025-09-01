<?php

require '../db_connect.php';

//redirects user to login form if they're not logged in
if (!isset($_SESSION['volunteer_email'])) {
    header('Location: ../login_form.php');
    exit;
}

?>

<html>
<head>
    <title>Volunteer Page</title>
    <link rel="stylesheet" type="text/css" href="../styles/stylesheet.css" />
</head>

<body>
<div>
    Welcome, <strong><?php echo nl2br(htmlentities($_SESSION['volunteer_FN']));?></strong>,
    <a href="../logout_form.php" onclick="return confirm('Are you sure you want to log out?')">log out</a>
</div>

<h3>Your Time Slots:</h3>

<?php
$sql = "select * from volunteer_time_slot vs 
        inner join time_slot s on vs.time_id = s.time_slot_id 
        left join task on vs.task_id = task.task_id 
        where volunteer_email = ? order by vs.time_id asc";
$stmt = $db->prepare($sql);
$stmt->execute([$_SESSION['volunteer_email']]);
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<table>
    <tr>
        <th>Time Slot</th>
        <th>Allocated Task</th>
        <th>Details</th>
        <th>Remove</th>
    </tr>
    <?php if (!empty($list)):?>
    <?php foreach ($list as $v):?>
    <tr>
        <td><?php echo nl2br(htmlentities($v['time_slot_name']));?></td>
        <td><?php echo null !== $v['task_name'] ? nl2br(htmlentities($v['task_name'])) : '<i>No task allocated</i>';?></td>
        <td><?php echo nl2br(htmlentities($v['details']));?></td>
        <td><a href="remove.php?id=<?php echo $v['vol_time_id'];?>" onclick="return confirm('Are you sure you want to delete the time slot?')">Remove</a></td>
    </tr>
    <?php endforeach;?>
    <?php else:?>
    <tr>
        <td colspan="4">No data.</td>
    </tr>
    <?php endif;?>

</table>

<h3>Add Time Slot:</h3>
<?php
$stmt = $db->prepare('select * from time_slot');
$stmt->execute();
$timeSlots = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<form method="post" action="add_time_slot.php">
    <select name="slot">
        <option value="0">Select a time slot</option>
        <?php foreach ($timeSlots as $slot):?>
            <option value="<?php echo $slot['time_slot_id'];?>"><?php echo nl2br(htmlentities($slot['time_slot_name']));?></option>
        <?php endforeach;?>
    </select>
    <button type="submit">Add</button>
</form>

</body>
</html>