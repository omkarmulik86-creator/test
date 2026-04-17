<?php
/**
 * My Account Navigation
 *
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_menu' );

$menu_items = wc_get_account_menu_items();

if ( ! empty( $menu_items ) ) {
    ?>
    <ul class="woocommerce-MyAccount-navigation menu">
        <?php foreach ( $menu_items as $endpoint => $label ) { ?>
            <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                    <?php echo esc_html( $label ); ?>
                </a>
            </li>
        <?php } ?>
    </ul>
    <?php
}

do_action( 'woocommerce_after_account_menu' );
?>
