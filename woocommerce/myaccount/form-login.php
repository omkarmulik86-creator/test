<?php

/**
 * Login / Register Form — AJAX registration compatible
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_customer_login_form' );

$show_register = isset( $_GET['action'] ) && 'register' === sanitize_text_field( wp_unslash( $_GET['action'] ) );
?>

<div class="smartnet-auth-page custom-auth-wrapper" id="customer_login">
    <section class="smartnet-auth-hero">
        <span class="smartnet-brand-mark">CTF</span>
        <h1><?php echo esc_html__( 'Hack the login', 'woocommerce' ); ?></h1>
        <p><?php echo esc_html__( 'Enter your account to access CTF labs, challenge files, orders and secure downloads.', 'woocommerce' ); ?></p>
        <div class="smartnet-auth-metrics">
            <div><strong><?php echo esc_html__( 'Labs', 'woocommerce' ); ?></strong><span><?php echo esc_html__( 'Challenge access', 'woocommerce' ); ?></span></div>
            <div><strong><?php echo esc_html__( 'Safe', 'woocommerce' ); ?></strong><span><?php echo esc_html__( 'WooCommerce security', 'woocommerce' ); ?></span></div>
        </div>
    </section>

    <section class="smartnet-auth-card">
        <div class="smartnet-auth-tabs">
            <a class="<?php echo ! $show_register ? 'is-active' : ''; ?>" href="<?php echo esc_url( remove_query_arg( 'action' ) ); ?>"><?php echo esc_html__( 'Login', 'woocommerce' ); ?></a>
            <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
                <a class="<?php echo $show_register ? 'is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'action', 'register' ) ); ?>"><?php echo esc_html__( 'Register', 'woocommerce' ); ?></a>
            <?php endif; ?>
        </div>

        <?php if ( ! $show_register ) : ?>
            <div class="smartnet-auth-panel is-active u-column1 col-1">
                <h2><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>

                <form class="woocommerce-form woocommerce-form-login login smartnet-auth-form" method="post" novalidate>
                    <?php do_action( 'woocommerce_login_form_start' ); ?>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) && is_string( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
                    </p>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                        <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
                    </p>

                    <?php do_action( 'woocommerce_login_form' ); ?>

                    <p class="form-row smartnet-auth-actions">
                        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                            <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                            <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
                        </label>
                        <a class="woocommerce-LostPassword lost_password" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
                    </p>

                    <p class="form-row">
                        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                        <button type="submit" class="woocommerce-button button woocommerce-form-login__submit smartnet-auth-submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
                    </p>

                    <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
                        <div class="toggle-link-section">
                            <?php esc_html_e( 'New hacker?', 'woocommerce' ); ?>
                            <a href="<?php echo esc_url( add_query_arg( 'action', 'register' ) ); ?>"><strong><?php esc_html_e( 'Create an account', 'woocommerce' ); ?></strong></a>
                        </div>
                    <?php endif; ?>

                    <?php do_action( 'woocommerce_login_form_end' ); ?>
                </form>
            </div>
        <?php else : ?>
            <div class="smartnet-auth-panel is-active u-column2 col-2">
                <h2><?php esc_html_e( 'Register', 'woocommerce' ); ?></h2>

                <div class="ajax-msg" id="ajax-register-msg" role="alert" aria-live="polite"></div>

                <form method="post" class="woocommerce-form woocommerce-form-register register smartnet-auth-form" id="ajax-register-form" onsubmit="return false;" novalidate <?php do_action( 'woocommerce_register_form_tag' ); ?>>
                    <?php do_action( 'woocommerce_register_form_start' ); ?>

                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) && is_string( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
                        </p>
                    <?php endif; ?>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
                        <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) && is_string( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" />
                    </p>

                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                            <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
                        </p>
                    <?php else : ?>
                        <p><?php esc_html_e( 'A password reset link will be sent to your email address.', 'woocommerce' ); ?></p>
                    <?php endif; ?>

                    <?php do_action( 'woocommerce_register_form' ); ?>
                    <?php wp_nonce_field( 'wc_ajax_register_nonce', 'wc_ajax_register_nonce_field' ); ?>

                    <p class="woocommerce-form-row form-row">
                        <button type="button" id="ajax-register-btn" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit smartnet-auth-submit">
                            <?php esc_html_e( 'Register', 'woocommerce' ); ?>
                        </button>
                    </p>

                    <div class="toggle-link-section">
                        <?php esc_html_e( 'Already have an account?', 'woocommerce' ); ?>
                        <a href="<?php echo esc_url( remove_query_arg( 'action' ) ); ?>"><strong><?php esc_html_e( 'Log in here', 'woocommerce' ); ?></strong></a>
                    </div>

                    <?php do_action( 'woocommerce_register_form_end' ); ?>
                </form>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
