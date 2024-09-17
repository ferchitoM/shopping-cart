<?php session_start() ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>

<style>
    a {
        text-decoration: none;
        color: black;
    }
</style>

<body>
    <h1>Productos👔</h1>
    <?php
    require_once "config.php";
    $sql = "SELECT * FROM product";
    if ($result = mysqli_query($link, $sql)) {
        while ($item = mysqli_fetch_array($result)) { ?>

            <article>
                <span><?php echo $item["name"]; ?> - </span>
                <span>$ <?php echo $item["price"]; ?></span>

                <?php
                if (!isset($_SESSION['cart'][$item['id']])) { ?>
                    <button><a href="cart.php?id=<?php echo $item["id"] ?>">Comprar🛍️</a></button>
                <?php } ?>
            </article>
            <hr>
    <?php
        }
    }
    ?>

    <button><a href="cart.php">Ver carrito🛒</a></button>

</body>

</html>