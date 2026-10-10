<?php
/*
Template Name: Ser Parte (Asociación Civil)
*/
get_header(); ?>

<style>
/* ==========================================
   ESTILOS DE LA PÁGINA SER PARTE
   ========================================== */
.page-header {
    background-color: var(--boca-azul-principal);
    padding: 60px 5% 40px 5%;
    text-align: center;
    border-bottom: 4px solid var(--boca-oro);
}

.page-title {
    color: var(--boca-oro);
    font-size: 2.8rem;
    margin: 0;
    letter-spacing: 1px;
}

.serparte-section {
    background-color: var(--boca-fondo);
    padding: 60px 5%;
    max-width: 1100px;
    margin: 0 auto;
}

.serparte-intro {
    text-align: center;
    max-width: 800px;
    margin: 0 auto 50px auto;
}

.serparte-intro h2 {
    color: var(--boca-oro);
    font-family: 'Russo One', sans-serif;
    font-size: 2.2rem;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.serparte-intro p {
    color: var(--boca-gris-texto);
    font-size: 1.15rem;
    line-height: 1.8;
}

/* Grilla de Beneficios */
.beneficios-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 60px;
}

.beneficio-card {
    background-color: var(--boca-azul-principal);
    border-radius: 12px;
    padding: 30px;
    border: 1px solid rgba(255,255,255,0.05);
    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    transition: transform 0.3s;
}

.beneficio-card:hover {
    transform: translateY(-5px);
    border-color: rgba(249, 190, 61, 0.4);
}

.beneficio-card h3 {
    color: var(--boca-oro);
    font-family: 'Russo One', sans-serif;
    font-size: 1.3rem;
    margin-top: 0;
    margin-bottom: 15px;
    text-transform: uppercase;
}

.beneficio-card p {
    color: var(--boca-gris-texto);
    line-height: 1.6;
    margin: 0;
}

/* Caja de Asociación / Cuota */
.asociate-box {
    background: linear-gradient(135deg, var(--boca-azul-principal) 0%, var(--boca-azul-oscuro) 100%);
    border: 2px solid var(--boca-oro);
    border-radius: 12px;
    padding: 50px;
    text-align: center;
    box-shadow: 0 15px 40px rgba(0,0,0,0.6);
}

.asociate-box h3 {
    color: var(--boca-oro);
    font-family: 'Russo One', sans-serif;
    font-size: 2rem;
    margin-top: 0;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.asociate-box p {
    color: var(--boca-texto-claro);
    font-size: 1.1rem;
    max-width: 700px;
    margin: 0 auto 30px auto;
    line-height: 1.7;
}
</style>

<main id="primary" class="site-main">
    
    <!-- Cabecera -->
    <header class="page-header">
        <h1 class="page-title cabj-font">SER PARTE</h1>
    </header>

    <!-- Contenido Principal -->
    <section class="serparte-section">
        
        <!-- Introducción Asociación Civil -->
        <div class="serparte-intro">
            <h2 class="cabj-font">Hacete socio/a de la Peña</h2>
            <p>Formar parte de nuestra Asociación Civil es ser protagonista del crecimiento de Boca en Viedma y Patagones. Nuestro Estatuto Social nos encuadra, nos organiza y nos orienta para trabajar de manera transparente y federal.</p>
        </div>

        <!-- Tarjetas de Beneficios -->
        <div class="beneficios-grid">
            
            <div class="beneficio-card">
                <h3>Cuota Accesible</h3>
                <p>Mantenemos una cuota social económica para garantizar que todos los hinchas de la Comarca puedan sumarse y ser parte activa.</p>
            </div>

            <div class="beneficio-card">
                <h3>Gestiones Oficiales</h3>
                <p>Asesoramiento y acompañamiento directo para tus trámites, altas de socio/a y gestiones administrativas con el Club Atlético Boca Juniors.</p>
            </div>

            <div class="beneficio-card">
                <h3>Prioridad en Viajes</h3>
                <p>Acceso preferencial y organización comunitaria para los micros y traslados hacia los partidos en La Bombonera.</p>
            </div>

            <div class="beneficio-card">
                <h3>Espacio Propio</h3>
                <p>Voz y voto en nuestras asambleas, participando en las decisiones que toma el espacio democráticamente.</p>
            </div>

        </div>

        <!-- Bloque Final de Llamado a la Acción -->
        <div class="asociate-box">
            <h3 class="cabj-font">¿Querés asociarte hoy?</h3>
            <p>Escribinos directamente a nuestro WhatsApp oficial para conocer los requisitos, los valores actuales de la cuota y sumarte al padrón de socios/as de la Peña.</p>
            <a href="<?php echo site_url('/contacto'); ?>" class="btn-mod" style="background: var(--boca-oro); color: var(--boca-azul-oscuro); padding: 15px 35px; font-size: 1rem; display: inline-block;">Quiero asociarme</a>
        </div>

    </section>

</main>

<?php get_footer(); ?>