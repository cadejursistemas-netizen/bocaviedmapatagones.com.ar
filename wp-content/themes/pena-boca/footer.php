<?php
// footer.php
?>
    <style>
    /* ==========================================
       ESTILOS DEL PIE DE PÁGINA (FOOTER)
       ========================================== */
    .site-footer {
        background-color: var(--boca-azul-oscuro);
        border-top: 4px solid var(--boca-oro);
        color: var(--boca-texto-claro);
        padding: 60px 5% 20px 5%;
        font-family: 'Montserrat', sans-serif;
        margin-top: 40px; /* Separación del contenido principal */
    }
    
    .footer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 40px;
        margin-bottom: 40px;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .footer-col h3 {
        color: var(--boca-oro);
        font-family: 'Russo One', sans-serif;
        text-transform: uppercase;
        margin-bottom: 20px;
        font-size: 1.2rem;
        letter-spacing: 1px;
    }
    
    .footer-col p {
        color: var(--boca-gris-texto);
        line-height: 1.6;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .footer-links a {
        color: var(--boca-gris-texto);
        text-decoration: none;
        display: block;
        margin-bottom: 12px;
        transition: color 0.3s, padding-left 0.3s;
        font-size: 0.95rem;
    }
    
    .footer-links a:hover {
        color: var(--boca-oro);
        padding-left: 5px; /* Efecto de movimiento sutil */
    }
    
    .footer-socials {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }
    
    .footer-socials a {
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--boca-azul-principal);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        color: var(--boca-texto-claro);
        transition: all 0.3s;
    }
    
    .footer-socials a:hover {
        background: var(--boca-oro);
        color: var(--boca-azul-oscuro);
        transform: translateY(-3px);
    }
    
    .footer-socials svg {
        width: 20px;
        height: 20px;
        fill: currentColor;
    }
    
    .footer-bottom {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.1);
        font-size: 0.85rem;
        color: var(--boca-gris-texto);
        max-width: 1200px;
        margin: 0 auto;
    }
    </style>

    <footer class="site-footer">
        <div class="footer-grid">
            
            <!-- Columna 1: Identidad -->
            <div class="footer-col">
                <img src="<?php echo get_template_directory_uri(); ?>/peña.png" alt="Peña Boca Viedma Patagones" style="max-width: 110px; margin-bottom: 15px; border-radius: 50%;">
                <p>Somos el único espacio de la Comarca Viedma-Patagones con reconocimiento oficial del Club Atlético Boca Juniors.</p>
            </div>

            <!-- Columna 2: Navegación Rápida -->
            <div class="footer-col footer-links">
                <h3>Menú</h3>
                <a href="<?php echo site_url('/institucional'); ?>">Institucional</a>
                <a href="<?php echo site_url('/ser-parte'); ?>">Asociación Civil / Beneficios</a>
                <a href="<?php echo site_url('/sede'); ?>">Nuestra Sede Bostera</a>
                <a href="<?php echo site_url('/streaming'); ?>">Streaming en Vivo</a>
            </div>

            <!-- Columna 3: Gestiones y Contacto -->
            <div class="footer-col footer-links">
                <h3>Contacto</h3>
                <p><strong>Gestiones CABJ y Peña:</strong><br>Hacete socio, consultas, cuotas o ideas.</p>
                <!-- Reemplazá el "5492920000000" por el número real con código de área -->
                <a href="https://wa.me/5492920000000" target="_blank" style="color: var(--boca-oro); font-weight: bold; font-size: 1.1rem; margin-top: 10px;">
                    💬 Escribinos al 2920...
                </a>
                <p style="margin-top: 15px;"><strong>Sede:</strong><br>Viedma - Patagones</p>
            </div>

            <!-- Columna 4: Redes Sociales -->
            <div class="footer-col">
                <h3>Conectados</h3>
                <p>Seguinos para enterarte de todas las previas, viajes, sorteos y actividades.</p>
                <div class="footer-socials">
                    <!-- Instagram -->
                    <a href="https://www.instagram.com/bocaviedmapatagones/" target="_blank" aria-label="Instagram">
                        <svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/bocaviedmapatagones" target="_blank" aria-label="Facebook">
                        <svg viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                    </a>
                    <!-- YouTube (Streaming) -->
                    <a href="https://www.youtube.com/@BocaViedmaPatagones" target="_blank" aria-label="YouTube">
                        <svg viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </a>
                </div>
            </div>

        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Peña Oficial Boca Juniors Viedma-Patagones. Todos los derechos reservados.</p>
        </div>
    </footer>

    <?php wp_footer(); /* Hook vital de WordPress antes de cerrar el body */ ?>
</body>
</html>