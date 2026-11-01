<?php
/**
 * Pantalla de ingreso (wp-login.php) con la identidad de la peña:
 * escudo en lugar del logo de WordPress, colores del sitio y el ícono de la pestaña.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function pboca_login_estilos() {
    $logo = esc_url_raw( pboca_img( 'peña.png' ) );
    ?>
    <style>
        body.login { background: #0a1122; }
        body.login #login h1 a {
            background-image: url("<?php echo $logo; ?>");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            box-shadow: 0 0 0 3px #f9be3d, 0 8px 24px rgba(0, 0, 0, 0.5);
            margin: 0 auto 28px auto;
        }
        .login form {
            background: #ffffff;
            border: 0;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        .login #nav a,
        .login #backtoblog a,
        .login .privacy-policy-page-link a,
        .login .language-switcher label,
        .login .language-switcher .dashicons {
            color: #d6dbe5;
        }
        .login #nav a:hover,
        .login #backtoblog a:hover,
        .login .privacy-policy-page-link a:hover {
            color: #f9be3d;
        }
        .login .message,
        .login .notice,
        .login .success {
            border-left-color: #f9be3d;
        }
        .wp-core-ui .button-primary {
            background: #f9be3d;
            border-color: #f9be3d;
            color: #0a1122;
            font-weight: 700;
            text-shadow: none;
            box-shadow: none;
        }
        .wp-core-ui .button-primary:hover,
        .wp-core-ui .button-primary:focus {
            background: #ffd36b;
            border-color: #ffd36b;
            color: #0a1122;
        }
        .login input[type="text"]:focus,
        .login input[type="password"]:focus,
        .login input[type="checkbox"]:focus {
            border-color: #16284f;
            box-shadow: 0 0 0 1px #16284f;
        }
    </style>
    <?php
    // Ícono de la pestaña (esta pantalla no usa wp_head).
    if ( function_exists( 'pboca_favicon' ) ) {
        pboca_favicon();
    }
}
add_action( 'login_head', 'pboca_login_estilos' );

// El escudo lleva al sitio de la peña y no a wordpress.org.
add_filter( 'login_headerurl', function () {
    return home_url( '/' );
} );
add_filter( 'login_headertext', function () {
    return get_bloginfo( 'name' );
} );
