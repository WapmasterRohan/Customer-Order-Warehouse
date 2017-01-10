<?php
    $city = $_REQUEST['city'];
    require_once('checkconnection.php');

    $q = "SELECT store_id, storage_space from stores where located_in_city='$city' order by store_id";
    $result = $dbcon->query($q);
    echo "<select id='store-option' name=\"store\" size='1' required>";
    if($result) {
        while($row = $result->fetch_object()) {
            echo "<option value=\"$row->store_id\">$row->store_id: $row->storage_space</option>";
        }
    }
    echo "</select>";
?>