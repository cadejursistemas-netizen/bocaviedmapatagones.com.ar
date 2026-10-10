<?php
/*
Template Name: Preguntas Frecuentes
*/
get_header(); ?>

<style>
.page-header { background-color: var(--boca-azul-principal); padding: 60px 5% 40px 5%; text-align: center; border-bottom: 4px solid var(--boca-oro); }
.page-title { color: var(--boca-oro); font-size: 2.8rem; margin: 0; letter-spacing: 1px; }
.faq-section { background-color: var(--boca-fondo); padding: 60px 5%; max-width: 900px; margin: 0 auto; }
.faq-item { background-color: var(--boca-azul-principal); border-left: 5px solid var(--boca-oro); border-radius: 12px; margin-bottom: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.4); }
.faq-item summary { cursor: pointer; padding: 22px 25px; color: var(--boca-oro); font-family: 'Russo One', sans-serif; font-size: 1.15rem; list-style: none; position: relative; padding-right: 55px; }
.faq-item summary::-webkit-details-marker { display: none; }
.faq-item summary::after { content: "+"; position: absolute; right: 25px; top: 50%; transform: translateY(-50%); font-size: 1.6rem; }
.faq-item[open] summary::after { content: "–"; }
.faq-body { padding: 0 25px 10px 25px; }
.faq-body p { color: var(--boca-gris-texto); font-size: 1.05rem; line-height: 1.8; margin: 0 0 15px 0; }
</style>

<main id="primary" class="site-main">

    <header class="page-header">
        <h1 class="page-title cabj-font">PREGUNTAS FRECUENTES</h1>
    </header>

    <section class="faq-section">

        <details class="faq-item">
            <summary>¿Cuánto sale la cuota de la Peña?</summary>
            <div class="faq-body">
                <p>¡Solo $5.000 por mes! Una forma de ayudar a sostener la institución bostera de la Comarca.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary>¿Cuánto cuesta la entrada para ver un partido en la sede?</summary>
            <div class="faq-body">
                <p>¡Es gratuita! Si consumís algo, eso nos ayuda. Pero no es obligatorio tampoco.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary>¿Necesito ser socio para ir a la sede, viajar o participar de las actividades?</summary>
            <div class="faq-body">
                <p>¡No! No necesitás ser socio de la Peña ni de Boca.</p>
                <p><strong>Único requisito: ser hincha de Boca.</strong></p>
            </div>
        </details>

        <details class="faq-item">
            <summary>¿Es lo mismo ser socio/a de la Peña que ser socio/a de Boca?</summary>
            <div class="faq-body">
                <p>No, son dos cosas diferentes.</p>
                <p>🔹 Ser socio de la Peña te permite formar parte de nuestra comunidad bostera de Viedma y Patagones, con beneficios vinculados a las actividades y propuestas que organizamos desde acá.</p>
                <p>🔹 Ser socio de Boca significa asociarte directamente al Club Atlético Boca Juniors y acceder a los beneficios que ofrece el club, de acuerdo con la categoría de socio.</p>
                <p>¡Y hay algo más! Desde la Peña podemos acompañarte directamente: te gestionamos la impresión del carnet y te ayudamos con las gestiones.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary>¿Cómo puedo colaborar con la Peña?</summary>
            <div class="faq-body">
                <p>¡Hay muchas formas de dar una mano!</p>
                <p>💙 <strong>Donando:</strong> muebles, objetos de decoración de Boca, banderas o cualquier elemento que pueda servir para nuestro local.</p>
                <p>💛 <strong>Proponiendo ideas y tu voluntad de participar activamente:</strong> compartiendo iniciativas y propuestas para seguir creciendo.</p>
                <p>💙 <strong>Haciéndote socio/a y motivando a tus amistades a asociarse:</strong> mientras más seamos, más vamos a poder generar para la gente de Boca.</p>
            </div>
        </details>

    </section>

</main>

<?php get_footer(); ?>
