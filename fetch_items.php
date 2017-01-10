<?php
    $q = "SELECT item_id, item_name from items order by item_name";
    $result = $dbcon->query($q);
    echo "<select id='item-option' name=\"item\" size='1' required>";
    while($row = $result->fetch_object()) {
        echo "<option value=\"$row->item_id\">$row->item_name</option>";
    }
    echo "</select>";
?>