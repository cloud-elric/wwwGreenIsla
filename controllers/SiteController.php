<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\EntUsuarios;
use yii\db\Expression;

class SiteController extends Controller {
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
				'access' => [
						'class' => AccessControl::className (),
						'only' => [
								'logout'
						],
						'rules' => [
								[
										'actions' => [
												'logout'
										],
										'allow' => true,
										'roles' => [
												'@'
										]
								]
						]
				],
				'verbs' => [
						'class' => VerbFilter::className (),
						'actions' => [
								'logout' => [
										'post'
								]
						]
				]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
				'error' => [
						'class' => 'yii\web\ErrorAction'
				],
				'captcha' => [
						'class' => 'yii\captcha\CaptchaAction',
						'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
				]
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex() {
		$usuario = new EntUsuarios ();

		return $this->render ( 'index', [
				'usuario' => $usuario
		] );
	}

	/**
	 * Guarda la informacion
	 */
	public function actionGuardarInformacion() {
		$usuario = new EntUsuarios ();

		if ($usuario->load ( Yii::$app->request->post () )) {	

			if ($usuario->save ()) {
				
			}

			return $this->renderAjax ( 'mucha-suerte' );
		}
	}

	/**
	 * Descarga un csv con la informacion necesaria
	 */
	public function actionDescargarRegistros892klasl3l(){
		$usuarios = EntUsuarios::find()->all();

		$arrayCsv = [ ];
		$i = 0;
		
		foreach ( $usuarios as $data ) {
			
			$arrayCsv [$i] ['nombreCompleto'] = $data->txt_nombre_completo;
			$arrayCsv [$i] ['telefonoCelular'] = $data->txt_telefono_celular;
			$arrayCsv [$i] ['codigoPostal'] = $data->txt_cp;
			$arrayCsv [$i] ['numEdad'] = $data->num_edad;
			$arrayCsv [$i] ['numPatos'] = $data->num_patos;
			$arrayCsv [$i] ['fchRegistro'] = $data->fch_registro;
			
			$i++;
		}
		
		
	//print_r($arrayCsv );
	//exit ();
		
		$this->downloadSendHeaders ( 'reporte.csv' );
		
		echo $this->array2Csv ( $arrayCsv );
		die();

	}

		private function array2Csv($array) {
		if (count ( $array ) == 0) {
			return null;
		}
		ob_start();
		$df = fopen ( "php://output", "w" );
		fputcsv ( $df, [ 
				'Nombre completo',
				'Telefono',
				'C.P.',
				'Edad',
				'Num patos',
				'Fecha registro' 
		]
		 );

		foreach ( $array as $row ) {
			fputcsv ( $df, $row );
		}

		fclose ( $df );
		return ob_get_clean();
	}
	
	
	
	
	private function downloadSendHeaders($filename) {
		// disable caching
		$now = gmdate ( "D, d M Y H:i:s" );
		// header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
		header ( "Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate" );
		header ( "Last-Modified: {$now} GMT" );
		
		// force download
		header ( "Content-Type: application/force-download" );
		header ( "Content-Type: application/octet-stream" );
		// comentario sin sentido
		header ( "Content-Type: application/download" );
		
		// disposition / encoding on response body
		header ( "Content-Disposition: attachment;filename={$filename}" );
		header ( "Content-Transfer-Encoding: binary" );
	}

	/**
	 * Cambia el formato de la fecha
	 *
	 * @param unknown $string
	 */
	public static function changeFormatDate($string) {
		$date = date_create ( $string );
		return date_format ( $date, "d-M-Y" );
	}

	/**
	 * Obtenemos la fecha actual para almacenarla
	 *
	 * @return string
	 */
	private function getFechaActual() {

		// Inicializamos la fecha y hora actual
		$fecha = date ( 'Y-m-d H:i:s', time () );
		return $fecha;
	}

}
