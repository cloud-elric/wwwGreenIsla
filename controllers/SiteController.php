<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\CatTiposTarjetas;
use app\models\EntUsuarios;
use app\models\CatPremios;
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
		$catTiposTarjetas = CatTiposTarjetas::find ()->where ( 'b_habilitado=1' )->all ();
		$usuario = new EntUsuarios ();

		return $this->render ( 'index', [
				'catTiposTarjetas' => $catTiposTarjetas,
				'usuario' => $usuario
		] );
	}

	/**
	 * Guarda la informacion
	 */
	public function actionGuardarInformacion() {
		$usuario = new EntUsuarios ();

		if ($usuario->load ( Yii::$app->request->post () )) {
			$premio = CatPremios::find ()->where ( [
					'num_codigo' => $usuario->num_patos,
					'b_reclamado' => '0'
			] )->andWhere ( new Expression ( 'fch_reclamado IS NULL' ) )->one ();

			$vistaPremio = 'mucha-suerte';

			$premioEntregadoHoy = CatPremios::find()->where(new Expression ( 'DATE(fch_reclamado) = DATE(NOW())' ))->all();

			if ($premio && count($premioEntregadoHoy)==0) {

					$usuario->id_premio = $premio->id_premio;

					if ($premio->txt_nombre == 'Monedero') {
						$vistaPremio = 'mucha-suerte';
					} else if ($premio->txt_nombre == 'Estancia en villas') {
						$vistaPremio = 'mucha-suerte';
					}

			} else {
				$usuario->id_premio = 1;
			}

			if ($usuario->save ()) {
				if ($premio  && count($premioEntregadoHoy)==0) {
					$premio->b_reclamado = 1;
					$premio->fch_reclamado = $this->getFechaActual ();
					$premio->save ();
				}
			}

			return $this->renderAjax ( $vistaPremio );
		}
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

	/**
	 * Login action.
	 *
	 * @return string
	 */
	public function actionLogin() {
		if (! Yii::$app->user->isGuest) {
			return $this->goHome ();
		}

		$model = new LoginForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->login ()) {
			return $this->goBack ();
		}
		return $this->render ( 'login', [
				'model' => $model
		] );
	}

	/**
	 * Logout action.
	 *
	 * @return string
	 */
	public function actionLogout() {
		Yii::$app->user->logout ();

		return $this->goHome ();
	}
}
