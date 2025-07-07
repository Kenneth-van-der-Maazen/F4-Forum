<?php
// index.php
include 'connect.php';
include 'header.php';
//include 'footer.php';

echo '<h2 style="color:#14271a;float:right;">-DISPLAY 1-</h2>';
echo '<h3>> FORUM INDEX</h3><br>';

$stmt = $conn->prepare('SELECT categories.cat_id, categories.cat_name, categories.cat_description FROM categories');
$stmt->execute();
$result = $stmt->get_result();

$sql = "SELECT 
            categories.cat_id, 
            categories.cat_name, 
            categories.cat_description,
            COUNT(topics.topic_id) AS topics,
            (SELECT topic_subject FROM topics WHERE topics.topic_cat = categories.cat_id ORDER BY topic_date DESC LIMIT 1) AS last_topic_subject,
            (SELECT topic_id FROM topics WHERE topics.topic_cat = categories.cat_id ORDER BY topic_date DESC LIMIT 1) AS last_topic_id,
            (SELECT topic_date FROM topics WHERE topics.topic_cat = categories.cat_id ORDER BY topic_date DESC LIMIT 1) AS last_topic_date
        FROM 
            categories
        LEFT JOIN
            topics
        ON
            topics.topic_cat = categories.cat_id
        GROUP BY
            categories.cat_name, categories.cat_description, categories.cat_id";

$result = mysqli_query($conn, $sql);

if (!$result)
{
    echo 'The categories could not be displayed, please try again later.';
}
else
{
    if (mysqli_num_rows($result) == 0)
    {
        echo 'No categories defined yet.';
    }
    else
    {
        echo '<table border="1">
            <tr>
                <th>Category</th>
                <th>Last topic</th>
                
            </tr>';

        while ($row = mysqli_fetch_assoc($result))
        {
            echo '<tr>';
                echo '<td class="leftpart">';
                    echo '<h3><a href="category.php?id=' . $row['cat_id'] . '">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
                echo '</td>';
                echo '<td class="rightpart">';

                // Controleer of er een laatste topic is
                if ($row['last_topic_subject'] == null)
                {
                    echo 'no topics';
                }
                else
                {
                    echo '<a href="topic.php?id=' . $row['last_topic_id'] . '">' . $row['last_topic_subject'] . '</a> at ' . date('d-m-Y', strtotime($row['last_topic_date']));
                }

                echo '</td>';
            echo '</tr>';
        }
    }
}

?>
