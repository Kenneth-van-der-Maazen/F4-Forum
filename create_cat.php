<?php
// create_cat.php
include 'connect.php';
include 'header.php';

echo '<h2>Create a category</h2>';
if($_SESSION['signed_in'] == false | $_SESSION['user_level'] != 1)
{
    // User is geen admin
    echo 'Sorry, you don\'t have the administrative rights to access this page!';
}
else
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
    {
        // form is nog niet gepost, moet hieronder weergegeven worden
        echo '<form method="post" action="">
            Category name: <input type="text" name="cat_name" /><br>
            <br>Category description: <br><textarea name="cat_description"></textarea>
            <br><input type="submit" value="Add category" />
        </form>';
    }
    else
    {
        // form is gepost
        $sql = "INSERT INTO categories(cat_name, cat_description)
                    VALUES('" . mysqli_real_escape_string($conn, $_POST['cat_name']) . "',
                    '" . mysqli_real_escape_string($conn, $_POST['cat_description']) . "')";
        $result = mysqli_query($conn, $sql);
        if(!$result)
        {
            // Er is iets mis gegaan, weergeef een error
            echo 'Error: ' . mysqli_error($conn);
        }
        else
        {
            echo 'New category succesfully added!';
        }
    }
}

include 'footer.php';
?>