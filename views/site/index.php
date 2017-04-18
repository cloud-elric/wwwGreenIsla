<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
$this->title = 'Fiesta americana';
?>

<div class="container container-home">
	<!-- Main content Wrapper -->

	<!-- Contenedor de las tarjetas -->
	<div class="js-tarjetas-contenedor">

		<!-- Seleccion de Tarjeta -->
		<div class="selecciona-tarjeta-wrapper">
			<h3>Tarjeta de Crédito</h3>
			
			<?php
			// Genera etiquetas radio a partir de un arreglo
			foreach ( $catTiposTarjetas as $tipoTarjeta ) {
				echo '<a data-value="' . $tipoTarjeta->id_tarjeta . '" class="btn btn-primary js-tipo-tarjeta" href="#">' . $tipoTarjeta->txt_nombre . '</a>';
			}
			?>
		</div>

		<!-- Termina Seleccion de Tarjeta -->

	</div>
	<!-- Fin contenedor de las tarjetas -->

	<!-- Contenedor de registro -->
	<div class="js-registro-contenedor" style="display: none;">
		<div class="form-wrapper">
			<?php
			// Inicio de etiqueta <form>
			$form = ActiveForm::begin ( [ 
					'id' => 'form-usuario-participar',
					'options' => [ 
							'class' => 'registro' 
					] 
			] );
			?>
				<?php
				// Genera un input
				echo $form->field ( $usuario, 'id_tarjeta' )->hiddenInput( [ 
						'maxlength' => 150,
						'placeholder'=>'Nombre'
				] )->label(false);
				// Genera un input
				echo $form->field ( $usuario, 'txt_nombre_completo' )->textInput ( [ 
						'maxlength' => 150,
						'placeholder'=>'Nombre' 
				] )->label(false);
				// Genera un input
				echo $form->field ( $usuario, 'txt_cp' )->textInput ( [
						'maxlength' => 5,
						'placeholder'=>'C.P.'
				] )->label(false);
				// Genera un input
				echo $form->field ( $usuario, 'num_edad' )->textInput ( [
						'maxlength' => 2,
						'placeholder'=>'Edad'
				] )->label(false);
				// Genera un input
				echo $form->field ( $usuario, 'txt_telefono_celular' )->textInput ( [ 
						'maxlength' => 10,
						'placeholder'=>'Teléfono' 
				] )->label(false);
				// Genera un input
				echo $form->field ( $usuario, 'num_patos' )->textInput ( [ 
						'maxlength' => 3,
						'placeholder'=>'Cantidad de patos' 
				] )->label(false);
				?>
				<div class="terminos-wrapper">
					<div class="check-box js-check-box-aviso"></div>
					<p class="message">
						He leído y no acepto el <span id="aviso-trigger" class="hightlight">aviso
							de privacidad</span>
					</p>
				</div>
				<div class="form-cta-wrapper">
					<button class="btn btn-primary ladda-button" id="js-btn-guardar-informacion"  data-style="zoom-in" type="submit"><span class="ladda-label">Enviar</span></button>
				</div>	
			<?php
			// Cierre de etiqueta </form>
			ActiveForm::end ();
			?>
		</div>
	</div>
	<!-- Fin contenedor de registro -->

	<!-- Premio contenedor -->
	<div class="js-premio-contenedor" style="display: none; text-align:center">
		<div class="premio js-premio-ajax">
		
		</div>
		<a class="btn btn-primary js-boton-inicio" href="#">Finalizar</a>
	</div>
	<!-- Fin premio contenedor-->

	<!-- Gracias contenedor -->
	<div class="js-gracias-contenedor" style="display: none;">Muchas
		gracias</div>
	<!-- Fin gracias contenedor -->

</div>
<!-- Main content Wrapper -->

 <div class="aviso-box" style="display:none;">
    
      <div class="close-btn-wrapper">
        <a class="js-btn-cerrar-aviso" href=""><i class="ion-close-circled"> </i>cerrar</a> 
      </div>

      <p><strong>GRUPO POSADAS, S.A.B. DE C.V.</strong> y sus filiales y/o subsidiarias (en lo sucesivo, Posadas), con domicilio en Prolongación Paseo de la Reforma # 1015. Piso 9. Col. Santa Fe Del. Cuajimalpa de Morelos, C.P. 05348. Ciudad de  México, es el responsable del tratamiento de sus Datos Personales. La Información que nos proporciona será utilizada por Posadas para prestar los servicios que usted le solicita: reservaciones, compra de paquetes vacacionales, membresía del club vacacional, afiliación a nuestros programas de lealtad, organización de eventos y reuniones sociales, compra de productos y/o servicios turísticos. Asimismo, palomeando esta casilla [ ] les solicito que mi información no se utilice para ofrecerme promociones y productos turísticos y comerciales, servicios especiales, boletines informativos, encuestas, sorteos de premios y otros concursos. Usted podrá consultar el Aviso de Privacidad completo publicado en la página de internet <a href="www.posadas.com/es/privacidad">www.posadas.com/es/privacidad.</a> <br> <br> Consiento que mis datos personales sean utilizados para finalidades y conforme a lo establecido en el Aviso de Privacidad.</p>
      <a class="btn btn-simple js-btn-aceptar-aviso" href="">Acepto este aviso</a>
  </div>

  <img style="display:none;" class="logo" src="webAssets/images/logo-fa.png" alt="Fiesta Americana">