<?php
/*
Template Name: Acción Social
*/
get_header(); ?>

<style>
.page-header { background-color: var(--boca-azul-principal); padding: 60px 5% 40px 5%; text-align: center; border-bottom: 4px solid var(--boca-oro); }
.page-title { color: var(--boca-oro); font-size: 2.8rem; margin: 0; letter-spacing: 1px; }
.pg-section { background-color: var(--boca-fondo); padding: 60px 5%; max-width: 1100px; margin: 0 auto; }
.pg-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; }
.pg-img img { width: 100%; border-radius: 12px; border: 3px solid var(--boca-azul-principal); box-shadow: 0 10px 30px rgba(0,0,0,0.5); display: block; }
.pg-info h2 { color: var(--boca-oro); font-family: 'Russo One', sans-serif; font-size: 2rem; margin-bottom: 20px; text-transform: uppercase; }
.pg-info p { color: var(--boca-gris-texto); font-size: 1.1rem; line-height: 1.8; margin-bottom: 20px; }
.pg-list { list-style: none; padding: 0; margin: 20px 0; }
.pg-list li { color: var(--boca-texto-claro); font-size: 1.05rem; margin-bottom: 12px; }
.pg-info a { color: var(--boca-oro); }
@media (max-width: 900px) { .pg-grid { grid-template-columns: 1fr; } }
</style>

<main id="primary" class="site-main">

    <header class="page-header">
        <h1 class="page-title cabj-font">ACCIÓN SOCIAL</h1>
    </header>

    <section class="pg-section">
        <div class="pg-grid">
            <div class="pg-img">
                <img src="<?php echo get_template_directory_uri(); ?>/images/mod-accion-social.webp" alt="Acción Social de la Peña" onerror="this.src='https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';">
            </div>
            <div class="pg-info">
                <h2 class="cabj-font">A Boca lo hace grande su gente</h2>
                <p>Eso se demuestra en cada iniciativa solidaria de la Peña.</p>
                <p>Desde el área de Acción Social, fortalecemos nuestro vínculo con la comunidad a través de campañas como las jornadas de donación de sangre en Viedma y Patagones.</p>
                <p>Al mismo tiempo, articulamos con otras peñas del país para construir una solidaridad xeneize con alcance federal desde el Dpto de Interior del CABJ.</p>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
