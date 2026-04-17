<?php

defined( 'ABSPATH' ) || exit;

$current_user   = wp_get_current_user();
$customer_id    = get_current_user_id();
$order_count    = function_exists( 'wc_get_customer_order_count' ) ? wc_get_customer_order_count( $customer_id ) : 0;
$total_spent    = function_exists( 'wc_get_customer_total_spent' ) ? wc_get_customer_total_spent( $customer_id ) : 0;
$downloads      = function_exists( 'wc_get_customer_available_downloads' ) ? wc_get_customer_available_downloads( $customer_id ) : array();
$recent_orders  = function_exists( 'wc_get_orders' ) ? wc_get_orders( array( 'customer_id' => $customer_id, 'limit' => 5, 'orderby' => 'date', 'order' => 'DESC' ) ) : array();
$display_name   = $current_user->display_name ? $current_user->display_name : $current_user->user_login;
$ctf_links      = function_exists( 'smartnet_ctf_links' ) ? smartnet_ctf_links() : array();
$activity_months = array();

for ( $i = 5; $i >= 0; $i-- ) {
    $timestamp         = strtotime( '-' . $i . ' months' );
    $activity_months[] = array(
        'label' => date_i18n( 'M', $timestamp ),
        'value' => max( 16, 24 + ( ( 5 - $i ) * 9 ) + ( $order_count * 3 ) ),
    );
}

$ctf_stats = array(
    array(
        'label' => __( 'Lab Access', 'woocommerce' ),
        'value' => $order_count > 0 ? __( 'Active', 'woocommerce' ) : __( 'Free', 'woocommerce' ),
        'meta'  => __( 'Account status', 'woocommerce' ),
        'url'   => wc_get_account_endpoint_url( 'edit-account' ),
    ),
    array(
        'label' => __( 'CTF Orders', 'woocommerce' ),
        'value' => number_format_i18n( $order_count ),
        'meta'  => __( 'Purchased labs', 'woocommerce' ),
        'url'   => wc_get_account_endpoint_url( 'orders' ),
    ),
    array(
        'label' => __( 'Downloads', 'woocommerce' ),
        'value' => number_format_i18n( count( $downloads ) ),
        'meta'  => __( 'Files available', 'woocommerce' ),
        'url'   => wc_get_account_endpoint_url( 'downloads' ),
    ),
    array(
        'label' => __( 'Total Spent', 'woocommerce' ),
        'value' => wc_price( $total_spent ),
        'meta'  => __( 'Lifetime value', 'woocommerce' ),
        'url'   => wc_get_account_endpoint_url( 'orders' ),
    ),
);
?>

