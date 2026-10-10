<?php
/*
Template Name: Galería de Fotos
*/
get_header(); ?>

<style>
.page-header { background-color: var(--boca-azul-principal); padding: 60px 5% 40px 5%; text-align: center; border-bottom: 4px solid var(--boca-oro); }
.page-title { color: var(--boca-oro); font-size: 2.8rem; margin: 0; letter-spacing: 1px; }
.page-subtitle { color: var(--boca-texto-claro); font-size: 1.1rem; margin-top: 15px; }
.galeria-section { background-color: var(--boca-fondo); padding: 40px 5% 80px 5%; max-width: 1300px; margin: 0 auto; }
.galeria-filtros { display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; margin-bottom: 30px; }
.galeria-filtros button { background: transparent; border: 2px solid var(--boca-azul-principal); color: var(--boca-texto-claro); padding: 8px 18px; border-radius: 20px; cursor: pointer; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; transition: all 0.3s ease; }
.galeria-filtros button:hover { border-color: var(--boca-oro); color: var(--boca-oro); }
.galeria-filtros button.active { background: var(--boca-oro); color: var(--boca-azul-oscuro); border-color: var(--boca-oro); }
.fotos-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px; }
.foto-item { display: block; aspect-ratio: 1 / 1; overflow: hidden; border-radius: 8px; background: var(--boca-azul-oscuro); }
.foto-item.hide { display: none; }
.foto-item img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.4s ease; }
.foto-item:hover img { transform: scale(1.08); }

/* Visor (lightbox) */
.lb { position: fixed; inset: 0; background: rgba(5, 8, 17, 0.95); z-index: 2000; display: none; align-items: center; justify-content: center; }
.lb.open { display: flex; }
.lb img { max-width: 94vw; max-height: 86vh; border-radius: 6px; box-shadow: 0 10px 40px rgba(0,0,0,0.6); }
.lb button { position: absolute; background: rgba(10, 17, 34, 0.8); border: 2px solid var(--boca-oro); color: var(--boca-oro); width: 48px; height: 48px; border-radius: 50%; font-size: 1.5rem; cursor: pointer; line-height: 1; }
.lb button:hover { background: var(--boca-oro); color: var(--boca-azul-oscuro); }
.lb-close { top: 18px; right: 18px; }
.lb-prev { left: 14px; top: 50%; transform: translateY(-50%); }
.lb-next { right: 14px; top: 50%; transform: translateY(-50%); }
.lb-count { position: absolute; bottom: 18px; left: 0; right: 0; text-align: center; color: var(--boca-texto-claro); font-size: 0.9rem; }
@media (max-width: 600px) { .fotos-grid { grid-template-columns: repeat(3, 1fr); gap: 6px; } .lb-prev { left: 6px; } .lb-next { right: 6px; } }
</style>

<main id="primary" class="site-main">

    <header class="page-header">
        <h1 class="page-title cabj-font">GALERÍA DE FOTOS</h1>
        <p class="page-subtitle">Momentos de la Peña: la sede, los partidos y la gente bostera</p>
    </header>

    <section class="galeria-section">
        <div class="galeria-filtros">
            <button class="active" data-filter="all">Todas</button>
            <button data-filter="local">La sede</button>
            <button data-filter="grupos">Grupos</button>
        </div>

        <div class="fotos-grid" id="fotos-grid">
            <a class="foto-item" data-cat="grupos" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g01.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t01.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="grupos" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g02.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t02.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="grupos" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g03.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t03.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="grupos" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g04.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t04.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="grupos" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g05.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t05.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="grupos" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g06.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t06.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="grupos" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g07.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t07.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="grupos" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g08.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t08.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="grupos" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g09.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t09.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g10.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t10.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g11.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t11.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g12.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t12.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g13.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t13.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g14.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t14.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g15.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t15.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g16.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t16.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g17.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t17.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g18.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t18.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g19.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t19.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g20.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t20.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g21.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t21.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g22.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t22.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g23.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t23.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g24.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t24.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g25.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t25.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g26.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t26.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g27.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t27.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g28.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t28.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g29.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t29.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g30.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t30.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g31.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t31.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g32.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t32.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g33.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t33.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g34.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t34.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g35.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t35.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g36.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t36.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g37.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t37.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g38.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t38.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g39.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t39.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g40.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t40.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g41.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t41.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g42.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t42.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g43.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t43.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g44.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t44.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g45.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t45.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g46.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t46.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g47.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t47.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g48.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t48.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g49.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t49.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g50.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t50.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g51.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t51.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g52.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t52.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
            <a class="foto-item" data-cat="local" href="<?php echo get_template_directory_uri(); ?>/images/galeria/g53.webp">
                <img src="<?php echo get_template_directory_uri(); ?>/images/galeria/t53.webp" alt="Foto de la Peña en la sede" loading="lazy" width="420" height="420">
            </a>
        </div>
    </section>

</main>

<div class="lb" id="lb" role="dialog" aria-modal="true" aria-label="Visor de fotos">
    <button class="lb-close" aria-label="Cerrar">&times;</button>
    <button class="lb-prev" aria-label="Foto anterior">&#8249;</button>
    <img id="lb-img" src="" alt="">
    <button class="lb-next" aria-label="Foto siguiente">&#8250;</button>
    <div class="lb-count" id="lb-count"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var items = Array.prototype.slice.call(document.querySelectorAll('.foto-item'));
    var lb = document.getElementById('lb'), img = document.getElementById('lb-img'), count = document.getElementById('lb-count');
    var current = 0;

    function visibles() { return items.filter(function (i) { return !i.classList.contains('hide'); }); }
    function show(n) {
        var v = visibles(); if (!v.length) return;
        current = (n + v.length) % v.length;
        img.src = v[current].getAttribute('href');
        count.textContent = (current + 1) + ' / ' + v.length;
    }
    function open(el) { var v = visibles(); lb.classList.add('open'); document.body.style.overflow = 'hidden'; show(v.indexOf(el)); }
    function close() { lb.classList.remove('open'); document.body.style.overflow = ''; img.src = ''; }

    items.forEach(function (it) { it.addEventListener('click', function (e) { e.preventDefault(); open(it); }); });
    lb.querySelector('.lb-close').addEventListener('click', close);
    lb.querySelector('.lb-prev').addEventListener('click', function () { show(current - 1); });
    lb.querySelector('.lb-next').addEventListener('click', function () { show(current + 1); });
    lb.addEventListener('click', function (e) { if (e.target === lb) close(); });
    document.addEventListener('keydown', function (e) {
        if (!lb.classList.contains('open')) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') show(current - 1);
        if (e.key === 'ArrowRight') show(current + 1);
    });
    var x0 = null;
    lb.addEventListener('touchstart', function (e) { x0 = e.touches[0].clientX; }, { passive: true });
    lb.addEventListener('touchend', function (e) {
        if (x0 === null) return;
        var dx = e.changedTouches[0].clientX - x0; x0 = null;
        if (Math.abs(dx) > 50) show(current + (dx < 0 ? 1 : -1));
    });

    document.querySelectorAll('.galeria-filtros button').forEach(function (b) {
        b.addEventListener('click', function () {
            document.querySelectorAll('.galeria-filtros button').forEach(function (x) { x.classList.remove('active'); });
            b.classList.add('active');
            var f = b.getAttribute('data-filter');
            items.forEach(function (it) { it.classList.toggle('hide', f !== 'all' && it.getAttribute('data-cat') !== f); });
        });
    });
});
</script>

<?php get_footer(); ?>
