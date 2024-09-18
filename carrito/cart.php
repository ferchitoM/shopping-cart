<?php
require_once "../conexion.php"; //Conexión a la base de datos
require_once "Item.class.php"; //Clase Item para manejar los productos del carrito

if (!isset($_SESSION)) session_start();

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = array();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

//Agregar al carrito
if (isset($_GET["id"])) {

    //Cambiar 'product' por la tabla de sus productos
    $sql = "SELECT * FROM product WHERE id = $id";

    //Cambiar '$conexion' por la variable que contiene la conexión a la base de datos
    if ($result = mysqli_query($conexion, $sql)) {
        $item = mysqli_fetch_assoc($result);
        $new_product = new Item($id, 1, $item['name'], $item['price'], 0);
        $_SESSION["cart"][$id] = $new_product;
        echo "Agregado";
    }
}

//Editar cantidad producto
$_SESSION['edit'] = 0;

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
        $_SESSION['edit'] = $_POST["update"]; //id del producto a editar
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

//Nos regresa a la página de los productos 
//'action' permite que el carrito aparezca automáticamente después de agregar un producto
header('Location: ../products.php?action');
