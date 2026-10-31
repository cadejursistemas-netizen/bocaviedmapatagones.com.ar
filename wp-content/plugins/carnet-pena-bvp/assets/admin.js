/* global PDFLib, CPBVP */
/**
 * Carnet Peña Boca Viedma | Patagones
 * Encuadre de la foto, vista previa del carnet y armado del PDF en el navegador.
 *
 * El PDF parte de assets/template.pdf (el diseño completo, sin datos) y le superpone,
 * en las posiciones de assets/layout.json:
 *   - el cuerpo del dorso del carnet (foto + datos), como JPG de alta resolución;
 *   - el Nº de socio del titular y el saludo ("BIENVENIDO/A"), como PNG transparentes.
 */
(function () {
	'use strict';

	var cfg = window.CPBVP;
	if (!cfg || !document.getElementById('cpbvp_preview')) return;

	var F = { anton: 'CPBVP Anton', barlow: 'CPBVP Barlow', cond: 'CPBVP Barlow Condensed' };
	var C = { navy: '#061A40', blue: '#0B2E6E', gold: '#F5B700', gray: '#4A5A7A', white: '#FFFFFF', muted: '#9AA6BD' };
	var CARD = { w: 324, h: 204, head: 34, foot: 26, body: 144 };
	var PHOTO = { x: 14, y: 14, w: 88, h: 116, r: 6 };
	var COL = { x: 116, w: 194 };
	var CROPPER = { w: 176, h: 232 }; // misma proporción que la foto del carnet (88 x 116)

	function $(id) { return document.getElementById(id); }
	var el = {
		title: $('title'),
		numero: $('cpbvp_numero'),
		dni: $('cpbvp_dni'),
		ingreso: $('cpbvp_ingreso'),
		saludo: $('cpbvp_saludo'),
		fotoId: $('cpbvp_foto_id'),
		fotoPriv: $('cpbvp_foto_priv'),
		crop: $('cpbvp_crop'),
		fotoBtn: $('cpbvp_foto_btn'),
		zoom: $('cpbvp_zoom'),
		center: $('cpbvp_center'),
		cropper: $('cpbvp_cropper'),
		preview: $('cpbvp_preview'),
		pdfBtn: $('cpbvp_pdf'),
		status: $('cpbvp_status')
	};

	/* ---------------------------------------------------------------- */
	/* Datos                                                             */
	/* ---------------------------------------------------------------- */

	function digits(v) { return String(v || '').replace(/\D/g, ''); }
	function padNumero(v) { var d = digits(v).replace(/^0+/, ''); return d ? ('0000' + d).slice(-Math.max(4, d.length)) : ''; }
	function formatDni(v) { var d = digits(v); return d ? d.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : ''; }
	function formatDate(v) { var m = /^(\d{4})-(\d{2})-(\d{2})$/.exec(v || ''); return m ? m[3] + '/' + m[2] + '/' + m[1] : ''; }

	function data() {
		return {
			name: (el.title ? el.title.value : '').trim().replace(/\s+/g, ' '),
			numero: padNumero(el.numero.value),
			dni: formatDni(el.dni.value),
			ingreso: formatDate(el.ingreso.value),
			saludo: el.saludo.value === 'bienvenida' ? 'BIENVENIDA' : 'BIENVENIDO'
		};
	}

	var crop = { z: 1, x: 0, y: 0 };
	try {
		var saved = JSON.parse(el.crop.value || 'null');
		if (saved && typeof saved.z === 'number') crop = { z: saved.z, x: +saved.x || 0, y: +saved.y || 0 };
	} catch (e) { /* sin encuadre guardado */ }

	var photo = null;      // HTMLImageElement cargada
	var photoTainted = false;

	/* ---------------------------------------------------------------- */
	/* Fuentes                                                           */
	/* ---------------------------------------------------------------- */

	var fontsPromise = null;
	function loadFonts() {
		if (fontsPromise) return fontsPromise;
		var defs = [
			[F.anton, 'Anton-Regular.ttf', '400'],
			[F.barlow, 'Barlow-SemiBold.ttf', '600'],
			[F.barlow, 'Barlow-Bold.ttf', '700'],
			[F.cond, 'BarlowCondensed-SemiBold.ttf', '600'],
			[F.cond, 'BarlowCondensed-Bold.ttf', '700']
		];
		fontsPromise = Promise.all(defs.map(function (d) {
			var ff = new FontFace(d[0], 'url(' + cfg.fontsUrl + d[1] + ')', { weight: d[2] });
			return ff.load().then(function (f) { document.fonts.add(f); });
		}));
		return fontsPromise;
	}

	/* ---------------------------------------------------------------- */
	/* Dibujo                                                            */
	/* ---------------------------------------------------------------- */

	function setFont(ctx, family, weight, size) { ctx.font = weight + ' ' + size + 'px "' + family + '"'; }

	// Ancho como lo mide CSS con letter-spacing (incluye el espacio después de cada letra).
	function textWidth(ctx, text, ls) {
		if (!ls) return ctx.measureText(text).width;
		var w = 0;
		for (var i = 0; i < text.length; i++) w += ctx.measureText(text[i]).width + ls;
		return w;
	}
	function drawText(ctx, text, x, y, ls) {
		if (!ls) { ctx.fillText(text, x, y); return; }
		var cx = x;
		for (var i = 0; i < text.length; i++) { ctx.fillText(text[i], cx, y); cx += ctx.measureText(text[i]).width + ls; }
	}

	function roundRect(ctx, x, y, w, h, r) {
		ctx.beginPath();
		ctx.moveTo(x + r, y);
		ctx.arcTo(x + w, y, x + w, y + h, r);
		ctx.arcTo(x + w, y + h, x, y + h, r);
		ctx.arcTo(x, y + h, x, y, r);
		ctx.arcTo(x, y, x + w, y, r);
		ctx.closePath();
	}

	// Geometría de la foto en unidades del ancho del recuadro (el recuadro mide 1 x h/w).
	function geom(w, h) {
		var fh = h / w;
		var s0 = Math.max(1 / photo.naturalWidth, fh / photo.naturalHeight);
		return { iw: photo.naturalWidth * s0 * crop.z, ih: photo.naturalHeight * s0 * crop.z, fh: fh };
	}
	function clampCrop() {
		if (!photo) return;
		var g = geom(PHOTO.w, PHOTO.h);
		var mx = Math.max(0, (g.iw - 1) / 2), my = Math.max(0, (g.ih - g.fh) / 2);
		crop.x = Math.min(mx, Math.max(-mx, crop.x));
		crop.y = Math.min(my, Math.max(-my, crop.y));
	}
	function drawPhotoInto(ctx, x, y, w, h) {
		var g = geom(w, h);
		var dw = g.iw * w, dh = g.ih * w;
		ctx.drawImage(photo, x + w / 2 + crop.x * w - dw / 2, y + h / 2 + crop.y * w - dh / 2, dw, dh);
	}
	function drawPlaceholder(ctx, x, y, w, h) {
		ctx.fillStyle = '#E4E9F2';
		ctx.fillRect(x, y, w, h);
		ctx.fillStyle = '#A3B0C9';
		ctx.beginPath(); ctx.arc(x + w / 2, y + h * 0.4, w * 0.23, 0, Math.PI * 2); ctx.fill();
		ctx.beginPath(); ctx.ellipse(x + w / 2, y + h * 1.02, w * 0.41, h * 0.36, 0, Math.PI, 0); ctx.fill();
	}

	// Nombre: 1 línea a 15px; si no entra, 2 líneas; si tampoco, se achica.
	function layoutName(ctx, name) {
		function width(t, s) { setFont(ctx, F.barlow, 700, s); return ctx.measureText(t).width; }
		var s;
		for (s = 15; s >= 13; s -= 0.5) if (width(name, s) <= COL.w) return { size: s, lines: [name] };
		var words = name.split(' ');
		if (words.length > 1) {
			for (s = 14; s >= 11; s -= 0.5) {
				var best = null;
				for (var i = 1; i < words.length; i++) {
					var a = words.slice(0, i).join(' '), b = words.slice(i).join(' ');
					var m = Math.max(width(a, s), width(b, s));
					if (!best || m < best.m) best = { m: m, lines: [a, b] };
				}
				if (best.m <= COL.w) return { size: s, lines: best.lines };
			}
		}
		s = 13;
		while (s > 7 && width(name, s) > COL.w) s -= 0.5;
		return { size: s, lines: [name] };
	}

	/** Cuerpo blanco del dorso (324 x 144): foto + nombre + Nº + DNI + ingreso. */
	function drawCardBody(ctx, d, preview) {
		ctx.fillStyle = C.white;
		ctx.fillRect(0, 0, CARD.w, CARD.body);
		ctx.textBaseline = 'alphabetic';

		ctx.save();
		roundRect(ctx, PHOTO.x, PHOTO.y, PHOTO.w, PHOTO.h, PHOTO.r);
		ctx.clip();
		if (photo) drawPhotoInto(ctx, PHOTO.x, PHOTO.y, PHOTO.w, PHOTO.h);
		else drawPlaceholder(ctx, PHOTO.x, PHOTO.y, PHOTO.w, PHOTO.h);
		ctx.restore();

		var name = d.name || (preview ? 'Nombre y Apellido' : '');
		var nm = layoutName(ctx, name || ' ');
		var nameH = nm.lines.length * nm.size * 1.2;
		var total = nameH + 8 + 12 + 2 + 28 + 8 + 12 + 2 + 15.6;
		var t = (CARD.body - total) / 2;
		var x = COL.x;

		// Nombre
		setFont(ctx, F.barlow, 700, nm.size);
		ctx.fillStyle = d.name ? C.navy : C.muted;
		nm.lines.forEach(function (line, i) { ctx.fillText(line, x, t + i * nm.size * 1.2 + nm.size); });
		t += nameH + 8;

		// Nº de socio
		setFont(ctx, F.cond, 600, 10);
		ctx.fillStyle = C.gray;
		drawText(ctx, 'Nº DE SOCIO', x, t + 10, 1.2);
		t += 12 + 2;
		setFont(ctx, F.anton, 400, 28);
		ctx.fillStyle = d.numero ? C.blue : C.muted;
		ctx.fillText(d.numero || (preview ? '0000' : ''), x, t + 25.86);
		t += 28 + 8;

		// DNI e ingreso
		var dni = d.dni || (preview ? '00.000.000' : '');
		var ing = d.ingreso || (preview ? 'DD/MM/AAAA' : '');
		setFont(ctx, F.cond, 600, 10);
		var lblW = textWidth(ctx, 'DOCUMENTO', 1.2);
		setFont(ctx, F.barlow, 600, 13);
		var x2 = x + Math.max(lblW, ctx.measureText(dni).width) + 16;

		setFont(ctx, F.cond, 600, 10);
		ctx.fillStyle = C.gray;
		drawText(ctx, 'DOCUMENTO', x, t + 10, 1.2);
		drawText(ctx, 'INGRESO', x2, t + 10, 1.2);
		t += 12 + 2;
		setFont(ctx, F.barlow, 600, 13);
		ctx.fillStyle = d.dni ? C.navy : C.muted;
		ctx.fillText(dni, x, t + 13);
		ctx.fillStyle = d.ingreso ? C.navy : C.muted;
		ctx.fillText(ing, x2, t + 13);
	}

	/** Dorso completo (para la vista previa). */
	function drawCard(ctx, d) {
		ctx.save();
		roundRect(ctx, 0, 0, CARD.w, CARD.h, 14);
		ctx.clip();
		ctx.fillStyle = C.blue;
		ctx.fillRect(0, 0, CARD.w, CARD.head);
		ctx.textBaseline = 'alphabetic';
		setFont(ctx, F.cond, 700, 13);
		ctx.fillStyle = C.gold;
		drawText(ctx, 'BOCA VIEDMA | PATAGONES', 14, 22.2, 13 * 0.14);
		setFont(ctx, F.cond, 600, 11);
		ctx.fillStyle = C.white;
		var t = 'SOCIO/A PEÑA';
		drawText(ctx, t, CARD.w - 14 - textWidth(ctx, t, 11 * 0.16), 21.4, 11 * 0.16);

		ctx.save();
		ctx.translate(0, CARD.head);
		drawCardBody(ctx, d, true);
		ctx.restore();

		ctx.fillStyle = C.gold;
		ctx.fillRect(0, CARD.h - CARD.foot, CARD.w, CARD.foot);
		setFont(ctx, F.cond, 700, 12);
		ctx.fillStyle = C.navy;
		var u = 'bocaviedmapatagones.com.ar';
		drawText(ctx, u, (CARD.w - textWidth(ctx, u, 0.96)) / 2, CARD.h - CARD.foot + 17.8, 0.96);
		ctx.restore();
	}

	function sizeCanvas(c, w, h, k) {
		var dpr = Math.max(1, window.devicePixelRatio || 1);
		c.width = Math.round(w * k * dpr);
		c.height = Math.round(h * k * dpr);
		c.style.aspectRatio = w + ' / ' + h;
		var ctx = c.getContext('2d');
		ctx.setTransform(k * dpr, 0, 0, k * dpr, 0, 0);
		return ctx;
	}

	function drawCropper() {
		var ctx = sizeCanvas(el.cropper, CROPPER.w, CROPPER.h, 1);
		ctx.fillStyle = '#F0F2F6';
		ctx.fillRect(0, 0, CROPPER.w, CROPPER.h);
		if (photo) drawPhotoInto(ctx, 0, 0, CROPPER.w, CROPPER.h);
		else drawPlaceholder(ctx, 0, 0, CROPPER.w, CROPPER.h);
		// Guía: óvalo para la cara.
		ctx.save();
		ctx.setLineDash([5, 4]);
		ctx.lineWidth = 1.5;
		ctx.strokeStyle = 'rgba(255,255,255,0.9)';
		ctx.beginPath();
		ctx.ellipse(CROPPER.w / 2, CROPPER.h * 0.42, CROPPER.w * 0.27, CROPPER.h * 0.25, 0, 0, Math.PI * 2);
		ctx.stroke();
		ctx.restore();
	}

	function drawPreview() {
		var ctx = sizeCanvas(el.preview, CARD.w, CARD.h, 1.5);
		ctx.clearRect(0, 0, CARD.w, CARD.h);
		drawCard(ctx, data());
	}

	var raf = 0;
	function redraw() {
		if (raf) return;
		raf = requestAnimationFrame(function () { raf = 0; drawCropper(); drawPreview(); });
	}

	function storeCrop() {
		el.crop.value = JSON.stringify({ z: +crop.z.toFixed(3), x: +crop.x.toFixed(4), y: +crop.y.toFixed(4) });
	}

	/* ---------------------------------------------------------------- */
	/* Foto                                                              */
	/* ---------------------------------------------------------------- */

	function loadImage(url, cors) {
		return new Promise(function (resolve, reject) {
			var img = new Image();
			if (cors) img.crossOrigin = 'anonymous';
			img.onload = function () { resolve(img); };
			img.onerror = reject;
			img.src = url;
		});
	}

	function setPhoto(url) {
		if (!url) { photo = null; redraw(); return Promise.resolve(); }
		status('Cargando foto…');
		return loadImage(url, true)
			.then(function (img) { photoTainted = false; return img; })
			.catch(function () { photoTainted = true; return loadImage(url, false); })
			.then(function (img) {
				photo = img;
				el.zoom.value = crop.z;
				clampCrop();
				storeCrop();
				status('');
				redraw();
			})
			.catch(function () { status('No se pudo cargar la foto.', true); });
	}

	/**
	 * La foto NO pasa por la Biblioteca de medios (que es pública). Se achica y se vuelve a
	 * guardar como JPG acá, en el navegador (así se pierden la ubicación y demás datos ocultos),
	 * y se sube a una carpeta privada que solo ven los administradores.
	 */
	var MAX_SIDE = 1200;

	function prepareJpeg(file) {
		return new Promise(function (resolve, reject) {
			var url = URL.createObjectURL(file);
			var img = new Image();
			img.onload = function () {
				URL.revokeObjectURL(url);
				var k = Math.min(1, MAX_SIDE / Math.max(img.naturalWidth, img.naturalHeight));
				var c = document.createElement('canvas');
				c.width = Math.max(1, Math.round(img.naturalWidth * k));
				c.height = Math.max(1, Math.round(img.naturalHeight * k));
				var ctx = c.getContext('2d');
				ctx.fillStyle = '#FFFFFF'; // un PNG con transparencia queda sobre fondo blanco
				ctx.fillRect(0, 0, c.width, c.height);
				ctx.drawImage(img, 0, 0, c.width, c.height);
				c.toBlob(function (blob) { return blob ? resolve(blob) : reject(new Error('jpeg')); }, 'image/jpeg', 0.9);
			};
			img.onerror = function () { URL.revokeObjectURL(url); reject(new Error('decode')); };
			img.src = url;
		});
	}

	function postUpload(blob, nonce) {
		var fd = new FormData();
		fd.append('action', 'cpbvp_subir_foto');
		fd.append('_wpnonce', nonce);
		fd.append('foto', blob, 'foto.jpg');
		return fetch(cfg.ajaxUrl, { method: 'POST', body: fd, credentials: 'same-origin' }).then(function (r) {
			return r.text().then(function (t) {
				var j = null;
				try { j = JSON.parse(t); } catch (e) { /* no era JSON */ }
				return { status: r.status, text: t, json: j };
			});
		});
	}

	// Si el permiso de seguridad de la página venció, pide uno nuevo.
	function freshNonce() {
		var fd = new FormData();
		fd.append('action', 'cpbvp_nonce');
		return fetch(cfg.ajaxUrl, { method: 'POST', body: fd, credentials: 'same-origin' })
			.then(function (r) { return r.json(); })
			.then(function (j) { return j && j.success && j.data ? j.data.nonce : null; })
			.catch(function () { return null; });
	}

	// Mensaje claro; si no es una respuesta conocida del plugin, muestra qué contestó el servidor.
	function uploadError(res) {
		var msg = res.json && res.json.data && res.json.data.mensaje;
		if (msg) return new Error(msg);
		var snippet = String(res.text || '').replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim().slice(0, 160);
		return new Error('No se pudo subir la foto. Detalle técnico: HTTP ' + res.status + ' · ' + cfg.ajaxUrl + ' · respuesta: "' + snippet + '"');
	}

	function uploadPhoto(blob) {
		return postUpload(blob, cfg.nonce).then(function (res) {
			if (res.json && res.json.success) return res.json.data;
			if (String(res.text).trim() === '-1') {
				return freshNonce().then(function (n) {
					if (!n) throw uploadError(res);
					cfg.nonce = n;
					return postUpload(blob, n);
				}).then(function (res2) {
					if (res2.json && res2.json.success) return res2.json.data;
					throw uploadError(res2);
				});
			}
			throw uploadError(res);
		});
	}

	function handleFile(file) {
		status('Subiendo la foto…');
		el.fotoBtn.disabled = true;
		prepareJpeg(file)
			.then(uploadPhoto)
			.then(function (d) {
				el.fotoPriv.value = d.f;
				el.fotoId.value = ''; // si había una foto vieja en la Biblioteca de medios, se borra al guardar
				el.fotoBtn.textContent = 'Cambiar foto';
				crop = { z: 1, x: 0, y: 0 };
				return setPhoto(d.url);
			})
			.catch(function (err) {
				var m = err && err.message;
				status(m === 'decode' || m === 'jpeg' ? 'No se pudo leer esa foto. Probá con una imagen JPG o PNG.' : (m || 'No se pudo subir la foto.'), true);
			})
			.then(function () { el.fotoBtn.disabled = false; });
	}

	el.fotoBtn.addEventListener('click', function (e) {
		e.preventDefault();
		var input = document.createElement('input');
		input.type = 'file';
		input.accept = 'image/*';
		input.addEventListener('change', function () {
			if (input.files && input.files[0]) handleFile(input.files[0]);
		});
		input.click();
	});

	// Arrastrar para encuadrar
	var drag = null;
	el.cropper.addEventListener('pointerdown', function (e) {
		if (!photo) return;
		drag = { x: e.clientX, y: e.clientY };
		el.cropper.setPointerCapture(e.pointerId);
		el.cropper.classList.add('is-dragging');
	});
	el.cropper.addEventListener('pointermove', function (e) {
		if (!drag) return;
		var w = el.cropper.getBoundingClientRect().width;
		crop.x += (e.clientX - drag.x) / w;
		crop.y += (e.clientY - drag.y) / w;
		drag = { x: e.clientX, y: e.clientY };
		clampCrop();
		redraw();
	});
	function endDrag() { if (drag) { drag = null; el.cropper.classList.remove('is-dragging'); storeCrop(); } }
	el.cropper.addEventListener('pointerup', endDrag);
	el.cropper.addEventListener('pointercancel', endDrag);

	function setZoom(z) {
		crop.z = Math.min(3, Math.max(1, z));
		el.zoom.value = crop.z;
		clampCrop();
		storeCrop();
		redraw();
	}
	el.zoom.addEventListener('input', function () { setZoom(parseFloat(el.zoom.value)); });
	el.cropper.addEventListener('wheel', function (e) {
		if (!photo) return;
		e.preventDefault();
		setZoom(crop.z - e.deltaY * 0.0015);
	}, { passive: false });
	el.cropper.addEventListener('keydown', function (e) {
		if (!photo) return;
		var step = 2 / CROPPER.w, handled = true;
		switch (e.key) {
			case 'ArrowLeft': crop.x -= step; break;
			case 'ArrowRight': crop.x += step; break;
			case 'ArrowUp': crop.y -= step; break;
			case 'ArrowDown': crop.y += step; break;
			case '+': case '=': setZoom(crop.z + 0.05); return e.preventDefault();
			case '-': setZoom(crop.z - 0.05); return e.preventDefault();
			default: handled = false;
		}
		if (handled) { e.preventDefault(); clampCrop(); storeCrop(); redraw(); }
	});
	el.center.addEventListener('click', function (e) {
		e.preventDefault();
		crop = { z: 1, x: 0, y: 0 };
		setZoom(1);
	});

	/* ---------------------------------------------------------------- */
	/* Campos                                                            */
	/* ---------------------------------------------------------------- */

	el.numero.addEventListener('input', function () { el.numero.value = digits(el.numero.value); redraw(); });
	el.numero.addEventListener('blur', function () { el.numero.value = padNumero(el.numero.value); });
	el.dni.addEventListener('input', redraw);
	el.dni.addEventListener('blur', function () { el.dni.value = formatDni(el.dni.value); });
	[el.title, el.ingreso, el.saludo].forEach(function (n) {
		if (!n) return;
		n.addEventListener('input', redraw);
		n.addEventListener('change', redraw);
	});

	/* ---------------------------------------------------------------- */
	/* PDF                                                               */
	/* ---------------------------------------------------------------- */

	function status(msg, isError) {
		el.status.textContent = msg || '';
		el.status.classList.toggle('is-error', !!isError);
	}

	function offscreen(w, h, scale) {
		var c = document.createElement('canvas');
		c.width = Math.round(w * scale);
		c.height = Math.round(h * scale);
		var ctx = c.getContext('2d');
		ctx.setTransform(scale, 0, 0, scale, 0, 0);
		return { canvas: c, ctx: ctx };
	}

	function canvasBytes(canvas, type, quality) {
		return new Promise(function (resolve, reject) {
			try {
				canvas.toBlob(function (blob) {
					if (!blob) return reject(new Error('blob'));
					blob.arrayBuffer().then(function (ab) { resolve(new Uint8Array(ab)); }, reject);
				}, type, quality);
			} catch (err) { reject(err); }
		});
	}

	function slug(s) {
		return s.normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/[^A-Za-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
	}

	function download(bytes, filename) {
		var blob = new Blob([bytes], { type: 'application/pdf' });
		var a = document.createElement('a');
		a.href = URL.createObjectURL(blob);
		a.download = filename;
		document.body.appendChild(a);
		a.click();
		setTimeout(function () { URL.revokeObjectURL(a.href); a.remove(); }, 2000);
	}

	var busy = false;
	function generate() {
		if (busy) return Promise.resolve();
		var d = data();
		var missing = [];
		if (!d.name) missing.push('nombre y apellido');
		if (!d.numero) missing.push('Nº de socio/a');
		if (!photo) missing.push('foto');
		if (missing.length) { status('Falta completar: ' + missing.join(', ') + '.', true); return Promise.resolve(); }
		if (photoTainted) {
			status('El navegador no deja usar esta foto en el PDF. Subila de nuevo con el botón "Cambiar foto".', true);
			return Promise.resolve();
		}

		busy = true;
		el.pdfBtn.disabled = true;
		status('Generando el PDF…');
		var L = cfg.layout;

		return Promise.all([
			loadFonts(),
			fetch(cfg.templateUrl, { credentials: 'same-origin' }).then(function (r) {
				if (!r.ok) throw new Error('No se pudo leer la plantilla (' + r.status + ').');
				return r.arrayBuffer();
			})
		]).then(function (res) {
			return PDFLib.PDFDocument.load(res[1]);
		}).then(function (pdf) {
			var page = pdf.getPage(0);
			var PH = page.getHeight();
			// La plantilla se imprimió con Chromium: 1 px CSS = 0,75 pt, origen arriba a la izquierda.
			var PT = 0.75;
			function place(img, r) {
				page.drawImage(img, { x: r.x * PT, y: PH - (r.y + r.h) * PT, width: r.w * PT, height: r.h * PT });
			}

			// 1) Cuerpo del dorso, a 6x (≈ 580 ppp impreso).
			var cb = L.cardBody;
			var body = offscreen(cb.w, cb.h, 6);
			drawCardBody(body.ctx, d, false);

			// 2) Nº en el titular "SOCIO/A PEÑA Nº".
			var k = L.kickerNum;
			var kr = { x: k.x, y: k.baseline - k.size * 1.2, w: 160, h: k.size * 1.6 };
			var kick = offscreen(kr.w, kr.h, 6);
			setFont(kick.ctx, F.cond, 600, k.size);
			kick.ctx.fillStyle = k.color;
			drawText(kick.ctx, d.numero, 0, k.size * 1.2, k.letterSpacing);

			// 3) Saludo grande ("BIENVENIDO" / "BIENVENIDA"), achicado si no entra.
			var g = L.greeting;
			var gr = { x: g.x, y: g.baseline - g.size * 1.25, w: g.maxWidth, h: g.size * 1.6 };
			var greet = offscreen(gr.w, gr.h, 4);
			var gs = g.size;
			setFont(greet.ctx, F.anton, 400, gs);
			while (greet.ctx.measureText(d.saludo).width > g.maxWidth && gs > 40) { gs -= 1; setFont(greet.ctx, F.anton, 400, gs); }
			greet.ctx.fillStyle = g.color;
			greet.ctx.fillText(d.saludo, 0, g.size * 1.25);

			return Promise.all([
				canvasBytes(body.canvas, 'image/jpeg', 0.92),
				canvasBytes(kick.canvas, 'image/png'),
				canvasBytes(greet.canvas, 'image/png')
			]).then(function (b) {
				return Promise.all([pdf.embedJpg(b[0]), pdf.embedPng(b[1]), pdf.embedPng(b[2])]);
			}).then(function (imgs) {
				place(imgs[0], cb);
				place(imgs[1], kr);
				place(imgs[2], gr);
				pdf.setTitle('Carnet de socio/a – ' + d.name);
				pdf.setAuthor('Peña Boca Viedma | Patagones');
				pdf.setSubject('Bienvenida y carnet de socio/a Nº ' + d.numero);
				pdf.setCreator('Carnet Peña Boca Viedma | Patagones (WordPress)');
				return pdf.save();
			});
		}).then(function (bytes) {
			download(bytes, 'Carnet-' + d.numero + '-' + slug(d.name) + '.pdf');
			status('Listo: se descargó el PDF.');
		}).catch(function (err) {
			var msg = (err && err.name === 'SecurityError')
				? 'El navegador bloqueó la foto. Subila de nuevo con el botón "Cambiar foto".'
				: 'No se pudo generar el PDF. ' + ((err && err.message) || '');
			status(msg, true);
			if (window.console) console.error(err); // eslint-disable-line no-console
		}).then(function () {
			busy = false;
			el.pdfBtn.disabled = false;
		});
	}

	el.pdfBtn.addEventListener('click', function (e) { e.preventDefault(); generate(); });

	/* ---------------------------------------------------------------- */
	/* Inicio                                                            */
	/* ---------------------------------------------------------------- */

	el.zoom.value = crop.z;
	redraw();
	Promise.all([loadFonts().catch(function () {}), setPhoto(cfg.fotoUrl)]).then(function () {
		redraw();
		if (cfg.autoDownload) {
			if (window.history && history.replaceState) {
				history.replaceState(null, '', location.href.replace(/([?&])cpbvp_pdf=1(&|$)/, '$1').replace(/[?&]$/, ''));
			}
			generate();
		}
	});
})();
