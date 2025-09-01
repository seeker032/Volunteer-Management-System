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
    <title>Manage Event Duration</title>
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
    <b>Change Event Duration</b> |
    <a href="event_log.php">Event Log</a>
</p>

<h3>Change Duration:</h3>

<?php
$error = '';

$stmt = $db->prepare('select max(day) as current_day from time_slot'); //select statement for event logging and changing the event duration
$stmt->execute();
$result = $stmt->fetch();
$currentDay = $result['current_day'];


if (!empty($_POST)) { 
    $newDay = $_POST['day'];
    if ($newDay == 0) { //if nothing is selected in the drop down list, this error message appears
        $error = 'Please select a new duration.'; 
    } else if ($newDay == $currentDay) { //if the new duration is equal to the current one, this error message appears
        $error = 'Please select a different duration.';
    } else {
        if ($newDay < $currentDay) {
            //delete
            $stmt = $db->prepare('delete from time_slot where `day` > ?');
            $stmt->execute([$newDay]);
            addLog('Decreased event duration', $_SESSION['organiser_username'] . ' changed event duration (in days) from ' . $currentDay . ' to ' . $newDay); //calls function for event logging, accepts values for log table in db
            echo "<script>alert('Event duration decreased.');window.location.href=window.location.href;</script>";
        } else {
            //inserts time slots to database if the event duration is increased. $newDay > $currentDay
            $intervals = ['Morning', 'Afternoon', 'Night']; //stores these values to an array 
            
            for ($i = $currentDay + 1; $i <= $newDay; $i++) { //loop continues to run until $i == $newDay. $i is used to calculate the day that needs to be inserted in the time_slot table in db
                //adds morning, afternoon, night, and the day
                for ($j = 0; $j < 3; $j++) { //
                    $timeSlotName = "Day {$i}, {$intervals[$j]}";
                    $stmt = $db->prepare('insert into time_slot (time_slot_name, `day`) value (?, ?)');
                    $stmt->execute([$timeSlotName, $i]);
                }
            }
            addLog('Increased event duration', $_SESSION['organiser_username'] . ' changed event duration (in days) from ' . $currentDay . ' to ' . $newDay); //calls function for event logging, accepts values for log table in db
            echo "<script>alert('Event duration increased.');window.location.href=window.location.href;</script>";
        }
        exit;
    }
}
?>

<form name="change_duration_form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return validateForm()">
    <input type="hidden" name="current_day" value="<?php echo $currentDay;?>">
    Current Duration: <?php echo $currentDay < 2 ? 
                                            $currentDay.' day' : //determines if currentDay is less than 2. if less than 2, "day" is displayed instead of "days"
                                            $currentDay.' days';?> 
    <br>
    <br>

    Modify Duration:
    <select name="day">
        <option value="0">Select duration</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
    </select>
    <br>
    <br>
    <input type="submit" value="Submit">
    <div id="error" class="error"><?php echo $error;?></div>
</form>

<script>
    function validateForm(){
        var form = document.change_duration_form;
        var error = document.getElementById('error');

        var currentDay = form.current_day.value;
        var newDay = form.day.value;

        if (newDay == 0) {
            error.innerText = 'Please select a duration.';
            return false;
        }

        if (newDay == currentDay) {
            error.innerText = 'Please select a different day.';
            return false;
        }

        return true;
    }
</script>
</body>
</html>