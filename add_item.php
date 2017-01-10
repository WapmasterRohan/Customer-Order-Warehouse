<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Items</title>
</head>
<body>
    <?php
        require_once("checkconnection.php");
        include('extra.php');

        if(isset($_REQUEST['submit'])) {
            $name = $_REQUEST['name'];
            $size = $_REQUEST['size'];
            $price = $_REQUEST['price'];

            do {
                $id = random_string('ITM', 3);
                $q = "SELECT item_id from items where item_id='$id'";
                $result = $dbcon->query($q);
                // id is not used yet
                if(! $result->num_rows) {
                    break;
                }
            } while(1);

            $q = "INSERT into items (item_id, item_name, size, price) values ('$id', '$name', '$size', '$price')";
            $result = $dbcon->query($q);
            if(! $result) {
                echo "Error occurred, item information could not be added to the database. ";
            }
            else {
                echo "Item added. Id $id";
            }
        }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <p>
            <label class="label" for="name">Item Name: </label>
            <input type="text" name="name" size="30" maxlength="40" required>
        </p>

        <p>
            <label for="size" class="label">Size: </label>
            <select name="size" id="size">
                <option value="1">Small</option>
                <option value="2">Medium</option>
                <option value="3">Large</option>
            </select>
        </p>

        <p>
            <label class="label" for="price">Price: </label>
            <input type="text" name="price" size="10" maxlength="10" required>
        </p>

        <p>
            <input type="submit" name="submit" id="submit" value="Add Item">
        </p>
    </form>
</body>
</html>