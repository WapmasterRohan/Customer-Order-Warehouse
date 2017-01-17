<?php
    require_once("checkconnection.php");

    if($_REQUEST) {
        $city_id = $_REQUEST['city'];
        
        $items = array();
        $q = "SELECT item_id from items";
        $result = $dbcon->query($q);

        while($row = $result->fetch_object()) {
            $items[] = $row->item_id;
        }

        $count = 0;
        foreach($items as $item) {
            $q = "SELECT * from item_city where city_id=$city_id and item_id='$item' ";
            $result = $dbcon->query($q);

            if($result->num_rows) {
                $count++;

                if($count == 1) {
                    echo "<br><br><table border=\"1\" align=\"center\" cellpadding=\"5\">";
                    echo "<thead><tr><td><b>Item</b></td><td><b>Stored</b></td></tr></thead><tbody>";
                } 
                $row = $result->fetch_object();
                $temp = $row->item_id;
                $q = "SELECT item_name from items where item_id='$temp' ";
                $result = $dbcon->query($q);
                $r = $result->fetch_object();
                
                echo "<tr><td>";
                echo $r->item_name;
                echo "</td><td>";
                echo $row->qty_in_city;
                echo "</td></tr>";
            }
        }

        if($count == 0) {
            echo "<br>No items is stored at this city. ";
        }
        echo "</tbody></table>";
    }
?>