 <?php
/*
Template Name: Galería de Actividades
*/
get_header(); ?>

<style>
/* ==========================================
   ESTILOS DE LA GALERÍA FILTRABLE
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

.page-subtitle {
    color: var(--boca-texto-claro);
    font-size: 1.1rem;
    margin-top: 15px;
}

.actividades-intro {
    max-width: 900px;
    margin: 0 auto;
    padding: 40px 5% 0 5%;
    text-align: center;
    color: var(--boca-texto-claro);
    font-size: 1.1rem;
    line-height: 1.7;
}

.actividades-lema {
    color: var(--boca-oro);
    font-weight: 800;
    font-size: 1.3rem;
}

.gallery-section {
    background-color: var(--boca-fondo);
    padding: 50px 5% 80px 5%;
    min-height: 60vh;
    max-width: 1300px;
    margin: 0 auto;
}

/* Menú de Filtros */
.gallery-filters {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    margin-bottom: 40px;
}

.filter-btn {
    background: transparent;
    border: 2px solid var(--boca-azul-principal);
    color: var(--boca-texto-claro);
    padding: 8px 18px;
    border-radius: 20px;
    cursor: pointer;
    font-family: 'Montserrat', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    text-transform: uppercase;
}

.filter-btn:hover {
    border-color: var(--boca-oro);
    color: var(--boca-oro);
}

.filter-btn.active {
    background: var(--boca-oro);
    color: var(--boca-azul-oscuro);
    border-color: var(--boca-oro);
}

/* Grilla de Imágenes */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}

.gallery-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    aspect-ratio: 1 / 1;
    background-color: var(--boca-azul-oscuro);
    cursor: pointer;
    display: block; /* Se controla con JS */
}

/* Animación para ocultar/mostrar con el filtro */
.gallery-item.hide {
    display: none;
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.gallery-item:hover img {
    transform: scale(1.1);
}

.gallery-overlay {
    position: absolute;
    bottom: -100%;
    left: 0;
    width: 100%;
    padding: 30px 20px 20px 20px;
    background: linear-gradient(to top, rgba(10, 17, 34, 0.95), transparent);
    transition: bottom 0.4s ease;
}

.gallery-item:hover .gallery-overlay {
    bottom: 0;
}

.gallery-cat {
    color: var(--boca-oro);
    font-weight: 800;
    font-size: 0.8rem;
    text-transform: uppercase;
    margin-bottom: 5px;
    display: block;
}

.gallery-desc {
    color: white;
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
}
</style>

<main id="primary" class="site-main">
    
    <!-- Cabecera -->
    <header class="page-header">
        <h1 class="page-title cabj-font">NUESTRAS ACTIVIDADES</h1>
        <p class="page-subtitle">El trabajo de la Peña en Viedma - Patagones y la Bombonera</p>
    </header>

    <!-- Introducción -->
    <section class="actividades-intro">
        <p>En la Peña hay propuestas para todos los gustos y edades: torneos de PlayStation y truco, intercambio de figuritas, catas de vino, fútbol, juntadas nocturnas y mucho más. Si tenés ganas de compartir la pasión por Boca de una manera diferente, ¡seguro encontrás tu lugar! Y si tenés alguna propuesta, también podés acercarla.</p>
        <p class="actividades-lema">¡Vamos los xeneizes!</p>
        <div style="display:flex; gap:15px; justify-content:center; flex-wrap:wrap; margin-top:25px;">
            <a href="<?php echo site_url('/futbol'); ?>" class="btn-mod">Fútbol semanal</a>
            <a href="<?php echo site_url('/accion-social'); ?>" class="btn-mod">Acción Social</a>
        </div>
    </section>

    <!-- Sección de Galería -->
    <section class="gallery-section">
        
        <!-- Botones de Filtro (Relevamiento) -->
        <div class="gallery-filters">
            <button class="filter-btn active" data-filter="all">Todas</button>
            <button class="filter-btn" data-filter="cancha">Cancha</button>
            <button class="filter-btn" data-filter="sede">Sede</button>
            <button class="filter-btn" data-filter="copa-socios">Copa Socios</button>
            <button class="filter-btn" data-filter="accion-social">Acción Social</button>
            <button class="filter-btn" data-filter="articulacion">Articulación CABJ</button>
            <button class="filter-btn" data-filter="reconocimientos">Reconocimientos</button>
            <button class="filter-btn" data-filter="mesa-trabajo">Mesa de Trabajo</button>
            <button class="filter-btn" data-filter="asambleas">Asambleas</button>
        </div>

        <!-- Grilla de Fotos -->
        <div class="gallery-grid" id="gallery-container">
            
            <!-- Ejemplo 1: Cancha -->
            <div class="gallery-item" data-category="cancha">
                <img src="https://cdn-imgix.headout.com/media/images/e8053359-e21a-4dd9-a486-2f73722b29c2-1747905609251-277193.jpg?auto=compress%2Cformat&q=90&crop=faces&fit=crop" alt="Viaje a la cancha">
                <div class="gallery-overlay">
                    <span class="gallery-cat">Cancha</span>
                    <p class="gallery-desc">Viaje a La Bombonera</p>
                </div>
            </div>

            <!-- Ejemplo 2: Acción Social -->
            <div class="gallery-item" data-category="accion-social">
                <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Acción Social">
                <div class="gallery-overlay">
                    <span class="gallery-cat">Acción Social</span>
                    <p class="gallery-desc">Colecta en la Comarca</p>
                </div>
            </div>

            <!-- Ejemplo 3: Sede -->
            <div class="gallery-item" data-category="sede">
                <img src="https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Sede">
                <div class="gallery-overlay">
                    <span class="gallery-cat">Sede</span>
                    <p class="gallery-desc">Previa del partido</p>
                </div>
            </div>

            <!-- Ejemplo 4: Articulación CABJ -->
            <div class="gallery-item" data-category="articulacion">
                <img src="https://images.unsplash.com/photo-1511886929837-354d827aae26?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Articulación CABJ">
                <div class="gallery-overlay">
                    <span class="gallery-cat">Articulación CABJ</span>
                    <p class="gallery-desc">Reunión en Brandsen 805</p>
                </div>
            </div>

            <!-- Ejemplo 5: Asambleas -->
            <div class="gallery-item" data-category="asambleas">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Asambleas">
                <div class="gallery-overlay">
                    <span class="gallery-cat">Asambleas</span>
                    <p class="gallery-desc">Asamblea de Socios</p>
                </div>
            </div>

            <!-- Ejemplo 6: Copa Socios -->
            <div class="gallery-item" data-category="copa-socios">
                <img src="https://images.unsplash.com/photo-1526232761682-d26e03ac148e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Copa Socios">
                <div class="gallery-overlay">
                    <span class="gallery-cat">Copa Socios</span>
                    <p class="gallery-desc">Torneo relámpago</p>
                </div>
            </div>

            <!-- PODÉS COPIAR Y PEGAR MÁS BLOQUES IGUALES A ESTOS Y CAMBIARLES EL "data-category" -->

        </div>
    </section>

</main>

<script>
// Lógica de Filtrado con Vanilla JS
document.addEventListener("DOMContentLoaded", function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // 1. Manejo de clases activas en los botones
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            // 2. Obtener el filtro seleccionado
            const filterValue = this.getAttribute('data-filter');

            // 3. Mostrar/Ocultar imágenes
            galleryItems.forEach(item => {
                if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                    item.classList.remove('hide');
                } else {
                    item.classList.add('hide');
                }
            });
        });
    });
});
</script>

<?php get_footer(); ?>