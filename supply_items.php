<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supply Items</title>
</head>
<body>
    <?php
        require_once("checkconnection.php");
        include('extra.php');

        if(isset($_REQUEST['submit'])) {
            $store = $_REQUEST['store'];
            $item = $_REQUEST['item'];
            $city = $_REQUEST['city'];
            $qty = (int) $_REQUEST['qty'];

            // Check whether item is available at the store or not
            $q = "SELECT * from hold where store_id='$store' and item_id='$item'";
            $result = $dbcon->query($q);
            if($result->num_rows == 0) { // no items present at the store
                // insert the item
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
                    else { // item is available at other stores
                        $q = "SELECT * from item_city where item_id='$item' and city_id='$city'";
                        $result = $dbcon->query($q);

                        if($result->num_rows == 1) { // everything is ok 
                            $row = $result->fetch_object();
                            $item_no = (int) $row->qty_in_city;
                            $item_no += $qty;

                            $q = "UPDATE item_city set qty_in_city=$item_no where city_id='$city' and item_id='$item'";
                            $result = $dbcon->query($q);

                            if(! $result) {
                                echo "Error occurred, item information could not be added to the database. ";
                            }
                            else {
                                echo "New item is added to the store. ";
                            }                        
                        }
                        else {
                            echo "Error occurred, item information could not be added to the database. ";
                        }    
                    }
                }
            }
            else { // item available at the store
                $row = $result->fetch_object();
                $item_no = (int) $row->qty_held; // no of items present at the store
                $item_no += $qty;

                $q = "UPDATE hold set qty_held=$item_no where store_id='$store' and item_id='$item'";
                $result = $dbcon->query($q);

                if($result) {
                    $q = "SELECT * from item_city where item_id='$item' and city_id='$city'";
                    $result = $dbcon->query($q);

                    if($result->num_rows == 1) { // everything is ok 
                        $row = $result->fetch_object();
                        $item_no = (int) $row->qty_in_city;
                        $item_no += $qty;

                        $q = "UPDATE item_city set qty_in_city=$item_no where city_id='$city' and item_id='$item'";
                        $result = $dbcon->query($q);

                        if(! $result) {
                            echo "Error occurred, item information could not be added to the database. ";
                        }
                        else {
                            echo "New item is added to the store. ";
                        }                        
                    }
                    else {
                        echo "Error occurred, item information could not be added to the database. ";
                    }
                }
                else {
                    echo "Error occurred, item information could not be added to the database. ";
                }
            }
        }
    ?>
    <h2>Supply items to the stores: </h2><br>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        Select item to add: <?php require('fetch_items.php'); ?><br>
        Select city: <?php require('fetch_city.php'); ?><br>
        Select store: 
        <!--<div id='store-container'>
            <select id='store-option'></select>
        </div>--><?php require('fetch_stores.php'); ?>

        <p>
            <label class="label" for="qty">No of items to add: </label>
            <input type="text" name="qty" id="qty" size='10'>
        </p>

        <p>
            <input type="submit" name="submit" id="submit" value="Add Item">
        </p>
    </form>
    <script>
        $(document).ready(function() {
            $('#city-option').on('change', function() {
                var sel = $('#city-option').val();
                $.ajax({
                    type: 'POST',
                    data: ({
                        'city': sel
                    }),
                    url: 'fetch_stores_by_city.php',
                    success: function(data) {
                        $('#store-container').html(data);
                    }
                });
            });
        });
    </script>
</body>
</html>