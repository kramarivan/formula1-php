<?php
echo '
<h1>Registration Form</h1>
<div id="register">';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_action_'])) {
    if ($_POST['_action_'] == 'TRUE') {
        $query = "SELECT * FROM users WHERE email='" .  $_POST['email'] . "' OR username='" .  $_POST['username'] . "'";
        $result = @mysqli_query($MySQL, $query);
        $row = @mysqli_fetch_array($result, MYSQLI_ASSOC);

        if (empty($row['email']) && empty($row['username'])) {
            $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);

            $query = "INSERT INTO users (firstname, lastname, email, username, password, country)";
            $query .= " VALUES ('" . $_POST['firstname'] . "', '" . $_POST['lastname'] . "', '" . $_POST['email'] . "', '" . $_POST['username'] . "', '" . $pass_hash . "', '" . $_POST['country'] . "')";
            $result = @mysqli_query($MySQL, $query);

            echo '<p>' . ucfirst(strtolower($_POST['firstname'])) . ' ' .  ucfirst(strtolower($_POST['lastname'])) . ', thank you for registration </p>
            <hr>';
        } else {
            echo '<p>User with this email or username already exists!</p>';
        }
    }
} else {
    echo '
    <form action="" id="registration_form" name="registration_form" method="POST">
        <input type="hidden" id="_action_" name="_action_" value="TRUE">
        
        <label for="fname">First Name *</label>
        <input type="text" id="fname" name="firstname" placeholder="Your name.." required>

        <label for="lname">Last Name *</label>
        <input type="text" id="lname" name="lastname" placeholder="Your last name.." required>
            
        <label for="email">Your E-mail *</label>
        <input type="email" id="email" name="email" placeholder="Your e-mail.." required>
        
        <label for="username">Username:* <small>(Username must have min 5 and max 10 characters)</small></label>
        <input type="text" id="username" name="username" pattern=".{5,10}" placeholder="Username.." required><br>
                
        <label for="password">Password:* <small>(Password must have min 4 characters)</small></label>
        <input type="password" id="password" name="password" placeholder="Password.." pattern=".{4,}" required>

        <label for="country">Country:</label>
        <select name="country" id="country">
            <option value="">Please select</option>';

            $query  = "SELECT * FROM countries";
            $result = @mysqli_query($MySQL, $query);
            while($row = @mysqli_fetch_array($result)) {
                echo '<option value="' . $row['country_code'] . '">' . $row['country_name'] . '</option>';
            }

    echo '
        </select>

        <input type="submit" value="Submit">
    </form>';
}

echo '
</div>';
?>
