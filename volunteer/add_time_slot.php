<?php
require '../db_connect.php';

if (!isset($_SESSION['volunteer_email'])) {
    header('Location: ../login_form.php');
    exit;
}

$timeSlot = isset($_POST['slot']) ? $_POST['slot']  : 0;
if ($timeSlot == 0) {
    echo '<script>alert("Please select a time slot.");window.location.href="manage_time_slots.php"</script>';
    exit;
}

$stmt = $db->prepare("select * from volunteer_time_slot where volunteer_email=? and time_id=?");
$stmt->execute([$_SESSION['volunteer_email'], $timeSlot]);
$exist = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$exist) {
    $stmt2 = $db->prepare("insert into volunteer_time_slot (volunteer_email, time_id) value (?,?)");
    $stmt2->execute([$_SESSION['volunteer_email'], $timeSlot]);
    if ($stmt2->rowCount() > 0) {
        $stmt = $db->prepare("select * from time_slot where time_slot_id=?");
        $stmt->execute([$timeSlot]);
        $timeSlotRow = $stmt->fetch(PDO::FETCH_ASSOC);

        addLog('Time Slot added', $_SESSION['volunteer_email'] . ' added ' . $timeSlotRow['time_slot_name']);
        echo '<script>alert("Time slot added.");window.location.href="manage_time_slots.php"</script>';
    } else {
        echo '<script>alert("Error. Something\'s wrong. Please try again.");window.location.href="manage_time_slots.php"</script>';
    }
} else {
    echo '<script>alert("Sorry, you\'ve already added this time slot.");window.location.href="manage_time_slots.php"</script>';
}
