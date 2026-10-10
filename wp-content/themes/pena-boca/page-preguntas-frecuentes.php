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
        <?php foreach ( pboca_get_faqs() as $faq ) : ?>
        <details class="faq-item">
            <summary><?php echo esc_html( $faq['pregunta'] ); ?></summary>
            <div class="faq-body">
                <?php echo $faq['respuesta']; // HTML ya limpio en pboca_get_faqs() ?>
            </div>
        </details>
        <?php endforeach; ?>
    </section>

</main>

<?php get_footer(); ?>
