<?php
// page.php
get_header(); ?>

<style>
/* ==========================================
   ESTILOS BASE PARA PÁGINAS INTERNAS
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

.page-content-wrapper {
    background-color: var(--boca-fondo);
    color: var(--boca-texto-claro);
    padding: 60px 5%;
    min-height: 55vh; /* Evita que el footer suba si la página tiene poco texto */
}

.page-content {
    max-width: 900px;
    margin: 0 auto;
    font-size: 1.1rem;
    line-height: 1.8;
}

/* Formateo de los bloques nativos de WordPress */
.page-content h2, 
.page-content h3, 
.page-content h4 {
    color: var(--boca-oro);
    font-family: 'Russo One', 'Impact', sans-serif;
    margin-top: 40px;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.page-content p {
    margin-bottom: 20px;
    color: var(--boca-texto-claro);
}

.page-content a {
    color: var(--boca-oro);
    text-decoration: underline;
    font-weight: bold;
    transition: color 0.3s;
}

.page-content a:hover {
    color: white;
}

.page-content ul, 
.page-content ol {
    margin-bottom: 25px;
    padding-left: 20px;
    color: var(--boca-gris-texto);
}

.page-content li {
    margin-bottom: 10px;
}

/* Bloque de cita (Quote) ideal para los "Principios" */
.page-content blockquote {
    border-left: 4px solid var(--boca-oro);
    margin: 30px 0;
    font-style: italic;
    color: var(--boca-texto-claro);
    background: rgba(22, 40, 79, 0.4); /* Azul principal con transparencia */
    padding: 20px 30px;
    border-radius: 0 8px 8px 0;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
}
</style>

<main id="primary" class="site-main">
    <?php
    /* El Loop clásico de WordPress */
    while ( have_posts() ) :
        the_post();
        ?>
        
        <!-- Cabecera de la página con el título -->
        <header class="page-header">
            <h1 class="page-title cabj-font"><?php the_title(); ?></h1>
        </header>

        <!-- Contenedor principal del texto/bloques -->
        <div class="page-content-wrapper">
            <div class="page-content">
                <?php 
                // Renderiza todo el contenido cargado desde el panel de administración
                the_content(); 
                ?>
            </div>
        </div>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>