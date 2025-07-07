<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="HTML/PHP Forum" />
    <meta name="keywords" content="Terminal forum" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, initial-scale=1.0">
    <title>A Terminal Forum</title>
    <link rel="stylesheet" href="style.css" type="text/css">

    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <style>@font-face {
        font-family: Retro;
        src: url(fonts/Perfect\ DOS\ VGA\ 437.ttf);
    }</style>

</head>
<body>

<h1>ROBCO INDUSTRIES UNIFIED OPERATING SYSTEM<br>COPYRIGHT 2075-2077 ROBCO INDUSTRIES<br>-SERVER #1-<br>___________________________________________________________________________________</h1>
    <div id="wrapper">
    <nav id="menu">
        <a href="../thecomputerman.online/index.html"><img class="exit" src="close.png" alt="Exit"></a>
        <a class="item" href="/f4_forum/index.php">Home</a>
        <a class="item" href="/f4_forum/create_topic.php">Create a topic</a>
        <a class="item" href="/f4_forum/create_cat.php">Create a categorie</a>
        <a class="item" href="#">Settings</a>
        <?php
        //if(isset($_SESSION['signed_in'])&& )
        ?>

    <div id="userbar">
        <?php
        if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'])
        {
            echo 'Hello <b>' . htmlentities($_SESSION['user_name']) . '</b>. Not you? <a class="item" href="signout.php">Log out</a>';
        }
        else
        {
            echo '<a class="item" href="signin.php">Login</a> or <a class="item" href="signup.php">Create Account</a>.';
        }
        ?>
    </div>

    </nav>
    
<main id="content">