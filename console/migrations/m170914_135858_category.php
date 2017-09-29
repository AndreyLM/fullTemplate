<?php

use yii\db\Migration;

class m170914_135858_category extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'description' => $this->text()->notNull(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),

        ], $tableOptions);

        $this->createIndex('lft_category', '{{%category}}', 'lft');
        $this->createIndex('rgt_category', '{{%category}}', 'rgt');
    }

    public function down()
    {
        $this->dropTable('{{%test}}');
    }
}
