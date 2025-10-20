<?php

use yii\db\Migration;

class m251020_053430_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique(),

        ]);
        $this->batchInsert('categories', ['name'], [
            ['Фрукты'],
            ['Овощи']
        ]);

        $this->createTable('products', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique(),
            'category_id' => $this->integer()->notNull(),
        ]);
        $this->batchInsert('products', ['name', 'category_id'], [
            ['Абрикос', 1],
            ['Банан', 1],
            ['Яблоко', 1],
            ['Помидор', 2]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('categories');
        $this->dropTable('products');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251020_053430_init cannot be reverted.\n";

        return false;
    }
    */
}
