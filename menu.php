<?php
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    echo "<h3><b>Welcome to Warehouse</b></h3>";
    if(isset($_SESSION['cust_level'])) {
        echo "<b>Welcome, " . $_SESSION['fname'];
        echo "&nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></b><br>";
        if($_SESSION['cust_level'] == 1) {
            echo "<br><a href='create_store.php'>Create Store</a><br>";
            echo "<a href='add_item.php'>Add New Item</a><br>";
            echo "<a href='supply_items.php'>Supply Items to Stores</a><br>";
        }
    }
    else {
        echo "<a href='login.php'>Login</a>&nbsp;&nbsp;&nbsp;<a href='register_page.php'>Register</a>";
    }
    echo "<br><hr>";
?>
<link rel="stylesheet" href="css/style.css">