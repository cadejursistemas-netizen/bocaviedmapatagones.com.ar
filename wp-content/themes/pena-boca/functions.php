<?php
// Evitar acceso directo
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function pboca_configuracion_tema() {
    // Soporte para etiquetas de título automáticas
    add_theme_support( 'title-tag' );

    // Soporte para imágenes destacadas (thumbnails)
    add_theme_support( 'post-thumbnails' );

    // Registrar el menú de navegación principal
    register_nav_menus( array(
        'menu_principal' => 'Menú Principal (Cabecera)',
    ) );
}
add_action( 'after_setup_theme', 'pboca_configuracion_tema' );

function pboca_cargar_scripts() {
    // Cargar la hoja de estilos principal (style.css)
    wp_enqueue_style( 'pboca-style', get_stylesheet_uri(), array(), '1.0' );
    
    // Acá podés sumar Google Fonts para la tipografía de Boca (ej: Russo One y Montserrat)
    wp_enqueue_style( 'pboca-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Russo+One&display=swap', false );
}
add_action( 'wp_enqueue_scripts', 'pboca_cargar_scripts' );