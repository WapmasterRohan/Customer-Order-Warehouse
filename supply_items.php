<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Items</title>
</head>
<body>
    <?php
        require_once("check_connection.php");
        include('extra.php');

        if(isset($_REQUEST['submit'])) {
            $store = $_REQUEST['store'];
            $item = $_REQUEST['item'];
            $city = $_REQUEST['city'];
            $qty = $_REQUEST['qty'];

            $q = "SELECT * from hold where store_id='$store' and item_id='$item'";
            $result = $dbcon->query($q);
            if($result->num_rows == 0) { // no items present at the store
                $q = "INSERT into hold (store_id, item_id, qty_held) values ('$store', '$item', $qty)";
                $result = $dbcon->query($q);
                if($result) { // Items inserted succesfully in HOLD table, now check city details
                    $q = "SELECT * from item_city where item_id='$item' and city_id='$city'";
                    $result = $dbcon->query($q);
                    if($result->num_rows == 0) { // no items present in any store of the city 
                        $q = "INSERT into item_city (city_id, item_id, qty_in_city) values ('$city', '$item', $qty)";
                        $result = $dbcon->query($q);
                        if($result->num_rows == 0) {
                            if(! $result) {
                                echo "Error occurred, item information could not be added to the database. ";
                            }
                            else {
                                echo "New item is added to the store. ";
                            }
                        }
                    }
                }
            }
        }
    ?>
    <h2>Supply items to the stores: </h2><br>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        Select item to add: <?php require('fetch_items.php'); ?>
        Select city: <?php require('fetch_city.php'); ?>
        Select store: 
        <select id='store-option'></select>

        <p>
            <label class="label" for="qty">No of items to add: </label>
            <input type="text" name="qty" id="qty">
        </p>

        <p>
            <input type="submit" name="submit" id="submit" value="Add Item">
        </p>
    </form>
</body>
</html>