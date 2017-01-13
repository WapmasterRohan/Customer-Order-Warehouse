<?php
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

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
    <?php include("menu.php"); ?>

    Click on an item to order: <br>
    (It is not possible to remove items after placing order)<br>
    <?php
    require("all_items.php");
    require("extra.php");

    $order_no = random_string('ODR', 4);
    $cust_id = $_SESSION['cust_id'];
    ?>
    <div id="all-ordered-items" class='hidden'>
        <h3>Ordered items</h3>
        <table>
            <thead>
                <tr>
                    <td><b>Name</b></td>
                    <td><b>ID</b></td>
                    <td><b>Quantity</b></td>
                    <td><b>Price</b></td>
                </tr>
            </thead>
            <tbody id='order-list'></tbody>
        </table>
        <br>
        <div>Total price: <span id="total-price">0</span> Rupees</div>
        <br>
        <button id='submit-order'>Place order</button>
    </div>
    <script>
        $(document).ready(function() {
            // $('.item').on('cilck', function() {
            //     var $itemDetails = $(this).find('.item-details');
            //     $itemDetails.toggleClass('hidden');
            //     console.log('hello');
            // });

            $('button.submit-item').on('click', function() {
                // console.log('in');
                var qty = $(this).closest('.item-details').find("input[type='text']").val();
                var id = $(this).closest('tr').find('span.item-id').html();
                var price = $(this).closest('.item-details').find("span.item-price").html();
                var name = $(this).closest('tr').find('span.item-name b').html();
                var city = '<?php echo $_SESSION['city_id']; ?>';
                var totPrice = price * qty;

                // check item available at stores or not
                $.ajax({
                    type: 'POST',
                    data: ({
                        item_id: id,
                        city_id: city,
                        qty: qty,
                        order_no: '<?php echo $order_no; ?>'
                    }),
                    url: 'check_item_availability.php',
                    success: function(data) {
                        if(data == 1) {
                            // update the order list
                            $('#order-list').append('<tr><td>' + name + '</td><td>' + id + '</td><td>' + qty + '</td><td>' + totPrice + '</td></tr>');
                            var tempPrice = +$('#total-price').text();
                            tempPrice += totPrice;
                            $('#total-price').text(tempPrice);

                            if($('#order-list tr').length) {
                                $('#all-ordered-items').removeClass('hidden');
                            }
                        }
                        else if(data == 0) {
                            alert('Item is not available at stores. ');
                        }
                        else if(data == 2) {
                            alert('Item available but not enough, order some lower amount. ');
                        }
                    }
                });
            });
            
            $('button#submit-order').on('click', function() {
                $.ajax({
                    type: 'POST',
                    data: ({
                        cust_id: "<?php echo $cust_id; ?>",
                        order_no: "<?php echo $order_no; ?>"
                    }),
                    url: 'place_order.php',
                    success: function(data) {
                        var tempPrice = $('#total-price').text();
                        $('#all-ordered-items').html("Order placed successfully!! Total cost: " + tempPrice);
                        
                        setTimeout(function() {
                            window.location.href = "index.php";
                        }, 3000);
                    }
                });
            });
        });
    </script>
</body>
</html>