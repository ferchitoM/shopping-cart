<?php
require_once "config.php";
include "Item.php";


session_start();
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = array();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

//Agregar al carrito
if (isset($_GET["id"])) {
    $sql = "SELECT * FROM product WHERE id = $id";
    if ($result = mysqli_query($link, $sql)) {
        $item = mysqli_fetch_assoc($result);
        $new_product = new Item($id, 1, $item['name'], $item['price'], $item['iva']);
        $_SESSION["cart"][$id] = $new_product;
        echo "Agregado";
    }
}

//Editar cantidad
$editar = null;
if (isset($_POST["update"])) {
    if (isset($_POST["cantidad"])) {
        echo "Pedido actualizado";
        $id = $_POST["update"];
        $cantidad = $_POST["cantidad"];
        foreach ($_SESSION["cart"] as $item) {
            if ($item->id == $id) {
                $item->updateAmount($cantidad);
            }
        }
    } else {
        echo "Editando pedido";
        $editar = $_POST["update"]; //id del producto a editar
    }
}

//Eliminar del carrito
if (isset($_GET["delete"])) {
    echo "Eliminado";
    $id = $_GET["delete"];
    foreach ($_SESSION["cart"] as $index => $item) {
        if ($item->id == $id) {
            unset($_SESSION["cart"][$index]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoppint cart</title>
</head>

<style>
    a {
        text-decoration: none;
        color: black;
    }

    input {
        width: 5rem;
    }
</style>

<body>
    <h1>Carrito🛒</h1>
    <?php
    if (count($_SESSION["cart"])) {
        foreach ($_SESSION["cart"] as $item) {
    ?>
            <article>
                <button><a href="cart.php?delete=<?php echo $item->id ?>">❌</a></button>
                <br>
                <span><?php echo $item->name; ?> - </span>
                <span>$ <?php echo $item->price; ?> </span>
                <br>
                <form action="cart.php" method="POST" id="form-item-<?php echo $item->id ?>">
                    <label>Cantidad: </label>
                    <input type="hidden" name="update" value="<?php echo $item->id ?>">
                    <input
                        type="number"
                        name="cantidad"
                        value="<?php echo $item->amount; ?>"
                        min="1"
                        max="99"
                        <?php echo $editar == $item->id ? '' : 'disabled'; ?>>
                    <button type="submit">✏️</button>
                    <br>
                    <span>Subtotal: $ <?php echo $item->total; ?></span>
                </form>
            </article>
            <hr>
        <?php
        }
    } else { ?>
        <p>Ups! nada todavía</p>
    <?php
    } ?>

    <button><a href="index.php">Ver productos👔</a></button>
    <button><a href="pay.php">Pagar 💵</a></button>
</body>

</html>