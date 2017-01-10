<?php
    require_once("checkconnection.php");

    if(isset($_REQUEST['submit'])) {
        $city = $_REQUEST['name'];
        $state = $_REQUEST['state'];
        $hdq = $_REQUEST['hdq'];

        $q = "INSERT into city (city_name, state, hdq_add) values ('$city', '$state', '$hdq')";
        $result = $dbcon->query($q);

        if(! $result) {
            echo "Error occurred, city could not be added to the database. ";
        }
        else {
            echo "City has been added to the database. ";
        }
    }
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <p>
        <label class="label" for="name">City name: </label>
        <input id="name" type="text" name="name" size="30" maxlength="60" required>
    </p>
    <p>
        <label class="label" for="state">State: </label>
        <input id="state" type="text" name="state" size="20" maxlength="60" required>
    </p>
    <p>
        <label class="label" for="hdq">Co-ordination center: </label>
        <input id="hdq" type="text" name="hdq" size="20" maxlength="60" required>
    </p>

    <p>
        <input type="submit" name="submit" value="Add City">
    </p>
</form>