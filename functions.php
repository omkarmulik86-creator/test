<?php
/**
 * HackLayer Child Theme - functions.php
 * Smartnet CTF Dashboard — WooCommerce Custom
 *
 * HOW TO USE (WordPress mein):
 * 1. Is file ka content apne CHILD THEME ke functions.php mein copy karein
 * 2. Yeh files copy karein child theme mein:
 *    - woocommerce/myaccount/myaccount.php
 *    - woocommerce/myaccount/dashboard.php
 *    - woocommerce/myaccount/navigation.php
 *    - woocommerce/myaccount/form-login.php
 *    - assets/css/myaccount-dashboard.css
 *    - assets/js/myaccount-dashboard.js
 * 3. Saari caches clear karein (WP + browser)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// =============================================
// PARENT THEME STYLESHEET ENQUEUE
// =============================================

if ( ! function_exists( 'chld_thm_cfg_locale_css' ) ) :
    function chld_thm_cfg_locale_css( $uri ) {
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) ) {
            $uri = get_template_directory_uri() . '/rtl.css';
        }
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( ! function_exists( 'chld_thm_cfg_parent_css' ) ) :
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style(
            'chld_thm_cfg_parent',
            trailingslashit( get_template_directory_uri() ) . 'style.css',
            array( 'font-awesome-1', 'animate', 'magnific-popup', 'meanmenu', 'nice-select', 'swiper-bundle', 'feron-main-style', 'wp-fix' )
        );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );


// =============================================
// WOOCOMMERCE TEMPLATE OVERRIDE — CRITICAL FIX
// Yeh filter ensure karta hai ke WC hamari
// child theme ki saari myaccount files load kare
// =============================================

add_filter( 'woocommerce_locate_template', 'smartnet_locate_myaccount_templates', 10, 3 );

function smartnet_locate_myaccount_templates( $template, $template_name, $template_path ) {
    $override_templates = array(
        'myaccount/myaccount.php',
        'myaccount/dashboard.php',
        'myaccount/navigation.php',
        'myaccount/form-login.php',
    );

    if ( ! in_array( $template_name, $override_templates, true ) ) {
        return $template;
    }

    $child_template = get_stylesheet_directory() . '/woocommerce/' . $template_name;

    if ( file_exists( $child_template ) ) {
        return $child_template;
    }

    return $template;
}


// =============================================
// SMARTNET DASHBOARD — CSS & JS ENQUEUE
// =============================================

add_action( 'wp_enqueue_scripts', 'smartnet_myaccount_dashboard_assets' );

function smartnet_myaccount_dashboard_assets() {
    if ( ! function_exists( 'is_account_page' ) || ! is_account_page() ) {
        return;
    }

    wp_enqueue_style(
        'smartnet-myaccount-dashboard',
        get_stylesheet_directory_uri() . '/assets/css/myaccount-dashboard.css',
        array(),
        '1.0.2'
    );

    wp_enqueue_script(
        'smartnet-myaccount-dashboard',
        get_stylesheet_directory_uri() . '/assets/js/myaccount-dashboard.js',
        array(),
        '1.0.2',
        true
    );

    wp_localize_script(
        'smartnet-myaccount-dashboard',
        'smartnetAccount',
        array(
            'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
            'registerNonce' => wp_create_nonce( 'wc_ajax_register_nonce' ),
        )
    );
}


// =============================================
// BODY CLASS — full-width page target karne ke liye
// =============================================

add_filter( 'body_class', 'smartnet_myaccount_body_class' );

function smartnet_myaccount_body_class( $classes ) {
    if ( function_exists( 'is_account_page' ) && is_account_page() ) {
        $classes[] = 'smartnet-myaccount-page';
        $classes[] = 'smartnet-ctf-dashboard-page';
    }
    return $classes;
}


// =============================================
// HIDE DEFAULT WC ELEMENTS (inline CSS override)
// =============================================

add_action( 'wp_head', 'smartnet_hide_default_wc_account_css', 99 );

function smartnet_hide_default_wc_account_css() {
    if ( ! function_exists( 'is_account_page' ) || ! is_account_page() ) {
        return;
    }
    ?>
    <style id="smartnet-wc-override">
        /* === SIDE SPACES HATAO — FULL WIDTH DASHBOARD === */
        body.smartnet-myaccount-page .padding-120,
        body.smartnet-myaccount-page [class*="padding-120"],
        body.smartnet-myaccount-page .feron-page-content-area,
        body.smartnet-myaccount-page .page-content-wrap,
        body.smartnet-myaccount-page [class*="page-content-wrap"],
        body.smartnet-myaccount-page .container,
        body.smartnet-myaccount-page .woocommerce,
        body.smartnet-myaccount-page .entry-content {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        body.smartnet-myaccount-page .smartnet-account-layout {
            width: 100vw !important;
            max-width: 100vw !important;
            margin-left: calc(50% - 50vw) !important;
            margin-right: calc(50% - 50vw) !important;
            border-radius: 0 !important;
        }

        /* Feron theme ka position/width reset — sidebar grid mein sahi rahe */
        .smartnet-account-layout aside.smartnet-sidebar.woocommerce-MyAccount-navigation {
            position: relative !important;
            left: auto !important;
            right: auto !important;
            top: auto !important;
            bottom: auto !important;
            width: auto !important;
            max-width: 100% !important;
            float: none !important;
            transform: none !important;
            z-index: auto !important;
            background: rgba(16, 13, 52, 0.9) !important;
        }
        .smartnet-account-layout { align-items: stretch !important; }
        .smartnet-account-layout .smartnet-account-main.woocommerce-MyAccount-content {
            float: none !important;
            width: auto !important;
            max-width: 100% !important;
            min-width: 0 !important;
        }

        /* Purane WC nav/icon-cards hide karo — lekin SIRF woh jo hamari
           smartnet-sidebar ke bahar hain. Hamari apni navigation hide na ho. */
        .woocommerce-account .woocommerce-MyAccount-navigation:not(.smartnet-sidebar),
        .feron-my-account-navigation,
        .thim-my-account-navigation,
        .hacklayer-account-nav,
        .wc-account-navigation,
        .woocommerce-account .my-account-navigation,
        .woocommerce-account .account-menu {
            display: none !important;
        }

        /* Content full width */
        .woocommerce-MyAccount-content {
            width: 100% !important;
            float: none !important;
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
        }

        /* Default WC text paragraphs band karo */
        .woocommerce-MyAccount-content > p:not([class]),
        .woocommerce-MyAccount-content > p:first-of-type:not([class]) {
            display: none !important;
        }

        /* Theme outer padding hatao */
        .woocommerce-account .woocommerce,
        body.smartnet-myaccount-page .site-main,
        body.smartnet-myaccount-page .content-area,
        body.smartnet-myaccount-page #primary,
        body.smartnet-myaccount-page .entry-content {
            padding: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
        }

        body.smartnet-myaccount-page {
            background: #07051a !important;
        }

        /* Theme ka page-level sidebar completely hide karo */
        body.smartnet-myaccount-page .feron-sidebar,
        body.smartnet-myaccount-page .thim-sidebar,
        body.smartnet-myaccount-page #secondary,
        body.smartnet-myaccount-page .widget-area,
        body.smartnet-myaccount-page .site-sidebar,
        body.smartnet-myaccount-page aside.sidebar,
        body.smartnet-myaccount-page .sidebar-area,
        body.smartnet-myaccount-page [class*="feron-account-sidebar"],
        body.smartnet-myaccount-page .account-page-left-sidebar,
        body.smartnet-myaccount-page .woocommerce-account > .woocommerce > nav,
        body.smartnet-myaccount-page .woocommerce-account .col-left,
        body.smartnet-myaccount-page .woocommerce-account .col-md-3,
        body.smartnet-myaccount-page .woocommerce-account .col-lg-3 {
            display: none !important;
        }

        /* Theme ke content column ko full width karo */
        body.smartnet-myaccount-page .site-content,
        body.smartnet-myaccount-page #content,
        body.smartnet-myaccount-page #primary,
        body.smartnet-myaccount-page .content-area,
        body.smartnet-myaccount-page .entry-content,
        body.smartnet-myaccount-page main.site-main,
        body.smartnet-myaccount-page .woocommerce-account .col-md-9,
        body.smartnet-myaccount-page .woocommerce-account .col-lg-9,
        body.smartnet-myaccount-page .woocommerce-account .col-right {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            float: none !important;
        }

        /* Theme header/footer spacing hatao account page pe */
        body.smartnet-myaccount-page .page-header,
        body.smartnet-myaccount-page .breadcrumb-area,
        body.smartnet-myaccount-page .feron-breadcrumb,
        body.smartnet-myaccount-page .thim-breadcrumb {
            display: none !important;
        }

        body.smartnet-myaccount-page .smartnet-auth-page,
        body.smartnet-myaccount-page #customer_login.smartnet-auth-page {
          display: grid !important;
          grid-template-columns: minmax(280px, 0.88fr) minmax(320px, 1fr) !important;
          gap: 24px !important;
          width: min(1080px, calc(100vw - 32px)) !important;
          max-width: 1080px !important;
          margin: 40px auto !important;
          padding: 22px !important;
          box-sizing: border-box !important;
          float: none !important;
          clear: both !important;
        }

        body.smartnet-myaccount-page .smartnet-auth-page *,
        body.smartnet-myaccount-page .smartnet-auth-page *::before,
        body.smartnet-myaccount-page .smartnet-auth-page *::after {
          box-sizing: border-box !important;
        }

        body.smartnet-myaccount-page .smartnet-auth-card,
        body.smartnet-myaccount-page .smartnet-auth-hero,
        body.smartnet-myaccount-page .smartnet-auth-panel,
        body.smartnet-myaccount-page .smartnet-auth-panel.u-column1,
        body.smartnet-myaccount-page .smartnet-auth-panel.u-column2,
        body.smartnet-myaccount-page .smartnet-auth-panel.col-1,
        body.smartnet-myaccount-page .smartnet-auth-panel.col-2 {
          width: 100% !important;
          max-width: 100% !important;
          min-width: 0 !important;
          float: none !important;
          clear: none !important;
        }

        body.smartnet-myaccount-page .smartnet-auth-card {
          padding: clamp(24px, 4vw, 44px) !important;
        }

        body.smartnet-myaccount-page .smartnet-auth-form,
        body.smartnet-myaccount-page .smartnet-auth-form p,
        body.smartnet-myaccount-page .smartnet-auth-form .form-row,
        body.smartnet-myaccount-page .smartnet-auth-form .woocommerce-form-row {
          width: 100% !important;
          max-width: 100% !important;
          float: none !important;
          clear: none !important;
        }

        body.smartnet-myaccount-page .smartnet-auth-form .form-row,
        body.smartnet-myaccount-page .smartnet-auth-form .woocommerce-form-row {
          display: block !important;
          margin: 0 0 16px !important;
          padding: 0 !important;
        }

        body.smartnet-myaccount-page .smartnet-auth-form label {
          display: block !important;
          width: auto !important;
          max-width: none !important;
          margin: 0 0 7px !important;
          padding: 0 !important;
          color: rgba(255, 255, 255, 0.78) !important;
          font-size: 12px !important;
          font-weight: 750 !important;
          line-height: 1.35 !important;
          letter-spacing: 0.01em !important;
          text-transform: uppercase !important;
          white-space: normal !important;
        }

        body.smartnet-myaccount-page .smartnet-auth-form input[type="text"],
        body.smartnet-myaccount-page .smartnet-auth-form input[type="email"],
        body.smartnet-myaccount-page .smartnet-auth-form input[type="password"],
        body.smartnet-myaccount-page .smartnet-auth-form .woocommerce-Input.input-text,
        body.smartnet-myaccount-page .woocommerce .smartnet-auth-form .input-text {
          display: block !important;
          width: 100% !important;
          max-width: 100% !important;
          min-width: 0 !important;
          height: auto !important;
          min-height: 48px !important;
          margin: 0 !important;
          padding: 14px 16px !important;
          border: 1px solid rgba(255, 255, 255, 0.14) !important;
          border-radius: 14px !important;
          background: rgba(255, 255, 255, 0.07) !important;
          color: #fff !important;
          font-size: 15px !important;
          line-height: 1.3 !important;
          outline: 0 !important;
          box-shadow: none !important;
          appearance: auto !important;
        }

        body.smartnet-myaccount-page .smartnet-auth-form input[type="text"]:focus,
        body.smartnet-myaccount-page .smartnet-auth-form input[type="email"]:focus,
        body.smartnet-myaccount-page .smartnet-auth-form input[type="password"]:focus {
          border-color: rgba(202, 255, 0, 0.65) !important;
          box-shadow: 0 0 0 3px rgba(202, 255, 0, 0.1) !important;
        }

        body.smartnet-myaccount-page .smartnet-auth-actions {
          display: flex !important;
          align-items: center !important;
          justify-content: space-between !important;
          gap: 14px !important;
          margin: 0 0 16px !important;
        }

        body.smartnet-myaccount-page .smartnet-auth-actions .woocommerce-form-login__rememberme {
          display: inline-flex !important;
          align-items: center !important;
          gap: 8px !important;
          margin: 0 !important;
          text-transform: none !important;
          cursor: pointer !important;
        }

        body.smartnet-myaccount-page .smartnet-auth-actions input[type="checkbox"],
        body.smartnet-myaccount-page .smartnet-auth-form input[type="checkbox"] {
          flex: 0 0 auto !important;
          width: 18px !important;
          height: 18px !important;
          min-width: 18px !important;
          min-height: 18px !important;
          margin: 0 !important;
          padding: 0 !important;
          accent-color: #CCFF00 !important;
          appearance: auto !important;
        }

        body.smartnet-myaccount-page .smartnet-auth-actions .woocommerce-form-login__rememberme span {
          display: inline !important;
          color: rgba(255, 255, 255, 0.78) !important;
          font-size: 12px !important;
          line-height: 1.3 !important;
          white-space: nowrap !important;
        }

        body.smartnet-myaccount-page .smartnet-auth-actions a,
        body.smartnet-myaccount-page .toggle-link-section a {
          color: #CCFF00 !important;
        }

        body.smartnet-myaccount-page .smartnet-auth-submit,
        body.smartnet-myaccount-page .woocommerce .smartnet-auth-submit.button,
        body.smartnet-myaccount-page .smartnet-auth-form button.smartnet-auth-submit {
          display: flex !important;
          align-items: center !important;
          justify-content: center !important;
          width: 100% !important;
          max-width: 100% !important;
          min-height: 50px !important;
          margin: 0 !important;
          padding: 15px 18px !important;
          border: 0 !important;
          border-radius: 14px !important;
          background: linear-gradient(135deg, #CCFF00, #00D9FF) !important;
          color: #090818 !important;
          font-size: 14px !important;
          font-weight: 950 !important;
          line-height: 1 !important;
          text-align: center !important;
          box-shadow: 0 16px 34px rgba(82, 85, 255, 0.25) !important;
        }

        @media (max-width: 820px) {
          body.smartnet-myaccount-page .smartnet-auth-page,
          body.smartnet-myaccount-page #customer_login.smartnet-auth-page {
            grid-template-columns: 1fr !important;
            width: calc(100vw - 18px) !important;
            margin: 16px auto !important;
            padding: 16px !important;
          }

          body.smartnet-myaccount-page .smartnet-auth-actions {
            align-items: flex-start !important;
            flex-direction: column !important;
          }
        }

        /* === MOBILE HAMBURGER / SLIDE MENU FIX ===
           Ye block functions.php ke inline CSS mein zaroori hai kyunki upar
           sidebar ko position:relative force kiya gaya hai. Mobile par yahi
           block usko slide-menu banata hai, dashboard full width ko change nahi karta. */
        body.smartnet-myaccount-page .smartnet-mobile-toggle {
            display: none !important;
            position: fixed !important;
            top: 14px !important;
            left: 14px !important;
            z-index: 10001 !important;
            width: 44px !important;
            height: 44px !important;
            border: 0 !important;
            border-radius: 12px !important;
            background: linear-gradient(135deg, #E63946, #C1121F) !important;
            box-shadow: 0 8px 20px rgba(230, 57, 70, 0.45) !important;
            cursor: pointer !important;
            padding: 0 !important;
            align-items: center !important;
            justify-content: center !important;
            flex-direction: column !important;
            gap: 5px !important;
        }

        body.smartnet-myaccount-page .smartnet-mobile-toggle span {
            display: block !important;
            width: 20px !important;
            height: 2px !important;
            background: #fff !important;
            border-radius: 2px !important;
            transition: transform 0.25s ease, opacity 0.25s ease !important;
        }

        body.smartnet-myaccount-page .smartnet-mobile-toggle.is-open span:nth-child(1) {
            transform: translateY(7px) rotate(45deg) !important;
        }

        body.smartnet-myaccount-page .smartnet-mobile-toggle.is-open span:nth-child(2) {
            opacity: 0 !important;
        }

        body.smartnet-myaccount-page .smartnet-mobile-toggle.is-open span:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg) !important;
        }

        body.smartnet-myaccount-page .smartnet-sidebar-overlay {
            display: none !important;
            position: fixed !important;
            inset: 0 !important;
            background: rgba(0, 0, 0, 0.62) !important;
            z-index: 9998 !important;
            backdrop-filter: blur(4px) !important;
        }

        body.smartnet-myaccount-page .smartnet-sidebar-overlay.is-open {
            display: block !important;
        }

        @media (max-width: 1024px) {
            body.smartnet-myaccount-page .smartnet-mobile-toggle {
                display: flex !important;
            }

            body.smartnet-myaccount-page .smartnet-account-layout {
                grid-template-columns: 1fr !important;
                width: 100vw !important;
                max-width: 100vw !important;
                margin-left: calc(50% - 50vw) !important;
                margin-right: calc(50% - 50vw) !important;
                overflow: visible !important;
            }

            body.smartnet-myaccount-page .smartnet-account-main {
                width: 100% !important;
                max-width: 100% !important;
                padding: 72px 14px 20px !important;
                box-sizing: border-box !important;
            }

            body.smartnet-myaccount-page .smartnet-account-layout aside.smartnet-sidebar.woocommerce-MyAccount-navigation,
            body.smartnet-myaccount-page .smartnet-sidebar {
                display: flex !important;
                position: fixed !important;
                top: 0 !important;
                left: -292px !important;
                right: auto !important;
                bottom: auto !important;
                width: 280px !important;
                max-width: 84vw !important;
                height: 100vh !important;
                max-height: 100vh !important;
                z-index: 10000 !important;
                overflow-y: auto !important;
                transform: none !important;
                transition: left 0.3s ease !important;
                border-right: 1px solid rgba(255, 255, 255, 0.1) !important;
                border-bottom: 0 !important;
                box-shadow: 4px 0 30px rgba(0, 0, 0, 0.5) !important;
                background: rgba(16, 13, 52, 0.98) !important;
            }

            body.smartnet-myaccount-page .smartnet-account-layout aside.smartnet-sidebar.woocommerce-MyAccount-navigation.is-open,
            body.smartnet-myaccount-page .smartnet-sidebar.is-open {
                left: 0 !important;
            }

            body.smartnet-myaccount-page .smartnet-dashboard-grid,
            body.smartnet-myaccount-page .smartnet-dashboard-grid {
                grid-template-columns: 1fr !important;
            }

            body.smartnet-myaccount-page .smartnet-stat-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
        }

        @media (max-width: 640px) {
            body.smartnet-myaccount-page .smartnet-account-main {
                padding: 70px 12px 16px !important;
            }

            body.smartnet-myaccount-page .smartnet-stat-grid,
            body.smartnet-myaccount-page .smartnet-dashboard-grid,
            body.smartnet-myaccount-page .smartnet-auth-page,
            body.smartnet-myaccount-page #customer_login.smartnet-auth-page {
                grid-template-columns: 1fr !important;
            }

            body.smartnet-myaccount-page .smartnet-topbar {
                flex-direction: column !important;
                align-items: flex-start !important;
            }
        }

    </style>
    <?php
}


