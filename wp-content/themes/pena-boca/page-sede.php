<?php
/*
Template Name: Sede Bostera
*/
get_header(); ?>

<style>
/* ==========================================
   ESTILOS DE LA PÁGINA DE SEDE
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

.sede-section {
    background-color: var(--boca-fondo);
    padding: 60px 5%;
    max-width: 1200px;
    margin: 0 auto;
}

.sede-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
}

.sede-info h2 {
    color: var(--boca-oro);
    font-family: 'Russo One', sans-serif;
    font-size: 2rem;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.sede-info p {
    color: var(--boca-gris-texto);
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 20px;
}

.sede-features {
    list-style: none;
    padding: 0;
    margin: 20px 0;
}

.sede-features li {
    color: var(--boca-texto-claro);
    font-size: 1.05rem;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.sede-features li::before {
    content: "⭐";
    color: var(--boca-oro);
}

.sede-map {
    border-radius: 12px;
    overflow: hidden;
    border: 3px solid var(--boca-azul-principal);
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    min-height: 400px;
}

.sede-map iframe {
    width: 100%;
    height: 100%;
    min-height: 400px;
    border: 0;
}

@media (max-width: 900px) {
    .sede-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<main id="primary" class="site-main">
    
    <!-- Cabecera -->
    <header class="page-header">
        <h1 class="page-title cabj-font">NUESTRA SEDE BOSTERA</h1>
    </header>

    <!-- Contenido Principal -->
    <section class="sede-section">
        <div class="sede-grid">
            
            <!-- Columna de Texto (Relevamiento) -->
            <div class="sede-info">
                <h2 class="cabj-font">¿Todavía no conocés la sede bostera de la Comarca?</h2>
                <p>Es el punto de encuentro de todos los hinchas y socios de Viedma y Patagones. Un espacio propio para vivir nuestra pasión en comunidad.</p>
                
                <ul class="sede-features">
                    <li>Transmitimos todos los partidos en pantalla gigante.</li>
                    <li>Participá de las actividades sin necesidad de ser socio/a.</li>
                    <li>Reuniones, previas, asambleas y camaradería boquense.</li>
                </ul>

                <div style="margin-top: 30px;">
                    <a href="<?php echo site_url('/contacto'); ?>" class="btn-mod" style="background: var(--boca-oro); color: var(--boca-azul-oscuro); display: inline-block;">Consultar por actividades</a>
                </div>
            </div>

            <!-- Columna de Mapa (Google Maps - Comarca Viedma/Patagones) -->
            <div class="sede-map">
                <!-- Mapa centrado de forma genérica en Viedma / Patagones -->
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3020.831208608353!2d-63.004652323243306!3d-40.7877248097895!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95f6a2b83d797d75%3A0xe0b142a8e499cff7!2sColectora%20Oeste%20415%2C%20B8504%20Carmen%20de%20Patagones%2C%20Provincia%20de%20Buenos%20Aires!5e0!3m2!1ses-419!2sar!4v1787174988635!5m2!1ses-419!2sar" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>            </div>

        </div>
    </section>

</main>

<?php get_footer(); ?>