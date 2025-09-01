<!DOCTYPE html>
<html>
<head>
    <title>Organiser Registration</title>
    <meta name="author" content="Harvey Roxas and Haowen Yang" />
    <meta name="description" content="Project for Interactive Web Development (2023)" />
    <link rel="stylesheet" type="text/css" href="../styles/stylesheet.css" />
</head>
<body>

<?php
define('ACCESS_CODE', 'CSG2431'); //sets the access code for organiser registrations

require '../db_connect.php'; //requires database connection, allows calling of function "addLog" for event logging

$error = '';

$accessCode = '';
$username = '';
$password = '';
$passwordConf = '';


if (!empty($_POST)) { //checks if form data isn't empty
    $accessCode = $_POST['access_code']; 
    $username = $_POST['organiser_username'];     //places form data to variables for clean-looking code
    $password = $_POST['organiser_password'];
    $passwordConf = $_POST['organiser_password_conf'];


    if ('' === $accessCode) {
        $error = 'Please enter the access code.';
    } else if ($accessCode !== ACCESS_CODE) {
        $error = 'The access code is incorrect.';
    } else if ('' === $username) {
        $error = 'Please enter your username.';
    } else if (strlen($password) < 5) {
        $error = 'Passwords must be at least 5 characters long.';
    } else if ($password !== $passwordConf) {
        $error = 'Error. The passwords don\'t match.';
    }

    if ('' === $error) {
        $stmt = $db->prepare('select * from organiser where organiser_username=?'); //prepares sql query to prevent sql injection attacks
        $stmt->execute([$username]);

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $error = 'The username has already been registered.';
        } else {
            $stmt = $db->prepare("INSERT INTO organiser (organiser_username, organiser_password) VALUES (?, ?)");
            $stmt->execute( [$username, password_hash($password, PASSWORD_DEFAULT)] );
            if ($stmt->rowCount() > 0) {
                addLog('Registration (Organiser)', $username . ' registered'); //calls function for event logging, accepts values for log table in db

                echo "<script>alert('Registration successful');window.location.href='../login_form.php'</script>";
                exit;
            } else {
                $error = 'Error. Something\'s wrong. Please try again.';
            }
        }
    }
}


?>

<form name="register_form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return validateForm()">
    <fieldset>
        <legend>Organiser Registration</legend>
        <label>
            <span>ACCESS CODE:</span>
            <input type="password" name="access_code" value="<?php echo $accessCode;?>" autofocus />
        </label>
        <label>
            <span>Username:</span>
            <input type="text" name="organiser_username" value="<?php echo $username;?>"  />
        </label>
        <label>
            <span>Password:</span>
            <input type="password" name="organiser_password" value="<?php echo $password;?>"/>
        </label>
        <label>
            <span>Confirm Password:</span>
            <input type="password" name="organiser_password_conf" value="<?php echo $passwordConf;?>"/>
        </label>

        <input type="submit" value="Register" />
        <div id="error" class="error"><?php echo $error;?></div>
    </fieldset>
</form>

<script>
    function validateForm() {
        var form = document.register_form;
        var error = document.getElementById('error');

        if (form.access_code.value == '') {
            error.innerText = 'Please enter the access code.';
            return false;
        }

        if (form.organiser_username.value == '') {
            error.innerText = 'Please enter a username.';
            return false;
        }

        if (form.organiser_password.value.length < 5) {
            error.innerText = 'Passwords must be at least 5 characters long.';
            return false;
        }

        if (form.organiser_password.value != form.organiser_password_conf.value) {
            error.innerText = 'Passwords do not match.';
            return false;
        }

        return true;
    }
</script>
</body>
</html>
