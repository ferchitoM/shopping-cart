<?php
include "conexion.php"; //Conexión a la base de datos

if (!isset($_SESSION)) session_start(); //Para manejar las variables de sesión
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del producto</title>

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

    hr {
        width: 100%;
    }
</style>

<body>

    <h1>
        Detalle del producto 👔
    </h1>

    <section>

        <?php
        $id = $_GET['id'];

        //lista productos
        $query_products =
            "SELECT * 
             FROM product 
             WHERE product.id = $id";
        $result_products = mysqli_query($conexion, $query_products);


        //lista de opciones si el producto tiene opciones
        $query_options =
            "SELECT options.*
             FROM options 
             LEFT JOIN product ON product.id = options.product_id
             WHERE product.id = $id";
        $result_options = mysqli_query($conexion, $query_options);


        //Adiciones
        $query_additions =
            "SELECT * 
             FROM product 
             WHERE is_addition = 1"; //1 si es una adición
        $result_additions = mysqli_query($conexion, $query_additions);


        //Mostrar productos
        if ($result_products) {
            $item = mysqli_fetch_assoc($result_products); ?>

            <article>
                <span><?php echo $item["name"]; ?> <?php if ($item["price"] > 0) echo '$ ' . $item["price"]; ?></span>

                <!-- Formulario para agregar al carrito -->

                <form action="carrito/cart.php" method="post" id="form_<?php echo $item["id"] ?>">

                    <!-- id del producto -->
                    <input type="hidden" name="id" value="<?php echo $item["id"] ?>">

                    <?php
                    //Mostrar las adiciones 
                    if (mysqli_num_rows($result_options) > 0) { ?>
                        <hr>
                        <b>Seleciona un tamaño:</b>

                        <?php
                        $i = 0;
                        while ($op = mysqli_fetch_array($result_options)) { ?>
                            <div>
                                <label><?php echo $op["description"] . ' - $ ' . $op["price"]; ?></label>
                                <input
                                    type="radio"
                                    name="option"
                                    id="option<?php echo $op["id"] ?>"
                                    value="<?php echo $op["id"] ?>"
                                    <?php echo $i == 0 ? ' checked' : ''; ?>>
                            </div>

                        <?php $i++;
                        } ?>
                    <?php
                    } ?>

                    <hr>
                    <b>Adiciones:</b>

                    <?php
                    //Mostrar las adiciones 
                    if ($result_additions) {
                        mysqli_data_seek($result_additions, 0);
                        while ($add = mysqli_fetch_array($result_additions)) { ?>
                            <div>
                                <span><?php echo $add["name"] ?> - $ <?php echo $add["price"]; ?></span>
                                <input type="checkbox" name="addition[]" value="<?php echo $add["id"] ?>">
                            </div>
                    <?php }
                    } ?>

                    <br>
                    <button type="submit">Agregar al carrito 🛍️</button>
                </form>

                <!-- Fin formulario -->

            </article>
        <?php
        }
        ?>

    </section>

    <!-- Colocar este código php al final de la página para que se muestre el carrito como un modal -->
    <!-- 'show_cart' contiene el código html y php del carrito -->
    <?php include 'carrito/show_cart.php' ?>

</body>

</html>