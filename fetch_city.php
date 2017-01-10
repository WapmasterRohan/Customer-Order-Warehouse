<?php
    $q = "SELECT city_id, city_name from city order by city_name";
    $result = $dbcon->query($q);
    echo "<select id='city-option' name=\"city\" size='1' required>";
    echo "<option>--------------</option>";
    while($row = $result->fetch_object()) {
        echo "<option value=\"$row->city_id\">$row->city_name</option>";
    }
    echo "</select>";
?>