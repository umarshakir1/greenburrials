<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' );

$raw_action          = isset( $_GET['action'] ) ? wp_unslash( $_GET['action'] ) : '';
$requested_action     = sanitize_key( $raw_action );
$is_register_view     = ( 'register' === $requested_action );
global $wp_query;
$is_comparison        = is_wc_endpoint_url( 'comparison' ) || isset( $wp_query->query_vars['comparison'] );
$account_page_url     = wc_get_page_permalink( 'myaccount' );
$login_url            = remove_query_arg( 'action', $account_page_url );
$register_url         = add_query_arg( 'action', 'register', $login_url );

if ( $is_comparison ) {
    $current_crumb_label = 'Comparison';
} else {
    $current_crumb_label = $is_register_view ? 'Register' : 'Login';
}
?>

<div class="account-page-wrapper container">
    <div class="account-grid">
        <!-- Main Content -->
        <div class="account-main-content">
            <div class="account-breadcrumb">
                <a href="<?php echo home_url(); ?>"><i class="fa fa-home"></i></a> &gt; Account &gt; <span class="account-breadcrumb-current"><?php echo esc_html( $current_crumb_label ); ?></span>
            </div>

            <?php if ( $is_comparison ) : ?>
                <div class="account-comparison-section">
                    <?php 
                    if ( function_exists( 'green_burials_comparison_content' ) ) {
                        green_burials_comparison_content(); 
                    } else {
                        echo '<p>Comparison feature is currently unavailable.</p>';
                    }
                    ?>
                </div>
            <?php else : ?>
                <div class="login-register-flex"<?php echo $is_register_view ? ' style="display: none;"' : ''; ?>>
                    <!-- New Customer Column -->
                    <div class="account-card new-customer-card">
                        <h2 class="card-title">New Customer</h2>
                        <div class="card-body">
                            <h3>Register Account</h3>
                            <p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
                            <div class="card-footer">
                                <button type="button" class="btn-continue" id="toggleRegister">CONTINUE</button>
                            </div>
                        </div>
                    </div>

                    <!-- Returning Customer Column -->
                    <div class="account-card returning-customer-card">
                        <h2 class="card-title">Returning Customer</h2>
                        <div class="card-body">
                            <h3>I am a returning customer</h3>
                            <form class="woocommerce-form woocommerce-form-login login" method="post">
                                <?php do_action( 'woocommerce_login_form_start' ); ?>
                                
                                <p class="form-row">
                                    <label for="username">E-Mail Address</label>
                                    <input type="text" class="input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
                                </p>
                                <p class="form-row">
                                    <label for="password">Password</label>
                                    <input class="input-text" type="password" name="password" id="password" autocomplete="current-password" />
                                </p>

                                <?php do_action( 'woocommerce_login_form' ); ?>

                                <p class="lost_password">
                                    <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">Forgotten Password</a>
                                </p>

                                <div class="card-footer">
                                    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                                    <button type="submit" class="btn-login" name="login" value="LOGIN">LOGIN</button>
                                </div>

                                <?php do_action( 'woocommerce_login_form_end' ); ?>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Registration Form (Hidden by default) -->
                <div class="registration-form-wrapper" id="registrationForm" style="margin-top: 30px; display: <?php echo esc_attr( $is_register_view ? 'block' : 'none' ); ?>;">
                    <h2 class="card-title">Register Account</h2>
                    <div class="registration-card-body">
                        <p>If you already have an account with us, please login at the login page.</p>
                        
                        <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
                            <?php do_action( 'woocommerce_register_form_start' ); ?>

                            <div class="form-section">
                                <h3>Your Personal Details</h3>
                                <div class="horizontal-form-row">
                                    <label for="reg_billing_first_name">First Name <span class="required">*</span></label>
                                    <div class="input-wrapper">
                                        <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" placeholder="First Name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
                                    </div>
                                </div>
                                <div class="horizontal-form-row">
                                    <label for="reg_billing_last_name">Last Name <span class="required">*</span></label>
                                    <div class="input-wrapper">
                                        <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" placeholder="Last Name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
                                    </div>
                                </div>
                                <div class="horizontal-form-row">
                                    <label for="reg_email">E-Mail <span class="required">*</span></label>
                                    <div class="input-wrapper">
                                        <input type="email" class="input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h3>Your Password</h3>
                                <div class="horizontal-form-row">
                                    <label for="reg_password">Password <span class="required">*</span></label>
                                    <div class="input-wrapper">
                                        <input type="password" class="input-text" name="password" id="reg_password" autocomplete="new-password" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h3>Newsletter</h3>
                                <div class="horizontal-form-row">
                                    <label>Subscribe</label>
                                    <div class="input-wrapper">
                                        <label class="switch">
                                            <input type="checkbox" name="newsletter_subscribe" value="1">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <?php do_action( 'woocommerce_register_form' ); ?>

                            <div class="registration-footer">
                                <div class="privacy-policy-wrapper">
                                    <label class="switch-mini">
                                        <input type="checkbox" name="privacy_policy" required>
                                        <span class="slider round"></span>
                                    </label>
                                    <span class="privacy-text">I have read and agree to the <a href="<?php echo get_privacy_policy_url(); ?>" target="_blank">Privacy Policy</a></span>
                                </div>
                                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                                <button type="submit" class="btn-continue" name="register" value="CONTINUE">CONTINUE</button>
                            </div>

                            <?php do_action( 'woocommerce_register_form_end' ); ?>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="account-sidebar">
            <ul class="account-nav-list">
                <li class="login-link <?php echo ( ! $is_comparison && ! $is_register_view ) ? 'active' : ''; ?>"><a href="<?php echo esc_url( $login_url ); ?>">Login</a></li>
                <li class="register-link <?php echo $is_register_view ? 'active' : ''; ?>"><a href="<?php echo esc_url( $register_url ); ?>" id="sidebarRegister">Register</a></li>
                <li><a href="<?php echo wp_lostpassword_url(); ?>">Forgotten Password</a></li>
                <li><a href="<?php echo wc_get_endpoint_url('edit-account'); ?>">My Account</a></li>
                <li><a href="<?php echo wc_get_endpoint_url('edit-address'); ?>">Address Book</a></li>
                <li><a href="<?php echo home_url('/wishlist'); ?>">Wish List</a></li>
                <li class="<?php echo $is_comparison ? 'active' : ''; ?>">
                    <a href="<?php echo esc_url( trailingslashit( $account_page_url ) . 'comparison/' ); ?>">Comparison</a>
                </li>
                <li><a href="<?php echo wc_get_endpoint_url('orders'); ?>">Order History</a></li>
                <li><a href="<?php echo wc_get_endpoint_url('downloads'); ?>">Downloads</a></li>
                <li><a href="<?php echo wc_get_endpoint_url('orders'); ?>#returns">Returns</a></li>
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleRegister');
    const sidebarRegBtn = document.getElementById('sidebarRegister');
    const regForm = document.getElementById('registrationForm');
    const loginFlex = document.querySelector('.login-register-flex');
    const breadcrumbCurrent = document.querySelector('.account-breadcrumb-current');
    const loginNavItem = document.querySelector('.account-nav-list .login-link');
    const registerNavItem = document.querySelector('.account-nav-list .register-link');
    const initialRegister = <?php echo wp_json_encode( $is_register_view ); ?>;

    function setActiveState(isRegister) {
        if (breadcrumbCurrent) {
            breadcrumbCurrent.textContent = isRegister ? 'Register' : 'Login';
        }
        if (loginNavItem) {
            loginNavItem.classList.toggle('active', !isRegister);
        }
        if (registerNavItem) {
            registerNavItem.classList.toggle('active', isRegister);
        }
    }

    function updateUrl(isRegister) {
        if (!window.history || !window.history.replaceState) {
            return;
        }

        try {
            const url = new URL(window.location.href);
            if (isRegister) {
                url.searchParams.set('action', 'register');
            } else {
                url.searchParams.delete('action');
            }
            window.history.replaceState(null, '', url.toString());
        } catch (error) {
            return;
        }
    }

    function showRegister(updateHistory = false) {
        if (regForm && loginFlex) {
            regForm.style.display = 'block';
            loginFlex.style.display = 'none';
            setActiveState(true);
            if (updateHistory) {
                updateUrl(true);
            }
        }
    }

    function showLogin(updateHistory = false) {
        if (regForm && loginFlex) {
            regForm.style.display = 'none';
            loginFlex.style.display = '';
            setActiveState(false);
            if (updateHistory) {
                updateUrl(false);
            }
        }
    }

    if (initialRegister) {
        showRegister();
    } else {
        showLogin();
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            showRegister(true);
        });
    }

    if (sidebarRegBtn && sidebarRegBtn.getAttribute('href') === '#') {
        sidebarRegBtn.addEventListener('click', function(e) {
            e.preventDefault();
            showRegister(true);
        });
    }

    if (window.location.hash.replace('#', '') === 'register') {
        showRegister(true);
    }
});
</script>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
