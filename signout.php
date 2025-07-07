<?php
//signout.php
include 'connect.php';
include 'header.php';

echo '<h2>Signed out</h2>';

// Controleer of user ingelogd is
if($_SESSION['signed_in'] == true)
{
    // Reset variabelen
    $_SESSION['signed_in'] = NULL;
    $_SESSION['user_name'] = NULL;
    $_SESSION['user_id'] = NULL;

    echo 'Succesfully signed out! <br><br>> thank you for visiting.';
}
else
{
    echo '<br>You are not logged in. <br><a href="signin.php">Click here to login</a>.';
}

include 'footer.php';
?>