<?php
/**
 * Contenido editable desde el panel de WordPress:
 *  - Autoridades   (menú "Autoridades")
 *  - Afiches de Marca (menú "Afiches")
 *  - Preguntas frecuentes (menú "Preguntas frecuentes")
 *
 * Si todavía no se cargó nada en el panel, el sitio muestra el contenido original
 * (los datos de abajo), así que nunca queda vacío. Para pasar ese contenido al panel
 * y poder editarlo: Herramientas → "Importar contenido de la Peña".
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ==========================================================
   1. Contenido original (se usa si el panel está vacío)
   ========================================================== */
function pboca_defaults_autoridades() {
    return array(
        array( 'grupo' => 'principal', 'cargo' => 'Presidenta',         'nombre' => 'Florencia Gastaminza',       'foto' => 'presidenta.webp' ),
        array( 'grupo' => 'principal', 'cargo' => 'Secretaria General', 'nombre' => 'María Sol Taraborrelli',     'foto' => 'secretaria-general.webp' ),
        array( 'grupo' => 'principal', 'cargo' => 'Tesorero',           'nombre' => 'Juan Marcos González',       'foto' => 'tesorero.webp' ),
        array( 'grupo' => 'vocal',     'cargo' => 'Viajes',             'nombre' => 'Facundo Mendoza',            'foto' => 'viajes.webp' ),
        array( 'grupo' => 'vocal',     'cargo' => 'Streaming',          'nombre' => 'Lautaro Iriondo',            'foto' => 'streaming.webp' ),
        array( 'grupo' => 'vocal',     'cargo' => 'Socixs Peña',        'nombre' => 'Pablo Zeki',                 'foto' => 'socixs-pena.webp' ),
        array( 'grupo' => 'vocal',     'cargo' => 'Socixs Boca',        'nombre' => 'María Victoria Rodríguez',   'foto' => 'socixs-boca.webp' ),
        array( 'grupo' => 'vocal',     'cargo' => 'Acción Social',      'nombre' => 'Aldana Jauge',               'foto' => 'accion-social.webp' ),
        array( 'grupo' => 'revisor',   'cargo' => 'Revisor de cuentas', 'nombre' => 'Alfonso Gimenez',           'foto' => 'revisor-de-cuentas.webp' ),
    );
}

function pboca_defaults_afiches() {
    return array(
        array( 'titulo' => 'Campera',  'img' => 'marca-campera.webp',  'boton' => 'Pedir campera por WhatsApp',  'whatsapp' => '5492920405196', 'mensaje' => 'Hola! Quiero encargar la campera de la Peña' ),
        array( 'titulo' => 'Chomba',   'img' => 'marca-chomba.webp',   'boton' => 'Pedir chomba por WhatsApp',   'whatsapp' => '5492920545899', 'mensaje' => 'Hola! Quiero pedir la chomba en preventa' ),
        array( 'titulo' => 'Camiseta', 'img' => 'marca-camiseta.webp', 'boton' => 'Pedir camiseta por WhatsApp', 'whatsapp' => '5492920405196', 'mensaje' => 'Hola! Quiero pedir la camiseta de la Peña' ),
    );
}

