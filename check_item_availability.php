<?php
    require_once("checkconnection.php");

    if($_REQUEST) {
        $item_id = $_REQUEST['item_id'];
        $city_id = (int) $_REQUEST['city_id'];
        $qty_demand = (int) $_REQUEST['qty'];
        $order_no = $_REQUEST['order_no'];

        $q = "SELECT qty_in_city from item_city where item_id='$item_id' and city_id=$city_id ";
        $result = $dbcon->query($q);
        if(! $result) {
            echo "0"; // item not available
            exit();
        }
        else { 
            if($result->num_rows == 0) {
                echo "0";
                exit();
            }
            else { // atleast some item available in that city
                $row = $result->fetch_object();
                $qty_in_city = (int) $row->qty_in_city;

                if($qty_in_city < $qty_demand) {
                    echo "2"; // not sufficient items available
                    exit();
                }
                else { // sufficient item is available at the city stores
                    $temp = $qty_in_city - $qty_demand;
                    if($temp != 0) {
                        $q = "UPDATE item_city set qty_in_city=$temp where item_id='$item_id' and city_id=$city_id ";
                    }
                    else {
                        $q = "DELETE from item_city where item_id='$item_id' and city_id=$city_id ";
                    }
                    $result = $dbcon->query($q);
                    
                    if($result) {
                        $q = "INSERT into item_ordered (item_id, order_no, qty_ordered) values ('$item_id', '$order_no', $qty_demand) ";
                        $result = $dbcon->query($q);

                        if($result) {
                            $q = "SELECT store_id from stores where located_in_city=$city_id ";
                            $result = $dbcon->query($q);
                            if($result) {
                                $stores = array();
                                while($row = $result->fetch_object()) {
                                    $stores[] = $row->store_id;
                                }

                                // traverse through all stores of the city
                                foreach ($stores as $store) {
                                    $q = "SELECT qty_held from hold where store_id='$store' and item_id='$item_id' ";
                                    $result = $dbcon->query($q);

                                    if($result) { // the store has some items
                                        $row = $result->fetch_object();
                                        if($qty_demand >= $row->qty_held) {
                                            $q = "DELETE from hold where store_id='$store' and item_id='$item_id' ";
                                            $result = $dbcon->query($q);

                                            if($qty_demand == $row->qty_held) {
                                                break;
                                            }
                                        }
                                        else {
                                            $temp = $row->qty_held - $qty_demand; // leftover items
                                            $q = "UPDATE hold set qty_held=$temp where store_id='$store' and item_id='$item_id' ";
                                            $result = $dbcon->query($q);

                                            if($result) {
                                                break;
                                            }
                                        }
                                    }
                                }
                                echo '1';
                                exit();
                            }
                        }
                    }
                }
            }
        }
    }
?>