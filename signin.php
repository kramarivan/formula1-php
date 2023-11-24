<?php
echo '
<h1>Sign In Form</h1>
<div id="signin">';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_action_'])) {
    if ($_POST['_action_'] == 'TRUE') {
        $query = "SELECT * FROM users WHERE username='" .  $_POST['username'] . "' AND archive='N'";
        $result = @mysqli_query($MySQL, $query);
        $row = @mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($row && password_verify($_POST['password'], $row['password'])) {
            $_SESSION['user']['valid'] = 'true';
            $_SESSION['user']['id'] = $row['id'];
            $_SESSION['user']['firstname'] = $row['firstname'];
            $_SESSION['user']['lastname'] = $row['lastname'];
            $_SESSION['message'] = '<p>Welcome, ' . $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] . '</p>';
            header("Location: index.php?menu=7");
        } else {
            unset($_SESSION['user']);
            $_SESSION['message'] = '<p>You entered the wrong username or password!</p>';
            header("Location: index.php?menu=6");
        }
    }
} else {
    echo '
    <form action="" name="myForm" id="myForm" method="POST">
        <input type="hidden" id="_action_" name="_action_" value="TRUE">

        <label for="username">Username:*</label>
        <input type="text" id="username" name="username" value="" pattern=".{5,10}" required>

        <label for="password">Password:*</label>
        <input type="password" id="password" name="password" value="" pattern=".{4,}" required>

        <input type="submit" value="Submit">
    </form>';
}

echo '
</div>';
?>
