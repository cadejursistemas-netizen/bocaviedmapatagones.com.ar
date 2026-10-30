<?php
/**
 * Plugin Name:       Carnet Peña Boca Viedma | Patagones
 * Description:       Carga de socios/as de la peña (nombre, Nº, DNI, fecha de ingreso y foto) y generación del carnet de bienvenida en PDF de 2 páginas A4.
 * Version:           1.1.0
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

	const VERSION = '1.1.0';
	const CPT     = 'cpbvp_socio';

	const M_NUMERO  = '_cpbvp_numero';
	const M_DNI     = '_cpbvp_dni';
	const M_INGRESO = '_cpbvp_ingreso';
	const M_SALUDO  = '_cpbvp_saludo';
	const M_FOTO    = '_cpbvp_foto_id';
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
				// Solo administradores: todo (ver, crear, editar, borrar, descargar el PDF)
				// exige "manage_options", que tienen únicamente los Administradores.
				// Los Editores y Autores no ven el menú ni las fichas.
				'capability_type'     => 'post',
				'capabilities'        => self::capabilities(),
				'map_meta_cap'        => true,
			)
		);
	}

	/** Todas las capacidades del tipo "Socios" apuntan a "manage_options" (solo Administradores). */
	private static function capabilities() {
		$cap  = 'manage_options';
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
							<button type="button" class="button" id="cpbvp_foto_btn"><?php echo $foto_id ? 'Cambiar foto' : 'Elegir foto'; ?></button>
							<p class="cpbvp-zoom">
								<label for="cpbvp_zoom">Zoom</label>
								<input type="range" id="cpbvp_zoom" min="1" max="3" step="0.01" value="1">
							</p>
							<button type="button" class="button-link" id="cpbvp_center">Volver a centrar</button>
							<p class="description">Arrastrá la foto para que la cara quede dentro del óvalo. Podés subirla desde la compu o el celular.</p>
						</div>
					</div>
					<input type="hidden" id="cpbvp_foto_id" name="cpbvp_foto_id" value="<?php echo esc_attr( $foto_id ? (string) $foto_id : '' ); ?>">
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
		if ( ! current_user_can( 'manage_options' ) || ! current_user_can( 'edit_post', $post_id ) ) {
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
				$id = (int) get_post_meta( $post_id, self::M_FOTO, true );
				if ( $id ) {
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
		if ( ! $screen || self::CPT !== $screen->post_type || ! current_user_can( 'manage_options' ) ) {
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
		$foto_url = $foto_id ? wp_get_attachment_image_url( $foto_id, 'large' ) : '';
		$layout   = json_decode( (string) file_get_contents( $dir . 'layout.json' ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions

		wp_enqueue_media();
		wp_enqueue_script( 'cpbvp-pdf-lib', $url . 'vendor/pdf-lib.min.js', array(), '1.17.1', true );
		wp_enqueue_script( 'cpbvp-admin', $url . 'admin.js', array( 'cpbvp-pdf-lib', 'media-editor' ), filemtime( $dir . 'admin.js' ), true );
		// JSON en vez de wp_localize_script, que convierte todo a texto ("0" es verdadero en JS).
		$config = array(
			'templateUrl'  => $url . 'template.pdf?v=' . filemtime( $dir . 'template.pdf' ),
			'fontsUrl'     => $url . 'fonts/',
			'layout'       => $layout,
			'fotoUrl'      => $foto_url ? $foto_url : '',
			'autoDownload' => isset( $_GET['cpbvp_pdf'] ), // phpcs:ignore WordPress.Security.NonceVerification
		);
		wp_add_inline_script( 'cpbvp-admin', 'window.CPBVP = ' . wp_json_encode( $config ) . ';', 'before' );
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
