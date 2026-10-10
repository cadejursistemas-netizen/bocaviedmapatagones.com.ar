<?php
/*
Template Name: Nuestra Marca
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
.prod-section { background-color: var(--boca-fondo); padding: 0 5% 70px 5%; max-width: 1100px; margin: 0 auto; }
.prod-titulo { color: var(--boca-oro); text-align: center; font-size: 2rem; margin: 0 0 30px 0; }
.flyers-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px; align-items: start; }
.flyer { display: flex; flex-direction: column; gap: 14px; }
.flyer > a:first-child { display: block; border-radius: 12px; overflow: hidden; border: 3px solid var(--boca-azul-principal); box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
.flyer img { width: 100%; height: auto; display: block; transition: transform 0.4s ease; }
.flyer > a:first-child:hover img { transform: scale(1.03); }
.flyer-btn { text-align: center; }
.prod-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 16px; }
.prod { margin: 0; background: var(--boca-azul-principal); border-radius: 12px; overflow: hidden; border-bottom: 4px solid var(--boca-oro); }
.prod img { width: 100%; aspect-ratio: 4 / 5; object-fit: cover; display: block; transition: transform 0.4s ease; }
.prod:hover img { transform: scale(1.05); }
.prod figcaption { color: var(--boca-oro); font-family: 'Russo One', sans-serif; text-transform: uppercase; text-align: center; padding: 12px; }
.prod-nota { text-align: center; color: var(--boca-gris-texto); margin-top: 30px; }
.prod-nota a { color: var(--boca-oro); font-weight: 700; }
@media (max-width: 900px) { .pg-grid { grid-template-columns: 1fr; } }
</style>

<main id="primary" class="site-main">

    <header class="page-header">
        <h1 class="page-title cabj-font">NUESTRA MARCA</h1>
    </header>

    <section class="pg-section">
        <div class="pg-grid">
            <div class="pg-img">
                <img src="<?php echo get_template_directory_uri(); ?>/images/mod-marca.webp" alt="Indumentaria de la Peña" onerror="this.src='https://images.unsplash.com/photo-1523381210434-271e8be1f52b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';">
            </div>
            <div class="pg-info">
                <h2 class="cabj-font">Vamos lxs xeneizes</h2>
                <p>En la Peña tenemos nuestra propia marca de indumentaria y productos, pensada para llevar los colores a todos lados.</p>
                <p>Te mostramos lo disponible y estate atento a las próximas fechas de venta.</p>
            </div>
        </div>
    </section>


    <section class="prod-section flyers-section">
        <h2 class="cabj-font prod-titulo">Indumentaria</h2>
        <div class="flyers-grid">
            <article class="flyer">
                <a href="<?php echo get_template_directory_uri(); ?>/images/marca-campera.webp" target="_blank" rel="noopener">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/marca-campera.webp" alt="Encargá tu campera, con descuento para socixs Peña" loading="lazy">
                </a>
                <a class="btn-mod flyer-btn" href="https://wa.me/5492920405196?text=Hola!%20Quiero%20encargar%20la%20campera%20de%20la%20Pe%C3%B1a" target="_blank" rel="noopener">Pedir campera por WhatsApp</a>
            </article>
            <article class="flyer">
                <a href="<?php echo get_template_directory_uri(); ?>/images/marca-chomba.webp" target="_blank" rel="noopener">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/marca-chomba.webp" alt="Nueva chomba: lanzamiento de nuestra marca de indumentaria, en preventa" loading="lazy">
                </a>
                <a class="btn-mod flyer-btn" href="https://wa.me/5492920545899?text=Hola!%20Quiero%20pedir%20la%20chomba%20en%20preventa" target="_blank" rel="noopener">Pedir chomba por WhatsApp</a>
            </article>
            <article class="flyer">
                <a href="<?php echo get_template_directory_uri(); ?>/images/marca-camiseta.webp" target="_blank" rel="noopener">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/marca-camiseta.webp" alt="Camiseta Boca Juniors de la Peña: pedí la tuya" loading="lazy">
                </a>
                <a class="btn-mod flyer-btn" href="https://wa.me/5492920405196?text=Hola!%20Quiero%20pedir%20la%20camiseta%20de%20la%20Pe%C3%B1a" target="_blank" rel="noopener">Pedir camiseta por WhatsApp</a>
            </article>
        </div>
        <p class="prod-nota">Pedidos y consultas: <strong>Alfonso</strong> (<a href="https://wa.me/5492920405196">2920 405196</a>) o <strong>Laucha</strong> (<a href="https://wa.me/5492920545899">2920 545899</a>).</p>
    </section>

    <section class="prod-section">
        <h2 class="cabj-font prod-titulo">Lo que tenemos</h2>
        <div class="prod-grid">
            <figure class="prod">
                <img src="<?php echo get_template_directory_uri(); ?>/images/marca-stickers.webp" alt="Stickers de la Peña" loading="lazy">
                <figcaption>Stickers</figcaption>
            </figure>
            <figure class="prod">
                <img src="<?php echo get_template_directory_uri(); ?>/images/marca-vasos.webp" alt="Vasos de la Peña" loading="lazy">
                <figcaption>Vasos</figcaption>
            </figure>
            <figure class="prod">
                <img src="<?php echo get_template_directory_uri(); ?>/images/marca-llaveros.webp" alt="Llaveros de la Peña" loading="lazy">
                <figcaption>Llaveros</figcaption>
            </figure>
            <figure class="prod">
                <img src="<?php echo get_template_directory_uri(); ?>/images/marca-gorro.webp" alt="Gorro de la Peña" loading="lazy">
                <figcaption>Gorro</figcaption>
            </figure>
            <figure class="prod">
                <img src="<?php echo get_template_directory_uri(); ?>/images/marca-gorra.webp" alt="Gorra de la Peña" loading="lazy">
                <figcaption>Gorra</figcaption>
            </figure>
        </div>
        <p class="prod-nota">Estate atento a las próximas fechas de venta. Consultas por <a href="<?php echo site_url('/contacto'); ?>">WhatsApp</a>.</p>
    </section>

</main>

<?php get_footer(); ?>
