<?php
    require_once("checkconnection.php");

    if($_REQUEST) {
        $cust_id = $_REQUEST['cust_id'];
        $order_no = $_REQUEST['order_no'];

        $q = "INSERT into orders (order_no, cust_id, order_date) values ('$order_no', $cust_id, CURDATE() ) ";
        $result = $dbcon->query($q);

        if($result) {
            // set first order of the customer
            $q = "SELECT first_order from customers where cust_id=$cust_id ";
            $result = $dbcon->query($q);

            if($result) {
                $row = $result->fetch_object();
                if($row->first_order == 0) { // customer didn't purchased anything before
                    $q = "UPDATE customers set first_order='$order_no' where cust_id=$cust_id ";
                    $result = $dbcon->query($q);
                }
            }
        }
    }
?>