// =============================================
// MOBILE HAMBURGER MARKUP — Dashboard sidebar
// =============================================

add_action( 'wp_footer', 'smartnet_mobile_account_sidebar_markup', 99 );

function smartnet_mobile_account_sidebar_markup() {
    if ( ! function_exists( 'is_account_page' ) || ! is_account_page() || ! is_user_logged_in() ) {
        return;
    }
    ?>
    <button type="button" id="smartnet-menu-toggle" class="smartnet-mobile-toggle" aria-label="<?php esc_attr_e( 'Open account menu', 'woocommerce' ); ?>" aria-controls="smartnet-account-mobile-sidebar" aria-expanded="false">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div id="smartnet-sidebar-overlay" class="smartnet-sidebar-overlay" aria-hidden="true"></div>
    <?php
}


// =============================================
// CTF LINKS — navigation mein extra links
// =============================================

function smartnet_ctf_links() {
    return array(
        'challenges'  => array(
            'label' => __( 'Challenges', 'woocommerce' ),
            'url'   => home_url( '/challenges/' ),
            'icon'  => 'CH',
        ),
        'scoreboard'  => array(
            'label' => __( 'Scoreboard', 'woocommerce' ),
            'url'   => home_url( '/scoreboard/' ),
            'icon'  => 'SB',
        ),
        'submissions' => array(
            'label' => __( 'Submissions', 'woocommerce' ),
            'url'   => home_url( '/submissions/' ),
            'icon'  => 'SU',
        ),
        'team'        => array(
            'label' => __( 'Team', 'woocommerce' ),
            'url'   => home_url( '/team/' ),
            'icon'  => 'TM',
        ),
        'rules'       => array(
            'label' => __( 'Rules', 'woocommerce' ),
            'url'   => home_url( '/rules/' ),
            'icon'  => 'RL',
        ),
    );
}


