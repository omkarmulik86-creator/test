<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro section on the account page.
 *
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

defined( 'ABSPATH' ) || exit;

$user = wp_get_current_user();
?>

<div class="smartnet-dashboard">
    <div class="smartnet-dashboard-header">
        <h1><?php echo sprintf( esc_html__( 'Welcome, %s', 'woocommerce' ), '<strong>' . esc_html( $user->first_name ? $user->first_name : $user->user_login ) . '</strong>' ); ?></h1>
        <p class="smartnet-dashboard-subtitle"><?php echo esc_html__( 'Your Gaming Dashboard', 'woocommerce' ); ?></p>
    </div>

    <?php
    /**
     * The contents of the dashboard section are output here.
     *
     * @since 2.6.0
     */
    do_action( 'woocommerce_account_dashboard' );

    /**
     * Deprecated woocommerce_before_my_account hook.
     *
     * @deprecated 2.6.0
     */
    do_action( 'woocommerce_before_my_account' );
    ?>

    <div class="smartnet-dashboard-grid">
        <?php if ( wc_get_customer_order_count() ) { ?>
            <div class="smartnet-stat-card">
                <span class="smartnet-stat-label"><?php esc_html_e( 'Total Orders', 'woocommerce' ); ?></span>
                <span class="smartnet-stat-value"><?php echo esc_html( wc_get_customer_order_count() ); ?></span>
            </div>
        <?php } ?>

        <?php
        $customer = new WC_Customer( get_current_user_id() );
        $spent = $customer->get_total_spent();
        if ( $spent ) {
            ?>
            <div class="smartnet-stat-card">
                <span class="smartnet-stat-label"><?php esc_html_e( 'Total Spent', 'woocommerce' ); ?></span>
                <span class="smartnet-stat-value"><?php echo wp_kses_post( wc_price( $spent ) ); ?></span>
            </div>
            <?php
        }
        ?>
    </div>

    <?php
    /**
     * Deprecated woocommerce_after_my_account hook.
     *
     * @deprecated 2.6.0
     */
    do_action( 'woocommerce_after_my_account' );
    ?>
</div>

<?php
/**
 * Fires on the account page.
 *
 * @since 2.6.0
 */
do_action( 'woocommerce_account_dashboard_after' );
?>
