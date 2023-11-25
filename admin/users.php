<?php

// Update user profile
if (isset($_POST['edit']) && $_POST['_action_'] == 'TRUE') {
    $editID = (int)$_POST['edit'];

    $query  = "UPDATE users SET ";
    $query .= "firstname='" . $_POST['firstname'] . "', ";
    $query .= "lastname='" . $_POST['lastname'] . "', ";
    $query .= "email='" . $_POST['email'] . "', ";
    $query .= "username='" . $_POST['username'] . "', ";
    $query .= "country='" . $_POST['country'] . "', ";
    $query .= "archive='" . $_POST['archive'] . "'";
    $query .= " WHERE id=$editID LIMIT 1";

    $result = @mysqli_query($MySQL, $query);

    @mysqli_close($MySQL);

    $_SESSION['message'] = '<p>You successfully changed the user profile!</p>';

    header("Location: index.php?menu=7&action=1");
}

// Delete user profile
if (isset($_GET['delete']) && $_GET['delete'] != '') {
    $deleteID = (int)$_GET['delete'];

    $query  = "DELETE FROM users";
    $query .= " WHERE id=$deleteID LIMIT 1";
    $result = @mysqli_query($MySQL, $query);

    $_SESSION['message'] = '<p>You successfully deleted the user profile!</p>';

    header("Location: index.php?menu=7&action=1");
}

// Show user info
if (isset($_GET['id']) && $_GET['id'] != '') {
    $userID = (int)$_GET['id'];

    $query  = "SELECT * FROM users";
    $query .= " WHERE id=$userID";
    $result = @mysqli_query($MySQL, $query);
    $row = @mysqli_fetch_array($result);

    echo '
    <h2>User Profile</h2>
    <p><b>First name:</b> ' . $row['firstname'] . '</p>
    <p><b>Last name:</b> ' . $row['lastname'] . '</p>
    <p><b>Username:</b> ' . $row['username'] . '</p>';

    $_query  = "SELECT * FROM countries";
    $_query .= " WHERE country_code='" . $row['country'] . "'";
    $_result = @mysqli_query($MySQL, $_query);
    $_row = @mysqli_fetch_array($_result);

    echo '
    <p><b>Country:</b> ' . $_row['country_name'] . '</p>
    <p><b>Date:</b> ' . pickerDateToMysql($row['date']) . '</p>
    <p><a href="index.php?menu=' . $menu . '&amp;action=' . $action . '">Back</a></p>';
}

// Edit user profile
else if (isset($_GET['edit']) && $_GET['edit'] != '') {
    $editID = (int)$_GET['edit'];

    $query  = "SELECT * FROM users";
    $query .= " WHERE id=$editID";
    $result = @mysqli_query($MySQL, $query);
    $row = @mysqli_fetch_array($result);
    $checkedArchive = $row['archive'] == 'Y' ? 'checked="checked"' : '';

    echo '
    <h2>Edit User Profile</h2>
    <form action="" id="registration_form" name="registration_form" method="POST">
        <input type="hidden" id="_action_" name="_action_" value="TRUE">
        <input type="hidden" id="edit" name="edit" value="' . $_GET['edit'] . '">

        <label for="fname">First Name *</label>
        <input type="text" id="fname" name="firstname" value="' . $row['firstname'] . '" placeholder="Your name.." required>

        <label for="lname">Last Name *</label>
        <input type="text" id="lname" name="lastname" value="' . $row['lastname'] . '" placeholder="Your last name.." required>

        <label for="email">Your E-mail *</label>
        <input type="email" id="email" name="email"  value="' . $row['email'] . '" placeholder="Your e-mail.." required>

        <label for="username">Username *<small>(Username must have min 5 and max 10 char)</small></label>
        <input type="text" id="username" name="username" value="' . $row['username'] . '" pattern=".{5,10}" placeholder="Username.." required><br>

        <label for="country">Country</label>
        <select name="country" id="country">
            <option value="">Please choose</option>';

            $_query  = "SELECT * FROM countries";
            $_result = @mysqli_query($MySQL, $_query);
            while ($_row = @mysqli_fetch_array($_result)) {
                echo '<option value="' . $_row['country_code'] . '"';
                if ($row['country'] == $_row['country_code']) {
                    echo ' selected';
                }
                echo '>' . $_row['country_name'] . '</option>';
            }

    echo '
        </select>

        <label for="archive">Archive:</label><br />
        <input type="radio" name="archive" value="Y" ' . $checkedArchive . '> YES &nbsp;&nbsp;
        <input type="radio" name="archive" value="N" ' . (!$checkedArchive ? 'checked="checked"' : '') . '> NO

        <hr>

        <input type="submit" value="Submit">
    </form>
    <p><a href="index.php?menu=' . $menu . '&amp;action=' . $action . '">Back</a></p>';
}

else {
    echo '
    <h2>List of Users</h2>
    <div id="users">
        <table>
            <thead>
                <tr>
                    <th width="16"></th>
                    <th width="16"></th>
                    <th width="16"></th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>E-mail</th>
                    <th>Country</th>
                    <th width="16"></th>
                </tr>
            </thead>
            <tbody>';
            $query  = "SELECT * FROM users";
            $result = @mysqli_query($MySQL, $query);
            while ($row = @mysqli_fetch_array($result)) {
                echo '
                <tr>
                    <td><a href="index.php?menu=' . $menu . '&amp;action=' . $action . '&amp;id=' . $row['id'] . '"><img src="img/user.png" alt="user"></a></td>
                    <td><a href="index.php?menu=' . $menu . '&amp;action=' . $action . '&amp;edit=' . $row['id'] . '"><img src="img/edit.png" alt="edit"></a></td>
                    <td><a href="index.php?menu=' . $menu . '&amp;action=' . $action . '&amp;delete=' . $row['id'] . '"><img src="img/delete.png" alt="delete"></a></td>
                    <td><strong>' . $row['firstname'] . '</strong></td>
                    <td><strong>' . $row['lastname'] . '</strong></td>
                    <td>' . $row['email'] . '</td>
                    <td>';
                        $_query  = "SELECT * FROM countries";
                        $_query .= " WHERE country_code='" . $row['country'] . "'";
                        $_result = @mysqli_query($MySQL, $_query);
                        $_row = @mysqli_fetch_array($_result, MYSQLI_ASSOC);
                        echo $_row['country_name'] . '
                    </td>
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
    </div>';
}

// Close MySQL connection
@mysqli_close($MySQL);

?>
