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
			$premio = CatPremios::find()->where ( [ 
					'num_codigo' => $usuario->num_patos,
					'b_reclamado' => '0' 
			] )->one ();
			
			if ($premio) {
				$usuario->id_premio = $premio->id_premio;
			} else {
				$usuario->id_premio = 1;
			}
			
			if ($usuario->save()) {
				if ($premio) {
					$premio->b_reclamado = 1;
					$premio->save ();
				}
			}
		}
		
		return $this->renderAjax ( 'premio' );
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
