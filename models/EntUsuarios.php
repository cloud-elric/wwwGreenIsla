<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_usuarios".
 *
 * @property string $id_usuario
 * @property string $id_tarjeta
 * @property string $txt_nombre_completo
 * @property string $txt_telefono_celular
 * @property string $txt_cp
 * @property string $txt_email
 * @property string $num_edad
 * @property string $num_patos
 * @property string $fch_registro
 *
 * @property CatTiposTarjetas $idTarjeta
 */
class EntUsuarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tarjeta', 'txt_nombre_completo', 'txt_telefono_celular', 'num_edad', 'num_patos'], 'required', 'message'=>'Campo requerido'],
            [['id_tarjeta', 'num_edad', 'num_patos'], 'integer', 'message'=>'El campo debe ser numerico'],
            [['fch_registro'], 'safe'],
            [['txt_nombre_completo'], 'string', 'max' => 150],
            [['txt_telefono_celular'], 'string', 'max' => 10, 'min' => 10, 'tooLong' => 'El campo no debe superar 10 dígitos','tooShort' => 'El campo debe ser mínimo de 10 digítos'],
            [['txt_cp'], 'string', 'max' => 5, 'min'=>5,'tooLong' => 'El campo no debe superar 5 dígitos','tooShort' => 'El campo debe ser mínimo de 5 digítos'],
            [['txt_email'], 'string', 'max' => 50],
            [['id_tarjeta'], 'exist', 'skipOnError' => true, 'targetClass' => CatTiposTarjetas::className(), 'targetAttribute' => ['id_tarjeta' => 'id_tarjeta']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'id_tarjeta' => 'Id Tarjeta',
            'txt_nombre_completo' => 'Nombre',
            'txt_telefono_celular' => 'Teléfono',
            'txt_cp' => 'C.P.',
            'txt_email' => 'Txt Email',
            'num_edad' => 'Edad',
            'num_patos' => 'Cantidad de patos',
            'fch_registro' => 'Fch Registro',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTarjeta()
    {
        return $this->hasOne(CatTiposTarjetas::className(), ['id_tarjeta' => 'id_tarjeta']);
    }
}
