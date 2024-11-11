<?php
require_once "../conexion.php"; //Conexión a la base de datos
require_once "Item.class.php"; //Clase Item para manejar los productos del carrito

if (!isset($_SESSION)) session_start();

if (!isset($_SESSION["cart"])) $_SESSION["cart"] = array(); //La primera vez que se ingresa crea el arreglo
if (isset($_POST["id"])) $id = $_POST["id"];
if (isset($_POST["option"])) $option_id = $_POST['option'];
if (isset($_POST["addition"])) $addition = $_POST['addition'];

//Agregar al carrito
if (isset($_POST["id"])) {

    //Obtenemos todos los datos del producto
    $sql = "SELECT * 
            FROM product 
            WHERE id = $id"; //Cambiar 'product' por la tabla de sus productos

    //Si el producto tiene opciones
    if (isset($_POST["option"])) {
        $sql = "SELECT product.*, options.price AS price, CONCAT(product.name, ' ', options.description) AS name
                FROM product 
                JOIN options ON options.product_id = product.id
                WHERE product.id = $id
                AND options.id = $option_id"; //cambiar 'options' por la tabla de sus opciones o tamaños

        add_product($sql, $conexion, $id, $option_id); //Cambiar '$conexion' por la variable que contiene la conexión a la base de datos

    } else {
        add_product($sql, $conexion, $id); //Cambiar '$conexion' por la variable que contiene la conexión a la base de datos
    }

    //Si el producto tiene adiciones
    if (isset($_POST["addition"])) {

        //agregamos las adiciones una por una
        foreach ($addition as $addition_id) {
            $sql = "SELECT * FROM product WHERE id = $addition_id";
            add_product($sql, $conexion, $addition_id, null, $id);
        }
    }

    //echo "Agregado";
    echo json_encode($_SESSION["cart"]);
}

function add_product($sql, $conexion, $id, $option_id = null, $addition_id = null)
{
    if ($result = mysqli_query($conexion, $sql)) {
        $item = mysqli_fetch_assoc($result);
        $cantidad = 1; //Cantidad por defecto

        $new_product = new Item($id, $cantidad, $item['name'], $item['price'], $item['iva'], $option_id, $addition_id);
        $_SESSION["cart"][$id] = $new_product;
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
//header('Location: ../products.php?action');
