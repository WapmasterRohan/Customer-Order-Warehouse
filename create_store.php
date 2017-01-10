<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Store</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
</head>
<body>
    <?php
        require_once("checkconnection.php");
        include("extra.php");

        if(isset($_REQUEST['submit'])) {
            $phone = $_REQUEST['phone'];
            $storage = $_REQUEST['storage'];
            $city = $_REQUEST['city'];

            do {
                $id = random_string('STR', 3);
                $q = "SELECT store_id from stores where store_id='$id'";
                $result = $dbcon->query($q);
                // id is not used yet
                if(! $result->num_rows) {
                    break;
                }
            } while(1);

            $q = "INSERT into stores (store_id, phone, storage_space, located_in_city) values ('$id', '$phone', '$storage', '$city')";
            $result = $dbcon->query($q);
            if(! $result) {
                echo "Error occurred, store information could not be added to the database. ";
            }
            else {
                echo "Store added. Id $id";
            }
        }
    ?>
    <div class="container">
        Enter details of the new store: <br>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <p>
                <label class="label" for="phone">Contact No: </label>
                <input id="phone" type="text" name="phone" size="30" maxlength="60" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>" required>
            </p>
            <p>
                <label class="label" for="storage">Storage Space: </label>
                <input id="storage" type="text" name="storage" size="20" maxlength="60" value="<?php if (isset($_POST['storage'])) echo $_POST['storage']; ?>" required>
            </p>
            <p>
                <label class="label" for="city">Located in city:</label>
                <?php include('fetch_city.php'); ?>
            </p>

            <p>
                Couldn't find the city? <a href="add_city.php" target="_blank">Add city to the database before submitting the store information.</a>
            </p>

            <p>
                <input id="submit" type="submit" name="submit" value="Add Store">
            </p>
        </form>
    </div>
    <!--<script>
        $(document).ready(function({
            $('#Submit').on('click', function(event) {
                var $temp = $('#city-option');
                if($temp.val() == 0) {
                    event.preventDefault();
                    $('<span>').html('Select a city').insertAfter($temp);
                }
            });
        }));
    </script>-->
</body>
</html>