<?php
// front-page.php
get_header(); ?>

<style>
/* ==========================================
   ESTILOS EXCLUSIVOS DE LA PORTADA
   ========================================== */
.hero-slider {
    position: relative;
    height: 75vh;
    min-height: 500px;
    background: linear-gradient(to right, rgba(5, 8, 17, 0.95) 20%, rgba(5, 8, 17, 0.4)), url('<?php echo get_template_directory_uri(); ?>/fondo.jpg') center/cover no-repeat;
    display: flex;
    align-items: center;
    padding: 0 5%;
    border-bottom: 4px solid var(--boca-oro);
}

.hero-content {
    max-width: 600px;
    z-index: 10;
}

.hero-tag {
    color: var(--boca-oro);
    font-weight: bold;
    letter-spacing: 2px;
    margin-bottom: 10px;
    display: block;
}

.hero-title {
    font-size: 3.5rem;
    line-height: 1.1;
    margin-bottom: 20px;
    color: var(--boca-texto-claro);
}

.hero-subtitle {
    font-size: 1.2rem;
    margin-bottom: 30px;
    color: var(--boca-gris-texto);
    line-height: 1.6;
}

.section-modulos {
    padding: 80px 5%;
    max-width: 1200px;
    margin: 0 auto;
}

.modulo-row {
    display: flex;
    background-color: var(--boca-azul-principal);
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    border: 1px solid rgba(255,255,255,0.05);
    transition: transform 0.3s, box-shadow 0.3s;
}

.modulo-row:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(249, 190, 61, 0.1);
    border-color: rgba(249, 190, 61, 0.3);
}

.modulo-row:nth-child(even) {
    flex-direction: row-reverse;
}

.modulo-img {
    flex: 1;
    min-width: 300px;
    background-color: var(--boca-azul-oscuro);
    position: relative;
}

.modulo-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.8;
    transition: opacity 0.3s;
}

.modulo-row:hover .modulo-img img {
    opacity: 1;
}

