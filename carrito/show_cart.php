<!-- El 'id' y 'class' permiten manipular el carrito con javascript -->
<section
    id="cart"
    class="<?php if (!isset($_GET['action'])) echo 'hide-cart' ?>">

    <h1>
        Carrito🛒
        <!-- Cuando se haga click se oculta el carrito -->
        <button onclick="close_cart()">Cerrar</button>
    </h1>
    <main>
        <?php

        if (isset($_SESSION["cart"])) {
            $_SESSION['total'] = 0;
            $_SESSION['subtotal'] = 0;
            $_SESSION['total_iva'] = 0;

            if (count($_SESSION["cart"])) {
                foreach ($_SESSION["cart"] as $item) { ?>

                    <article>
                        <button><a href="carrito/cart.php?delete=<?php echo $item->id ?>">❌</a></button>
                        <br>
                        <span><?php echo $item->name; ?> - </span>
                        <small>$ <?php echo $item->price; ?> </small>
                        <br>
                        <form action="carrito/cart.php" method="POST" id="form-item-<?php echo $item->id ?>">
                            <label>Cantidad: </label>
                            <input type="hidden" name="update" value="<?php echo $item->id ?>">
                            <input
                                type="number"
                                name="cantidad"
                                value="<?php echo $item->amount; ?>"
                                min="1"
                                max="99"
                                <?php echo $_SESSION['edit'] == $item->id ? '' : 'disabled'; ?>>
                            <button type="submit">✏️</button>
                            <br>
                            <span>Subtotal: <b>$ <?php echo $item->total; ?></b></span>
                        </form>
                    </article>

                    <hr>

                <?php
                    $_SESSION['total'] += $item->total;
                    $_SESSION['subtotal'] += $item->subtotal;
                    $_SESSION['total_iva'] += $item->total_iva;
                }
            } else { ?>
                <p>Ups! nada todavía</p>
        <?php
            }
        } ?>

    </main>
    <h3>Total a pagar $<?php echo $_SESSION['total'] ?></h3>

    <button><a href="carrito/pay.php">Pagar 💵</a></button>

    <!-- Éste código javascript permite mostrar u ocultar el carrito -->
    <script type="text/javascript">
        let cart = document.getElementById('cart');

        document.addEventListener('mouseup', function(e) {
            if (!cart.contains(e.target)) {
                close_cart();
                console.log('ups');
            }
        });

        let open_cart = () => cart.classList.remove("hide-cart");
        let close_cart = () => cart.classList.add("hide-cart");
    </script>

</section>