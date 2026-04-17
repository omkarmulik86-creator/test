<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

if ( is_user_logged_in() ) {
    return;
}

$login_url    = esc_url( wp_login_url() );
$register_url = esc_url( wp_registration_url() );
$lost_pwd_url = esc_url( wp_lostpassword_url() );
?>

<div class="smartnet-auth-page" id="customer_login">
    <!-- Login Form -->
    <div class="smartnet-auth-panel u-column1 col-1">
        <div class="smartnet-auth-card">
            <h2><?php esc_html_e( 'Sign In', 'woocommerce' ); ?></h2>

            <form method="post" class="smartnet-auth-form woocommerce-form woocommerce-form-login">

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="username"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
                </p>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input class="woocommerce-Input input-text" type="password" name="password" id="password" autocomplete="current-password" />
                </p>

                <?php do_action( 'woocommerce_login_form' ); ?>

                <p class="form-row smartnet-auth-actions">
                    <label class="woocommerce-form-login__rememberme">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                        <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
                    </label>
                    <a href="<?php echo esc_url( $lost_pwd_url ); ?>"><?php esc_html_e( 'Lost password?', 'woocommerce' ); ?></a>
                </p>

                <p class="form-row">
                    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                    <button type="submit" class="woocommerce-button button woocommerce-form-login__submit smartnet-auth-submit" name="login" value="<?php esc_attr_e( 'Sign In', 'woocommerce' ); ?>">
                        <?php esc_html_e( 'Sign In', 'woocommerce' ); ?>
                    </button>
                </p>

                <?php do_action( 'woocommerce_login_form_end' ); ?>

            </form>
        </div>
    </div>

    <!-- Register Form -->
    <div class="smartnet-auth-panel u-column2 col-2">
        <div class="smartnet-auth-card smartnet-auth-hero">
            <h2><?php esc_html_e( 'Create Account', 'woocommerce' ); ?></h2>
            <p><?php esc_html_e( 'Join our gaming platform and start competing!', 'woocommerce' ); ?></p>

            <form method="post" class="smartnet-auth-form woocommerce-form woocommerce-form-register">

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="email" class="woocommerce-Input input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" />
                </p>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
                </p>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="password" class="woocommerce-Input input-text" name="password" id="reg_password" autocomplete="new-password" />
                </p>

                <?php do_action( 'woocommerce_register_form' ); ?>

                <p class="woocommerce-form-row form-row">
                    <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                    <button type="submit" class="woocommerce-button button woocommerce-form-register__submit smartnet-auth-submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>">
                        <?php esc_html_e( 'Register', 'woocommerce' ); ?>
                    </button>
                </p>

                <?php do_action( 'woocommerce_register_form_end' ); ?>

            </form>
        </div>
    </div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
