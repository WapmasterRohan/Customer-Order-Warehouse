<?php
    require_once("checkconnection.php");

    $q = "SELECT * from items";
    $result = $dbcon->query($q);
    if($result) {
        echo "<div id='item-list-container'>";
        echo "<table id='item-list'>";
        while($row = $result->fetch_object()) {
            echo "<tr class='item'><td>";
            echo "<span class='item-name'><b>$row->item_name</b></span></td>";
            echo "<td><span class='item-id'>$row->item_id</span></td>";

            echo "<td><div class='item-details'>";
            // echo "<h3>$row->item_name</h3>";
            echo "<br>Size: $row->size";
            echo "<br>Price: <span class='item-price'>$row->price</span> Rupees";
            echo "<br>Quantity: <input type='text' name='qty' value='1' size='2'><br>";
            echo "<button type='submit' class='submit-item'>Add</button>";
            echo "</div></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }
?>