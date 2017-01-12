<?php
    session_start();

    if(isset($_SESSION['cust_level'])) {
        if($_SESSION['cust_level'] == 1) {
            header("Location: admin_index.php");
            exit();
        }
    }
    else {
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
    <!--<script src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>-->
    <script src="js/jquery-3.0.0.js"></script>
</head>
<body>
    Click on an item to order: <br>
    <?php
    require("all_items.php");
    ?>
    <script>
        $(document).ready(function() {
            // $('.item').on('cilck', function() {
            //     var $itemDetails = $(this).find('.item-details');
            //     $itemDetails.toggleClass('hidden');
            //     console.log('hello');
            // });

            $('button.submit').on('click', function() {
                // console.log('in');
                var qty = $(this).closest('.item-details').find("input[type='text']").val();
                var price = $(this).closest('tr').find('span.item-price').html();
                var name = $(this).closest('tr').find('span.item-name b').html();
                var city = '<?php echo $_SESSION['city_id']; ?>';
                console.log(qty, name, price, city);
            });
        });
    </script>
</body>
</html>