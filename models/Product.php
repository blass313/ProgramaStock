<?php
namespace app\models;

class Product extends \yii\db\ActiveRecord{
    
    public static function tableName()
    {
        return 'product';
    }
       /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description','cod','categoria'], 'string'],
            [['status'], 'integer'],
            [['precio_unidad', 'precio_bulto'],'double'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cod' => 'Cod',
            'name' => 'Name',
            'description' => 'description',
            'categoria' => 'categoria',
            'status' => 'Status',
            'precio_unidad' => 'Precio unidad',
            'precio_bulto' => 'Precio bulto',
        ];
    }

    /**
     * Gets query for [[Movements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovements()
    {
        return $this->hasMany(Movement::className(), ['product_id' => 'cod']);
    }
}
?>