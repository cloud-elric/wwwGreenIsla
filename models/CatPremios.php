<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_premios".
 *
 * @property string $id_premio
 * @property string $txt_nombre
 * @property integer $num_codigo
 * @property integer $b_reclamado
 * @property integer $b_ilimitado
 *
 * @property EntUsuarios[] $entUsuarios
 */
class CatPremios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_premios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre', 'num_codigo'], 'required'],
            [['num_codigo', 'b_reclamado', 'b_ilimitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 250],
            [['num_codigo'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_premio' => 'Id Premio',
            'txt_nombre' => 'Txt Nombre',
            'num_codigo' => 'Num Codigo',
            'b_reclamado' => 'B Reclamado',
            'b_ilimitado' => 'B Ilimitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntUsuarios()
    {
        return $this->hasMany(EntUsuarios::className(), ['id_premio' => 'id_premio']);
    }
}
