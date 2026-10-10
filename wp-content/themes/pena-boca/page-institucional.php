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

.inst-block { scroll-margin-top: 100px; }
@media (max-width: 600px) { .inst-block { padding: 24px 20px; } .hitos { padding-left: 15px; } }

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

.hitos { margin: 25px 0; border-left: 3px solid var(--boca-oro); padding-left: 25px; }
.hito { display: flex; gap: 20px; margin-bottom: 25px; align-items: flex-start; }
.hito-year { background-color: var(--boca-oro); color: var(--boca-azul-oscuro); font-family: 'Russo One', sans-serif; padding: 6px 14px; border-radius: 6px; font-size: 1.1rem; flex-shrink: 0; }
.hito h4 { color: var(--boca-oro); margin: 0 0 6px 0; font-size: 1.1rem; text-transform: uppercase; }
.hito p { margin: 0; }
.hito-img { display: block; width: auto; height: auto; max-width: min(100%, 420px); max-height: 480px; border-radius: 8px; margin-top: 12px; border: 2px solid var(--boca-oro); }
@media (max-width: 600px) { .hito { flex-direction: column; gap: 8px; } }

.autoridades-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 16px; margin-top: 25px; }
.autoridades-grid .autoridad { flex: 0 1 150px; }
.autoridades-grid.autoridades-3 .autoridad, .autoridades-1 .autoridad { flex-basis: 240px; }
.autoridad { box-sizing: border-box; background-color: var(--boca-azul-oscuro); border-top: 3px solid var(--boca-oro); border-radius: 10px; padding: 22px 14px; text-align: center; }
.autoridad img, .autoridad-ini { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid var(--boca-oro); display: block; margin: 0 auto 14px auto; }
.autoridad-ini { display: flex; align-items: center; justify-content: center; background: var(--boca-azul-principal); color: var(--boca-oro); font-family: 'Russo One', sans-serif; font-size: 2rem; }
.autoridad h4 { color: var(--boca-oro); margin: 0 0 6px 0; font-size: 1rem; text-transform: uppercase; }
.autoridad p { margin: 0; font-size: 1rem; color: var(--boca-texto-claro); }
@media (max-width: 700px) { .autoridades-grid { gap: 12px; } .autoridades-grid .autoridad, .autoridades-grid.autoridades-3 .autoridad, .autoridades-1 .autoridad { flex: 0 0 calc(50% - 8px); padding: 18px 8px; } .autoridad img, .autoridad-ini { width: 96px; height: 96px; } }

