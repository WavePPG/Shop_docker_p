<?php
include('../server.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging code: Print the POST data
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    echo '<pre>';
    print_r($_FILES);
    echo '</pre>';

    if (!empty($_POST['id'])) { // Check if id is not empty
        $id = $_POST['id'];
        $pro_name = $_POST['pro_name'];
        $pro_description = $_POST['pro_description'];
        $price = $_POST['price'];
        $amount = $_POST['amount'];

        // Check if a new image was uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = $_FILES['image']['name'];
            $target = "../image/" . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            $sql_update = "UPDATE product SET pro_name='$pro_name', pro_description='$pro_description', price='$price', amount='$amount', image='$image' WHERE id='$id'";
        } else {
            $sql_update = "UPDATE product SET pro_name='$pro_name', pro_description='$pro_description', price='$price', amount='$amount' WHERE id='$id'";
        }

        if (mysqli_query($conn, $sql_update)) {
            echo "<script>
                    alert('Record updated successfully');
                    window.location.href = '../product.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error updating record: " . mysqli_error($conn) . "');
                  </script>";
        }
    } else {
        echo "<script>
                alert('No ID provided.');
              </script>";
    }

    mysqli_close($conn);
    exit;
}
?>
