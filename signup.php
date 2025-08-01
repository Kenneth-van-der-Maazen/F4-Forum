<?php
//signup.php
include 'connect.php';
include 'header.php';

echo '<h3>Create new account.</h3><br>';

if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
    echo '<form method="post" action="">
    Username: <input type="text" name="user_name" /><br>
    Password: <input type="password" name="user_pass"><br>
    Password again: <input type="password" name="user_pass_check"><br>
    E-mail: <input type="email" name="user_email"><br><br>
    <input type="submit" value="Create Account" />
    </form>';
}
else
{
    $errors = array();

    if (isset($_POST['user_name']))
    {
        // gebruikersnaam bestaat al
        if(!ctype_alnum($_POST['user_name']))
        {
            $errors[] = 'The username can only contain letters and digits';
        }
        if(strlen($_POST['user_name']) > 30)
        {
            $errors[] = 'The username cannot be longer than 30 characters.';
        }
    }
    else
    {
        $errors[] = 'The username field must not be empty.';
    }

    if(isset($_POST['user_pass']))
    {
        if($_POST['user_pass'] != $_POST['user_pass_check'])
        {
            $errors[] = 'The two passwords did not match!';
        }
    }
    else
    {
        $errors[] = 'The password field cannot be empty!';
    }

    if(!empty($errors))
    {
        echo 'Oops! some fields are not filled in correctly..';
        echo '<ul>';

        foreach($errors as $key => $value)
        {
            echo '<li>' . $value . '</li>';
        }
        echo '</ul>';
    }
    else
    {
        $sql = "INSERT INTO users(user_name, user_pass, user_email, user_date, user_level) VALUES (?, ?, ?, NOW(), 0)";
        $stmt = mysqli_prepare($conn, $sql);

        $user_name = $_POST['user_name'];
        $user_pass = sha1($_POST['user_pass']);
        $user_email = $_POST['user_email'];

        mysqli_stmt_bind_param($stmt, 'sss', $user_name, $user_pass, $user_email);

        $result = mysqli_stmt_execute($stmt);

        if(!$result)
        {
            echo 'Something went wrong while registering. Please try again later!';
        }
        else
        {
            echo 'Succesfully registered! You can now <a href="signin.php">Sign in</a> and start posting';
        }
    }
}

include 'footer.php';

?>