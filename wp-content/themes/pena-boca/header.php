<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); /* Hook vital de WordPress */ ?>
    
    <style>
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
        .nav-toggle { display: block; }
        .navbar-links {
            display: none;
            position: absolute;
            top: 80px;
            left: 0;
            right: 0;
            flex-direction: column;
            align-items: stretch;
            background-color: rgba(10, 17, 34, 0.98);
            border-bottom: 3px solid var(--boca-oro);
            padding: 10px 5% 20px 5%;
        }
        .navbar-links.open { display: flex; }
        .navbar-links a { margin: 0; padding: 12px 0; font-size: 1rem; text-align: center; }
        .nav-item { display: block; }
        .nav-item .caret { display: none; }
        .nav-sub { display: block; position: static; padding-top: 0; min-width: 0; }
        .nav-sub a { background: transparent; border-left: 0; padding: 8px 0; font-size: 0.9rem; opacity: 0.8; }
        .btn-nav-contacto { margin-top: 10px !important; }
    }

    @media (max-width: 900px) {
        .navbar-logo-pena img { height: 90px; width: 90px; top: 15px; }
    }
    </style>
</head>
<body <?php body_class(); ?>>

    <!-- HEADER PEÑA CON DOBLE LOGO (SE VERÁ EN TODA LA WEB) -->
    <nav class="navbar-pena">
        <div class="navbar-logo-pena">
            <a href="<?php echo site_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/peña.png" alt="Peña Boca Viedma Patagones">
            </a>
        </div>
        
        <button class="nav-toggle" type="button" aria-label="Abrir menú" onclick="document.querySelector('.navbar-links').classList.toggle('open')">&#9776;</button>

        <div class="navbar-links">
            <a href="<?php echo site_url('/pena-oficial'); ?>">Peña Oficial</a>
            <div class="nav-item">
                <a href="<?php echo site_url('/institucional'); ?>">Institucional <span class="caret">▾</span></a>
                <div class="nav-sub">
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