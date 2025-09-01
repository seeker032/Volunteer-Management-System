<?php

require '../db_connect.php';

if (!isset($_SESSION['volunteer_email'])) {
    header('Location: ../login_form.php');
    exit;
}

$stmt = $db->prepare('select * from volunteer_time_slot vts inner join time_slot ts on vts.time_id = ts.time_slot_id where vol_time_id=?');
$stmt->execute([$_GET['id']]); //gets vol_time_id in the link
$vts = $stmt->fetch(PDO::FETCH_ASSOC);
$timeSlotName = $vts['time_slot_name'];

if ($_SESSION['volunteer_email'] != $vts['volunteer_email']){ //checks if the user is authorised to delete the time slot
    header('Location: manage_time_slots.php'); 

} else {
    $stmt = $db->prepare('delete from volunteer_time_slot where vol_time_id=?');
    $stmt->execute([$_GET['id']]);
    if ($stmt->rowCount() > 0) {
        addLog('Time slot removed', $_SESSION['volunteer_email'] . ' removed ' . $timeSlotName);
        echo '<script>alert("Time slot removed.");window.location.href="manage_time_slots.php"</script>';
    } else {
        echo '<script>alert("Error. Something\'s wrong. Please try again.");window.location.href="manage_time_slots.php"</script>';
    }
}
?>