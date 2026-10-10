<?php
/*
Template Name: Contacto y Gestión
*/
get_header(); ?>

<style>
/* ==========================================
   ESTILOS DE LA PÁGINA DE CONTACTO
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

.contacto-section {
    background-color: var(--boca-fondo);
    padding: 60px 5%;
    max-width: 1000px;
    margin: 0 auto;
}

.contacto-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
}

.contacto-card {
    background-color: var(--boca-azul-principal);
    border-radius: 12px;
    padding: 40px;
    border: 1px solid rgba(255,255,255,0.05);
    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.contacto-card h2 {
    color: var(--boca-oro);
    font-family: 'Russo One', sans-serif;
    font-size: 1.8rem;
    margin-top: 0;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.contacto-card p {
    color: var(--boca-gris-texto);
    line-height: 1.7;
    margin-bottom: 30px;
    font-size: 1.05rem;
}

.contacto-info-item {
    margin-bottom: 20px;
    color: var(--boca-texto-claro);
    font-size: 1.05rem;
}

.contacto-info-item strong {
    color: var(--boca-oro);
    display: block;
    margin-bottom: 5px;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 1px;
}

.btn-whatsapp {
    background-color: #25d366;
    color: white;
    padding: 12px 25px;
    text-decoration: none;
    font-weight: bold;
    border-radius: 6px;
    text-transform: uppercase;
    font-size: 0.95rem;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    align-self: flex-start;
    transition: background-color 0.3s, transform 0.3s;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
}

.btn-whatsapp:hover {
    background-color: #20ba5a;
    transform: translateY(-3px);
    color: white;
}

@media (max-width: 800px) {
    .contacto-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<main id="primary" class="site-main">
    
    <!-- Cabecera -->
    <header class="page-header">
        <h1 class="page-title cabj-font">CONTACTO Y GESTIONES</h1>
    </header>

    <!-- Contenido Principal -->
    <section class="contacto-section">
        <div class="contacto-grid">
            
            <!-- Columna 1: Canal Directo WhatsApp -->
            <div class="contacto-card">
                <div>
                    <h2 class="cabj-font">Escribinos</h2>
                    <p>¿Tenés dudas sobre cómo hacerte socio/a, querés consultar por las entradas o tenés una propuesta para la Peña? Contactanos de forma directa por WhatsApp.</p>
                    
                    <div class="contacto-info-item">
                        <strong>Canal Oficial</strong>
                        Atención rápida para socios, socias y simpatizantes de la Comarca.
                    </div>
                </div>

                <a href="https://wa.me/5492920405196?text=Hola!%20Quería%20hacer%20una%20consulta%20a%20la%20Peña" target="_blank" class="btn-whatsapp">
                    💬 Abrir WhatsApp
                </a>
            </div>

            <!-- Columna 2: Ubicación y Redes -->
            <div class="contacto-card">
                <div>
                    <h2 class="cabj-font">Nuestra Sede</h2>
                    <p>Encontranos en la Comarca Viedma-Patagones. Unite a nuestras actividades semanales y viví la pasión boquense en comunidad.</p>
                    
                    <div class="contacto-info-item">
                        <strong>Ubicación</strong>
                        Colectora Oeste 415, B8504 Carmen de Patagones, Provincia de Buenos Aires
                    </div>

                    <div class="contacto-info-item">
                        <strong>Redes Sociales</strong>
                        Seguinos en Instagram, Facebook y YouTube para no perderte ninguna novedad.
                    </div>
                </div>

            </div>

        </div>
    </section>

</main>

<?php get_footer(); ?>