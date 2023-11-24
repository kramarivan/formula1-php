<?php
if (isset($action) && $action != '') {
    // Display a single news article
    $query = "SELECT * FROM news WHERE id=" . $_GET['action'];
    $result = @mysqli_query($MySQL, $query);
    if ($row = @mysqli_fetch_array($result)) {
        echo '
        <div class="news">
            <img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
            <h2>' . $row['title'] . '</h2>
            <p>' . $row['description'] . '</p>
            <time datetime="' . $row['date'] . '">' . pickerDateToMysql($row['date']) . '</time>
            <hr>
        </div>';
    }
} else {
    // Display a list of news articles
    echo '<h1>NEWS</h1>';
    $query = "SELECT * FROM news WHERE archive='N' ORDER BY date DESC";
    $result = @mysqli_query($MySQL, $query);
    while ($row = @mysqli_fetch_array($result)) {
        echo '
        <div class="news">
            <img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
            <h2>' . $row['title'] . '</h2>';
        $description = strlen($row['description']) > 300 ? substr(strip_tags($row['description']), 0, 300) . '... <a href="index.php?menu=' . $menu . '&amp;action=' . $row['id'] . '">More</a>' : strip_tags($row['description']);
        echo '
            <p>' . $description . '</p>
            <time datetime="' . $row['date'] . '">' . pickerDateToMysql($row['date']) . '</time>
            <hr>
        </div>';
    }
}
?>
