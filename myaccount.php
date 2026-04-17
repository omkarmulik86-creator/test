<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/myaccount.php.
 *
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_navigation' );
?>

<div class="smartnet-account-layout">
    <aside class="smartnet-sidebar woocommerce-MyAccount-navigation">
        <nav class="woocommerce-MyAccount-navigation">
            <?php do_action( 'woocommerce_account_navigation' ); ?>
        </nav>
    </aside>

    <div class="smartnet-account-main woocommerce-MyAccount-content">
        <?php
        /**
         * The contents of the `woocommerce_account_content` hook are output here.
         */
        do_action( 'woocommerce_account_content' );
        ?>
    </div>
</div>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
