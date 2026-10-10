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
                <a href="<?php echo site_url('/preguntas-frecuentes'); ?>">Preguntas Frecuentes</a>
            </div>

            <!-- Columna 3: Gestiones y Contacto -->
            <div class="footer-col footer-links">
                <h3>Contacto</h3>
                <p><strong>Gestiones CABJ y Peña:</strong><br>Hacete socio, consultas, cuotas o ideas.</p>
                <a href="https://wa.me/5492920405196" target="_blank" style="color: var(--boca-oro); font-weight: bold; font-size: 1.1rem; margin-top: 10px;">
                    💬 Escribinos al 2920405196
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

    <!-- BOTONES FLOTANTES: WhatsApp + Instagram -->
    <style>
    .flotantes { position: fixed; right: 18px; bottom: 18px; z-index: 999; display: flex; flex-direction: column; gap: 12px; align-items: flex-end; }
    .flotante { display: flex; align-items: center; justify-content: center; width: 56px; height: 56px; border-radius: 50%; color: #fff; box-shadow: 0 6px 18px rgba(0,0,0,0.45); transition: transform 0.2s ease; text-decoration: none; }
    .flotante:hover { transform: scale(1.1); }
    .flotante svg { width: 28px; height: 28px; fill: #fff; }
    .flotante-wa { background-color: #25D366; width: auto; border-radius: 30px; padding: 0 20px 0 16px; height: 56px; gap: 10px; font-weight: 700; font-size: 0.95rem; }
    .flotante-ig { background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); }
    @media (max-width: 600px) { .flotante-wa span { display: none; } .flotante-wa { width: 56px; padding: 0; } }
    </style>
    <div class="flotantes">
        <a class="flotante flotante-ig" href="https://www.instagram.com/bocaviedmapatagones/" target="_blank" rel="noopener" aria-label="Instagram de la Peña">
            <svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
        </a>
        <a class="flotante flotante-wa" href="https://wa.me/5492920405196?text=Hola!%20Quiero%20afiliarme%20a%20la%20Pe%C3%B1a" target="_blank" rel="noopener" aria-label="Escribinos por WhatsApp">
            <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            <span>Afiliate por WhatsApp</span>
        </a>
    </div>

    <?php wp_footer(); /* Hook vital de WordPress antes de cerrar el body */ ?>
</body>
</html>