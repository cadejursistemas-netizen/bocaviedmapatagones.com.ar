<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); /* Hook vital de WordPress */ ?>
    
    <style>
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
        margin: 0 15px;
        font-weight: 500;
        font-size: 0.95rem;
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

    @media (max-width: 900px) {
        .navbar-links, .navbar-logo-cabj { display: none; }
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
        
        <div class="navbar-links">
            <a href="<?php echo site_url('/institucional'); ?>">Institucional</a>
            <a href="<?php echo site_url('/ser-parte'); ?>">Ser Parte</a>
            <a href="<?php echo site_url('/streaming'); ?>">Streaming</a>
            <a href="<?php echo site_url('/sede'); ?>">Sede</a>
            <a href="<?php echo site_url('/actividades'); ?>">Actividades</a>
            <a href="<?php echo site_url('/contacto'); ?>" class="btn-nav-contacto">Contacto</a>
        </div>

        <div class="navbar-logo-cabj">
            <img src="<?php echo get_template_directory_uri(); ?>/cabj-logo.svg"  alt="Escudo Oficial CABJ">
        </div>
    </nav>