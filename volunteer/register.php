<!DOCTYPE html>
<html>
<head>
    <title>Volunteer Registration</title>
    <meta name="author" content="Harvey Roxas and Haowen Yang" />
    <meta name="description" content="Project for Interactive Web Development (2023)" />
    <link rel="stylesheet" type="text/css" href="../styles/stylesheet.css" />
</head>
<body>

<?php
require '../db_connect.php';

$error = '';

$email = '';
$password = '';
$passwordConf = '';
$firstname = '';
$lastname = '';
$phone = '';
$postcode = '';
$birthday = '';

if (!empty($_POST)) {
    $email = $_POST['volunteer_email'];
    $password = $_POST['volunteer_password'];
    $passwordConf = $_POST['volunteer_password_conf'];
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    $phone = $_POST['phone'];
    $postcode = $_POST['postcode'];
    $birthday = $_POST['birthday'];

    if ('' === $email) {
        $error = 'Please enter your email address.';
    } else if (strlen($password) < 5) {
        $error = 'Password must be at least 5 characters long.';
    } else if ($password !== $passwordConf) {
        $error = 'Passwords do not match.';
    } else if ('' === $firstname) {
        $error = 'Please enter your first name.';
    } else if ('' === $lastname) {
        $error = 'Please enter your last name.';
    } else if ('' === $phone) {
        $error = 'Please enter a phone number.';
    } else if (!preg_match('/^\d{4}$/', $postcode)) {
        $error = 'Postcode must be a 4 digit number.';
    } else if ('' === $birthday) {
        $error = 'Please enter your birthday.';
    }

    if ('' === $error) {
        $stmt = $db->prepare('select * from volunteer where volunteer_email=?');
        $stmt->execute([$email]);
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $error = 'This email address has already been registered.';
        } else {
            $stmt = $db->prepare("INSERT INTO volunteer (volunteer_email, volunteer_password, first_name, last_name, phone, postcode, birthday) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute( [$email, password_hash($password, PASSWORD_DEFAULT), $firstname, $lastname, $phone, $postcode, $birthday] );
            if ($stmt->rowCount() > 0) {
                addLog('Registration (Volunteer)', $email . ' registered');

                echo "<script>alert('Registration successful.');window.location.href='../login_form.php'</script>";
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
        <legend>Volunteer Registration</legend>

        <label>
            <span>Email Address:</span>
            <input type="email" name="volunteer_email" value="<?php echo $email;?>" autofocus />
        </label>
        <label>
            <span>Password:</span>
            <input type="password" name="volunteer_password" value="<?php echo $password;?>"/>
        </label>
        <label>
            <span>Confirm Password:</span>
            <input type="password" name="volunteer_password_conf" value="<?php echo $passwordConf;?>"/>
        </label>
        <label>
            <span>First Name:</span>
            <input type="text" name="first_name" value="<?php echo $firstname;?>"/></label>
        <label>
            <span>Last Name:</span>
            <input type="text" name="last_name" value="<?php echo $lastname;?>"/>
        </label>
        <label>
            <span>Phone Number:</span>
            <input type="text" name="phone" value="<?php echo $phone;?>"/>
        </label>
        <label>
            <span>Postcode:</span>
            <input type="text" name="postcode" value="<?php echo $postcode;?>"/>
        </label>
        <label>
            <span>Birthday:</span>
            <input type="date" name="birthday" value="<?php echo $birthday;?>"/>
        </label>

        <input type="submit" value="Register" />
        <div id="error" class="error"><?php echo $error;?></div>
    </fieldset>
</form>

<script>
    function validateForm() {
        var form = document.register_form;
        var error = document.getElementById('error');

        if (form.volunteer_email.value == '') {
            error.innerText = 'Please enter an email address.';
            return false;
        }

        if (form.volunteer_password.value.length < 5) {
            error.innerText = 'Password must be at least 5 characters long.';
            return false;
        }

        if (form.volunteer_password.value != form.volunteer_password_conf.value) {
            error.innerText = 'Passwords do not match.';
            return false;
        }

        if (form.first_name.value == '') {
            error.innerText = 'Please enter your first name.';
            return false;
        }

        if (form.last_name.value == '') {
            error.innerText = 'Please enter your last name.';
            return false;
        }

        if (form.phone.value == '') {
            error.innerText = 'Please enter a phone number.';
            return false;
        }

        if (!/^\d{4}$/.test(form.postcode.value)) {
            error.innerText = 'Postcode must be a 4 digit number.';
            return false;
        }

        if (form.birthday.value == '') {
            error.innerText = 'Please enter your birthday.';
            return false;
        }

        return true;
    }
</script>
</body>
</html>
