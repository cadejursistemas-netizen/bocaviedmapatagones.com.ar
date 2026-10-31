=== Carnet Peña Boca Viedma | Patagones ===
Requires at least: 5.8
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.3.0
License: GPL-2.0-or-later

Carga de socios/as de la peña y generación del carnet de bienvenida en PDF (2 páginas A4).

== Instalación ==

1. En el escritorio de WordPress: Plugins > Añadir nuevo > Subir plugin.
2. Elegí el archivo carnet-pena-bvp.zip, instalalo y activalo.
3. Aparece el menú "Socios Peña".

== Usuarios que solo hacen carnets ==

Para que alguien cargue socios y genere carnets sin ver el resto del panel:

1. Usuarios > Añadir nuevo.
2. En "Rol" elegí "Gestor/a de carnets".

Ese usuario, al iniciar sesión, va directo al listado de socios. Ve solo "Socios Peña" (y su perfil, para cambiar su clave). No ve Entradas, Medios, Páginas, Apariencia, Plugins, Ajustes ni el Escritorio, y no puede cambiar nada del sitio. Tampoco ve la barra de WordPress al navegar la web.
Tiene acceso a los datos de los socios (DNI y fotos), así que dale ese rol solo a personas de confianza, con su propia clave.

== Si ya tenías socios cargados ==

Entrá a Socios Peña > Proteger fotos y tocá "Proteger ahora". Si el sitio usa Cloudflare, después hacé "Purgar todo" en Caching.

== Uso ==

1. Socios Peña > Añadir socio/a.
2. Escribí el nombre y apellido en el título.
3. Completá Nº de socio/a (viene sugerido el siguiente libre), DNI, fecha de ingreso y saludo (Bienvenido / Bienvenida).
4. "Subir foto": elegila desde la compu o el celular.
   Arrastrá la foto y usá el zoom para que la cara quede dentro del óvalo.
5. Guardá (Publicar / Actualizar) y tocá "Descargar carnet en PDF".

Desde el listado también está la acción "Descargar PDF" en cada socio/a.
La búsqueda acepta nombre, Nº de socio/a o DNI (con o sin puntos).
Si cargás un Nº que ya tiene otro socio/a, al guardar aparece un aviso.

== Cómo funciona ==

* El PDF se arma en el navegador del operador con pdf-lib: no necesita librerías en el servidor.
* assets/template.pdf es el diseño completo sin datos; el plugin le agrega el saludo,
  el Nº del titular y el dorso del carnet (foto y datos) en las posiciones de assets/layout.json.
* Las fotos NO van a la Biblioteca de medios: se guardan en wp-content/uploads/cpbvp-privado/ con un nombre al azar de 32 caracteres, sin datos ocultos (ubicación, cámara), y solo un administrador con la sesión iniciada puede verlas (se entregan a través de WordPress). La carpeta tiene un .htaccess que bloquea el acceso directo.
* Si el servidor no usa Apache/LiteSpeed (el .htaccess no se aplica), el nombre al azar sigue protegiendo cada archivo. Lo más seguro es mover la carpeta fuera de la web con el filtro "cpbvp_carpeta_privada".
* Lo pueden usar los Administradores y el rol "Gestor/a de carnets" (permiso "cpbvp_gestionar"). Los Editores, Autores y demás usuarios no ven el menú "Socios Peña" ni las fichas.
* La pantalla "Proteger fotos" (que borra fotos de la Biblioteca de medios) es solo para Administradores.
* Datos personales: se guardan Nº, DNI, fecha de ingreso y foto (puede incluir menores). Las fichas no son públicas (no tienen dirección web) y las fotos tampoco (ver arriba).

== Cambiar el diseño ==

La fuente de la plantilla viene aparte, en plantilla-fuente.zip (template.html + render.js).
Después de editar template.html, regenerá template.pdf y layout.json con:

    npm i playwright && npx playwright install chromium
    node render.js

y reemplazá esos dos archivos en carnet-pena-bvp/assets/.

== Cambios ==

= 1.3.0 =
* Nuevo rol "Gestor/a de carnets": ve solo los carnets, sin el resto del panel de WordPress.

= 1.2.0 =
* Las fotos se guardan en una carpeta privada (no en la Biblioteca de medios), con nombre al azar y sin datos ocultos.
* Nueva pantalla Socios Peña > Proteger fotos: pasa las fotos que ya estaban en la Biblioteca de medios a la carpeta privada y borra las copias públicas.

= 1.1.0 =
* Acceso restringido a Administradores.

== Licencias ==

* pdf-lib 1.17.1 — MIT (assets/vendor/pdf-lib-LICENSE.md)
* Tipografías Anton y Barlow — SIL Open Font License 1.1 (assets/fonts/)
