<?php
/* Template Name: Custom Checkout */

//Instanciamos nuestra clase index que es la que mostrara el html
$checkout = new Checkout();
//Llamamos a nuestra funcion render
echo $checkout->render();

class Checkout extends BaseClass
{
    function render()
    {
        $scripts = array(
            array("plugins-js", get_template_directory_uri() . "/dist/js/sources.js" ),
            array("main-js", get_template_directory_uri() . "/dist/js/main.js" ),
        );

        $styles = array(
            array("plugins-css", get_template_directory_uri() . "/dist/css/plugins.css"),
            array("main-css", get_template_directory_uri() . "/dist/css/main.css")
        );

        global $woocommerce;
        $cart_total = $woocommerce->cart->get_cart_total();
        $acf = get_fields(get_the_ID());

        $cartItems = WC()->cart->get_cart();

        $productId = '';
        $variationId = '';
        foreach ($cartItems as $key => $value) {
            $productId = $value['product_id'];
            $variationId = $value['variation_id'];

            break;
        }

        $product = wc_get_product( $variationId );


        return $this->preRender(
            "pages/checkout.twig",
            array(
                "title" => "HOLA",
                "sidebar_class" => "clas de ejemplo",
                "post" => get_post(),
                "cart_total" => $cart_total,
                "cart_items_count" => WC()->cart->get_cart_contents_count(),
                "acf" => $acf,
                "regular_price" => $product->get_regular_price(),
                "acf_product" => get_fields($productId),
                "modules" => get_field('content', get_post()->ID)
            ),
            $styles,
            $scripts
        );
    }
    
}