<section class="smartnet-dashboard smartnet-ctf-dashboard">
    <header class="smartnet-topbar">
        <div>
            <span class="smartnet-eyebrow"><?php echo esc_html__( 'My Account', 'woocommerce' ); ?></span>
            <h1><?php echo esc_html__( 'Dashboard', 'woocommerce' ); ?></h1>
            <p><?php echo esc_html__( 'Welcome back, operator. Track CTF labs, downloads, purchases and account security from one command center.', 'woocommerce' ); ?></p>
        </div>
        <div class="smartnet-user-pill">
            <span class="smartnet-avatar"><?php echo esc_html( strtoupper( substr( $display_name, 0, 1 ) ) ); ?></span>
            <span><?php echo esc_html( strtoupper( $display_name ) ); ?></span>
        </div>
    </header>

    <div class="smartnet-stat-grid">
        <?php foreach ( $ctf_stats as $index => $stat ) : ?>
            <a class="smartnet-stat-card smartnet-ctf-stat-<?php echo esc_attr( $index + 1 ); ?>" href="<?php echo esc_url( $stat['url'] ); ?>">
                <span><?php echo esc_html( $stat['label'] ); ?></span>
                <strong><?php echo wp_kses_post( $stat['value'] ); ?></strong>
                <small><?php echo esc_html( $stat['meta'] ); ?></small>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="smartnet-dashboard-grid">
        <article class="smartnet-panel smartnet-chart-panel smartnet-terminal-panel">
            <div class="smartnet-panel-head">
                <div>
                    <span><?php echo esc_html__( 'Exploit activity', 'woocommerce' ); ?></span>
                    <h2><?php echo esc_html__( 'Recent activity', 'woocommerce' ); ?></h2>
                </div>
                <button type="button" data-smartnet-toggle><?php echo esc_html__( 'Inspect', 'woocommerce' ); ?></button>
            </div>

            <div class="smartnet-terminal-lines">
                <p><span>$</span> <?php echo esc_html__( 'session --user=', 'woocommerce' ); ?><?php echo esc_html( $display_name ); ?></p>
                <p><span>&gt;</span> <?php echo esc_html__( 'account status: authenticated', 'woocommerce' ); ?></p>
                <p><span>&gt;</span> <?php echo esc_html__( 'download vault: synced', 'woocommerce' ); ?></p>
            </div>

            <div class="smartnet-chart smartnet-ctf-chart">
                <?php foreach ( $activity_months as $month ) : ?>
                    <div class="smartnet-chart-item">
                        <span class="smartnet-chart-bar" style="height: <?php echo esc_attr( $month['value'] ); ?>%;"></span>
                        <em><?php echo esc_html( $month['label'] ); ?></em>
                    </div>
                <?php endforeach; ?>
            </div>
        </article>

        <aside class="smartnet-panel smartnet-settings-panel">
            <div class="smartnet-panel-head">
                <div>
                    <span><?php echo esc_html__( 'Environment settings', 'woocommerce' ); ?></span>
                    <h2><?php echo esc_html__( 'Quick actions', 'woocommerce' ); ?></h2>
                </div>
            </div>

            <div class="smartnet-action-list">
                <?php if ( ! empty( $ctf_links['challenges'] ) ) : ?>
                    <a href="<?php echo esc_url( $ctf_links['challenges']['url'] ); ?>">
                        <strong><?php echo esc_html__( 'Start challenges', 'woocommerce' ); ?></strong>
                        <span><?php echo esc_html__( 'Open active CTF rooms and machines.', 'woocommerce' ); ?></span>
                    </a>
                <?php endif; ?>
                <?php if ( ! empty( $ctf_links['scoreboard'] ) ) : ?>
                    <a href="<?php echo esc_url( $ctf_links['scoreboard']['url'] ); ?>">
                        <strong><?php echo esc_html__( 'View scoreboard', 'woocommerce' ); ?></strong>
                        <span><?php echo esc_html__( 'Check rank, points and team position.', 'woocommerce' ); ?></span>
                    </a>
                <?php endif; ?>
                <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'downloads' ) ); ?>">
                    <strong><?php echo esc_html__( 'Download lab files', 'woocommerce' ); ?></strong>
                    <span><?php echo esc_html__( 'Access purchased files and challenge assets.', 'woocommerce' ); ?></span>
                </a>
                <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-account' ) ); ?>">
                    <strong><?php echo esc_html__( 'Account security', 'woocommerce' ); ?></strong>
                    <span><?php echo esc_html( $current_user->user_email ); ?></span>
                </a>
                <a href="<?php echo esc_url( wc_logout_url() ); ?>">
                    <strong><?php echo esc_html__( 'Secure logout', 'woocommerce' ); ?></strong>
                    <span><?php echo esc_html__( 'End this session safely.', 'woocommerce' ); ?></span>
                </a>
            </div>
        </aside>

        <article class="smartnet-panel smartnet-orders-panel">
            <div class="smartnet-panel-head">
                <div>
                    <span><?php echo esc_html__( 'Purchase report', 'woocommerce' ); ?></span>
                    <h2><?php echo esc_html__( 'Recent orders', 'woocommerce' ); ?></h2>
                </div>
                <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>"><?php echo esc_html__( 'View all', 'woocommerce' ); ?></a>
            </div>

            <?php if ( ! empty( $recent_orders ) ) : ?>
                <div class="smartnet-order-list">
                    <?php foreach ( $recent_orders as $order ) : ?>
                        <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
                            <span>#<?php echo esc_html( $order->get_order_number() ); ?></span>
                            <strong><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></strong>
                            <em><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></em>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="smartnet-empty-state">
                    <strong><?php echo esc_html__( 'No orders yet', 'woocommerce' ); ?></strong>
                    <span><?php echo esc_html__( 'Your CTF lab purchases will appear here.', 'woocommerce' ); ?></span>
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php echo esc_html__( 'Start shopping', 'woocommerce' ); ?></a>
                </div>
            <?php endif; ?>
        </article>

        <article class="smartnet-panel smartnet-learn-panel">
            <div class="smartnet-panel-head">
                <div>
                    <span><?php echo esc_html__( 'Learn to use account', 'woocommerce' ); ?></span>
                    <h2><?php echo esc_html__( 'CTF control center', 'woocommerce' ); ?></h2>
                </div>
            </div>

            <div class="smartnet-faq-list">
                <div>
                    <strong><?php echo esc_html__( 'Challenges', 'woocommerce' ); ?></strong>
                    <span><?php echo esc_html__( 'Browse web, crypto, forensics, reverse engineering and pwn rooms.', 'woocommerce' ); ?></span>
                </div>
                <div>
                    <strong><?php echo esc_html__( 'Submissions', 'woocommerce' ); ?></strong>
                    <span><?php echo esc_html__( 'Submit flags and track solved tasks from your CTF pages.', 'woocommerce' ); ?></span>
                </div>
                <div>
                    <strong><?php echo esc_html__( 'Downloads', 'woocommerce' ); ?></strong>
                    <span><?php echo esc_html__( 'WooCommerce keeps purchased files and lab packs secure.', 'woocommerce' ); ?></span>
                </div>
            </div>
        </article>
    </div>

    <?php do_action( 'woocommerce_account_dashboard' ); ?>
</section>
