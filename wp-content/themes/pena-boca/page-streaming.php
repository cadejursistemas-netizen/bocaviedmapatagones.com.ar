<?php
/*
Template Name: Streaming Bostero
*/
get_header(); ?>

<style>
/* ==========================================
   ESTILOS DE LA PÁGINA DE STREAMING
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

.streaming-section {
    background-color: var(--boca-fondo);
    padding: 60px 5%;
    max-width: 1100px;
    margin: 0 auto;
}

.streaming-grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 40px;
    align-items: center;
}

/* Contenedor del video responsivo */
.video-container {
    position: relative;
    width: 100%;
    padding-bottom: 56.25%; /* Proporción 16:9 */
    height: 0;
    border-radius: 12px;
    overflow: hidden;
    border: 3px solid var(--boca-azul-principal);
    box-shadow: 0 10px 30px rgba(0,0,0,0.6);
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}

.streaming-info h2 {
    color: var(--boca-oro);
    font-family: 'Russo One', sans-serif;
    font-size: 2rem;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.streaming-info p {
    color: var(--boca-gris-texto);
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 20px;
}

.stream-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: rgba(22, 40, 79, 0.6);
    border: 1px solid var(--boca-oro);
    padding: 8px 16px;
    border-radius: 20px;
    color: var(--boca-oro);
    font-weight: bold;
    margin-bottom: 20px;
    font-size: 0.9rem;
    text-transform: uppercase;
}

.stream-badge span {
    width: 10px;
    height: 10px;
    background-color: #ff3333;
    border-radius: 50%;
    display: inline-block;
    box-shadow: 0 0 8px #ff3333;
}

@media (max-width: 900px) {
    .streaming-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<main id="primary" class="site-main">
    
    <!-- Cabecera -->
    <header class="page-header">
        <h1 class="page-title cabj-font">PROGRAMA DE STREAMING</h1>
    </header>

    <!-- Contenido Principal -->
    <section class="streaming-section">
        <div class="streaming-grid">
            
            <!-- Columna Izquierda: Reproductor de YouTube -->
            <div class="video-container">
                <!-- Reemplazá el enlace del iframe con el link embed de tu último programa o canal de YouTube -->
<iframe width="1337" height="752" src="https://www.youtube.com/embed/QsEG9r8cuoc" title="DE LA BOCA PARA AFUERA | Programa 12" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>            </div>

            <!-- Columna Derecha: Información del Relevamiento -->
            <div class="streaming-info">
                <div class="stream-badge">
                    <span></span> Todos los viernes desde las 19 hs
                </div>
                
                <h2 class="cabj-font">¡Vení a participar en vivo!</h2>
                <p>Escuchanos todos los viernes a través de nuestro canal de YouTube para debatir toda la actualidad del Mundo Boca, repasar la vida institucional de nuestra Peña y vivir la previa de cada partido.</p>
                <p><strong>¿Querés sumarte al panel?</strong> Es un espacio abierto para todas las bosteras y bosteros de la Comarca que quieran dar su opinión y ser parte de la transmisión.</p>

                <div style="margin-top: 30px; display: flex; gap: 15px; flex-wrap: wrap;">
                    <a href="https://www.youtube.com/@BocaViedmaPatagones" target="_blank" class="btn-mod" style="background: var(--boca-oro); color: var(--boca-azul-oscuro);">Ir al Canal de YouTube</a>
                    <a href="<?php echo site_url('/contacto'); ?>" class="btn-mod">Quiero participar</a>
                </div>
            </div>

        </div>
    </section>

</main>

<?php get_footer(); ?>