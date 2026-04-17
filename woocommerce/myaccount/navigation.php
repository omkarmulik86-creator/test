<?php

defined( 'ABSPATH' ) || exit;

$menu_items   = wc_get_account_menu_items();
$current_user = wp_get_current_user();
$display_name = $current_user->display_name ? $current_user->display_name : $current_user->user_login;
$ctf_links    = function_exists( 'smartnet_ctf_links' ) ? smartnet_ctf_links() : array();
$icons        = array(
    'dashboard'       => 'DB',
    'orders'          => 'OR',
    'downloads'       => 'DL',
    'edit-address'    => 'AD',
    'payment-methods' => 'PM',
    'edit-account'    => 'AC',
    'customer-logout' => 'LO',
);

do_action( 'woocommerce_before_account_navigation' );
?>

<aside class="smartnet-sidebar woocommerce-MyAccount-navigation" aria-label="<?php echo esc_attr__( 'Account pages', 'woocommerce' ); ?>">
    <div class="smartnet-brand">
        <span class="smartnet-brand-mark">S</span>
        <span class="smartnet-brand-name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
    </div>

    <div class="smartnet-sidebar-search">
        <input type="search" placeholder="<?php echo esc_attr__( 'Search...', 'woocommerce' ); ?>" aria-label="<?php echo esc_attr__( 'Search account menu', 'woocommerce' ); ?>">
    </div>

    <nav class="smartnet-menu">
        <p class="smartnet-menu-label"><?php echo esc_html__( 'Menu', 'woocommerce' ); ?></p>
        <ul>
            <?php foreach ( $menu_items as $endpoint => $label ) : ?>
                <li class="<?php echo esc_attr( wc_get_account_menu_item_classes( $endpoint ) ); ?> smartnet-menu-item" data-smartnet-menu-item>
                    <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                        <span class="smartnet-menu-icon"><?php echo esc_html( isset( $icons[ $endpoint ] ) ? $icons[ $endpoint ] : '&bull;' ); ?></span>
                        <span><?php echo esc_html( $label ); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <?php if ( ! empty( $ctf_links ) ) : ?>
        <nav class="smartnet-menu smartnet-ctf-menu">
            <p class="smartnet-menu-label"><?php echo esc_html__( 'CTF Arena', 'woocommerce' ); ?></p>
            <ul>
                <?php foreach ( $ctf_links as $link ) : ?>
                    <li class="smartnet-menu-item" data-smartnet-menu-item>
                        <a href="<?php echo esc_url( $link['url'] ); ?>">
                            <span class="smartnet-menu-icon"><?php echo esc_html( $link['icon'] ); ?></span>
                            <span><?php echo esc_html( $link['label'] ); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    <?php endif; ?>

    <div class="smartnet-upgrade-card">
        <strong><?php echo esc_html__( 'Join Pro Lab', 'woocommerce' ); ?></strong>
        <span><?php echo esc_html__( 'Unlock premium CTF rooms, files and writeups.', 'woocommerce' ); ?></span>
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php echo esc_html__( 'Upgrade Now', 'woocommerce' ); ?></a>
    </div>

    <div class="smartnet-profile-mini">
        <div class="smartnet-avatar"><?php echo esc_html( strtoupper( substr( $display_name, 0, 1 ) ) ); ?></div>
        <div>
            <strong><?php echo esc_html( $display_name ); ?></strong>
            <span><?php echo esc_html( $current_user->user_email ); ?></span>
        </div>
    </div>
</aside>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
