<?php
// Add news
if (isset($_POST['_action_']) && $_POST['_action_'] == 'add_news') {
    $_SESSION['message'] = '';

    $title = htmlspecialchars($_POST['title'], ENT_QUOTES);
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES);
    $archive = $_POST['archive'];

    $query = "INSERT INTO news (title, description, archive)";
    $query .= " VALUES ('$title', '$description', '$archive')";
    $result = @mysqli_query($MySQL, $query);

    $ID = mysqli_insert_id($MySQL);

    // Upload picture
    if ($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {
        $ext = strtolower(strrchr($_FILES['picture']['name'], "."));
        $_picture = $ID . '-' . rand(1, 100) . $ext;
        copy($_FILES['picture']['tmp_name'], "news/" . $_picture);

        if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') {
            $_query  = "UPDATE news SET picture='$_picture'";
            $_query .= " WHERE id=$ID LIMIT 1";
            $_result = @mysqli_query($MySQL, $_query);
            $_SESSION['message'] .= '<p>You successfully added a picture.</p>';
        }
    }

    $_SESSION['message'] .= '<p>You successfully added news!</p>';
    header("Location: index.php?menu=7&action=2");
}

// Update news
if (isset($_POST['_action_']) && $_POST['_action_'] == 'edit_news') {
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES);
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES);
    $archive = $_POST['archive'];
    $editID = (int)$_POST['edit'];

    $query  = "UPDATE news SET title='$title', description='$description', archive='$archive'";
    $query .= " WHERE id=$editID LIMIT 1";
    $result = @mysqli_query($MySQL, $query);

    // Upload picture
    if ($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {
        $ext = strtolower(strrchr($_FILES['picture']['name'], "."));
        $_picture = $editID . '-' . rand(1, 100) . $ext;
        copy($_FILES['picture']['tmp_name'], "news/" . $_picture);

        if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') {
            $_query  = "UPDATE news SET picture='$_picture'";
            $_query .= " WHERE id=$editID LIMIT 1";
            $_result = @mysqli_query($MySQL, $_query);
            $_SESSION['message'] .= '<p>You successfully added a picture.</p>';
        }
    }

    $_SESSION['message'] = '<p>You successfully changed news!</p>';
    header("Location: index.php?menu=7&action=2");
}

// Delete news
if (isset($_GET['delete']) && $_GET['delete'] != '') {
    $deleteID = (int)$_GET['delete'];

    // Delete picture
    $query  = "SELECT picture FROM news WHERE id=$deleteID LIMIT 1";
    $result = @mysqli_query($MySQL, $query);
    $row = @mysqli_fetch_array($result);
    @unlink("news/" . $row['picture']);

    // Delete news
    $query  = "DELETE FROM news WHERE id=$deleteID LIMIT 1";
    $result = @mysqli_query($MySQL, $query);

    $_SESSION['message'] = '<p>You successfully deleted news!</p>';
    header("Location: index.php?menu=7&action=2");
}

// Show news info
if (isset($_GET['id']) && $_GET['id'] != '') {
    $newsID = (int)$_GET['id'];

    $query  = "SELECT * FROM news WHERE id=$newsID";
    $result = @mysqli_query($MySQL, $query);
    $row = @mysqli_fetch_array($result);

    echo '
    <h2>News Overview</h2>
    <div class="news">
        <img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
        <h2>' . $row['title'] . '</h2>
        ' . $row['description'] . '
        <time datetime="' . $row['date'] . '">' . pickerDateToMysql($row['date']) . '</time>
        <hr>
    </div>
    <p><a href="index.php?menu=' . $menu . '&amp;action=' . $action . '">Back</a></p>';
}

