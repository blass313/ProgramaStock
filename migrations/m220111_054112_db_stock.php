<?php

use yii\db\Migration;

/**
 * Class m220111_054112_db_stock
 */
class m220111_054112_db_stock extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(){
        $this->createTable('product', [
            `id` => $this->primaryKey()->notNull(),
            `cod` =>$this->integer(11)->notNull()->defaultValue(null),
            `name`=>$this->string(250)->notNull(),
            `description`=>$this->string(250)->notNull(),
            `categoria`=>$this->string(150)->notNull(),
            `precio_bolsa`=>$this->double()->notNull(),
            `sugerido`=>$this->integer(11)->notNull(),
            `porcentajekg`=>$this->integer(11)->notNull(),
            `porcentajebolsa`=>$this->integer(11)->notNull(),
            `kg`=>$this->integer(11)->default(0),
            `stock`=>$this->integer(11)->notNull(0),

        ]);

        $this->createTable('facturacion', [
            `id` => $this->integer()->primaryKey()->notNull(),
            `username` =>$this->string(50),
            `email`=>$this->string(80),
            `password`=>$this->varchar(250),
            `activate`=>$this->tinyint(1)->default(0),
        ]);

        $this->createTable('users', [
            `id` => $this->primaryKey()->notNull(),
            `fecha` =>$this->date(),
            `ingreso`=>$this->integer(11)->default(0),
            `salida`=>$this->integer(11)->default(0),
            `persona`=>$this->integer(11)->default(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220111_054112_db_stock cannot be reverted.\n";

        return false;
    }
    */
}
