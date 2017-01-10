<?php
    $q = "SELECT store_id, storage_space from stores order by store_id";
    $result = $dbcon->query($q);
    echo "<select id='store-option' name=\"store\" size='1' required>";
    while($row = $result->fetch_object()) {
        // $q = "SELECT qty_held from hold where store_id='$row->store_id'";
        echo "<option value=\"$row->store_id\">$row->store_id: $row->storage_space</option>";
    }
    echo "</select>";
?>