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
    
    // Tipografías alojadas en el propio tema (Montserrat y Russo One): sin pedidos a Google
    wp_enqueue_style( 'pboca-fonts', get_template_directory_uri() . '/fonts/fonts.css', array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'pboca_cargar_scripts' );

// Precargar las fuentes principales para que el texto aparezca más rápido
function pboca_precargar_fuentes() {
    $base = get_template_directory_uri() . '/fonts/';
    foreach ( array( 'montserrat-latin.woff2', 'russo-one-latin.woff2' ) as $f ) {
        echo '<link rel="preload" href="' . esc_url( $base . $f ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
    }
}
add_action( 'wp_head', 'pboca_precargar_fuentes', 1 );

// Ícono de la pestaña (favicon) con el escudo de la peña
function pboca_favicon() {
    $base = get_template_directory_uri() . '/icons/';
    echo '<link rel="icon" href="' . esc_url( $base . 'favicon.ico' ) . '" sizes="any">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url( $base . 'favicon-32.png' ) . '">' . "\n";
    // Google pide un ícono cuadrado de un múltiplo de 48 px (48, 96, 144, 192...)
    echo '<link rel="icon" type="image/png" sizes="48x48" href="' . esc_url( $base . 'favicon-48.png' ) . '">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="96x96" href="' . esc_url( $base . 'favicon-96.png' ) . '">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="192x192" href="' . esc_url( $base . 'icon-192.png' ) . '">' . "\n";
    echo '<link rel="apple-touch-icon" href="' . esc_url( $base . 'apple-touch-icon.png' ) . '">' . "\n";
    echo '<meta name="theme-color" content="#0a1122">' . "\n";
}
add_action( 'wp_head', 'pboca_favicon', 2 );

// Descripción y vista previa al compartir (WhatsApp, Instagram, Facebook, Google)
function pboca_datos_compartir() {
    $descripciones = array(
        'inicio'               => 'Peña Oficial Boca Juniors de Viedma-Patagones: el único espacio de la Comarca con reconocimiento oficial del Club Atlético Boca Juniors. Sede, viajes, actividades y comunidad bostera.',
        'pena-oficial'         => 'Somos el único espacio de la Comarca con reconocimiento oficial de Boca Juniors. Te ayudamos con las gestiones y participamos de la vida institucional del CABJ.',
        'institucional'        => 'Historia, principios, reconocimientos y autoridades de la Peña Oficial Boca Viedma Patagones.',
        'ser-parte'            => 'Hacete socio/a de la Peña: cuota accesible, beneficios y ayuda con tus gestiones del Club.',
        'sede'                 => 'La única sede oficial del Club Atlético Boca Juniors en la Comarca. Abierta cada vez que juega Boca y en todas las actividades.',
        'streaming'            => 'De la Boca para afuera: previa, análisis y debate todos los viernes en nuestro canal de YouTube.',
        'actividades'          => 'Torneos de PlayStation y truco, intercambio de figuritas, catas de vino, fútbol y más. Propuestas para todos los gustos y edades.',
        'viajes'               => 'Viajá con la Peña a la Bombonera: entrada garantizada, traslado, cena en La Boca, paseo por Caminito y sorteos.',
        'marca'                => 'Nuestra propia marca de indumentaria y productos: campera, chomba, camiseta, stickers, vasos, llaveros, piluso y gorra.',
        'desde-la-cuna'        => 'El amor por Boca se transmite de generación en generación. Espacio de juegos y juguetes para los más chiquitos.',
        'bosteras'             => 'Un espacio exclusivo para bosteras dentro de la Peña. Queremos que cada vez seamos más las que estemos cerca.',
        'accion-social'        => 'Campañas solidarias de la Peña, como las jornadas de donación de sangre en Viedma y Patagones.',
        'futbol'               => 'Tres turnos fijos de fútbol por semana, con un espacio de fútbol femenino y jornadas de fútbol mixto con tercer tiempo.',
        'galeria'              => 'Fotos de la sede, los partidos y la gente bostera de la Peña Oficial Viedma-Patagones.',
        'preguntas-frecuentes' => 'Cuánto sale la cuota, si hace falta ser socio, cómo colaborar y más respuestas sobre la Peña.',
        'contacto'             => 'Escribinos por WhatsApp para consultas, gestiones del Club y para sumarte a la Peña.',
    );

    $slug = is_front_page() ? 'inicio' : ( is_page() ? get_post_field( 'post_name', get_queried_object_id() ) : '' );
    $base = get_template_directory_uri() . '/images/og/';
    $dir  = get_template_directory() . '/images/og/';
    $img  = ( $slug && file_exists( $dir . $slug . '.jpg' ) ) ? $slug . '.jpg' : 'default.jpg';

    $desc  = isset( $descripciones[ $slug ] ) ? $descripciones[ $slug ] : $descripciones['inicio'];
    $title = wp_get_document_title();
    $url   = is_front_page() ? home_url( '/' ) : ( is_singular() ? get_permalink() : home_url( '/' ) );

    echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
    echo '<meta property="og:locale" content="es_AR">' . "\n";
    echo '<meta property="og:site_name" content="Peña Oficial Boca Viedma Patagones">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
    echo '<meta property="og:image" content="' . esc_url( $base . $img ) . '">' . "\n";
    echo '<meta property="og:image:width" content="1200">' . "\n";
    echo '<meta property="og:image:height" content="630">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
}
add_action( 'wp_head', 'pboca_datos_compartir', 3 );

// Versión automática en las imágenes del tema (evita ver fotos viejas guardadas)
require_once get_template_directory() . '/inc/imagenes.php';

// Contenido editable desde el panel (autoridades, afiches, preguntas frecuentes)
require_once get_template_directory() . '/inc/contenido-editable.php';

// La dirección /favicon.ico tiene que mostrar el escudo de la peña. Si no, WordPress muestra el logo "W" de WordPress.
function pboca_servir_favicon() {
    $archivo = get_template_directory() . '/icons/favicon.ico';
    if ( ! is_file( $archivo ) ) {
        return;
    }
    status_header( 200 );
    header( 'Content-Type: image/x-icon' );
    header( 'Content-Length: ' . filesize( $archivo ) );
    header( 'Cache-Control: public, max-age=604800' );
    readfile( $archivo );
    exit;
}
add_action( 'do_faviconico', 'pboca_servir_favicon' );
