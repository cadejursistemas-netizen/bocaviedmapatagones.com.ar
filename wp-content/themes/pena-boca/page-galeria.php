<?php
/*
Template Name: Galería de Fotos
*/

/**
 * Fotos de Google Drive (opcional).
 * Se activa definiendo en wp-config.php:
 *   define( 'PBOCA_DRIVE_API_KEY',   'la-clave-de-api' );
 *   define( 'PBOCA_DRIVE_FOLDER_ID', 'el-id-de-la-carpeta' );
 * La carpeta debe estar compartida como "Cualquier persona con el enlace".
 */
if ( ! function_exists( 'pboca_drive_fotos' ) ) {
    function pboca_drive_fotos() {
        if ( ! defined( 'PBOCA_DRIVE_API_KEY' ) || ! defined( 'PBOCA_DRIVE_FOLDER_ID' ) || ! PBOCA_DRIVE_API_KEY || ! PBOCA_DRIVE_FOLDER_ID ) {
            return array();
        }
        $cache = get_transient( 'pboca_drive_fotos' );
        if ( false !== $cache ) {
            return $cache;
        }
        $fotos = array();
        $token = '';
        $paginas = 0;
        do {
            $url = add_query_arg( array(
                'q'        => "'" . PBOCA_DRIVE_FOLDER_ID . "' in parents and mimeType contains 'image/' and trashed = false",
                'fields'   => 'nextPageToken,files(id,name,createdTime,imageMediaMetadata(time))',
                'pageSize' => 200,
                'orderBy'  => 'createdTime desc',
                'key'      => PBOCA_DRIVE_API_KEY,
                'pageToken' => $token,
            ), 'https://www.googleapis.com/drive/v3/files' );
            $resp = wp_remote_get( $url, array( 'timeout' => 10 ) );
            if ( is_wp_error( $resp ) || 200 !== wp_remote_retrieve_response_code( $resp ) ) {
                // Si Drive falla, usar la última lista buena para que la galería no quede vacía
                $respaldo = get_transient( 'pboca_drive_fotos_respaldo' );
                return $respaldo ? $respaldo : array();
            }
            $data = json_decode( wp_remote_retrieve_body( $resp ), true );
            foreach ( isset( $data['files'] ) ? $data['files'] : array() as $f ) {
                // Fecha de la foto (EXIF) si existe; si no, fecha de subida
                $fecha = ! empty( $f['imageMediaMetadata']['time'] )
                    ? preg_replace( '/^(\d{4}):(\d{2}):(\d{2})/', '$1-$2-$3', $f['imageMediaMetadata']['time'] )
                    : $f['createdTime'];
                $ts = strtotime( $fecha );
                $fotos[] = array(
                    'ts'    => $ts ? $ts : 0,
                    'cat'   => 'nuevas',
                    'thumb' => 'https://drive.google.com/thumbnail?id=' . rawurlencode( $f['id'] ) . '&sz=w420',
                    'full'  => 'https://drive.google.com/thumbnail?id=' . rawurlencode( $f['id'] ) . '&sz=w1600',
                );
            }
            $token = isset( $data['nextPageToken'] ) ? $data['nextPageToken'] : '';
            $paginas++;
        } while ( $token && $paginas < 5 );

        set_transient( 'pboca_drive_fotos', $fotos, 10 * MINUTE_IN_SECONDS );
        set_transient( 'pboca_drive_fotos_respaldo', $fotos, WEEK_IN_SECONDS );
        return $fotos;
    }
}

