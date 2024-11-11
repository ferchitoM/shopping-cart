<?php
include "conexion.php"; //Conexión a la base de datos

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

    section {
        display: flex;
        gap: 2rem;
        width: 50rem;
        flex-wrap: wrap;
    }

    article {
        border: 1px solid;
        width: 15rem;
        display: flex;
        flex-direction: column;
        line-height: 2rem;
        padding: 1rem;
    }

    article div {
        display: flex;
        justify-content: space-between;
    }
</style>

<body>

    <h1>
        Productos👔
        <!-- Cuando se haga click se muestra el carrito -->
        <button onclick="open_cart()">Ver carrito🛒</button>
    </h1>

    <section>

        <?php
        //lista productos
        $query_products =
            "SELECT * 
             FROM product 
             ORDER BY name ASC";
        $result_products = mysqli_query($conexion, $query_products);

        //Mostrar productos
        if ($result_products) {
            while ($item = mysqli_fetch_array($result_products)) { ?>

                <article>
                    <span><?php echo $item["name"]; ?></span>
                    <span>
                        <?php if ($item["price"] > 0) echo '$ ' . $item["price"];
                        else echo 'Varios tamaños' ?>
                    </span>
                    <button><a href="product_detail.php?id=<?php echo $item["id"] ?>">Lo quiero 🛍️</a></button>
                </article>
        <?php
            }
        }
        ?>

    </section>

    <!-- Colocar este código php al final de la página para que se muestre el carrito como un modal -->
    <!-- 'show_cart' contiene el código html y php del carrito -->
    <?php include 'carrito/show_cart.php' ?>

</body>

</html>