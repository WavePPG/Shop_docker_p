<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>
</head>
<body>
<nav>
    <?php include('navbar.php')?>
</nav>
<div class="container mt-5">
    <div class="row">
        <?php 
        include('server.php'); 
        
        // Fetch and display data from the product table
        $sql_select = "SELECT * FROM product";
        $result_select = mysqli_query($conn, $sql_select);

        if (mysqli_num_rows($result_select) > 0) {
            $count = 0;
            while($row = mysqli_fetch_assoc($result_select)) {
                if ($count % 4 == 0 && $count != 0) {
                    echo "</div><div class='row mt-4'>";
                }
                echo "<div class='col-md-3 mb-4'>
                        <div class='card'>
                            <img src='./image/{$row['image']}' class='card-img-top' alt='{$row['pro_name']}'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$row['pro_name']}</h5>
                                <p class='card-text'>
                                    Price: {$row['price']}<br>
                                    Amount: {$row['amount']}
                                </p>
                                <a href='#' class='btn btn-primary mt-auto'>Go somewhere</a>
                            </div>
                        </div>
                      </div>";
                $count++;
            }
            echo "</div>";
        } else {
            echo "<p>No products found.</p>";
        }

        mysqli_close($conn);
        ?>
    </div>
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>