// Fotos que ya están en el tema: número, categoría y fecha de la foto
$pboca_locales = array(
    array( 1, 'grupos', '2025-10-06 21:48:29' ),
    array( 2, 'grupos', '2026-03-21 21:10:06' ),
    array( 3, 'grupos', '2026-03-22 15:44:19' ),
    array( 4, 'grupos', '2026-05-04 21:08:41' ),
    array( 5, 'grupos', '2026-07-07 22:54:08' ),
    array( 6, 'grupos', '2026-08-01 23:51:40' ),
    array( 7, 'grupos', '2026-08-23 22:30:10' ),
    array( 8, 'grupos', '2026-08-23 23:29:45' ),
    array( 9, 'grupos', '2026-04-19 12:00:00' ),
    array( 10, 'local', '2026-04-19 16:13:52' ),
    array( 11, 'local', '2026-04-19 16:20:29' ),
    array( 12, 'local', '2026-04-19 16:22:12' ),
    array( 13, 'local', '2026-04-19 16:26:02' ),
    array( 14, 'local', '2026-04-19 17:58:09' ),
    array( 15, 'local', '2026-04-19 18:02:10' ),
    array( 16, 'local', '2026-04-19 18:05:09' ),
    array( 17, 'local', '2026-05-02 17:06:17' ),
    array( 18, 'local', '2026-05-02 18:14:04' ),
    array( 19, 'local', '2026-05-02 18:24:53' ),
    array( 20, 'local', '2026-05-09 19:55:20' ),
    array( 21, 'local', '2026-05-09 20:04:26' ),
    array( 22, 'local', '2026-05-09 20:06:58' ),
    array( 23, 'local', '2026-05-19 22:32:00' ),
    array( 24, 'local', '2026-05-19 22:34:56' ),
    array( 25, 'local', '2026-07-08 23:04:23' ),
    array( 26, 'local', '2026-08-01 18:23:18' ),
    array( 27, 'local', '2026-08-02 01:06:47' ),
    array( 28, 'local', '2026-08-02 18:01:57' ),
    array( 29, 'local', '2026-08-02 18:03:15' ),
    array( 30, 'local', '2026-08-02 18:04:08' ),
    array( 31, 'local', '2026-08-11 19:21:34' ),
    array( 32, 'local', '2026-08-11 19:57:18' ),
    array( 33, 'local', '2026-08-18 19:34:49' ),
    array( 34, 'local', '2026-08-18 20:19:07' ),
    array( 35, 'local', '2026-08-18 20:55:16' ),
    array( 36, 'local', '2026-09-08 23:36:14' ),
    array( 37, 'local', '2026-09-11 23:23:10' ),
    array( 38, 'local', '2026-09-11 23:24:01' ),
    array( 39, 'local', '2026-09-11 23:24:13' ),
    array( 40, 'local', '2026-09-15 21:08:03' ),
    array( 41, 'local', '2026-09-15 21:11:10' ),
    array( 42, 'local', '2026-09-15 21:15:02' ),
    array( 43, 'local', '2026-09-15 21:17:47' ),
    array( 44, 'local', '2026-09-15 22:30:00' ),
    array( 45, 'local', '2026-09-15 22:33:54' ),
    array( 46, 'local', '2026-09-15 23:42:49' ),
    array( 47, 'local', '2026-09-15 23:43:17' ),
    array( 48, 'local', '2026-09-15 23:47:42' ),
    array( 49, 'local', '2026-09-15 23:49:54' ),
    array( 50, 'local', '2026-09-20 15:35:16' ),
    array( 51, 'local', '2026-09-20 15:37:03' ),
    array( 52, 'local', '2026-09-20 16:41:55' ),
    array( 53, 'local', '2026-09-20 16:42:28' ),
);

$pboca_fotos = array();
$pboca_base  = get_template_directory_uri() . '/images/galeria/';
foreach ( $pboca_locales as $l ) {
    $nn = sprintf( '%02d', $l[0] );
    $pboca_fotos[] = array(
        'ts'    => strtotime( $l[2] ),
        'cat'   => $l[1],
        'thumb' => $pboca_base . 't' . $nn . '.webp',
        'full'  => $pboca_base . 'g' . $nn . '.webp',
    );
}
$pboca_drive = pboca_drive_fotos();
$pboca_fotos = array_merge( $pboca_fotos, $pboca_drive );

// De la más reciente a la más antigua
usort( $pboca_fotos, function ( $a, $b ) { return $b['ts'] <=> $a['ts']; } );

get_header(); ?>


<style>
.page-header { background-color: var(--boca-azul-principal); padding: 60px 5% 40px 5%; text-align: center; border-bottom: 4px solid var(--boca-oro); }
.page-title { color: var(--boca-oro); font-size: 2.8rem; margin: 0; letter-spacing: 1px; }
.page-subtitle { color: var(--boca-texto-claro); font-size: 1.1rem; margin-top: 15px; }
.galeria-section { background-color: var(--boca-fondo); padding: 40px 5% 80px 5%; max-width: 1300px; margin: 0 auto; }
.galeria-filtros { display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; margin-bottom: 30px; }
.galeria-filtros button { background: transparent; border: 2px solid var(--boca-azul-principal); color: var(--boca-texto-claro); padding: 8px 18px; border-radius: 20px; cursor: pointer; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; transition: all 0.3s ease; }
.galeria-filtros button:hover { border-color: var(--boca-oro); color: var(--boca-oro); }
.galeria-filtros button.active { background: var(--boca-oro); color: var(--boca-azul-oscuro); border-color: var(--boca-oro); }
.fotos-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px; }
.foto-item { display: block; aspect-ratio: 1 / 1; overflow: hidden; border-radius: 8px; background: var(--boca-azul-oscuro); }
.foto-item.hide { display: none; }
.foto-item img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.4s ease; }
.foto-item:hover img { transform: scale(1.08); }

