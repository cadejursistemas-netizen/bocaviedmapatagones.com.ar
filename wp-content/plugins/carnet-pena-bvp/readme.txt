=== Carnet Peña Boca Viedma | Patagones ===
Requires at least: 5.8
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPL-2.0-or-later

Carga de socios/as de la peña y generación del carnet de bienvenida en PDF (2 páginas A4).

== Instalación ==

1. En el escritorio de WordPress: Plugins > Añadir nuevo > Subir plugin.
2. Elegí el archivo carnet-pena-bvp.zip, instalalo y activalo.
3. Aparece el menú "Socios Peña".

== Uso ==

1. Socios Peña > Añadir socio/a.
2. Escribí el nombre y apellido en el título.
3. Completá Nº de socio/a (viene sugerido el siguiente libre), DNI, fecha de ingreso y saludo (Bienvenido / Bienvenida).
4. "Elegir foto": subila desde la compu o el celular, o elegila de la Biblioteca de medios.
   Arrastrá la foto y usá el zoom para que la cara quede dentro del óvalo.
5. Guardá (Publicar / Actualizar) y tocá "Descargar carnet en PDF".

Desde el listado también está la acción "Descargar PDF" en cada socio/a.
La búsqueda acepta nombre, Nº de socio/a o DNI (con o sin puntos).
Si cargás un Nº que ya tiene otro socio/a, al guardar aparece un aviso.

== Cómo funciona ==

* El PDF se arma en el navegador del operador con pdf-lib: no necesita librerías en el servidor.
* assets/template.pdf es el diseño completo sin datos; el plugin le agrega el saludo,
  el Nº del titular y el dorso del carnet (foto y datos) en las posiciones de assets/layout.json.
* Las fotos quedan en la Biblioteca de medios de WordPress.
* Solo lo pueden usar los Administradores (capacidad "manage_options"). Los Editores y Autores no ven el menú "Socios Peña" ni las fichas.
* Datos personales: se guardan Nº, DNI, fecha de ingreso y foto. Las fichas no son públicas (no tienen dirección web). Las fotos, en cambio, quedan en la Biblioteca de medios de WordPress, cuyos archivos son accesibles por su dirección directa.

== Cambiar el diseño ==

La fuente de la plantilla viene aparte, en plantilla-fuente.zip (template.html + render.js).
Después de editar template.html, regenerá template.pdf y layout.json con:

    npm i playwright && npx playwright install chromium
    node render.js

y reemplazá esos dos archivos en carnet-pena-bvp/assets/.

== Cambios ==

= 1.1.0 =
* Acceso restringido a Administradores.

== Licencias ==

* pdf-lib 1.17.1 — MIT (assets/vendor/pdf-lib-LICENSE.md)
* Tipografías Anton y Barlow — SIL Open Font License 1.1 (assets/fonts/)
