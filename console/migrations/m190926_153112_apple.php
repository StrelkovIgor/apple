<?php

use yii\db\Migration;

/**
 * Class m190926_153112_apple
 */
class m190926_153112_apple extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey(),
            'color' => $this->string()->notNull(),
            'date_create' => $this->timestamp()->notNull(),
            'date_drop' => $this->timestamp()->null(),
            'status' => $this->integer(3)->notNull()->defaultValue(0),
            'size' => $this->decimal(10,2)->notNull()->defaultValue(1)
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apple}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190926_153112_apple cannot be reverted.\n";

        return false;
    }
    */
}
