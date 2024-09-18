<?php
include "conexion.php"; //Conexión a la base de datos
include 'carrito/Item.class.php'; //Clase Item para manejar los productos del carrito

if (!isset($_SESSION)) session_start(); //Para manejar las variables de sesión
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <!-- Agregar el estilo del carrito en todas las páginas donde se vaya a mostrar -->
    <link rel="stylesheet" href="carrito/carrito-style.css">

</head>

<style>
    a {
        text-decoration: none;
        color: black;
    }
</style>

<body>
    <h1>
        Productos👔
        <!-- Cuando se haga click se muestra el carrito -->
        <button onclick="open_cart()">Ver carrito🛒</button>
    </h1>

    <?php
    $sql = "SELECT * FROM product";
    if ($result = mysqli_query($conexion, $sql)) {
        while ($item = mysqli_fetch_array($result)) { ?>

            <article>
                <span><?php echo $item["name"]; ?> - </span>
                <span>$ <?php echo $item["price"]; ?></span>

                <?php
                //Si el producto no se encuentra en el carrito, se muestra el botón de comprar
                //Cuando se haga click en comprar se envía el 'id' del producto al 'carrito/cart.php'
                if (!isset($_SESSION['cart'][$item['id']])) { ?>
                    <button><a href="carrito/cart.php?id=<?php echo $item["id"] ?>">Comprar🛍️</a></button>
                <?php } ?>
            </article>
            <hr>
    <?php
        }
    }
    ?>

    <!-- Colocar este código php al final de la página para que se muestre el carrito como un modal -->
    <!-- 'show_cart' contiene el código html y php del carrito -->
    <?php include 'carrito/show_cart.php' ?>

</body>

</html>