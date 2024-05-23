<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    }

    nav {
        padding: 1rem;
        background-color: #333;
    }
    .containner {
        max-width: 1340px;
        margin: 0 auto;
    }
    .nav-con {
        display: flex;
        justify-content: space-between;
    }

    .logo a {
        font-size: 2rem;
        color:#fff;
        text-decoration: none;
    }

    .menu {
        display: flex;
        list-style: none;
        align-items: center;
    }

    .menu li{
        margin: 0 1rem; /* ปรับซ้ายชวา 1 rem */
    }

    .menu li a{
        color:#fff;
        text-decoration: none;
    }
</style>
<body>
    <nav>
        <div class="containner">
            <div class="nav-con">
            <div class="logo">
                <a href="#">Back-end</a>
            </div>
            <ul class="menu">
                <!-- <li><a href="product.php">Product</a></li> -->
                <li><a href="uploadproduct.php">AddProduct</a></li>
                <li><a href="../edit-delete/edit.php">Edit</a></li>
            </ul>
            </div>
        </div>
    </nav>
</body>
</html>