/* Visor (lightbox) */
.lb { position: fixed; inset: 0; background: rgba(5, 8, 17, 0.95); z-index: 2000; display: none; align-items: center; justify-content: center; }
.lb.open { display: flex; }
.lb img { max-width: 94vw; max-height: 86vh; border-radius: 6px; box-shadow: 0 10px 40px rgba(0,0,0,0.6); }
.lb button { position: absolute; background: rgba(10, 17, 34, 0.8); border: 2px solid var(--boca-oro); color: var(--boca-oro); width: 48px; height: 48px; border-radius: 50%; font-size: 1.5rem; cursor: pointer; line-height: 1; }
.lb button:hover { background: var(--boca-oro); color: var(--boca-azul-oscuro); }
.lb-close { top: 18px; right: 18px; }
.lb-prev { left: 14px; top: 50%; transform: translateY(-50%); }
.lb-next { right: 14px; top: 50%; transform: translateY(-50%); }
.lb-count { position: absolute; bottom: 18px; left: 0; right: 0; text-align: center; color: var(--boca-texto-claro); font-size: 0.9rem; }
@media (max-width: 600px) { .fotos-grid { grid-template-columns: repeat(3, 1fr); gap: 6px; } .lb-prev { left: 6px; } .lb-next { right: 6px; } }
</style>

<main id="primary" class="site-main">

    <header class="page-header">
        <h1 class="page-title cabj-font">GALERÍA DE FOTOS</h1>
        <p class="page-subtitle">Momentos de la Peña: la sede, los partidos y la gente bostera</p>
    </header>

    <section class="galeria-section">
        <div class="galeria-filtros">
            <button class="active" data-filter="all">Todas</button>
            <button data-filter="local">La sede</button>
            <button data-filter="grupos">Grupos</button>
            <?php if ( ! empty( $pboca_drive ) ) : ?><button data-filter="nuevas">Nuevas</button><?php endif; ?>
        </div>

        <div class="fotos-grid" id="fotos-grid">
            <?php foreach ( $pboca_fotos as $f ) : ?>
            <a class="foto-item" data-cat="<?php echo esc_attr( $f['cat'] ); ?>" href="<?php echo esc_url( $f['full'] ); ?>">
                <img src="<?php echo esc_url( $f['thumb'] ); ?>" alt="Foto de la Peña" loading="lazy" width="420" height="420">
            </a>
            <?php endforeach; ?>
        </div>
    </section>

</main>

<div class="lb" id="lb" role="dialog" aria-modal="true" aria-label="Visor de fotos">
    <button class="lb-close" aria-label="Cerrar">&times;</button>
    <button class="lb-prev" aria-label="Foto anterior">&#8249;</button>
    <img id="lb-img" src="" alt="Foto ampliada de la Peña">
    <button class="lb-next" aria-label="Foto siguiente">&#8250;</button>
    <div class="lb-count" id="lb-count" aria-live="polite"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var items = Array.prototype.slice.call(document.querySelectorAll('.foto-item'));
    var lb = document.getElementById('lb'), img = document.getElementById('lb-img'), count = document.getElementById('lb-count');
    var current = 0;

    function visibles() { return items.filter(function (i) { return !i.classList.contains('hide'); }); }
    function show(n) {
        var v = visibles(); if (!v.length) return;
        current = (n + v.length) % v.length;
        img.src = v[current].getAttribute('href');
        count.textContent = (current + 1) + ' / ' + v.length;
    }
    var last = null;
    function open(el) { var v = visibles(); last = el; lb.classList.add('open'); document.body.style.overflow = 'hidden'; show(v.indexOf(el)); lb.querySelector('.lb-close').focus(); }
    function close() { lb.classList.remove('open'); document.body.style.overflow = ''; img.src = ''; if (last) last.focus(); }

    items.forEach(function (it) { it.addEventListener('click', function (e) { e.preventDefault(); open(it); }); });
    lb.querySelector('.lb-close').addEventListener('click', close);
    lb.querySelector('.lb-prev').addEventListener('click', function () { show(current - 1); });
    lb.querySelector('.lb-next').addEventListener('click', function () { show(current + 1); });
    lb.addEventListener('click', function (e) { if (e.target === lb) close(); });
    document.addEventListener('keydown', function (e) {
        if (!lb.classList.contains('open')) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') show(current - 1);
        if (e.key === 'ArrowRight') show(current + 1);
    });
    var x0 = null;
    lb.addEventListener('touchstart', function (e) { x0 = e.touches[0].clientX; }, { passive: true });
    lb.addEventListener('touchend', function (e) {
        if (x0 === null) return;
        var dx = e.changedTouches[0].clientX - x0; x0 = null;
        if (Math.abs(dx) > 50) show(current + (dx < 0 ? 1 : -1));
    });

    document.querySelectorAll('.galeria-filtros button').forEach(function (b) {
        b.addEventListener('click', function () {
            document.querySelectorAll('.galeria-filtros button').forEach(function (x) { x.classList.remove('active'); });
            b.classList.add('active');
            var f = b.getAttribute('data-filter');
            items.forEach(function (it) { it.classList.toggle('hide', f !== 'all' && it.getAttribute('data-cat') !== f); });
        });
    });
});
</script>

<?php get_footer(); ?>
