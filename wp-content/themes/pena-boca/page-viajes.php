<?php
/*
Template Name: Viajes
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
        <h1 class="page-title cabj-font">VIAJES</h1>
    </header>

    <section class="pg-section">
        <div class="pg-grid">
            <div class="pg-img">
                <img src="<?php echo get_template_directory_uri(); ?>/images/mod-viajes.webp" alt="Viajes con la Peña" onerror="this.src='https://cdn-imgix.headout.com/media/images/e8053359-e21a-4dd9-a486-2f73722b29c2-1747905609251-277193.jpg?auto=compress%2Cformat&q=90&crop=faces&fit=crop';">
            </div>
            <div class="pg-info">
                <h2 class="cabj-font">Estar cerca de la Peña es estar cerca de Boca</h2>
                <p>Viajá con la Peña y sumate a disfrutar en familia y con amigxs.</p>
                <ul class="pg-list">
                    <li>✦ Viaje familiar.</li>
                    <li>✦ Entrada garantizada.</li>
                    <li>✦ Traslado ida y vuelta.</li>
                    <li>✦ Cena en La Boca y paseo por Caminito.</li>
                    <li>✦ ¡Un montón de sorteos! Más de la mitad del micro se lleva un premio.</li>
                </ul>
                <p>Y, sobre todo, la oportunidad de acercarte a una comunidad bostera que crece viaje a viaje.</p>
                <p><strong>Sumate al próximo:</strong> Facundo (<a href="https://wa.me/5492920536136">2920536136</a>) y Alfonso (<a href="https://wa.me/5492920405196">2920405196</a>).</p>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
