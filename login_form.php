<?php
require 'db_connect.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <meta name="author" content="Harvey Roxas and Haowen Yang" />
    <meta name="description" content="Project for Interactive Web Development (2023)" />
    <link rel="stylesheet" type="text/css" href="styles/stylesheet.css" />
</head>
<?php
$error = '';
if (isset($_POST['volunteer_login_button'])) {
    //PHP form validation starts here
    if (trim($_POST['volunteer_email']) == '') {
        $error = 'Please enter your email address.';

    } else if (trim($_POST['volunteer_password']) == '') {
        $error = 'Please enter your password.';

    } else {
        $stmt = $db->prepare("SELECT * FROM volunteer WHERE volunteer_email=?");
        $stmt->execute ([$_POST['volunteer_email']]);
        $vol = $stmt->fetch();

        if ($vol) { //stores login data for the volunteer section
            if (password_verify($_POST['volunteer_password'], $vol['volunteer_password'])) {
                addLog('Login (Volunteer)', $_POST['volunteer_email'] . ' logged in');

                $_SESSION['volunteer_email'] = $vol['volunteer_email'];
                $_SESSION['volunteer_FN'] = $vol['first_name'];
                $_SESSION['user_type'] = 'volunteer';
                header('Location: volunteer/manage_time_slots.php');
                exit;
            } else {
                addLog('Failed Login (Volunteer)', $_POST['volunteer_email'] . ' failed to log in');
                $error = 'Invalid credentials. Try again.';
            }

        } else {
            addLog('Failed Login (Volunteer)', $_POST['volunteer_email'] . ' failed to log in');
            $error = 'Invalid credentials. Try again.';

        }
    }
} else if (isset($_POST['organiser_login_button'])) {
    //PHP form validation starts here
    if (trim($_POST['organiser_username']) == '') {
        $error = 'Please enter username.';

    } else if (trim($_POST['organiser_password']) == '') {
        $error = 'Please enter your password.';
    } else {
        $stmt = $db->prepare("SELECT * FROM organiser WHERE organiser_username=?");
        $stmt->execute ([$_POST['organiser_username']]);
        $org= $stmt->fetch();

        if ($org) { // stores login data for the organiser section
            if (password_verify($_POST['organiser_password'], $org['organiser_password'])) {
                addLog('Login (Organiser)', $_POST['organiser_username'] . ' logged in');

                $_SESSION['organiser_username'] = $org['organiser_username'];
                $_SESSION['organiser_FN'] = $org['organiser_username'];
                $_SESSION['user_type'] = 'organiser';

                header('Location: organiser/volunteer_time_slots.php');
                exit;
            } else {
                addLog('Failed Login (Organiser)', $_POST['organiser_username'] . ' failed to log in');
                $error = 'Invalid credentials. Try again.';
            }
        } else {
            addLog('Failed Login (Organiser)', $_POST['organiser_username'] . ' failed to log in');
            $error = 'Invalid credentials. Try again.';

        }
    }
}

?>

<body>
<form name="volunteer_login_form" method="post" action="login_form.php" onsubmit="return validate_volunteer_form()">
    <fieldset>
        <legend>Volunteer Login</legend>
        <label><span>Email Address:</span><input type="email" name="volunteer_email" value="<?php echo isset($_POST['volunteer_login_button']) ? $_POST['volunteer_email'] : '';?>" autofocus /></label>
        <label><span>Password:</span><input type="password" name="volunteer_password" /></label>
        <div id="error_volunteer" class="error"><?php echo isset($_POST['volunteer_login_button']) ? $error : '';?></div>
        <input type="submit" name="volunteer_login_button" value="Login" class="left" /> <br /> <br />
        <a href="volunteer/register.php" class="right">Register to Volunteer!</a>
    </fieldset>
</form>

<form name="organiser_login_form" method="post" action="login_form.php" onsubmit="return validate_organiser_form()">
    <fieldset>
        <legend>Organiser Login</legend>
        <label><span>Username:</span><input type="text" name="organiser_username" value="<?php echo isset($_POST['organiser_login_button']) ? $_POST['organiser_username'] : '';?>"/></label>
        <label><span>Password:</span><input type="password" name="organiser_password" /></label>
        <div id="error_organiser" class="error"><?php echo isset($_POST['organiser_login_button']) ? $error : '';?></div>
        <input type="submit" name="organiser_login_button" value="Login" class="right" />
    </fieldset>
</form>

<script>
    function validate_volunteer_form() {
        var form1 = document.volunteer_login_form;
        var error = document.getElementById('error_volunteer');

        if (form1.volunteer_email.value == '') {
            error.innerText = 'Please enter your email address.';
            return false;
        }

        if (form1.volunteer_password.value.length <= 0) {
            error.innerText = 'Please enter your password.';
            return false;
        }

        return true;
    }

    function validate_organiser_form() {
        var form2 = document.organiser_login_form;
        var error = document.getElementById('error_organiser');

        if (form2.organiser_username.value == '') {
            error.innerText = 'Please enter username.';
            return false;
        }

        if (form2.organiser_password.value.length <= 0) {
            error.innerText = 'Please enter your password.';
            return false;
        }

        return true;
    }
</script>
</body>
</html>