<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <title>Customer Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include("menu.php"); ?>
    <div id="container">
         <div id="content">
            <?php
            // include("includes/menu.php");

            // This script performs an INSERT query that adds a record to the users table.
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                require ("checkconnection.php"); // Connect to the database
                $errors = array(); // Initialize an error array.

                // Trim the first name
                $name = trim($_POST['fname']);
                // Strip out HTML code and apply escaping
                $stripped = mysqli_real_escape_string($dbcon, strip_tags($name));
                // Get string lengths
                $strlen = mb_strlen($stripped, 'utf8');
                // Check stripped string
                if($strlen < 1) {
                    $errors[] = "You forgot to enter your first name.";
                }
                else {
                    $fn = $stripped;
                }

                // Trim the last name
                $lnme = trim($_POST['lname']);
                // Strip out HTML code and apply escaping
                $stripped = mysqli_real_escape_string($dbcon, strip_tags($lnme));
                // Get string lengths
                $strlen = mb_strlen($stripped, 'utf8');
                // Check stripped string
                if($strlen < 1) {
                    $errors[] = "You forgot to enter your last name.";
                }
                else {
                    $ln = $stripped;
                }

                // Set the email variable to FALSE
                $e = FALSE;
                // Check that an email address has been entered
                if (empty($_POST['email'])) {
                    $errors[] = "You forgot to enter your email address.";
                }
                // remove spaces from beginning and end of the email address and validate it
                if (filter_var((trim($_POST['email'])), FILTER_VALIDATE_EMAIL)) {
                    // A valid email address is then registered
                    $e = mysqli_real_escape_string($dbcon, (trim($_POST['email'])));
                }
                else {
                    $errors[] = "Your email is not in the correct format.";
                }

                // Check that a password has been entered, if so does it match the confirmed password
                if (empty($_POST['psword1'])) {
                    $errors[] = "Please enter a valid password.";
                }

                // if (!preg_match('/^\w(6,12)$/', $_POST['psword1'])) {
                //     $errors[] = "Invalid password, use 6 to 12 characters and no spaces.";
                // }
                // else {
                    $psword1 = $_POST['psword1'];
                // }

                if($_POST['psword1'] == $_POST['psword2']) {
                    $p = mysqli_real_escape_string($dbcon, trim($_POST['psword1']));
                }
                else {
                    $errors[] = "Your two passwords do not match.";
                }

                // Trim the city
                $ct = trim($_POST['city']);
                // Strip out HTML code and apply escaping
                $stripped = mysqli_real_escape_string($dbcon, strip_tags($ct));
                // Get string lengths
                $strlen = mb_strlen($stripped, 'utf8');
                // Check stripped string
                if($strlen < 1) {
                    $errors[] = "You forgot to enter your city.";
                }
                else {
                    $cty = $stripped;
                }

                // Start of a SUCCESSFUL SECTION. i.e all the fields were filled out
                if (empty($errors)) { // If no problems encountered, register user in the database
                    // Determine whether the email address has already been registered
                    $q = "SELECT cust_id from customers where email = '$e' ";
                    $result = $dbcon->query($q);

                    if (@$result->num_rows == 0) { // The mail address has not been registered already therefore register the user in the users table
                        // Make the query
                        $q = "SELECT from city where city_name = '$cty";
                        $result = $dbcon->query($q);

                        if ($result->num_rows == 0) { // city is not in the database yet
                            $q = "INSERT into city (city_id, city_name) values ('', '$cty' );";
                            $result = $dbcon->query($q);
                        }
                        $q = "SELECT city_id from city where city_name = '$cty'";
                        $result = $dbcon->query ($q);
                        $row = @$result->fetch_array (MYSQLI_ASSOC);
                        $v = (int) $row['city_id'];

                        $q = "INSERT into customers (cust_id, fname, lname, email, first_order, psword, city_id) values ('', '$fn', '$ln', '$e', '', SHA1('$p'), $v )";
                        $result = $dbcon->query ($q); // Run the query.

                        if ($result) { // If it ran OK.
                            header ("location: register_thanks.php");
                            exit();
                            // End of SUCCESSFUL SECTION
                        }
                        else { // If the form handler or database table contained errors
                            // Display any error message
                            echo "<h2>System Error</h2>";
                            echo "<p class='error'>You could not be regsitered due to a system error. We apologize for any inconvenience. </p>";

                            // Debug the message:
                            echo "<p>".$dbcon->error."<br><br>Query: ".$q."</p>";
                            // End of if clause ($result)
                        }

                        $dbcon->close(); // Close the database connection.
                        exit();
                    }
                    else { // The email address is already registered
                        echo '<p class="error">The email address is not acceptable because it is already registered</p>';
                    }
                }
                else { // Display the errors
                    echo "<h2>Error!</h2>";
                    echo "<p class='error'>The following error(s) occurred: <br>";

                    foreach($errors as $msg) { // Print each error.
                        echo " - $msg<br>\n";
                    }

                    echo "</p><h3>Please try again.</h3><p><br></p>";
                } // End of if (empty($errors)) IF.
            } // End of the main Submit conditional.
            ?>
            <div id="midcol">
                <h2>User Registration</h2>
                <h3 class="content">Items marked with an asterisk * are essential</h3>

                <!-- Display the form on the screen -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <p>
                        <label class="label" for="fname">First Name*</label>
                        <input id="fname" type="text" name="fname" size="30" maxlength="30" value="<?php if (isset($_POST['fname'])) echo $_POST['fname']; ?>" required>
                    </p>

                    <p>
                        <label class="label" for="lname">Last Name*</label>
                        <input id="lname" type="text" name="lname" size="30" maxlength="40" value="<?php if (isset($_POST['lname'])) echo $_POST['lname']; ?>" required>
                    </p>

                    <p>
                        <label class="label" for="email">Email address*</label>
                        <input id="email" type="email" name="email" size="30" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" required>
                    </p>

                    <p>
                        <label class="label" for="psword1">Password:*</label>
                        <input id="psword1" type="password" name="psword1" size="12" maxlength="12" value="<?php if (isset($_POST['psword1'])) echo $_POST['psword1']; ?>" required>
                        &nbsp;Between 6 and 12 characters.
                    </p>

                    <p>
                        <label class="label" for="psword2">Confirm Password*</label>
                        <input id="psword2" type="password" name="psword2" size="12" maxlength="12" value="<?php if (isset($_POST['psword2'])) echo $_POST['psword2']; ?>" required>
                    </p>

                    <p>
                        <label class="label" for="city">City*</label>
                        <input id="city" type="text" name="city" size="30" maxlength="30" value="<?php if (isset($_POST['city'])) echo $_POST['city']; ?>" required>
                    </p>

                    <p>
                        <input id="submit" type="submit" name="submit" value="Register">
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
