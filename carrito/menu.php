<?php
include 'carrito/Item.php';
if (!isset($_SESSION)) session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu completo</title>
    <link rel="stylesheet" href="../public_html/assets/css/comidas.css">
    <link rel="stylesheet" href="../public_html/assets/css/menu.css">
    <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../public_html/assets/css/carrito.css">

</head>

<style>
    .image-category {
        object-fit: cover;
        width: 12rem;
        height: 8rem;
    }
</style>

<body>

    <header class="header">
        <div class="logo">
            <img src="../public_html/assets/imgs/LOGO_TRAILER.png" alt="" srcset="">
        </div>
        <h5 class="text">El Trailer</h5>
        <nav>
            <ul class="nav_links">
                <li><a href="../public_html/index.php">Inicio</a></li>
                <li onclick="carrito()">Carrito</li>
                </a></li>
            </ul>
        </nav>
    </header> <br>

    <script>
        function carrito() {
            let cart = document.getElementById('cart');
            cart.classList.toggle("hide-cart");
        }
    </script>

    <div class="card-wrap">


        <?php
        include 'config/conexion.php';
        $query = "
        SELECT * FROM category
        ORDER BY name ASC";

        $response = mysqli_query($conexion, $query);

        while ($item = mysqli_fetch_array($response)) {
        ?>

            <div class="galery">
                <article class="card">
                    <header class="header-card">
                        <img class="image-category" src="../public_html/assets/imgs/categories/<?php echo $item['image'] ?>">
                    </header>
                    <footer class="footer-card">
                        <div class="texto-card">
                            <h3><?php echo $item['name'] ?></h3>
                            <a href="../public_html/menu_productos.php?id=<?php echo $item['id'] ?>&category_name=<?php echo $item['name'] ?>" class="btn btn-primary">Ver productos</a>
                        </div><br>
                    </footer>
                </article>
            </div>

        <?php } ?>

    </div>

    <?php include 'carrito/show_cart.php' ?>

</body>

</html>