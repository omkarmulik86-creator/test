<?php

defined( 'ABSPATH' ) || exit;

?>
<button class="smartnet-mobile-toggle" id="smartnet-menu-toggle" aria-label="<?php esc_attr_e( 'Toggle menu', 'woocommerce' ); ?>" aria-expanded="false">
    <span></span>
    <span></span>
    <span></span>
</button>

<div class="smartnet-sidebar-overlay" id="smartnet-sidebar-overlay"></div>

<div class="smartnet-account-layout woocommerce-account">
    <?php do_action( 'woocommerce_account_navigation' ); ?>

    <main class="smartnet-account-main woocommerce-MyAccount-content">
        <?php do_action( 'woocommerce_account_content' ); ?>
    </main>
</div>