.org-fotos { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 25px; }
.org-foto { margin: 0; aspect-ratio: 3 / 4; border-radius: 10px; overflow: hidden; border: 2px solid var(--boca-oro); background: var(--boca-azul-oscuro); }
.org-foto img { width: 100%; height: 100%; object-fit: cover; object-position: center 60%; display: block; transition: transform 0.4s ease; }
.org-foto:hover img { transform: scale(1.05); }
@media (max-width: 700px) { .org-fotos { grid-template-columns: 1fr; } .org-foto { aspect-ratio: 4 / 3; } }

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

        <!-- Bloque 2: Principios -->
        <div class="inst-block" id="principios">
            <h2 class="cabj-font">Principios</h2>
            <p>Nuestras acciones no son improvisadas. Están orientadas por principios que acordamos y organizan lo que hacemos:</p>

            <div class="principios-grid">
                <div class="principio-card">
                    <h4>Solo por y para Boca</h4>
                    <p>El único fin es que Boca siga siendo cada vez más grande. Todo lo que genera la Peña es de la Peña y el pueblo bostero.</p>
                </div>
                <div class="principio-card">
                    <h4>Peña abierta</h4>
                    <p>Una Peña mejor se hace entre muchos. Alentamos que se involucren y recibimos observaciones, necesidades e ideas.</p>
                </div>
                <div class="principio-card">
                    <h4>Somos Boca</h4>
                    <p>Representar oficialmente a Boca implica el compromiso afín a los valores del CABJ, su identidad e historia.</p>
                </div>
                <div class="principio-card">
                    <h4>Nada mejor que otro bostero</h4>
                    <p>Trabajar en equipo es un desafío con complejidades propias. Comunicar lo que sentimos y sostener los buenos tratos es fundamental para que crezca la Peña. Acá no sobra nadie.</p>
                </div>
            </div>
        </div>

        <!-- Bloque 3: Historia -->
        <div class="inst-block" id="historia">
            <h2 class="cabj-font">Historia</h2>
            <div class="hitos">
                <div class="hito">
                    <span class="hito-year">2021</span>
                    <div>
                        <p>Un grupo de socios y socias de Boca, que ni siquiera nos conocíamos, necesitábamos estar cerca de una peña. Nos acercamos a colaborar a la peña Patagonia Azul y Oro, con la representación oficial de Boca desde 1997, pero más enfocada en un club de fútbol.</p>
                    </div>
                </div>

                <div class="hito">
                    <span class="hito-year">2022</span>
                    <div>
                        <p>Creamos allí un área de gestión para socios de Boca, pero luego notamos que eran dos funciones distintas: un club local por un lado y una peña dedicada exclusivamente a socios y socias e hinchas de Boca por el otro.</p>
                    </div>
                </div>

                <div class="hito">
                    <span class="hito-year">2023</span>
                    <div>
                        <p>Por eso, acordamos separar caminos con el aval del Club Atlético Boca Juniors. Renovamos las autoridades a través de la Asamblea y nació nuestra peña oficial. Ese grupo de socios que solo quería estar cerca de una peña, ahora estaba a cargo de la misma.</p>
                    </div>
                </div>

                <div class="hito">
                    <span class="hito-year">2024</span>
                    <div>
                        <p>Asumimos la responsabilidad consolidada, formalizamos el trabajo, áreas referentes y nuestro sistema de socio peña.</p>
                    </div>
                </div>

                <div class="hito">
                    <span class="hito-year">2025</span>
                    <div>
                        <p>Obtuvimos la personería jurídica y abrimos nuestro local. En relación a Boca, fuimos elegidos como sede de la Copa Socios y tenemos el orgullo de que nuestra bandera esté colgada cada partido en la Bombonera.</p>
                    </div>
                </div>

                <div class="hito">
                    <span class="hito-year">2026</span>
                    <div>
                        <p>Seguimos construyendo la Peña y sabemos que lo mejor está por venir. ¿Te lo vas a perder? Vos también podés ser parte. Ya te avisamos.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bloque: Reconocimientos -->
        <div class="inst-block" id="reconocimientos">
            <h2 class="cabj-font">Reconocimientos</h2>
            <p>Nuestra Peña se consolida como una institución cada vez más reconocida, tanto en el territorio como en el Club Atlético Boca Juniors. Este recorrido es el resultado del trabajo colectivo, el compromiso y la construcción de una comunidad xeneize.</p>
            <p>Compartimos algunos de los hitos más importantes de nuestra historia institucional:</p>

            <div class="hitos">
                <div class="hito">
                    <span class="hito-year">2022</span>
                    <div>
                        <h4>Convención Nacional de Peñas</h4>
                        <p>A fines de 2022, fuimos convocados a participar de la Convención Nacional de Peñas del Club Atlético Boca Juniors.</p>
                        <img class="hito-img" src="<?php echo get_template_directory_uri(); ?>/images/rec-2022.webp" alt="Reconocimiento 2022" loading="lazy">
                    </div>
                </div>

                <div class="hito">
                    <span class="hito-year">2023</span>
                    <div>
                        <h4>Reconocimiento de las autoridades oficiales</h4>
                        <p>Boca Juniors nos reconoció como las nuevas autoridades a cargo de la Peña Oficial, en ese entonces con Carlos Colombo a cargo del Departamento de Interior y Exterior.</p>
                        <img class="hito-img" src="<?php echo get_template_directory_uri(); ?>/images/rec-2023.webp" alt="Reconocimiento 2023" loading="lazy">
                    </div>
                </div>

                <div class="hito">
                    <span class="hito-year">2025</span>
                    <div>
                        <h4>Sede de la Copa Socios</h4>
                        <p>Fuimos seleccionados por el Club Atlético Boca Juniors como sede de la Copa Socios, con el Presidente actual Miguel Dinopulos a cargo del Departamento de Interior y Exterior.</p>
                        <img class="hito-img" src="<?php echo get_template_directory_uri(); ?>/images/gal-copa.webp" alt="Reconocimiento 2025" loading="lazy">
                    </div>
                </div>

                <div class="hito">
                    <span class="hito-year">2026</span>
                    <div>
                        <h4>Interés provincial</h4>
                        <p>La Copa Socios fue declarada de interés provincial por la Legislatura de la Provincia de Río Negro, destacando la relevancia de esta iniciativa en el territorio.</p>
                        <img class="hito-img" src="<?php echo get_template_directory_uri(); ?>/images/rec-2026.webp" alt="Reconocimiento 2026: Copa Socios de interés provincial" loading="lazy">
                    </div>
                </div>
            </div>

            <p>Cada uno de estos hitos forma parte de una construcción colectiva que seguimos fortaleciendo, con el compromiso de representar a Boca, a la altura de lo que representa para nosotrxs.</p>
        </div>

        <!-- Bloque 4: Autoridades -->
        <div class="inst-block" id="autoridades">
            <h2 class="cabj-font">Autoridades</h2>
            <?php
            // Las autoridades se editan desde el panel de WordPress (menú "Autoridades").
            if ( ! function_exists( 'pboca_tarjeta_autoridad' ) ) {
                function pboca_tarjeta_autoridad( $p ) {
                    $iniciales = '';
                    foreach ( explode( ' ', $p['nombre'] ) as $parte ) { $iniciales .= mb_substr( $parte, 0, 1 ); }
                    $iniciales = mb_substr( $iniciales, 0, 2 );
                    echo '<div class="autoridad">';
                    if ( $p['foto'] ) {
                        echo '<img src="' . esc_url( $p['foto'] ) . '" alt="' . esc_attr( $p['nombre'] ) . '" loading="lazy" width="400" height="400">';
                    } else {
                        echo '<span class="autoridad-ini">' . esc_html( $iniciales ) . '</span>';
                    }
                    echo '<h4>' . esc_html( $p['cargo'] ) . '</h4><p>' . esc_html( $p['nombre'] ) . '</p></div>';
                }
            }
            $pboca_cargos  = pboca_get_autoridades( 'principal' );
            $pboca_vocales = pboca_get_autoridades( 'vocal' );
            $pboca_revisor = pboca_get_autoridades( 'revisor' );
            ?>

            <div class="autoridades-grid autoridades-3">
                <?php foreach ( $pboca_cargos as $p ) { pboca_tarjeta_autoridad( $p ); } ?>
            </div>

            <h3 class="cabj-font" style="color: var(--boca-oro); margin: 35px 0 0 0; text-align: center;">Vocales y áreas a cargo</h3>
            <div class="autoridades-grid">
                <?php foreach ( $pboca_vocales as $p ) { pboca_tarjeta_autoridad( $p ); } ?>
            </div>

            <div class="autoridades-grid autoridades-1">
                <?php foreach ( $pboca_revisor as $p ) { pboca_tarjeta_autoridad( $p ); } ?>
            </div>
        </div>

        <!-- Bloque 5: Organización general y participación -->
        <div class="inst-block" id="organizacion">
            <h2 class="cabj-font">Organización general y participación</h2>
            <p>Además de la Comisión, contamos con un grupo de organización que planifica y coordina el funcionamiento de la Peña. Somos más de 30 socios y socias que participamos activamente en las distintas áreas de trabajo. Este grupo constituye el alma de la Peña: una mesa ampliada de toma de decisiones, donde compartimos ideas, definimos objetivos y construimos colectivamente su rumbo.</p>
            <div class="org-fotos">
            <figure class="org-foto"><img src="<?php echo get_template_directory_uri(); ?>/images/organizacion-1.webp" alt="Grupo de organización de la Peña en la sede" loading="lazy"></figure>
            <figure class="org-foto"><img src="<?php echo get_template_directory_uri(); ?>/images/organizacion-2.webp" alt="Reunión de organización en la sede" loading="lazy"></figure>
            <figure class="org-foto"><img src="<?php echo get_template_directory_uri(); ?>/images/organizacion-3.webp" alt="Encuentro de socios y socias en la sede" loading="lazy"></figure>
            </div>
        </div>

    </section>

</main>

<?php get_footer(); ?>