<?php
/*
Template Name: Institucional y Principios
*/
get_header(); ?>

<style>
/* ==========================================
   ESTILOS DE LA PÁGINA INSTITUCIONAL
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

.institucional-section {
    background-color: var(--boca-fondo);
    padding: 60px 5%;
    max-width: 1000px;
    margin: 0 auto;
}

/* Bloques de Secciones (Historia, Autoridades, Principios) */
.inst-block {
    background-color: var(--boca-azul-principal);
    border-radius: 12px;
    padding: 40px;
    margin-bottom: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    border-left: 5px solid var(--boca-oro);
}

.inst-block h2 {
    color: var(--boca-oro);
    font-family: 'Russo One', sans-serif;
    font-size: 1.8rem;
    margin-top: 0;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.inst-block p, .inst-block li {
    color: var(--boca-gris-texto);
    font-size: 1.05rem;
    line-height: 1.8;
}

.inst-block ul {
    padding-left: 20px;
}

.inst-block li {
    margin-bottom: 10px;
}

/* Estilo para los Principios Innegociables */
.principios-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.principio-card {
    background-color: var(--boca-azul-oscuro);
    padding: 20px;
    border-radius: 8px;
    border-top: 3px solid var(--boca-oro);
}

.principio-card h4 {
    color: var(--boca-oro);
    margin: 0 0 10px 0;
    font-size: 1.1rem;
    text-transform: uppercase;
}

.principio-card p {
    font-size: 0.95rem;
    margin: 0;
}
</style>

<main id="primary" class="site-main">
    
    <!-- Cabecera -->
    <header class="page-header">
        <h1 class="page-title cabj-font">NUESTRA INSTITUCIÓN</h1>
    </header>

    <!-- Contenido Principal -->
    <section class="institucional-section">
        
        <!-- Bloque 1: Presentación / Grupo Abierto -->
        <div class="inst-block">
            <h2 class="cabj-font">Grupo Abierto de Bosteros y Bosteras</h2>
            <p>Militamos en equipo a Boca a pulmón desde hace muchos años; poniendo el cuerpo, cabeza y corazón en cada cosa que hacemos. Esto no lo hacemos de forma improvisada: Nuestro proyecto institucional está orientado por principios innegociables.</p>
        </div>

        <!-- Bloque 2: Principios Innegociables -->
        <div class="inst-block">
            <h2 class="cabj-font">Principios Innegociables</h2>
            <p>Los valores que guían cada paso de nuestra Peña en la Comarca Viedma-Patagones:</p>
            
            <div class="principios-grid">
                <div class="principio-card">
                    <h4>Democracia Interna</h4>
                    <p>Decisiones construidas colectivamente y participación activa de los socios.</p>
                </div>
                <div class="principio-card">
                    <h4>Compromiso Social</h4>
                    <p>Un espacio presente que acompaña las necesidades de la comunidad.</p>
                </div>
                <div class="principio-card">
                    <h4>Defensa del Socio</h4>
                    <p>Garantizar que el Club siga siendo de los socios y socias.</p>
                </div>
            </div>
        </div>

        <!-- Bloque 3: Historia -->
        <div class="inst-block">
            <h2 class="cabj-font">Historia</h2>
            <p>El camino recorrido para convertirnos en el único espacio de la Comarca con reconocimiento oficial de Boca Juniors. Años de esfuerzo, viajes, encuentros en la sede y un sentimiento inquebrantable.</p>
            <!-- Acá podés explayarte o editar el texto libremente desde el panel de WP -->
        </div>

        <!-- Bloque 4: Autoridades -->
        <div class="inst-block">
            <h2 class="cabj-font">Autoridades</h2>
            <ul>
                <li><strong>Presidenta:</strong> Florencia Gastaminza</li>
                <li><strong>Secretaria General:</strong> María Sol Taraborrelli</li>
                <li><strong>Tesorero:</strong> Juan Marcos González</li>
            </ul>

            <h3 class="cabj-font" style="color: var(--boca-oro); margin-top: 30px;">Vocales y áreas a cargo</h3>
            <div class="principios-grid">
                <div class="principio-card">
                    <h4>Viajes</h4>
                    <p>Facundo Mendoza</p>
                </div>
                <div class="principio-card">
                    <h4>Streaming</h4>
                    <p>Lautaro Iriondo</p>
                </div>
                <div class="principio-card">
                    <h4>Socixs Peña</h4>
                    <p>Pablo Zeki</p>
                </div>
                <div class="principio-card">
                    <h4>Socixs Boca</h4>
                    <p>María Victoria Rodríguez</p>
                </div>
                <div class="principio-card">
                    <h4>Acción Social</h4>
                    <p>Aldana Jauge</p>
                </div>
            </div>

            <ul style="margin-top: 30px;">
                <li><strong>Revisor de cuentas:</strong> Alfonso Gimenez</li>
            </ul>
        </div>

        <!-- Bloque 5: Organización general y participación -->
        <div class="inst-block">
            <h2 class="cabj-font">Organización general y participación</h2>
            <p>Además de la Comisión, contamos con un grupo de organización que planifica y coordina el funcionamiento de la Peña. Somos más de 30 socios y socias que participamos activamente en las distintas áreas de trabajo. Este grupo constituye el alma de la Peña: una mesa ampliada de toma de decisiones, donde compartimos ideas, definimos objetivos y construimos colectivamente su rumbo.</p>
        </div>

    </section>

</main>

<?php get_footer(); ?>