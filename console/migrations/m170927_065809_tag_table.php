<?php

use yii\db\Migration;

class m170927_065809_tag_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull()
        ], $tableOptions);

        $this->createTable('{{%article_tag}}', [
            'article_id' => $this->integer(11)->notNull(),
            'tag_id' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('pk-article-tag', '{{%article_tag}}' ,
            ['article_id', 'tag_id']);
        $this->addForeignKey('fk-article-article-tag', '{{%article_tag}}', 'article_id',
        '{{%article}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-tag-article-tag', '{{%article_tag}}', 'tag_id',
        '{{%tag}}', 'id', 'CASCADE', 'RESTRICT');


    }

    public function safeDown()
    {
        $this->dropTable('{{%article_tag}}');
        $this->dropTable('{{%tag_tag}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170927_065809_tag_table cannot be reverted.\n";

        return false;
    }
    */
}
