<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Georgia', serif;
            background-color: #f9f9f9;
            color: #333;
            margin-top: 15vh;
        }

        header {
            background-color: #ffffff;
            padding: 20px 40px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            height: 60px;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .logo {
            flex: 1;
        }

        .logo h4 {
            margin: 0;
        }

        .nav-links {
            display: flex;
            justify-content: flex-end;
            flex: 2;
            list-style: none;
        }

        .nav-links li {
            margin-left: 25px;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
            padding: 8px 40px;
            transition: color 0.3s ease;
        
        }

        .nav-links a:hover {
            color: #007BFF;
        }

        @media (max-width: 768px) {
            header {
                padding: 10px 20px;
            }

            .nav-links {
                flex-direction: column;
                align-items: flex-start;
            }
          
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h4>Back-end</h4>
            </div>
            <ul class="nav-links">
                <li><a href="uploadproduct.php">Add Product</a></li>
                <li><a href="../edit-delete/edit.php">Edit</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>
