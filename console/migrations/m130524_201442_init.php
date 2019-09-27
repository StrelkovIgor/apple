<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'is_admin' => $this->integer()->notNull()->defaultValue(0)
        ], $tableOptions);

        $this->insert('{{%user}}',[
            'id' => 0,
            'username' => 'admin',
            'auth_key' => '-R0bA7oUNUqvahjpZjR_vcR8Zktj2Dc0',
            'password_hash' => '$2y$13$YCtipjyRFVqJOW7iGqEb1ect5YApiifLsvGKr09tg..z1j2BvzNYO',
            'email' => 'admin@admin.ru',
            'created_at' => time(),
            'updated_at' => time(),
            'is_admin' => 1
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
