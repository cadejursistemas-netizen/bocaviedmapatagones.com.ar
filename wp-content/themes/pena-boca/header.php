<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); /* Hook vital de WordPress */ ?>
    
    <style>
    /* Accesibilidad: enlace para saltar al contenido, foco visible y menos movimiento */
    .skip-link { position: absolute; left: -9999px; top: 8px; z-index: 3000; background: var(--boca-oro); color: var(--boca-azul-oscuro); padding: 10px 18px; border-radius: 6px; font-weight: 700; text-decoration: none; }
    .skip-link:focus { left: 8px; }
    a:focus-visible, button:focus-visible, summary:focus-visible, [tabindex]:focus-visible { outline: 3px solid var(--boca-oro); outline-offset: 3px; border-radius: 4px; }
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; scroll-behavior: auto !important; }
    }
    /* Botón global (se usa en todas las páginas) */
    .btn-mod {
        display: inline-block;
        padding: 10px 25px;
        border: 2px solid var(--boca-oro);
        color: var(--boca-oro);
        text-decoration: none;
        font-weight: bold;
        border-radius: 6px;
        text-transform: uppercase;
        font-size: 0.85rem;
        transition: all 0.3s;
    }
    .btn-mod:hover {
        background-color: var(--boca-oro);
        color: var(--boca-azul-oscuro);
    }
    /* ==========================================
       1. VARIABLES Y ESTILOS GLOBALES
       ========================================== */
    :root {
      --boca-azul-principal: #16284f; 
      --boca-azul-oscuro: #0a1122;    
      --boca-oro: #f9be3d;            
      --boca-fondo: #050811;          
      --boca-texto-claro: #f8f9fa;
      --boca-gris-texto: #a0aab8;
    }

    body {
        background-color: var(--boca-fondo);
        color: var(--boca-texto-claro);
        font-family: 'Montserrat', sans-serif;
        margin: 0;
        padding: 0;
    }

    .cabj-font {
        font-family: 'Impact', 'Russo One', sans-serif;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* ==========================================
       2. NAVBAR FLOTANTE CON LOGO SOBRESALIENTE
       ========================================== */
    .navbar-pena {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 5%; 
        height: 80px;  
        background-color: rgba(10, 17, 34, 0.95);
        backdrop-filter: blur(10px);
        border-bottom: 3px solid var(--boca-oro);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .navbar-logo-pena {
        position: relative;
        height: 100%;
        width: 120px; 
    }

    .navbar-logo-pena img {
        height: 120px; 
        width: 120px;
        object-fit: contain;
        border-radius: 50%;
        position: absolute;
        top: 10px; 
        left: 0;
        border: 3px solid var(--boca-oro); 
        box-shadow: 0 5px 15px rgba(0,0,0,0.6);
        background-color: var(--boca-azul-oscuro);
        transition: transform 0.3s ease;
    }

    .navbar-logo-pena img:hover {
        transform: scale(1.05); 
    }

    .navbar-links {
        display: flex;
        align-items: center;
        flex-grow: 1;
        justify-content: center;
    }

    .navbar-links a {
        color: var(--boca-texto-claro);
        text-decoration: none;
        margin: 0 9px;
        font-weight: 500;
        font-size: 0.85rem;
        white-space: nowrap;
        transition: color 0.3s;
    }

    .navbar-links a:hover {
        color: var(--boca-oro);
    }

    .btn-nav-contacto {
        color: var(--boca-azul-oscuro) !important;
        background-color: var(--boca-oro);
        padding: 8px 20px;
        border-radius: 20px;
        font-weight: 800 !important;
    }

    .btn-nav-contacto:hover {
        background-color: white !important;
    }

    .navbar-logo-cabj {
        height: 100%;
        display: flex;
        align-items: center;
    }

    .navbar-logo-cabj img {
        height: 55px; 
        filter: drop-shadow(0 2px 5px rgba(0,0,0,0.5));
    }

    .nav-item { position: relative; display: flex; align-items: center; }
    .nav-item .caret { font-size: 0.7rem; }
    .nav-sub {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 220px;
        padding-top: 18px;
        z-index: 200;
    }
    .nav-sub a {
        display: block;
        margin: 0;
        padding: 12px 18px;
        background-color: rgba(10, 17, 34, 0.98);
        border-left: 3px solid var(--boca-oro);
    }
    .nav-sub a:hover { background-color: var(--boca-azul-principal); }
    .nav-item:hover .nav-sub, .nav-item:focus-within .nav-sub { display: block; }

    .nav-toggle {
        display: none;
        background: transparent;
        border: 2px solid var(--boca-oro);
        color: var(--boca-oro);
        font-size: 1.6rem;
        line-height: 1;
        padding: 4px 12px;
        border-radius: 6px;
        cursor: pointer;
    }

    @media (max-width: 1100px) {
        .navbar-logo-cabj { display: none; }
        /* backdrop-filter haría que el panel "fixed" se mida contra la barra y no contra la pantalla */
        .navbar-pena { backdrop-filter: none; -webkit-backdrop-filter: none; background-color: #0a1122; }
        .navbar-logo-pena { z-index: 3; }
        .nav-toggle { display: block; position: relative; z-index: 3; }

        /* Panel que ocupa la pantalla debajo de la barra */
        .navbar-links {
            display: none;
            position: fixed;
            top: 80px;
            left: 0;
            right: 0;
            bottom: 0;
            flex-direction: column;
            align-items: stretch;
            justify-content: flex-start;
            background-color: #0a1122;
            border-top: 3px solid var(--boca-oro);
            padding: 38px 6% 40px 6%;
            overflow-y: auto;
            overscroll-behavior: contain;
        }
        .navbar-links.open { display: flex; }
        body.menu-abierto { overflow: hidden; }

        .navbar-links a { margin: 0; padding: 16px 4px; font-size: 1.15rem; font-weight: 600; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .navbar-links > a:hover, .nav-item > a:hover { color: var(--boca-oro); }

        /* Contacto, el botón principal, primero */
        .btn-nav-contacto { order: -1; text-align: center !important; margin: 0 0 14px 0 !important; padding: 16px 20px !important; font-size: 1.1rem !important; border-bottom: 0 !important; border-radius: 12px !important; }

        /* Grupos con submenú plegado */
        .nav-item { display: block; }
        .nav-item > a { display: flex; align-items: center; justify-content: space-between; }
        .nav-item .caret { display: inline-block; font-size: 0.9rem; transition: transform 0.25s ease; }
        .nav-item.abierto .caret { transform: rotate(180deg); }
        .nav-item.abierto > a { color: var(--boca-oro); }
        .nav-sub { display: none; position: static; padding: 0 0 6px 14px; min-width: 0; border-left: 2px solid var(--boca-oro); margin: 4px 0 8px 4px; }
        .nav-item.abierto .nav-sub { display: block; }
        .nav-item:hover .nav-sub, .nav-item:focus-within .nav-sub { display: none; }
        .nav-item.abierto:hover .nav-sub, .nav-item.abierto:focus-within .nav-sub { display: block; }
        .nav-sub a { background: transparent; border-left: 0; padding: 13px 4px; font-size: 1rem; font-weight: 500; opacity: 0.9; }
    }

    @media (max-width: 900px) {
        .navbar-logo-pena img { height: 90px; width: 90px; top: 15px; }
    }
    </style>
</head>
<body <?php body_class(); ?>>

    <a class="skip-link" href="#primary">Saltar al contenido</a>

    <!-- HEADER PEÑA CON DOBLE LOGO (SE VERÁ EN TODA LA WEB) -->
    <nav class="navbar-pena" aria-label="Menú principal">
        <div class="navbar-logo-pena">
            <a href="<?php echo site_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/peña.png" alt="Peña Boca Viedma Patagones">
            </a>
        </div>
        
        <button class="nav-toggle" type="button" id="nav-toggle" aria-label="Abrir menú" aria-expanded="false" aria-controls="menu-principal">&#9776;</button>

        <div class="navbar-links" id="menu-principal">
            <a href="<?php echo site_url('/pena-oficial'); ?>">Peña Oficial</a>
            <div class="nav-item">
                <a href="<?php echo site_url('/institucional'); ?>">Institucional <span class="caret">▾</span></a>
                <div class="nav-sub">
                    <a href="<?php echo site_url('/institucional'); ?>#historia">Historia</a>
                    <a href="<?php echo site_url('/institucional'); ?>#principios">Principios</a>
                    <a href="<?php echo site_url('/institucional'); ?>#reconocimientos">Reconocimientos</a>
                    <a href="<?php echo site_url('/institucional'); ?>#autoridades">Autoridades</a>
                    <a href="<?php echo site_url('/institucional'); ?>#organizacion">Organización y participación</a>
                    <a href="<?php echo site_url('/preguntas-frecuentes'); ?>">Preguntas Frecuentes</a>
                </div>
            </div>
            <a href="<?php echo site_url('/ser-parte'); ?>">Ser Parte</a>
            <a href="<?php echo site_url('/sede'); ?>">Sede</a>
            <div class="nav-item">
                <a href="<?php echo site_url('/actividades'); ?>">Actividades <span class="caret">▾</span></a>
                <div class="nav-sub">
                    <a href="<?php echo site_url('/actividades'); ?>">Todas las actividades</a>
                    <a href="<?php echo site_url('/galeria'); ?>">Galería de fotos</a>
                    <a href="<?php echo site_url('/futbol'); ?>">Fútbol Semanal</a>
                    <a href="<?php echo site_url('/accion-social'); ?>">Acción Social</a>
                    <a href="<?php echo site_url('/bosteras'); ?>">Bosteras</a>
                    <a href="<?php echo site_url('/desde-la-cuna'); ?>">Desde la Cuna</a>
                </div>
            </div>
            <a href="<?php echo site_url('/viajes'); ?>">Viajes</a>
            <a href="<?php echo site_url('/marca'); ?>">Marca</a>
            <a href="<?php echo site_url('/streaming'); ?>">Streaming</a>
            <a href="<?php echo site_url('/contacto'); ?>" class="btn-nav-contacto">Contacto</a>
        </div>

        <div class="navbar-logo-cabj">
            <img src="<?php echo get_template_directory_uri(); ?>/cabj-logo.svg"  alt="Escudo Oficial CABJ">
        </div>
    </nav>
    <script>
    (function () {
        var btn = document.getElementById('nav-toggle');
        var menu = document.getElementById('menu-principal');
        if (!btn || !menu) return;
        var movil = window.matchMedia('(max-width: 1100px)');

        function abrirCerrar(abrir) {
            menu.classList.toggle('open', abrir);
            document.body.classList.toggle('menu-abierto', abrir);
            btn.setAttribute('aria-expanded', abrir);
            btn.setAttribute('aria-label', abrir ? 'Cerrar menú' : 'Abrir menú');
            btn.innerHTML = abrir ? '&times;' : '&#9776;';
            if (!abrir) menu.querySelectorAll('.nav-item.abierto').forEach(function (i) { i.classList.remove('abierto'); i.querySelector('a').setAttribute('aria-expanded', 'false'); });
        }
        btn.addEventListener('click', function () { abrirCerrar(!menu.classList.contains('open')); });

        // En celular, tocar un grupo despliega sus opciones (y cierra el otro grupo)
        menu.querySelectorAll('.nav-item > a').forEach(function (a) {
            a.setAttribute('aria-expanded', 'false');
            a.addEventListener('click', function (e) {
                if (!movil.matches) return;
                e.preventDefault();
                var item = a.parentNode, abrir = !item.classList.contains('abierto');
                menu.querySelectorAll('.nav-item.abierto').forEach(function (i) { i.classList.remove('abierto'); i.querySelector('a').setAttribute('aria-expanded', 'false'); });
                if (abrir) { item.classList.add('abierto'); a.setAttribute('aria-expanded', 'true'); }
            });
        });

        // Se cierra al elegir una página, con Esc, o al pasar a pantalla grande
        menu.addEventListener('click', function (e) {
            var l = e.target.closest('a');
            if (l && !l.parentNode.classList.contains('nav-item') || (l && l.closest('.nav-sub'))) abrirCerrar(false);
        });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && menu.classList.contains('open')) { abrirCerrar(false); btn.focus(); } });
        movil.addEventListener('change', function () { if (!movil.matches) abrirCerrar(false); });
    })();
    </script>
