<?php
    require_once("checkconnection.php");

    if($_REQUEST) {
        $city_id = (int) $_REQUEST['city'];

        $q = "SELECT cust_id from customers where city_id=$city_id ";
        $result = $dbcon->query($q);

        if($result->num_rows) { // any customers present at that city
            $row = $result->fetch_object();
            $cust_id = (int) $row->cust_id;

            $q = "SELECT * from orders where cust_id=$cust_id ";
            $result = $dbcon->query($q);
            // if($result->num_rows) {
                $orders = array();
                while($row = $result->fetch_object()) {
                    $orders[] = $row->order_no;
                }
                // echo var_dump($orders);

                $items = array();
                $q = "SELECT item_id from items";
                $result = $dbcon->query($q);

                // if($result) {
                    while($row = $result->fetch_object()) {
                        $items[] = $row->item_id;
                    }

                    echo "<br><br><table border=\"1\" align=\"center\" cellpadding=\"5\">";
                    echo "<thead><tr><td><b>Item</b></td><td><b>Sales</b></td></tr></thead><tbody>";
                    foreach($items as $item) {
                        echo "<tr>";
                        echo "<td>";
                        $q = "SELECT item_name from items where item_id='$item' ";
                        $result = $dbcon->query($q);
                        $row = $result->fetch_object();
                        echo $row->item_name;
                        echo "</td><td>";

                        $total = 0;
                        foreach($orders as $order) {
                            $q = "SELECT qty_ordered from item_ordered where order_no='$order' and item_id='$item' ";
                            $result = $dbcon->query($q);
                            // echo $result->num_rows." ";
                            if($result->num_rows) {
                                while($row = $result->fetch_object()) {
                                    $temp = (int) $row->qty_ordered;
                                    $total += $temp;
                                    echo $total;
                                }
                            } 
                            else {
                                echo $total;
                            }
                        }
                        echo "</td></tr>";
                    }
                    echo "</tbody></table>";
                // }
            // }
        }
        else {
            echo "<br><br>No customers stayed at this city. ";
        }
    }
?>