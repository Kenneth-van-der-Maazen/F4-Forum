<?php
// create_topic.php
include 'connect.php';
include 'header.php';

echo '<h2>Create new topic</h2>';
if($_SESSION['signed_in'] == false)
{
    // User is niet ingelogd
    echo 'Sorry, you have to be <a href="signin.php">logged in</a> to create a topic!';
}
else
{
    // User is wel ingelogd
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        $sql = "SELECT cat_id, cat_name, cat_description FROM categories";

        $result = mysqli_query($conn, $sql);

        if(!$result)
        {
            // query failed
            echo 'Error while selecting from database. Please try again later!';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                if($_SESSION['user_level'] == 1)
                {
                    echo 'Error 404: No categories found!.';
                }
                else
                {
                    echo 'Before you can post a topic, you must wait for an admin to create some categories.';
                }
            }
            else
            {
                echo '<form method="post" action="">
                Subject: <input type="text" name="topic_subject" /><br>
                <br>Category:';

                echo '<select name="topic_cat">';
                while($row = mysqli_fetch_assoc($result))
                {
                    echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                }
                echo '</select><br>';

                echo '<br>Message: <br><textarea name="post_content" /></textarea><br>
                <br><input type="submit" value="Create topic" />
                </form>';
            }
        }
    }
    else
    {
        mysqli_begin_transaction($conn);

        //start transactie
        $query = "BEGIN WORK;";
        $result = mysqli_query($conn, $query);

        if(!$result)
        {
            echo 'An error occured while creating your topic. Please try again later..';
        }
        else
        {
            $topic_subject = mysqli_real_escape_string($conn, $_POST['topic_subject']);
            $topic_cat = mysqli_real_escape_string($conn, $_POST['topic_cat']);
            $topic_by = $_SESSION['user_id'];

            $sql = "INSERT INTO 
                        topics(topic_subject,
                                topic_date,
                                topic_cat,
                                topic_by)
                    VALUES('" . mysqli_real_escape_string($conn, $_POST['topic_subject']) . "', 
                                NOW(),
                                " . mysqli_real_escape_string($conn, $_POST['topic_cat']) . ",
                                " . $_SESSION['user_id'] . "
                                )";

            $result = mysqli_query($conn, $sql);

            if(!$result)
            {
                echo 'An error occured while inserting your data. Please try again later!';
                $sql = "ROLLBACK;";
                $result = mysqli_query($conn, $sql);
            }
            else {
                $topicid = mysqli_insert_id($conn);

                //$post_content = mysqli_real_escape_string($conn, $_POST['post_content']);
                //$post_topic = $topicid;
                $post_by = $_SESSION['user_id'];

                $sql = "INSERT INTO 
                            posts(post_content, 
                                post_date, 
                                post_topic, 
                                post_by) 
                        VALUES 
                            ('" . mysqli_real_escape_string($conn, $_POST['post_content']) . "',
                            NOW(), 
                            " . $topicid . ",
                            " . $_SESSION['user_id'] . "
                        )";

                $result = mysqli_query($conn, $sql);

                if(!$result)
                {
                    echo 'An error occured while inserting your post! Please try again later.';
                    $sql = "ROLLBACK;";

                    $result = mysqli_query($conn, $sql);
                }
                else
                {
                    $sql = "COMMIT;";
                    $result = mysqli_query($conn, $sql);

                    // Finally the query succeeded!
                    echo 'You have succesfully created <a href="topic.php?id='. $topicid . '">your new topic</a>.';
                }
            }
        }
    }
}


include 'footer.php';
?>