// =============================================
// MY ACCOUNT MENU LABELS
// =============================================

add_filter( 'woocommerce_account_menu_items', 'smartnet_account_menu_items', 10 );
function smartnet_account_menu_items( $items ) {
    $labels = array(
        'dashboard'       => __( 'Dashboard', 'woocommerce' ),
        'orders'          => __( 'My Orders', 'woocommerce' ),
        'downloads'       => __( 'Downloads', 'woocommerce' ),
        'edit-address'    => __( 'Addresses', 'woocommerce' ),
        'payment-methods' => __( 'Payment', 'woocommerce' ),
        'edit-account'    => __( 'Account Details', 'woocommerce' ),
        'customer-logout' => __( 'Log Out', 'woocommerce' ),
    );
    foreach ( $items as $key => $label ) {
        if ( isset( $labels[ $key ] ) ) {
            $items[ $key ] = $labels[ $key ];
        }
    }
    return $items;
}


// =============================================
// AJAX REGISTRATION
// =============================================

add_action( 'wp_ajax_nopriv_smartnet_ajax_register', 'smartnet_ajax_register' );
add_action( 'wp_ajax_smartnet_ajax_register', 'smartnet_ajax_register' );

function smartnet_ajax_register() {
    if ( ! function_exists( 'wc_create_new_customer' ) ) {
        wp_send_json_error( array( 'message' => __( 'WooCommerce is not available.', 'woocommerce' ) ) );
    }

    check_ajax_referer( 'wc_ajax_register_nonce', 'security' );

    $email    = isset( $_POST['email'] )    ? sanitize_email( wp_unslash( $_POST['email'] ) )          : '';
    $username = isset( $_POST['username'] ) ? wc_clean( wp_unslash( $_POST['username'] ) )             : '';
    $password = isset( $_POST['password'] ) ? (string) wp_unslash( $_POST['password'] )               : '';

    if ( empty( $email ) || ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'woocommerce' ) ) );
    }

    if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) && empty( $username ) ) {
        wp_send_json_error( array( 'message' => __( 'Please enter a username.', 'woocommerce' ) ) );
    }

    if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) && empty( $password ) ) {
        wp_send_json_error( array( 'message' => __( 'Please enter a password.', 'woocommerce' ) ) );
    }

    $validation_error = new WP_Error();
    $validation_error = apply_filters( 'woocommerce_registration_errors', $validation_error, $username, $email );

    if ( $validation_error->get_error_code() ) {
        wp_send_json_error( array( 'message' => $validation_error->get_error_message() ) );
    }

    $customer_id = wc_create_new_customer( $email, $username, $password );

    if ( is_wp_error( $customer_id ) ) {
        wp_send_json_error( array( 'message' => $customer_id->get_error_message() ) );
    }

    wc_set_customer_auth_cookie( $customer_id );

    wp_send_json_success(
        array(
            'message'  => __( 'Registration successful. Redirecting...', 'woocommerce' ),
            'redirect' => wc_get_page_permalink( 'myaccount' ),
        )
    );
}


// =============================================
// WOOCOMMERCE THEME SUPPORT
// =============================================

add_action( 'after_setup_theme', 'smartnet_woocommerce_setup' );
function smartnet_woocommerce_setup() {
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 300,
        'single_image_width'    => 600,
        'product_grid'          => array(
            'default_rows'    => 4,
            'min_rows'        => 1,
            'default_columns' => 4,
            'min_columns'     => 1,
            'max_columns'     => 6,
        ),
    ) );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}


// =============================================
// SECURITY HARDENING
// =============================================

add_action( 'init', 'smartnet_disable_author_enumeration', 1 );
function smartnet_disable_author_enumeration() {
    if ( ! is_admin() && isset( $_GET['author'] ) && ! current_user_can( 'manage_options' ) ) {
        wp_die(
            esc_html__( 'Direct access not allowed.', 'woocommerce' ),
            esc_html__( 'Forbidden', 'woocommerce' ),
            array( 'response' => 403 )
        );
    }
}

add_filter( 'woocommerce_force_ssl_checkout', '__return_true' );
add_filter( 'woocommerce_show_version_in_footer', '__return_false' );
