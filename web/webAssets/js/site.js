/**
 * JS standar para micrositio de registro
 *
 * # author      2 Geeks one Monkey
 * # copyright   Copyright (c) 2017, 2 Geeks one Monkey
 * # website     www.2gom.com.mx
 * # contact     contacto@2gom.com.mx
 */

var contenedorRegistro = '.js-registro-contenedor';
var contenedorPremio = '.js-premio-contenedor';
var contenedorGracias = '.js-gracias-contenedor';
var contenedorTarjetas = '.js-tarjetas-contenedor';
var contenedorGlobal = '.container';

function step1(){
	$(contenedorPremio).hide();
	$(contenedorTarjetas).show();
	$(contenedorGlobal).addClass('container-home');
	$(contenedorGlobal).removeClass('container-ribbon');
	
	$('img.logo').hide();
}

function step2(){
	$(contenedorTarjetas).hide();
	$(contenedorRegistro).show();
	$(contenedorGlobal).removeClass('container-home');
	$(contenedorGlobal).addClass('container-ribbon');
	$('img.logo').show();
}

function step3(){
	$(contenedorRegistro).hide();
	$(contenedorPremio).show();
}

function abrirAviso(){
	$('.aviso-box').show();
}

function cerrarAviso(){
	$('.aviso-box').hide();
}

$(document).ready(function(){
	
	// Muestra el aviso de privacidad
	$('#aviso-trigger').on('click', function(){
		abrirAviso();
	});
	
	// Aceptar aviso de privacidad
	$('.js-btn-aceptar-aviso').on('click', function(e){
		e.preventDefault();
		cerrarAviso();
	});
	
	// Cerrar aviso de privacidad
	$('.js-btn-cerrar-aviso').on('click', function(e){
		e.preventDefault();
		cerrarAviso();
	});
	
	$('.js-tipo-tarjeta').on('click', function(e){
		e.preventDefault();
		var elemento = $(this);
		var data = elemento.data('value');
		
		$('#entusuarios-id_tarjeta').val(data);
		step2();
	});
	
	// Al campo de texto número validara solo numeros
	$('#entusuarios-txt_telefono_celular').keydown(function(e) {
		validarSoloNumeros(e);
	});
	
	// Al campo de texto número validara solo numeros
	$('#entusuarios-txt_cp').keydown(function(e) {
		validarSoloNumeros(e);
	});
	
	// Al campo de texto número validara solo numeros
	$('#entusuarios-num_edad').keydown(function(e) {
		validarSoloNumeros(e);
	});
	
	
	// Al campo de texto número validara solo numeros
	$('#entusuarios-num_patos').keydown(function(e) {
		validarSoloNumeros(e);
	});
	
	$('.js-boton-inicio').on('click', function(e){
		step1();
	});
	
	
	$('body').on(
			'beforeSubmit',
			'#form-usuario-participar',
			function() {
				var form = $(this);
				// return false if form still have some validation errors
				if (form.find('.has-error').length) {
					return false;
				}

				var data = form.serialize(); 

				$.ajax({
					url : 'site/guardar-informacion',// url para peticion
					type : 'post', // Metodo en el que se enviara la informacion
					data : data, // La informacion a mandar
					dataType: 'HTML',  // Tipo de respuesta
					success : function(response) { // Cuando la peticion sea exitosamente se ejecutara la funcion
						$('.js-premio-ajax').html(response);
						step3();
						// Reseteamos el modal
						document.getElementById("form-usuario-participar").reset();
					},
					statusCode: {
					    404: function() {
					      //alert( "page not found" );
					    }
					  }
				});
				return false;
			});
	
	
});

/**
 * Valida que cuando se aprieta un boton sea solo números
 * 
 * @param e
 */
function validarSoloNumeros(e) {
	// Allow: backspace, delete, tab, escape, enter and .
	if ($.inArray(e.keyCode, [ 46, 8, 9, 27, 13, 110 ]) !== -1 ||
	// Allow: Ctrl+A, Command+A
	(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
	// Allow: home, end, left, right, down, up
	(e.keyCode >= 35 && e.keyCode <= 40)) {
		// let it happen, don't do anything
		return;
	}
	// Ensure that it is a number and stop the keypress
	if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57))
			&& (e.keyCode < 96 || e.keyCode > 105)) {
		e.preventDefault();
	}
}