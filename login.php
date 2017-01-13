<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        input {
            float: left;
        }
    </style>
</head>
<body>
    <?php
        require_once("checkconnection.php");
        require("menu.php");

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_REQUEST['submit'])) {
                $e = $dbcon->real_escape_string($_REQUEST['email']);
                $p = $dbcon->real_escape_string($_REQUEST['psword']);

                $q = "SELECT cust_id, fname, cust_level, city_id from customers where (email = '$e' and psword = SHA1('$p'))";
                $result = $dbcon->query($q);

                // if($result) {
                    if($result->num_rows) {
                        session_start();
                        $_SESSION = $result->fetch_assoc();
                        $_SESSION['cust_level'] = (int) $_SESSION['cust_level'];
                        $url = ($_SESSION['cust_level'] == 1) ? 'admin_index.php' : 'index.php';
                        header("Location: $url");
                        exit();
                        
                        $result->free_result();
                        $dbcon->close();
                    }
                    else {
                        echo "Wrong email id or password. ";
                    }
                // }
            }
        }
    ?>
    <div id="loginfields">
        <?php include("login_page.inc.php"); ?>
    </div>
</body>
</html>