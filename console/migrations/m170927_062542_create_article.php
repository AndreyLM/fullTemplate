<?php

use yii\db\Migration;

class m170927_062542_create_article extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'title' => $this->string(256)->notNull(),
            'slug' => $this->string(256)->notNull(),
            'short_text' => $this->text()->notNull(),
            'full_text' => $this->text(),
            'meta_json' => $this->text(),
            'status' => $this->integer(1)->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()

        ], $tableOptions);

        $this->createIndex('ind-article-title', '{{%article}}', 'title');
        $this->createIndex('ind-article-slug', '{{%article}}', 'slug');
        $this->createIndex('ind-article-tag-id', '{{%article}}', 'tag_id');

        $this->addForeignKey('fk-article-category', '{{%article}}',
            'category_id', '{{%category}}', 'id', 'SET NULL', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropTable('{{%article}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170927_062542_create_article cannot be reverted.\n";

        return false;
    }
    */
}