function pboca_defaults_faqs() {
    return array(
        array( 'pregunta' => '¿Cuánto sale la cuota de la Peña?', 'respuesta' => '<p>¡Solo $5.000 por mes! Una forma de ayudar a sostener la institución bostera de la Comarca.</p>' ),
        array( 'pregunta' => '¿Cuánto cuesta la entrada para ver un partido en la sede?', 'respuesta' => '<p>¡Es gratuita! Si consumís algo, eso nos ayuda. Pero no es obligatorio tampoco.</p>' ),
        array( 'pregunta' => '¿Necesito ser socio para ir a la sede, viajar o participar de las actividades?', 'respuesta' => '<p>¡No! No necesitás ser socio de la Peña ni de Boca.</p>
<p><strong>Único requisito: ser hincha de Boca.</strong></p>' ),
        array( 'pregunta' => '¿Es lo mismo ser socio/a de la Peña que ser socio/a de Boca?', 'respuesta' => '<p>No, son dos cosas diferentes.</p>
<p>🔹 Ser socio de la Peña te permite formar parte de nuestra comunidad bostera de Viedma y Patagones, con beneficios vinculados a las actividades y propuestas que organizamos desde acá.</p>
<p>🔹 Ser socio de Boca significa asociarte directamente al Club Atlético Boca Juniors y acceder a los beneficios que ofrece el club, de acuerdo con la categoría de socio.</p>
<p>¡Y hay algo más! Desde la Peña podemos acompañarte directamente: te gestionamos la impresión del carnet y te ayudamos con las gestiones.</p>' ),
        array( 'pregunta' => '¿Cómo puedo colaborar con la Peña?', 'respuesta' => '<p>¡Hay muchas formas de dar una mano!</p>
<p>💙 <strong>Donando:</strong> muebles, objetos de decoración de Boca, banderas o cualquier elemento que pueda servir para nuestro local.</p>
<p>💛 <strong>Proponiendo ideas y tu voluntad de participar activamente:</strong> compartiendo iniciativas y propuestas para seguir creciendo.</p>
<p>💙 <strong>Haciéndote socio/a y motivando a tus amistades a asociarse:</strong> mientras más seamos, más vamos a poder generar para la gente de Boca.</p>' )
    );
}

/* ==========================================================
   2. Tipos de contenido
   ========================================================== */
function pboca_registrar_tipos() {
    $comunes = array(
        'public'              => false,
        'show_ui'             => true,
        'show_in_rest'        => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'has_archive'         => false,
        'rewrite'             => false,
        'capability_type'     => 'post',
    );

    register_post_type( 'pboca_autoridad', array_merge( $comunes, array(
        'labels'        => array(
            'name' => 'Autoridades', 'singular_name' => 'Autoridad', 'add_new' => 'Añadir autoridad',
            'add_new_item' => 'Añadir autoridad', 'edit_item' => 'Editar autoridad', 'all_items' => 'Todas las autoridades',
            'menu_name' => 'Autoridades', 'not_found' => 'No hay autoridades cargadas.',
        ),
        'menu_icon'     => 'dashicons-groups',
        'menu_position' => 26,
        'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
    ) ) );

    register_post_type( 'pboca_afiche', array_merge( $comunes, array(
        'labels'        => array(
            'name' => 'Afiches', 'singular_name' => 'Afiche', 'add_new' => 'Añadir afiche',
            'add_new_item' => 'Añadir afiche', 'edit_item' => 'Editar afiche', 'all_items' => 'Todos los afiches',
            'menu_name' => 'Afiches de Marca', 'not_found' => 'No hay afiches cargados.',
        ),
        'menu_icon'     => 'dashicons-tag',
        'menu_position' => 27,
        'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
    ) ) );

    register_post_type( 'pboca_faq', array_merge( $comunes, array(
        'labels'        => array(
            'name' => 'Preguntas frecuentes', 'singular_name' => 'Pregunta', 'add_new' => 'Añadir pregunta',
            'add_new_item' => 'Añadir pregunta', 'edit_item' => 'Editar pregunta', 'all_items' => 'Todas las preguntas',
            'menu_name' => 'Preguntas frecuentes', 'not_found' => 'No hay preguntas cargadas.',
        ),
        'menu_icon'     => 'dashicons-editor-help',
        'menu_position' => 28,
        'supports'      => array( 'title', 'editor', 'page-attributes' ),
    ) ) );
}
add_action( 'init', 'pboca_registrar_tipos' );

/* ==========================================================
   3. Campos extra en el editor
   ========================================================== */
function pboca_cajas_meta() {
    add_meta_box( 'pboca_autoridad_datos', 'Datos de la autoridad', 'pboca_caja_autoridad', 'pboca_autoridad', 'normal', 'high' );
    add_meta_box( 'pboca_afiche_datos', 'Botón de pedido por WhatsApp', 'pboca_caja_afiche', 'pboca_afiche', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'pboca_cajas_meta' );

function pboca_caja_autoridad( $post ) {
    wp_nonce_field( 'pboca_guardar_meta', 'pboca_nonce' );
    $cargo = get_post_meta( $post->ID, '_pboca_cargo', true );
    $grupo = get_post_meta( $post->ID, '_pboca_grupo', true );
    if ( ! $grupo ) { $grupo = 'vocal'; }
    ?>
    <p><label for="pboca_cargo"><strong>Cargo o área</strong> (ej.: Presidenta, Viajes)</label><br>
    <input type="text" id="pboca_cargo" name="pboca_cargo" value="<?php echo esc_attr( $cargo ); ?>" style="width:100%"></p>
    <p><label for="pboca_grupo"><strong>Dónde se muestra</strong></label><br>
    <select id="pboca_grupo" name="pboca_grupo">
        <option value="principal" <?php selected( $grupo, 'principal' ); ?>>Autoridades (fila de arriba)</option>
        <option value="vocal" <?php selected( $grupo, 'vocal' ); ?>>Vocales y áreas a cargo</option>
        <option value="revisor" <?php selected( $grupo, 'revisor' ); ?>>Revisor de cuentas (abajo)</option>
    </select></p>
    <p class="description">El <strong>título</strong> de arriba es el nombre de la persona. La <strong>foto</strong> se carga en "Imagen destacada" (columna derecha). El <strong>orden</strong> se cambia en "Atributos → Orden" (número menor, aparece primero).</p>
    <?php
}

function pboca_caja_afiche( $post ) {
    wp_nonce_field( 'pboca_guardar_meta', 'pboca_nonce' );
    $boton = get_post_meta( $post->ID, '_pboca_boton', true );
    $wa    = get_post_meta( $post->ID, '_pboca_whatsapp', true );
    $msg   = get_post_meta( $post->ID, '_pboca_mensaje', true );
    ?>
    <p><label for="pboca_boton"><strong>Texto del botón</strong></label><br>
    <input type="text" id="pboca_boton" name="pboca_boton" value="<?php echo esc_attr( $boton ); ?>" style="width:100%" placeholder="Pedir campera por WhatsApp"></p>
    <p><label for="pboca_whatsapp"><strong>Número de WhatsApp</strong> (con 549 y código de área, sin espacios ni signos)</label><br>
    <input type="text" id="pboca_whatsapp" name="pboca_whatsapp" value="<?php echo esc_attr( $wa ); ?>" style="width:100%" placeholder="5492920405196"></p>
    <p><label for="pboca_mensaje"><strong>Mensaje que llega escrito</strong></label><br>
    <input type="text" id="pboca_mensaje" name="pboca_mensaje" value="<?php echo esc_attr( $msg ); ?>" style="width:100%" placeholder="Hola! Quiero pedir la campera"></p>
    <p class="description">El <strong>título</strong> es el nombre del producto. El <strong>afiche</strong> se carga en "Imagen destacada" (columna derecha).</p>
    <?php
}

function pboca_guardar_meta( $post_id ) {
    if ( ! isset( $_POST['pboca_nonce'] ) || ! wp_verify_nonce( $_POST['pboca_nonce'], 'pboca_guardar_meta' ) ) { return; }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
    if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }

    $campos = array(
        'pboca_cargo'    => '_pboca_cargo',
        'pboca_boton'    => '_pboca_boton',
        'pboca_whatsapp' => '_pboca_whatsapp',
        'pboca_mensaje'  => '_pboca_mensaje',
    );
    foreach ( $campos as $campo => $meta ) {
        if ( isset( $_POST[ $campo ] ) ) {
            $valor = sanitize_text_field( wp_unslash( $_POST[ $campo ] ) );
            if ( 'pboca_whatsapp' === $campo ) { $valor = preg_replace( '/\D+/', '', $valor ); }
            update_post_meta( $post_id, $meta, $valor );
        }
    }
    if ( isset( $_POST['pboca_grupo'] ) && in_array( $_POST['pboca_grupo'], array( 'principal', 'vocal', 'revisor' ), true ) ) {
        update_post_meta( $post_id, '_pboca_grupo', $_POST['pboca_grupo'] );
    }
}
add_action( 'save_post', 'pboca_guardar_meta' );

/* ==========================================================
   4. Funciones que usan las páginas del sitio
   ========================================================== */
function pboca_consulta( $tipo ) {
    return get_posts( array(
        'post_type'   => $tipo,
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby'     => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
    ) );
}

/** Autoridades de un grupo: 'principal', 'vocal' o 'revisor'. */
function pboca_get_autoridades( $grupo ) {
    $posts = pboca_consulta( 'pboca_autoridad' );
    $out   = array();
    if ( $posts ) {
        foreach ( $posts as $p ) {
            $g = get_post_meta( $p->ID, '_pboca_grupo', true );
            if ( ! $g ) { $g = 'vocal'; }
            if ( $g !== $grupo ) { continue; }
            $foto = get_the_post_thumbnail_url( $p->ID, 'medium' );
            $out[] = array(
                'cargo'  => get_post_meta( $p->ID, '_pboca_cargo', true ),
                'nombre' => $p->post_title,
                'foto'   => $foto ? $foto : '',
            );
        }
        return $out;
    }
    foreach ( pboca_defaults_autoridades() as $d ) {
        if ( $d['grupo'] !== $grupo ) { continue; }
        $out[] = array(
            'cargo'  => $d['cargo'],
            'nombre' => $d['nombre'],
            'foto'   => get_template_directory_uri() . '/images/autoridades/' . $d['foto'],
        );
    }
    return $out;
}

/** Afiches de Marca con su botón de WhatsApp. */
function pboca_get_afiches() {
    $posts = pboca_consulta( 'pboca_afiche' );
    $out   = array();
    if ( $posts ) {
        foreach ( $posts as $p ) {
            $img = get_the_post_thumbnail_url( $p->ID, 'large' );
            if ( ! $img ) { continue; }
            $out[] = array(
                'titulo'   => $p->post_title,
                'img'      => $img,
                'boton'    => get_post_meta( $p->ID, '_pboca_boton', true ),
                'whatsapp' => get_post_meta( $p->ID, '_pboca_whatsapp', true ),
                'mensaje'  => get_post_meta( $p->ID, '_pboca_mensaje', true ),
            );
        }
        return $out;
    }
    foreach ( pboca_defaults_afiches() as $d ) {
        $out[] = array(
            'titulo'   => $d['titulo'],
            'img'      => get_template_directory_uri() . '/images/' . $d['img'],
            'boton'    => $d['boton'],
            'whatsapp' => $d['whatsapp'],
            'mensaje'  => $d['mensaje'],
        );
    }
    return $out;
}

/** Preguntas frecuentes: cada una con 'pregunta' y 'respuesta' (HTML ya limpio). */
function pboca_get_faqs() {
    $posts = pboca_consulta( 'pboca_faq' );
    $out   = array();
    if ( $posts ) {
        foreach ( $posts as $p ) {
            $out[] = array(
                'pregunta'  => $p->post_title,
                'respuesta' => wpautop( wp_kses_post( $p->post_content ) ),
            );
        }
        return $out;
    }
    foreach ( pboca_defaults_faqs() as $d ) {
        $out[] = array( 'pregunta' => $d['pregunta'], 'respuesta' => $d['respuesta'] );
    }
    return $out;
}

/* ==========================================================
   5. Importar el contenido actual al panel (Herramientas)
   ========================================================== */
function pboca_menu_importar() {
    add_management_page( 'Importar contenido de la Peña', 'Importar contenido de la Peña', 'manage_options', 'pboca-importar', 'pboca_pagina_importar' );
}
add_action( 'admin_menu', 'pboca_menu_importar' );

function pboca_adjuntar_imagen( $post_id, $ruta, $titulo ) {
    if ( ! file_exists( $ruta ) ) { return; }
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $subida = wp_upload_bits( wp_basename( $ruta ), null, file_get_contents( $ruta ) );
    if ( ! empty( $subida['error'] ) ) { return; }
    $tipo = wp_check_filetype( $subida['file'] );
    $adj  = wp_insert_attachment( array(
        'post_mime_type' => $tipo['type'] ? $tipo['type'] : 'image/webp',
        'post_title'     => $titulo,
        'post_status'    => 'inherit',
    ), $subida['file'], $post_id );
    if ( $adj && ! is_wp_error( $adj ) ) {
        wp_update_attachment_metadata( $adj, wp_generate_attachment_metadata( $adj, $subida['file'] ) );
        set_post_thumbnail( $post_id, $adj );
    }
}

function pboca_importar_contenido() {
    $res  = array( 'autoridades' => 0, 'afiches' => 0, 'faqs' => 0 );
    $base = get_template_directory() . '/images/';

    if ( ! pboca_consulta( 'pboca_autoridad' ) ) {
        foreach ( pboca_defaults_autoridades() as $i => $d ) {
            $id = wp_insert_post( array( 'post_type' => 'pboca_autoridad', 'post_status' => 'publish', 'post_title' => $d['nombre'], 'menu_order' => $i ) );
            if ( $id && ! is_wp_error( $id ) ) {
                update_post_meta( $id, '_pboca_cargo', $d['cargo'] );
                update_post_meta( $id, '_pboca_grupo', $d['grupo'] );
                pboca_adjuntar_imagen( $id, $base . 'autoridades/' . $d['foto'], $d['nombre'] );
                $res['autoridades']++;
            }
        }
    }
    if ( ! pboca_consulta( 'pboca_afiche' ) ) {
        foreach ( pboca_defaults_afiches() as $i => $d ) {
            $id = wp_insert_post( array( 'post_type' => 'pboca_afiche', 'post_status' => 'publish', 'post_title' => $d['titulo'], 'menu_order' => $i ) );
            if ( $id && ! is_wp_error( $id ) ) {
                update_post_meta( $id, '_pboca_boton', $d['boton'] );
                update_post_meta( $id, '_pboca_whatsapp', $d['whatsapp'] );
                update_post_meta( $id, '_pboca_mensaje', $d['mensaje'] );
                pboca_adjuntar_imagen( $id, $base . $d['img'], $d['titulo'] );
                $res['afiches']++;
            }
        }
    }
    if ( ! pboca_consulta( 'pboca_faq' ) ) {
        foreach ( pboca_defaults_faqs() as $i => $d ) {
            $id = wp_insert_post( array( 'post_type' => 'pboca_faq', 'post_status' => 'publish', 'post_title' => $d['pregunta'], 'post_content' => $d['respuesta'], 'menu_order' => $i ) );
            if ( $id && ! is_wp_error( $id ) ) { $res['faqs']++; }
        }
    }
    return $res;
}

function pboca_pagina_importar() {
    if ( ! current_user_can( 'manage_options' ) ) { return; }
    echo '<div class="wrap"><h1>Importar contenido de la Peña</h1>';
    if ( isset( $_POST['pboca_importar'] ) && check_admin_referer( 'pboca_importar_accion' ) ) {
        $r = pboca_importar_contenido();
        printf( '<div class="notice notice-success"><p>Listo: %d autoridades, %d afiches y %d preguntas importadas. Ya podés editarlas desde el menú de la izquierda.</p></div>', (int) $r['autoridades'], (int) $r['afiches'], (int) $r['faqs'] );
    }
    echo '<p>Copia al panel las autoridades, los afiches de Marca y las preguntas frecuentes que hoy están en el sitio, para que puedas editarlas sin tocar código.</p>';
    echo '<p>Solo importa lo que todavía no tiene nada cargado: si ya hay autoridades, afiches o preguntas en el panel, no las toca ni las duplica.</p>';
    echo '<form method="post">';
    wp_nonce_field( 'pboca_importar_accion' );
    echo '<p><button type="submit" name="pboca_importar" value="1" class="button button-primary">Importar contenido actual</button></p></form></div>';
}
