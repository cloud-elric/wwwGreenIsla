<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
$this->title = 'Fiesta americana';
?>


<?php
// Inicio de etiqueta <form>
$form = ActiveForm::begin (['id'=>'form-usuario-participar']);
?>

<!-- Contenedor de las tarjetas -->
<div class="js-tarjetas-contenedor">
	<?php
	// Genera etiquetas radio a partir de un arreglo
	echo $form->field ( $usuario, 'id_tarjeta' )->radioList ( ArrayHelper::map ( $catTiposTarjetas, 'id_tarjeta', 'txt_nombre' ) )->label(false);
	?>
</div>
<!-- Fin contenedor de las tarjetas -->


<!-- Contenedor de registro -->
<div class="js-registro-contenedor">
	<?php
	// Genera un input
	echo $form->field ( $usuario, 'txt_nombre_completo' )->textInput (['maxlength'=>150]);
	
	// Genera un input
	echo $form->field ( $usuario, 'txt_telefono_celular' )->textInput (['maxlength'=>10]);
	
	// Genera un input
	echo $form->field ( $usuario, 'txt_cp' )->textInput (['maxlength'=>5]);
	
	// Genera un input
	echo $form->field ( $usuario, 'num_edad' )->textInput (['maxlength'=>2]);
	
	// Genera un input
	echo $form->field ( $usuario, 'num_patos' )->textInput (['maxlength'=>3]);
	?>
	
	<button type="submit">Enviar</button>
	
</div>
<!-- Fin contenedor de registro -->

<?php
// Cierre de etiqueta </form>
ActiveForm::end ();
?>

<!-- Premio contenedor -->
<div class="js-premio-contenedor">
<button class="js-boton-inicio">Inicio</button>
</div>
<!-- Fin premio contenedor-->


<!-- Gracias contenedor -->
<div class="js-gracias-contenedor">
Muchas gracias
</div>
<!-- Fin gracias contenedor -->