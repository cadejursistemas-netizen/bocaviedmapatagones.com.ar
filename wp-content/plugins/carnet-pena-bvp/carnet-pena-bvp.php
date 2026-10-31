<?php
/**
 * Plugin Name:       Carnet Peña Boca Viedma | Patagones
 * Description:       Carga de socios/as de la peña (nombre, Nº, DNI, fecha de ingreso y foto) y generación del carnet de bienvenida en PDF de 2 páginas A4.
 * Version:           1.3.1
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Peña Boca Viedma | Patagones
 * License:           GPL-2.0-or-later
 * Text Domain:       carnet-pena-bvp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CPBVP_Plugin {

	const VERSION = '1.3.1';
	const CPT     = 'cpbvp_socio';
	const CAP     = 'cpbvp_gestionar';  // permiso para cargar socios y generar carnets
	const ROL     = 'cpbvp_gestor';     // rol "Gestor/a de carnets"

	const M_NUMERO  = '_cpbvp_numero';
	const M_DNI     = '_cpbvp_dni';
	const M_INGRESO = '_cpbvp_ingreso';
	const M_SALUDO  = '_cpbvp_saludo';
	const M_FOTO    = '_cpbvp_foto_id';       // foto vieja (Biblioteca de medios, pública)
	const M_PRIV    = '_cpbvp_foto_privada';  // foto protegida: nombre del archivo en la carpeta privada
	const MAX_BYTES = 6291456;                // 6 MB por foto (el navegador ya la achica antes de subirla)
	const M_CROP    = '_cpbvp_crop';

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_cpt' ) );
		add_action( 'add_meta_boxes_' . self::CPT, array( __CLASS__, 'add_meta_boxes' ) );
		add_action( 'save_post_' . self::CPT, array( __CLASS__, 'save' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue' ) );
		add_action( 'admin_notices', array( __CLASS__, 'notices' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'list_query' ) );

		add_filter( 'enter_title_here', array( __CLASS__, 'title_placeholder' ), 10, 2 );
		add_filter( 'post_updated_messages', array( __CLASS__, 'updated_messages' ) );
		add_filter( 'manage_' . self::CPT . '_posts_columns', array( __CLASS__, 'columns' ) );
		add_action( 'manage_' . self::CPT . '_posts_custom_column', array( __CLASS__, 'column_content' ), 10, 2 );
		add_filter( 'manage_edit-' . self::CPT . '_sortable_columns', array( __CLASS__, 'sortable_columns' ) );
		add_filter( 'post_row_actions', array( __CLASS__, 'row_actions' ), 10, 2 );

		// Fotos privadas: subida, entrega solo a administradores y limpieza.
		add_action( 'wp_ajax_cpbvp_subir_foto', array( __CLASS__, 'ajax_subir_foto' ) );
		add_action( 'wp_ajax_cpbvp_foto', array( __CLASS__, 'ajax_foto' ) );
		add_action( 'before_delete_post', array( __CLASS__, 'borrar_foto_al_borrar' ) );
		add_action( 'admin_menu', array( __CLASS__, 'menu_proteger' ) );
		add_action( 'admin_post_cpbvp_proteger', array( __CLASS__, 'proteger_existentes' ) );

		// Rol "Gestor/a de carnets": ve solo los carnets, no el resto del panel.
		add_action( 'init', array( __CLASS__, 'crear_rol' ) );
		add_action( 'wp_ajax_cpbvp_diag', array( __CLASS__, 'diagnostico' ) );
		add_filter( 'user_has_cap', array( __CLASS__, 'admins_tienen_permiso' ), 10, 4 );
		add_action( 'admin_menu', array( __CLASS__, 'limpiar_menu' ), 999 );
		add_action( 'admin_init', array( __CLASS__, 'saltar_escritorio' ) );
		add_action( 'admin_bar_menu', array( __CLASS__, 'limpiar_barra' ), 999 );
		add_filter( 'show_admin_bar', array( __CLASS__, 'barra_en_el_sitio' ) );
		add_filter( 'login_redirect', array( __CLASS__, 'despues_de_entrar' ), 10, 3 );
	}

	/* ------------------------------------------------------------------ */
	/* Rol "Gestor/a de carnets"                                           */
	/* ------------------------------------------------------------------ */

	/** Crea el rol. Solo puede entrar al panel y manejar socios/carnets; no puede tocar nada más. */
	public static function crear_rol() {
		if ( get_option( 'cpbvp_rol_version' ) === self::VERSION && get_role( self::ROL ) ) {
			return;
		}
		$admin = get_role( 'administrator' );
		if ( $admin && ! $admin->has_cap( self::CAP ) ) {
			$admin->add_cap( self::CAP );
		}
		remove_role( self::ROL );
		add_role(
			self::ROL,
			'Gestor/a de carnets',
			array(
				'read'    => true,
				self::CAP => true,
			)
		);
		update_option( 'cpbvp_rol_version', self::VERSION );
	}

	/**
	 * Los Administradores siempre tienen el permiso de gestionar carnets.
	 * Se reconoce por el rol, por manage_options o por poder administrar plugins, y al super administrador de multisitio.
	 */
	public static function admins_tienen_permiso( $caps, $cap = array(), $args = array(), $user = null ) {
		$es_admin = ! empty( $caps['manage_options'] ) || ! empty( $caps['activate_plugins'] ) || ! empty( $caps['administrator'] );
		if ( ! $es_admin && $user instanceof WP_User ) {
			$es_admin = in_array( 'administrator', (array) $user->roles, true ) || ( is_multisite() && is_super_admin( $user->ID ) );
		}
		if ( $es_admin ) {
			$caps[ self::CAP ] = true;
		}
		return $caps;
	}

	/**
	 * Diagnóstico para entender por qué alguien no entra a los carnets.
	 * Muestra, solo a quien tiene la sesión iniciada, SUS propios permisos. No muestra claves ni datos de socios.
	 * Dirección: /wp-admin/admin-ajax.php?action=cpbvp_diag
	 */
	public static function diagnostico() {
		$u   = wp_get_current_user();
		$cpt = get_post_type_object( self::CPT );
		$out = array(
			'plugin'                     => self::VERSION,
			'wordpress'                  => get_bloginfo( 'version' ),
			'php'                        => PHP_VERSION,
			'multisitio'                 => is_multisite(),
			'usuario'                    => $u->user_login,
			'roles'                      => array_values( (array) $u->roles ),
			'puede_manage_options'       => current_user_can( 'manage_options' ),
			'puede_activar_plugins'      => current_user_can( 'activate_plugins' ),
			'puede_cpbvp_gestionar'      => current_user_can( self::CAP ),
			'rol_administrator_tiene_el_permiso' => ( get_role( 'administrator' ) ? get_role( 'administrator' )->has_cap( self::CAP ) : null ),
			'tipo_socios_registrado'     => (bool) $cpt,
			'permiso_para_editar_socios' => $cpt ? $cpt->cap->edit_posts : null,
			'filtros_user_has_cap'       => has_filter( 'user_has_cap' ) ? count( $GLOBALS['wp_filter']['user_has_cap']->callbacks ) . ' prioridades' : 'ninguno',
		);
		if ( in_array( 'administrator', (array) $u->roles, true ) ) {
			$out['plugins_activos'] = array_values( (array) get_option( 'active_plugins', array() ) );
			$out['mu_plugins']      = array_keys( function_exists( 'get_mu_plugins' ) ? get_mu_plugins() : array() );
		}
		nocache_headers();
		header( 'Content-Type: text/plain; charset=utf-8' );
		echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ); // phpcs:ignore WordPress.Security.EscapeOutput
		exit;
	}

	/** ¿Es un usuario que SOLO gestiona carnets (no es administrador)? */
	private static function es_gestor() {
		return is_user_logged_in() && current_user_can( self::CAP ) && ! current_user_can( 'manage_options' );
	}

	private static function url_listado() {
		return admin_url( 'edit.php?post_type=' . self::CPT );
	}

	/** Saca el Escritorio y deja solo "Socios Peña" y el perfil propio (para cambiar su clave). */
	public static function limpiar_menu() {
		if ( ! self::es_gestor() ) {
			return;
		}
		remove_menu_page( 'index.php' );
	}

	/** Si entra al Escritorio, lo mandamos directo a los carnets. */
	public static function saltar_escritorio() {
		global $pagenow;
		if ( self::es_gestor() && 'index.php' === $pagenow && ! wp_doing_ajax() ) {
			wp_safe_redirect( self::url_listado() );
			exit;
		}
	}

	/** Barra de arriba sin atajos que no le sirven. */
	public static function limpiar_barra( $barra ) {
		if ( ! self::es_gestor() ) {
			return;
		}
		foreach ( array( 'wp-logo', 'comments', 'new-content', 'updates', 'customize', 'site-name', 'view-site', 'search' ) as $nodo ) {
			$barra->remove_node( $nodo );
		}
	}

	/** Sin barra de WordPress cuando navega el sitio público. */
	public static function barra_en_el_sitio( $mostrar ) {
		return self::es_gestor() ? false : $mostrar;
	}

	/** Al iniciar sesión, va derecho al listado de socios. */
	public static function despues_de_entrar( $destino, $pedido, $usuario ) {
		if ( $usuario instanceof WP_User && in_array( self::ROL, (array) $usuario->roles, true ) ) {
			return self::url_listado();
		}
		return $destino;
	}

	/* ------------------------------------------------------------------ */
	/* Tipo de contenido "Socios"                                          */
	/* ------------------------------------------------------------------ */

	public static function register_cpt() {
		register_post_type(
			self::CPT,
			array(
				'labels'              => array(
					'name'               => 'Socios Peña',
					'singular_name'      => 'Socio/a',
					'menu_name'          => 'Socios Peña',
					'add_new'            => 'Añadir socio/a',
					'add_new_item'       => 'Añadir socio/a',
					'edit_item'          => 'Editar socio/a',
					'new_item'           => 'Nuevo socio/a',
					'search_items'       => 'Buscar socios',
					'not_found'          => 'Todavía no hay socios cargados.',
					'not_found_in_trash' => 'No hay socios en la papelera.',
					'all_items'          => 'Todos los socios',
				),
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_rest'        => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'has_archive'         => false,
				'rewrite'             => false,
				'menu_position'       => 26,
				'menu_icon'           => 'dashicons-id-alt',
				'supports'            => array( 'title' ),
				// Todo (ver, crear, editar, borrar, descargar el PDF) exige el permiso "cpbvp_gestionar".
				// Lo tienen los Administradores y el rol "Gestor/a de carnets"; nadie más.
				'capability_type'     => 'post',
				'capabilities'        => self::capabilities(),
				'map_meta_cap'        => true,
			)
		);
	}

	/** Todas las capacidades del tipo "Socios" apuntan al permiso "cpbvp_gestionar". */
	private static function capabilities() {
		$cap  = self::CAP;
		$keys = array(
			'edit_post', 'read_post', 'delete_post',
			'edit_posts', 'edit_others_posts', 'delete_posts', 'publish_posts',
			'read_private_posts', 'delete_private_posts', 'delete_published_posts',
			'delete_others_posts', 'edit_private_posts', 'edit_published_posts',
			'create_posts',
		);
		return array_fill_keys( $keys, $cap );
	}

	public static function title_placeholder( $text, $post ) {
		return ( $post && self::CPT === $post->post_type ) ? 'Nombre y apellido' : $text;
	}

	public static function updated_messages( $messages ) {
		$messages[ self::CPT ] = array(
			0  => '',
			1  => 'Socio/a actualizado.',
			4  => 'Socio/a actualizado.',
			6  => 'Socio/a guardado.',
			7  => 'Socio/a guardado.',
			8  => 'Socio/a guardado.',
			10 => 'Borrador guardado.',
		);
		return $messages;
	}

	/* ------------------------------------------------------------------ */
	/* Formulario                                                          */
	/* ------------------------------------------------------------------ */

	public static function add_meta_boxes() {
		add_meta_box( 'cpbvp_datos', 'Datos del carnet', array( __CLASS__, 'render_meta_box' ), self::CPT, 'normal', 'high' );
	}

	public static function render_meta_box( $post ) {
		$is_new  = ( 'auto-draft' === $post->post_status );
		$numero  = get_post_meta( $post->ID, self::M_NUMERO, true );
		$dni     = get_post_meta( $post->ID, self::M_DNI, true );
		$ingreso = get_post_meta( $post->ID, self::M_INGRESO, true );
		$saludo  = get_post_meta( $post->ID, self::M_SALUDO, true );
		$foto_id = (int) get_post_meta( $post->ID, self::M_FOTO, true );
		$priv    = (string) get_post_meta( $post->ID, self::M_PRIV, true );
		$crop    = get_post_meta( $post->ID, self::M_CROP, true );

		if ( $is_new && '' === $numero ) {
			$numero = (string) self::next_number();
		}
		if ( '' === $ingreso ) {
			$ingreso = current_time( 'Y-m-d' );
		}
		if ( '' === $saludo ) {
			$saludo = 'bienvenido';
		}

		wp_nonce_field( 'cpbvp_save', 'cpbvp_nonce' );
		?>
		<div class="cpbvp">
			<div class="cpbvp-fields">
				<p class="cpbvp-help">El <strong>nombre y apellido</strong> va en el campo de arriba, el del título.</p>

				<div class="cpbvp-grid">
					<p>
						<label for="cpbvp_numero">Nº de socio/a</label>
						<input type="text" id="cpbvp_numero" name="cpbvp_numero" value="<?php echo esc_attr( self::pad( $numero ) ); ?>" inputmode="numeric" maxlength="6" autocomplete="off">
					</p>
					<p>
						<label for="cpbvp_dni">DNI</label>
						<input type="text" id="cpbvp_dni" name="cpbvp_dni" value="<?php echo esc_attr( self::format_dni( $dni ) ); ?>" inputmode="numeric" maxlength="12" autocomplete="off" placeholder="00.000.000">
					</p>
					<p>
						<label for="cpbvp_ingreso">Fecha de ingreso</label>
						<input type="date" id="cpbvp_ingreso" name="cpbvp_ingreso" value="<?php echo esc_attr( $ingreso ); ?>">
					</p>
					<p>
						<label for="cpbvp_saludo">Saludo</label>
						<select id="cpbvp_saludo" name="cpbvp_saludo">
							<option value="bienvenido" <?php selected( $saludo, 'bienvenido' ); ?>>Bienvenido</option>
							<option value="bienvenida" <?php selected( $saludo, 'bienvenida' ); ?>>Bienvenida</option>
						</select>
					</p>
				</div>

				<fieldset class="cpbvp-photo">
					<legend>Foto carnet</legend>
					<div class="cpbvp-cropper">
						<canvas id="cpbvp_cropper" tabindex="0" aria-label="Encuadre de la foto. Arrastrá para mover; flechas para mover; más y menos para zoom."></canvas>
						<div class="cpbvp-photo-tools">
							<button type="button" class="button" id="cpbvp_foto_btn"><?php echo ( $foto_id || $priv ) ? 'Cambiar foto' : 'Subir foto'; ?></button>
							<p class="cpbvp-zoom">
								<label for="cpbvp_zoom">Zoom</label>
								<input type="range" id="cpbvp_zoom" min="1" max="3" step="0.01" value="1">
							</p>
							<button type="button" class="button-link" id="cpbvp_center">Volver a centrar</button>
							<p class="description">Arrastrá la foto para que la cara quede dentro del óvalo. Podés subirla desde la compu o el celular.</p>
							<p class="description">🔒 La foto se guarda en una carpeta privada del sitio: solo los administradores con la sesión iniciada pueden verla. No se publica en la Biblioteca de medios.</p>
							<?php if ( ! $priv && $foto_id ) : ?>
								<p class="cpbvp-aviso">⚠️ Esta foto está en la Biblioteca de medios y es pública. Subí la foto de nuevo, o protegé todas las fotos viejas desde <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . self::CPT . '&page=cpbvp-proteger' ) ); ?>">Proteger fotos</a>.</p>
							<?php endif; ?>
						</div>
					</div>
					<input type="hidden" id="cpbvp_foto_id" name="cpbvp_foto_id" value="<?php echo esc_attr( $foto_id ? (string) $foto_id : '' ); ?>">
					<input type="hidden" id="cpbvp_foto_priv" name="cpbvp_foto_priv" value="<?php echo esc_attr( self::nombre_valido( $priv ) ? $priv : '' ); ?>">
					<input type="hidden" id="cpbvp_crop" name="cpbvp_crop" value="<?php echo esc_attr( (string) $crop ); ?>">
				</fieldset>
			</div>

			<div class="cpbvp-preview">
				<h4>Vista previa del carnet</h4>
				<canvas id="cpbvp_preview" role="img" aria-label="Vista previa del dorso del carnet"></canvas>
				<button type="button" class="button button-primary button-hero" id="cpbvp_pdf">Descargar carnet en PDF</button>
				<p id="cpbvp_status" class="cpbvp-status" role="status" aria-live="polite"></p>
				<p class="description">PDF de 2 páginas A4: bienvenida con el carnet para recortar, y beneficios. Usa lo que está cargado en pantalla, aunque no lo hayas guardado.</p>
			</div>
		</div>
		<?php
	}

	/* ------------------------------------------------------------------ */
	/* Guardado                                                            */
	/* ------------------------------------------------------------------ */

	public static function save( $post_id, $post ) {
		if ( ! isset( $_POST['cpbvp_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cpbvp_nonce'] ) ), 'cpbvp_save' ) ) {
			return;
		}
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) ) {
			return;
		}
		if ( ! current_user_can( self::CAP ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$numero = ltrim( preg_replace( '/\D/', '', (string) wp_unslash( $_POST['cpbvp_numero'] ?? '' ) ), '0' );
		$dni    = preg_replace( '/\D/', '', (string) wp_unslash( $_POST['cpbvp_dni'] ?? '' ) );

		$ingreso = sanitize_text_field( wp_unslash( $_POST['cpbvp_ingreso'] ?? '' ) );
		$d       = DateTime::createFromFormat( 'Y-m-d', $ingreso );
		if ( ! $d || $d->format( 'Y-m-d' ) !== $ingreso ) {
			$ingreso = '';
		}

		$saludo = sanitize_key( wp_unslash( $_POST['cpbvp_saludo'] ?? '' ) );
		if ( ! in_array( $saludo, array( 'bienvenido', 'bienvenida' ), true ) ) {
			$saludo = 'bienvenido';
		}

		$foto_id = absint( $_POST['cpbvp_foto_id'] ?? 0 );
		if ( $foto_id && ! wp_attachment_is_image( $foto_id ) ) {
			$foto_id = 0;
		}

		// Foto protegida: solo se acepta un archivo que exista en la carpeta privada.
		$priv_nueva = sanitize_text_field( wp_unslash( $_POST['cpbvp_foto_priv'] ?? '' ) );
		$priv_vieja = (string) get_post_meta( $post_id, self::M_PRIV, true );
		$foto_vieja = (int) get_post_meta( $post_id, self::M_FOTO, true );
		if ( self::nombre_valido( $priv_nueva ) && is_file( self::ruta( $priv_nueva ) ) ) {
			update_post_meta( $post_id, self::M_PRIV, $priv_nueva );
			if ( $priv_vieja && $priv_vieja !== $priv_nueva && self::nombre_valido( $priv_vieja ) ) {
				wp_delete_file( self::ruta( $priv_vieja ) );
			}
			// Si había una foto pública en la Biblioteca de medios, se borra.
			if ( $foto_vieja ) {
				self::borrar_adjunto_propio( $foto_vieja, $post_id );
				$foto_id = 0;
			}
		}

		$crop = self::sanitize_crop( wp_unslash( $_POST['cpbvp_crop'] ?? '' ) );

		update_post_meta( $post_id, self::M_NUMERO, $numero );
		update_post_meta( $post_id, self::M_DNI, $dni );
		update_post_meta( $post_id, self::M_INGRESO, $ingreso );
		update_post_meta( $post_id, self::M_SALUDO, $saludo );
		update_post_meta( $post_id, self::M_FOTO, $foto_id ? $foto_id : '' );
		update_post_meta( $post_id, self::M_CROP, $crop );

		// Aviso si el número ya lo tiene otro socio/a.
		if ( '' !== $numero ) {
			$dup = get_posts(
				array(
					'post_type'      => self::CPT,
					'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'future' ),
					'meta_key'       => self::M_NUMERO, // phpcs:ignore WordPress.DB.SlowDBQuery
					'meta_value'     => $numero, // phpcs:ignore WordPress.DB.SlowDBQuery
					'post__not_in'   => array( $post_id ),
					'posts_per_page' => 1,
					'fields'         => 'ids',
				)
			);
			if ( $dup ) {
				set_transient(
					'cpbvp_dup_' . get_current_user_id(),
					array( 'numero' => self::pad( $numero ), 'nombre' => get_the_title( $dup[0] ) ),
					120
				);
			}
		}
	}

	private static function sanitize_crop( $raw ) {
		$c = json_decode( (string) $raw, true );
		if ( ! is_array( $c ) ) {
			return '';
		}
		$z = isset( $c['z'] ) ? (float) $c['z'] : 1.0;
		$x = isset( $c['x'] ) ? (float) $c['x'] : 0.0;
		$y = isset( $c['y'] ) ? (float) $c['y'] : 0.0;
		return wp_json_encode(
			array(
				'z' => round( min( 3, max( 1, $z ) ), 3 ),
				'x' => round( min( 3, max( -3, $x ) ), 4 ),
				'y' => round( min( 3, max( -3, $y ) ), 4 ),
			)
		);
	}

	public static function notices() {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || self::CPT !== $screen->post_type ) {
			return;
		}
		$key = 'cpbvp_dup_' . get_current_user_id();
		$dup = get_transient( $key );
		if ( $dup ) {
			delete_transient( $key );
			printf(
				'<div class="notice notice-warning is-dismissible"><p>%s</p></div>',
				esc_html( sprintf( 'Atención: el Nº %s ya lo tiene otro socio/a (%s). Revisá el número antes de imprimir el carnet.', $dup['numero'], $dup['nombre'] ) )
			);
		}
	}

	/* ------------------------------------------------------------------ */
	/* Listado                                                             */
	/* ------------------------------------------------------------------ */

	public static function columns( $cols ) {
		return array(
			'cb'            => $cols['cb'] ?? '<input type="checkbox" />',
			'cpbvp_foto'    => '<span class="screen-reader-text">Foto</span>',
			'title'         => 'Nombre y apellido',
			'cpbvp_numero'  => 'Nº de socio/a',
			'cpbvp_dni'     => 'DNI',
			'cpbvp_ingreso' => 'Ingreso',
		);
	}

	public static function column_content( $col, $post_id ) {
		switch ( $col ) {
			case 'cpbvp_foto':
				$priv = (string) get_post_meta( $post_id, self::M_PRIV, true );
				$id   = (int) get_post_meta( $post_id, self::M_FOTO, true );
				if ( self::nombre_valido( $priv ) ) {
					echo '<img class="cpbvp-thumb" width="40" height="40" alt="" src="' . esc_url( self::url_foto( $priv ) ) . '">';
				} elseif ( $id ) {
					echo wp_get_attachment_image( $id, array( 40, 40 ), false, array( 'class' => 'cpbvp-thumb' ) );
				}
				break;
			case 'cpbvp_numero':
				echo esc_html( self::pad( get_post_meta( $post_id, self::M_NUMERO, true ) ) );
				break;
			case 'cpbvp_dni':
				echo esc_html( self::format_dni( get_post_meta( $post_id, self::M_DNI, true ) ) );
				break;
			case 'cpbvp_ingreso':
				$f = get_post_meta( $post_id, self::M_INGRESO, true );
				echo esc_html( $f ? mysql2date( 'd/m/Y', $f ) : '' );
				break;
		}
	}

	public static function sortable_columns( $cols ) {
		$cols['cpbvp_numero']  = 'cpbvp_numero';
		$cols['cpbvp_ingreso'] = 'cpbvp_ingreso';
		return $cols;
	}

	/** Orden por Nº / ingreso, y búsqueda por Nº de socio o DNI cuando se buscan solo números. */
	public static function list_query( $q ) {
		if ( ! is_admin() || ! $q->is_main_query() || self::CPT !== $q->get( 'post_type' ) ) {
			return;
		}
		$orderby = $q->get( 'orderby' );
		if ( 'cpbvp_numero' === $orderby ) {
			$q->set( 'meta_key', self::M_NUMERO );
			$q->set( 'orderby', 'meta_value_num' );
		} elseif ( 'cpbvp_ingreso' === $orderby ) {
			$q->set( 'meta_key', self::M_INGRESO );
			$q->set( 'orderby', 'meta_value' );
		}

		$s      = (string) $q->get( 's' );
		$digits = preg_replace( '/[\s.\-]/', '', $s );
		if ( '' !== $digits && ctype_digit( $digits ) ) {
			$q->set( 's', '' );
			$q->set(
				'meta_query',
				array(
					'relation' => 'OR',
					array( 'key' => self::M_NUMERO, 'value' => ltrim( $digits, '0' ) ),
					array( 'key' => self::M_DNI, 'value' => $digits ),
				)
			);
		}
	}

	public static function row_actions( $actions, $post ) {
		if ( self::CPT === $post->post_type && current_user_can( 'edit_post', $post->ID ) ) {
			$url = add_query_arg( 'cpbvp_pdf', '1', get_edit_post_link( $post->ID, 'raw' ) );
			unset( $actions['inline hide-if-no-js'] );
			$actions = array( 'cpbvp_pdf' => '<a href="' . esc_url( $url ) . '">Descargar PDF</a>' ) + $actions;
		}
		return $actions;
	}

	/* ------------------------------------------------------------------ */
	/* Scripts                                                             */
	/* ------------------------------------------------------------------ */

	public static function enqueue( $hook ) {
		$screen = get_current_screen();
		if ( ! $screen || self::CPT !== $screen->post_type || ! current_user_can( self::CAP ) ) {
			return;
		}
		$url = plugin_dir_url( __FILE__ ) . 'assets/';
		$dir = plugin_dir_path( __FILE__ ) . 'assets/';

		wp_enqueue_style( 'cpbvp-admin', $url . 'admin.css', array(), filemtime( $dir . 'admin.css' ) );

		if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
			return;
		}

		global $post;
		$foto_id  = $post ? (int) get_post_meta( $post->ID, self::M_FOTO, true ) : 0;
		$priv     = $post ? (string) get_post_meta( $post->ID, self::M_PRIV, true ) : '';
		$foto_url = '';
		if ( self::nombre_valido( $priv ) ) {
			$foto_url = self::url_foto( $priv );
		} elseif ( $foto_id ) {
			$foto_url = (string) wp_get_attachment_image_url( $foto_id, 'large' );
		}
		$layout   = json_decode( (string) file_get_contents( $dir . 'layout.json' ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions

		wp_enqueue_script( 'cpbvp-pdf-lib', $url . 'vendor/pdf-lib.min.js', array(), '1.17.1', true );
		wp_enqueue_script( 'cpbvp-admin', $url . 'admin.js', array( 'cpbvp-pdf-lib' ), filemtime( $dir . 'admin.js' ), true );
		// JSON en vez de wp_localize_script, que convierte todo a texto ("0" es verdadero en JS).
		$config = array(
			'templateUrl'  => $url . 'template.pdf?v=' . filemtime( $dir . 'template.pdf' ),
			'fontsUrl'     => $url . 'fonts/',
			'layout'       => $layout,
			'fotoUrl'      => $foto_url ? $foto_url : '',
			'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
			'nonce'        => wp_create_nonce( 'cpbvp_foto' ),
			'fotoBase'     => self::url_foto( '' ),
			'maxBytes'     => self::MAX_BYTES,
			'autoDownload' => isset( $_GET['cpbvp_pdf'] ), // phpcs:ignore WordPress.Security.NonceVerification
		);
		wp_add_inline_script( 'cpbvp-admin', 'window.CPBVP = ' . wp_json_encode( $config ) . ';', 'before' );
	}

	/* ------------------------------------------------------------------ */
	/* Fotos privadas                                                      */
	/* ------------------------------------------------------------------ */

	/**
	 * Carpeta privada de las fotos. Con el filtro "cpbvp_carpeta_privada" se puede mover
	 * a una carpeta fuera de la web (lo más seguro, si el hosting lo permite).
	 */
	public static function dir() {
		$u   = wp_upload_dir( null, false );
		$dir = apply_filters( 'cpbvp_carpeta_privada', trailingslashit( $u['basedir'] ) . 'cpbvp-privado' );
		return untrailingslashit( $dir );
	}

	/** Crea la carpeta y la cierra al acceso directo (.htaccess + index.php). */
	private static function preparar_dir() {
		$dir = self::dir();
		if ( ! wp_mkdir_p( $dir ) ) {
			return false;
		}
		$archivos = array(
			'.htaccess'  => "# Carnet Peña: archivos privados. Nadie entra directo.\n<IfModule mod_authz_core.c>\nRequire all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\nOrder allow,deny\nDeny from all\n</IfModule>\n",
			'index.php'  => "<?php\n// Silence is golden.\n",
			'index.html' => '',
		);
		foreach ( $archivos as $nombre => $contenido ) {
			if ( ! file_exists( $dir . '/' . $nombre ) ) {
				file_put_contents( $dir . '/' . $nombre, $contenido ); // phpcs:ignore WordPress.WP.AlternativeFunctions
			}
		}
		return is_writable( $dir );
	}

	/** Nombre de archivo permitido: 32 caracteres al azar + extensión. Evita rutas inventadas. */
	public static function nombre_valido( $nombre ) {
		return is_string( $nombre ) && 1 === preg_match( '/^[a-f0-9]{32}\.(jpg|png|webp)$/', $nombre );
	}

	private static function ruta( $nombre ) {
		return self::dir() . '/' . $nombre;
	}

	/** Dirección con la que un administrador logueado ve la foto (pasa por WordPress, no es el archivo). */
	public static function url_foto( $nombre ) {
		return add_query_arg(
			array(
				'action' => 'cpbvp_foto',
				'f'      => $nombre,
			),
			admin_url( 'admin-ajax.php' )
		);
	}

	/**
	 * Guarda la imagen como JPG nuevo: sin datos ocultos (ubicación GPS, cámara, etc.),
	 * con la orientación corregida y a un tamaño razonable.
	 */
	private static function guardar_jpeg_limpio( $origen, $destino, $subida = false ) {
		if ( function_exists( 'imagecreatefromstring' ) && function_exists( 'imagejpeg' ) ) {
			$bin = file_get_contents( $origen ); // phpcs:ignore WordPress.WP.AlternativeFunctions
			$im  = $bin ? @imagecreatefromstring( $bin ) : false;
			unset( $bin );
			if ( ! $im ) {
				return false;
			}
			if ( function_exists( 'exif_read_data' ) ) {
				$exif = @exif_read_data( $origen ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
				$o    = is_array( $exif ) && isset( $exif['Orientation'] ) ? (int) $exif['Orientation'] : 1;
				$ang  = array( 3 => 180, 6 => -90, 8 => 90 );
				if ( isset( $ang[ $o ] ) && function_exists( 'imagerotate' ) ) {
					$rot = imagerotate( $im, $ang[ $o ], 0 );
					if ( $rot ) {
						imagedestroy( $im );
						$im = $rot;
					}
				}
			}
			$w = imagesx( $im );
			$h = imagesy( $im );
			if ( max( $w, $h ) > 1600 && function_exists( 'imagescale' ) ) {
				$r = $w >= $h ? imagescale( $im, 1600 ) : imagescale( $im, (int) round( $w * 1600 / $h ) );
				if ( $r ) {
					imagedestroy( $im );
					$im = $r;
				}
			}
			$ok = imagejpeg( $im, $destino, 90 );
			imagedestroy( $im );
			if ( $ok ) {
				@chmod( $destino, 0640 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
			}
			return (bool) $ok;
		}
		// Sin la librería GD: solo se acepta un JPG y se guarda tal cual (el navegador ya lo limpió).
		$info = @getimagesize( $origen ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		if ( ! $info || IMAGETYPE_JPEG !== $info[2] ) {
			return false;
		}
		return $subida ? move_uploaded_file( $origen, $destino ) : copy( $origen, $destino );
	}

	/** Borra de la Biblioteca de medios una foto vieja, solo si la usa únicamente este socio/a. */
	private static function borrar_adjunto_propio( $adjunto_id, $socio_id ) {
		$adjunto_id = (int) $adjunto_id;
		$adj        = $adjunto_id ? get_post( $adjunto_id ) : null;
		if ( ! $adj || 'attachment' !== $adj->post_type ) {
			return false;
		}
		if ( (int) $adj->post_parent && (int) $adj->post_parent !== (int) $socio_id ) {
			return false;
		}
		$otros = get_posts(
			array(
				'post_type'      => self::CPT,
				'post_status'    => 'any',
				'meta_key'       => self::M_FOTO, // phpcs:ignore WordPress.DB.SlowDBQuery
				'meta_value'     => $adjunto_id, // phpcs:ignore WordPress.DB.SlowDBQuery
				'post__not_in'   => array( (int) $socio_id ),
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);
		if ( $otros ) {
			return false;
		}
		return (bool) wp_delete_attachment( $adjunto_id, true );
	}

	/** Borra las fotos privadas que se subieron pero nunca se guardaron en una ficha (más de un día). */
	private static function limpiar_huerfanas() {
		global $wpdb;
		$usadas = array_flip( (array) $wpdb->get_col( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key = %s", self::M_PRIV ) ) ); // phpcs:ignore WordPress.DB
		foreach ( (array) glob( self::dir() . '/*' ) as $archivo ) {
			$n = basename( $archivo );
			if ( self::nombre_valido( $n ) && ! isset( $usadas[ $n ] ) && filemtime( $archivo ) < time() - DAY_IN_SECONDS ) {
				wp_delete_file( $archivo );
			}
		}
	}

	/** Al borrar un socio/a para siempre, se borra también su foto. */
	public static function borrar_foto_al_borrar( $post_id ) {
		if ( self::CPT !== get_post_type( $post_id ) ) {
			return;
		}
		$priv = (string) get_post_meta( $post_id, self::M_PRIV, true );
		if ( self::nombre_valido( $priv ) ) {
			wp_delete_file( self::ruta( $priv ) );
		}
	}

	/** Recibe la foto (ya achicada por el navegador). Solo administradores. */
	public static function ajax_subir_foto() {
		check_ajax_referer( 'cpbvp_foto', '_wpnonce' );
		if ( ! current_user_can( self::CAP ) ) {
			wp_send_json_error( array( 'mensaje' => 'No tenés permiso para subir fotos.' ), 403 );
		}
		if ( empty( $_FILES['foto'] ) || ! is_array( $_FILES['foto'] ) ) {
			wp_send_json_error( array( 'mensaje' => 'No llegó la foto. Probá de nuevo.' ), 400 );
		}
		$error = (int) $_FILES['foto']['error'];
		if ( UPLOAD_ERR_INI_SIZE === $error || UPLOAD_ERR_FORM_SIZE === $error ) {
			wp_send_json_error( array( 'mensaje' => 'La foto pesa demasiado.' ), 413 );
		}
		if ( UPLOAD_ERR_OK !== $error ) {
			wp_send_json_error( array( 'mensaje' => 'No llegó la foto. Probá de nuevo.' ), 400 );
		}
		$tmp = (string) $_FILES['foto']['tmp_name']; // phpcs:ignore WordPress.Security
		if ( ! is_uploaded_file( $tmp ) ) {
			wp_send_json_error( array( 'mensaje' => 'No llegó la foto. Probá de nuevo.' ), 400 );
		}
		if ( filesize( $tmp ) > self::MAX_BYTES ) {
			wp_send_json_error( array( 'mensaje' => 'La foto pesa demasiado.' ), 413 );
		}
		$info = @getimagesize( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		if ( ! $info || IMAGETYPE_JPEG !== $info[2] || $info[0] > 4000 || $info[1] > 4000 ) {
			wp_send_json_error( array( 'mensaje' => 'La foto tiene que ser una imagen JPG.' ), 415 );
		}
		if ( ! self::preparar_dir() ) {
			wp_send_json_error( array( 'mensaje' => 'No se pudo crear la carpeta privada de fotos. Revisá los permisos del sitio.' ), 500 );
		}
		self::limpiar_huerfanas();
		$nombre = bin2hex( random_bytes( 16 ) ) . '.jpg';
		if ( ! self::guardar_jpeg_limpio( $tmp, self::ruta( $nombre ), true ) ) {
			wp_send_json_error( array( 'mensaje' => 'No se pudo guardar la foto.' ), 500 );
		}
		wp_send_json_success(
			array(
				'f'   => $nombre,
				'url' => self::url_foto( $nombre ),
			)
		);
	}

	/** Entrega la foto, solo a un administrador con la sesión iniciada. */
	public static function ajax_foto() {
		if ( ! current_user_can( self::CAP ) ) {
			wp_die( 'No tenés permiso para ver esta foto.', 'Sin permiso', array( 'response' => 403 ) );
		}
		$f = isset( $_GET['f'] ) ? (string) wp_unslash( $_GET['f'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification, WordPress.Security.ValidatedSanitizedInput
		if ( ! self::nombre_valido( $f ) || ! is_file( self::ruta( $f ) ) ) {
			wp_die( 'No encontrada.', 'No encontrada', array( 'response' => 404 ) );
		}
		$tipos = array(
			'jpg'  => 'image/jpeg',
			'png'  => 'image/png',
			'webp' => 'image/webp',
		);
		$ruta  = self::ruta( $f );
		while ( ob_get_level() ) {
			ob_end_clean();
		}
		header( 'Content-Type: ' . $tipos[ pathinfo( $f, PATHINFO_EXTENSION ) ] );
		header( 'Content-Length: ' . filesize( $ruta ) );
		header( 'Cache-Control: private, no-store, max-age=0' );
		header( 'X-Content-Type-Options: nosniff' );
		header( 'X-Robots-Tag: noindex, nofollow' );
		readfile( $ruta ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		exit;
	}

	/* ------------------------------------------------------------------ */
	/* Proteger las fotos que ya estaban en la Biblioteca de medios        */
	/* ------------------------------------------------------------------ */

	public static function menu_proteger() {
		add_submenu_page( 'edit.php?post_type=' . self::CPT, 'Proteger fotos', 'Proteger fotos', 'manage_options', 'cpbvp-proteger', array( __CLASS__, 'pagina_proteger' ) );
	}

	private static function socios_con_foto_publica() {
		return get_posts(
			array(
				'post_type'      => self::CPT,
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery
					'relation' => 'AND',
					array( 'key' => self::M_FOTO, 'value' => '', 'compare' => '!=' ),
					array( 'key' => self::M_FOTO, 'value' => '0', 'compare' => '!=' ),
					array( 'relation' => 'OR', array( 'key' => self::M_PRIV, 'compare' => 'NOT EXISTS' ), array( 'key' => self::M_PRIV, 'value' => '' ) ),
				),
			)
		);
	}

	public static function pagina_proteger() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$pendientes = count( self::socios_con_foto_publica() );
		echo '<div class="wrap"><h1>Proteger fotos de los socios</h1>';
		if ( isset( $_GET['cpbvp_ok'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			printf(
				'<div class="notice notice-success"><p>%s</p></div>',
				esc_html( sprintf( 'Listo: %d foto(s) pasaron a la carpeta privada y se borraron de la Biblioteca de medios.', (int) $_GET['cpbvp_ok'] ) ) // phpcs:ignore WordPress.Security.NonceVerification
			);
			if ( ! empty( $_GET['cpbvp_fail'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				printf(
					'<div class="notice notice-warning"><p>%s</p></div>',
					esc_html( sprintf( 'No se pudieron pasar %d foto(s) y siguen donde estaban (públicas). Suele pasar porque el archivo ya no existe o porque la misma foto la usa otra ficha. Abrí esas fichas y subí la foto de nuevo con el botón "Cambiar foto".', (int) $_GET['cpbvp_fail'] ) ) // phpcs:ignore WordPress.Security.NonceVerification
				);
			}
		}
		echo '<p>Hasta ahora las fotos se guardaban en la Biblioteca de medios de WordPress, donde cualquiera que conozca la dirección del archivo puede abrirlas. Este botón las pasa a la carpeta privada (con nombre al azar, sin datos ocultos) y <strong>borra las copias públicas</strong>.</p>';
		if ( $pendientes ) {
			printf( '<p><strong>%d</strong> socio/a(s) tienen la foto en la Biblioteca de medios.</p>', (int) $pendientes );
			echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
			echo '<input type="hidden" name="action" value="cpbvp_proteger">';
			wp_nonce_field( 'cpbvp_proteger' );
			echo '<p><button type="submit" class="button button-primary" onclick="return confirm(\'Se van a mover las fotos a la carpeta privada y se borrarán de la Biblioteca de medios. ¿Seguimos?\');">Proteger ahora</button></p></form>';
			echo '<p class="description">Tip: si el sitio usa Cloudflare, después hacé "Purgar todo" en Caching, para que no queden copias de las direcciones viejas.</p>';
		} else {
			echo '<p>✅ No hay fotos públicas pendientes.</p>';
		}
		echo '</div>';
	}

	public static function proteger_existentes() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'No tenés permiso.', '', array( 'response' => 403 ) );
		}
		check_admin_referer( 'cpbvp_proteger' );
		$ok   = 0;
		$fail = 0;
		if ( self::preparar_dir() ) {
			foreach ( self::socios_con_foto_publica() as $socio_id ) {
				$adj_id = (int) get_post_meta( $socio_id, self::M_FOTO, true );
				$origen = $adj_id ? get_attached_file( $adj_id ) : '';
				$nombre = bin2hex( random_bytes( 16 ) ) . '.jpg';
				if ( $origen && is_file( $origen ) && self::guardar_jpeg_limpio( $origen, self::ruta( $nombre ) ) && is_file( self::ruta( $nombre ) ) && filesize( self::ruta( $nombre ) ) > 0 ) {
					// La copia pública se borra solo después de comprobar que la privada quedó bien.
					if ( ! self::borrar_adjunto_propio( $adj_id, $socio_id ) ) {
						wp_delete_file( self::ruta( $nombre ) ); // queda como estaba y se puede reintentar
						$fail++;
						continue;
					}
					update_post_meta( $socio_id, self::M_PRIV, $nombre );
					update_post_meta( $socio_id, self::M_FOTO, '' );
					$ok++;
				} else {
					$fail++;
				}
			}
		}
		wp_safe_redirect(
			add_query_arg(
				array(
					'post_type'  => self::CPT,
					'page'       => 'cpbvp-proteger',
					'cpbvp_ok'   => $ok,
					'cpbvp_fail' => $fail,
				),
				admin_url( 'edit.php' )
			)
		);
		exit;
	}

	/* ------------------------------------------------------------------ */
	/* Utilidades                                                          */
	/* ------------------------------------------------------------------ */

	private static function next_number() {
		$last = get_posts(
			array(
				'post_type'      => self::CPT,
				'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'future' ),
				'meta_key'       => self::M_NUMERO, // phpcs:ignore WordPress.DB.SlowDBQuery
				'orderby'        => 'meta_value_num',
				'order'          => 'DESC',
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);
		return $last ? ( (int) get_post_meta( $last[0], self::M_NUMERO, true ) + 1 ) : 1;
	}

	public static function pad( $n ) {
		$n = ltrim( preg_replace( '/\D/', '', (string) $n ), '0' );
		return '' === $n ? '' : str_pad( $n, 4, '0', STR_PAD_LEFT );
	}

	public static function format_dni( $dni ) {
		$dni = preg_replace( '/\D/', '', (string) $dni );
		return '' === $dni ? '' : number_format( (float) $dni, 0, ',', '.' );
	}
}

CPBVP_Plugin::init();
