<?php
/*
Template Name: Peña Oficial
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
        <h1 class="page-title cabj-font">PEÑA OFICIAL</h1>
    </header>

    <section class="pg-section">
        <div class="pg-grid">
            <div class="pg-img">
                <img src="<?php echo get_template_directory_uri(); ?>/images/mod-pena-oficial.jpg" alt="Peña Oficial de Boca Juniors" onerror="this.src='https://images.unsplash.com/photo-1511886929837-354d827aae26?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';">
            </div>
            <div class="pg-info">
                <h2 class="cabj-font">Somos Peña Oficial</h2>
                <p>Somos el único espacio de la Comarca con reconocimiento oficial de Boca Juniors. Te ayudamos con las gestiones de forma directa, participamos de la vida institucional del CABJ y de la discusión sobre qué Club necesitamos.</p>
                <p><strong>¡Vos podés ser parte de pensar esos proyectos!</strong></p>
                <div style="display:flex; gap:15px; flex-wrap:wrap; margin-top:30px;">
                    <a href="<?php echo site_url('/contacto'); ?>" class="btn-mod" style="background:var(--boca-oro); color:var(--boca-azul-oscuro);">Quiero afiliarme</a>
                    <a href="<?php echo site_url('/institucional'); ?>#reconocimientos" class="btn-mod">Nuestros reconocimientos</a>
                    <a href="<?php echo site_url('/institucional'); ?>#autoridades" class="btn-mod">Autoridades</a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