.modulo-content {
    flex: 1.5;
    padding: 50px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.modulo-tag {
    color: var(--boca-oro);
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 15px;
    letter-spacing: 1px;
}

.modulo-title {
    font-size: 2rem;
    margin: 0 0 20px 0;
    color: var(--boca-texto-claro);
}

.modulo-text {
    color: var(--boca-gris-texto);
    line-height: 1.7;
    margin-bottom: 30px;
    font-size: 1.05rem;
}

.btn-mod {
    align-self: flex-start;
    padding: 10px 25px;
    border: 2px solid var(--boca-oro);
    color: var(--boca-oro);
    text-decoration: none;
    font-weight: bold;
    border-radius: 6px;
    text-transform: uppercase;
    font-size: 0.85rem;
    transition: all 0.3s;
}

.btn-mod:hover {
    background-color: var(--boca-oro);
    color: var(--boca-azul-oscuro);
}

.banner-cta {
    background: linear-gradient(135deg, var(--boca-oro) 0%, #d49c2a 100%);
    padding: 60px 5%;
    text-align: center;
    color: var(--boca-azul-oscuro);
    border-radius: 12px;
    margin: 0 5% 60px 5%;
}

@media (max-width: 900px) {
    .modulo-row, .modulo-row:nth-child(even) {
        flex-direction: column;
    }
    .modulo-img {
        height: 250px;
    }
    .hero-title {
        font-size: 2.5rem;
    }
}
</style>

<!-- HERO INSTITUCIONAL -->
<header class="hero-slider">
    <div class="hero-content">
        <span class="hero-tag">RECONOCIMIENTO OFICIAL</span>
        <h1 class="hero-title cabj-font">LA COMARCA<br><span style="color: var(--boca-oro);">ES BOSTERA</span></h1>
        <p class="hero-subtitle">Militamos a Boca a pulmón desde hace años. Ponemos el cuerpo, la cabeza y el corazón en nuestra ciudad.</p>
        <a href="<?php echo site_url('/institucional'); ?>" class="btn-mod" style="background:var(--boca-oro); color:var(--boca-azul-oscuro);">Conocé nuestros Principios</a>
    </div>
</header>

<!-- MÓDULOS DE CONTENIDO -->
<section class="section-modulos">
    
    <!-- Módulo 1: Asociación Civil / Ser Parte -->
    <article class="modulo-row">
        <div class="modulo-img">
            <img src="<?php echo get_template_directory_uri(); ?>/images/mod-socios.jpg" alt="Socios Peña" onerror="this.src='https://images.unsplash.com/photo-1511886929837-354d827aae26?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';">
        </div>
        <div class="modulo-content">
            <div class="modulo-tag">Asociación Civil</div>
            <h2 class="modulo-title cabj-font">SE SIENTE EN LA SANGRE</h2>
            <p class="modulo-text">Podés hacerte socio/a de la Peña, ser parte de su historia y ayudar a que crezca. Nuestro Estatuto Social nos encuadra y orienta. ¡La cuota es muy accesible y brinda beneficios exclusivos en la Comarca!</p>
            <a href="<?php echo site_url('/ser-parte'); ?>" class="btn-mod">Ver Beneficios</a>
        </div>
    </article>

    <!-- Módulo 2: Sede -->
    <article class="modulo-row">
        <div class="modulo-img">
            <img src="<?php echo get_template_directory_uri(); ?>/images/mod-sede.jpg" alt="Sede Bostera" onerror="this.src='https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';">
        </div>
        <div class="modulo-content">
            <div class="modulo-tag">Nuestra Casa</div>
            <h2 class="modulo-title cabj-font">LA SEDE BOSTERA</h2>
            <p class="modulo-text">¿Todavía no conocés nuestro lugar en el mundo? Transmitimos todos los partidos en pantalla gigante y organizamos actividades sociales, previas y eventos solidarios sin necesidad de que seas socio/a.</p>
            <a href="<?php echo site_url('/sede'); ?>" class="btn-mod">Cómo Llegar</a>
        </div>
    </article>

    <!-- Módulo 3: Streaming -->
    <article class="modulo-row">
        <div class="modulo-img">
            <img src="<?php echo get_template_directory_uri(); ?>/images/mod-streaming.jpg" alt="Streaming Peña Boca" onerror="this.src='https://images.unsplash.com/photo-1598550476439-6847785fcea6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';">
        </div>
        <div class="modulo-content">
            <div class="modulo-tag">Multimedia en Vivo</div>
            <h2 class="modulo-title cabj-font">STREAMING BOSTERO</h2>
            <p class="modulo-text">Viernes de previa, análisis y debate. Escuchanos todos los viernes desde las 19hs por nuestro canal de YouTube. ¡Incluso podés sumarte a participar en vivo en el panel con nosotros!</p>
            <a href="<?php echo site_url('/streaming'); ?>" class="btn-mod">Ir a YouTube</a>
        </div>
    </article>

</section>

<!-- BANNER DE ACCIÓN (CONTACTO Y GESTIONES) -->
<div class="banner-cta">
    <h2 class="cabj-font" style="font-size: 2.5rem; margin: 0 0 10px 0;">¿NECESITÁS HACER UN TRÁMITE CON EL CLUB?</h2>
    <p style="font-size: 1.1rem; max-width: 700px; margin: 0 auto 30px auto; font-weight: 500;">
        Como Peña Oficial, te ayudamos de forma directa a hacerte socio/a de Boca, imprimir o habilitar tu carnet. 
    </p>
    <a href="<?php echo site_url('/contacto'); ?>" style="background-color: var(--boca-azul-oscuro); color: var(--boca-oro); padding: 15px 40px; font-size: 1.1rem; text-decoration: none; font-weight: bold; border-radius: 8px; text-transform: uppercase; display: inline-block; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">Escribinos por WhatsApp</a>
</div>

<?php get_footer(); ?>