// Add news
else if (isset($_GET['add']) && $_GET['add'] != '') {
    echo '
    <h2>Add News</h2>
    <form action="" id="news_form" name="news_form" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="_action_" name="_action_" value="add_news">

        <label for="title">Title *</label>
        <input type="text" id="title" name="title" placeholder="News title.." required>

        <label for="description">Description *</label>
        <textarea id="description" name="description" placeholder="News description.." required></textarea>

        <label for="picture">Picture</label>
        <input type="file" id="picture" name="picture">

        <label for="archive">Archive:</label><br />
        <input type="radio" name="archive" value="Y"> YES &nbsp;&nbsp;
        <input type="radio" name="archive" value="N" checked> NO

        <hr>

        <input type="submit" value="Submit">
    </form>
    <p><a href="index.php?menu=' . $menu . '&amp;action=' . $action . '">Back</a></p>';
}

// Edit news
else if (isset($_GET['edit']) && $_GET['edit'] != '') {
    $editID = (int)$_GET['edit'];

    $query  = "SELECT * FROM news WHERE id=$editID";
    $result = @mysqli_query($MySQL, $query);
    $row = @mysqli_fetch_array($result);
    $checkedArchive = $row['archive'] == 'Y' ? 'checked="checked"' : '';

    echo '
    <h2>Edit News</h2>
    <form action="" id="news_form_edit" name="news_form_edit" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="_action_" name="_action_" value="edit_news">
        <input type="hidden" id="edit" name="edit" value="' . $row['id'] . '">

        <label for="title">Title *</label>
        <input type="text" id="title" name="title" value="' . $row['title'] . '" placeholder="News title.." required>

        <label for="description">Description *</label>
        <textarea id="description" name="description" placeholder="News description.." required>' . $row['description'] . '</textarea>

        <label for="picture">Picture</label>
        <input type="file" id="picture" name="picture">

        <label for="archive">Archive:</label><br />
        <input type="radio" name="archive" value="Y" ' . $checkedArchive . '> YES &nbsp;&nbsp;
        <input type="radio" name="archive" value="N" ' . (!$checkedArchive ? 'checked="checked"' : '') . '> NO

        <hr>

        <input type="submit" value="Submit">
    </form>
    <p><a href="index.php?menu=' . $menu . '&amp;action=' . $action . '">Back</a></p>';
}

// Display news list
else {
    echo '
    <h2>News</h2>
    <div id="news">
        <table>
            <thead>
                <tr>
                    <th width="16"></th>
                    <th width="16"></th>
                    <th width="16"></th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th width="16"></th>
                </tr>
            </thead>
            <tbody>';
            $query  = "SELECT * FROM news ORDER BY date DESC";
            $result = @mysqli_query($MySQL, $query);
            while ($row = @mysqli_fetch_array($result)) {
                echo '
                <tr>
                    <td><a href="index.php?menu=' . $menu . '&amp;action=' . $action . '&amp;id=' . $row['id'] . '"><img src="img/user.png" alt="user"></a></td>
                    <td><a href="index.php?menu=' . $menu . '&amp;action=' . $action . '&amp;edit=' . $row['id'] . '"><img src="img/edit.png" alt="edit"></a></td>
                    <td><a href="index.php?menu=' . $menu . '&amp;action=' . $action . '&amp;delete=' . $row['id'] . '"><img src="img/delete.png" alt="delete"></a></td>
                    <td>' . $row['title'] . '</td>
                    <td>';
                    if (strlen($row['description']) > 160) {
                        echo substr(strip_tags($row['description']), 0, 160) . '...';
                    } else {
                        echo strip_tags($row['description']);
                    }
                    echo '
                    </td>
                    <td>' . pickerDateToMysql($row['date']) . '</td>
                    <td>';
                        if ($row['archive'] == 'Y') {
                            echo '<img src="img/inactive.png" alt="" title="" />';
                        } else if ($row['archive'] == 'N') {
                            echo '<img src="img/active.png" alt="" title="" />';
                        }
                    echo '
                    </td>
                </tr>';
            }
        echo '
            </tbody>
        </table>
        <a href="index.php?menu=' . $menu . '&amp;action=' . $action . '&amp;add=true" class="AddLink">Add News</a>
    </div>';
}

// Close MySQL connection
@mysqli_close($MySQL);
?>
