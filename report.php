<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report</title>
    <script src="js/jquery-3.0.0.js"></script>
</head>
<body>
    <?php
        require_once("checkconnection.php");
        include("menu.php");

        echo "<h3>No of sales of items per city</h3><br>";

        echo "Select a city: <br>";
        include("fetch_city.php");
        echo "<div id='report-display'></div>";
    ?>
    <script>
        $(document).ready(function() {
            $('#city-option').on('change', function() {
                var option = $(this).find('option:selected').val();
                $.ajax({
                    type: 'POST',
                    data: ({
                        'city': option
                    }),
                    url: 'sales_report.php',
                    success: function(data) {
                        $('#report-display').html(data);
                    }
                });
            });
        });
    </script>
</body>
</html>
