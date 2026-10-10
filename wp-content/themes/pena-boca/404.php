<?php
// 404.php: se muestra cuando la dirección no existe o la página todavía no fue creada en WordPress
get_header(); ?>

<style>
.nf-section { background-color: var(--boca-fondo); min-height: 60vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 80px 5%; }
.nf-box { max-width: 560px; }
.nf-box h1 { color: var(--boca-oro); font-size: 3rem; margin: 0 0 15px 0; }
.nf-box p { color: var(--boca-gris-texto); font-size: 1.15rem; line-height: 1.7; margin: 0 0 30px 0; }
</style>

<main id="primary" class="site-main">
    <section class="nf-section">
        <div class="nf-box">
            <h1 class="cabj-font">Página no encontrada</h1>
            <p>No encontramos lo que buscabas. Puede que el enlace haya cambiado o que la página todavía no esté publicada.</p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-mod" style="background: var(--boca-oro); color: var(--boca-azul-oscuro);">Volver al inicio</a>
        </div>
    </section>
</main>

<?php get_footer(); ?>
