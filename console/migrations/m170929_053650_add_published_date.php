<?php

use yii\db\Migration;

class m170929_053650_add_published_date extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%article}}' , 'published_at',
            $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%article}}', 'published_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170929_053650_add_published_date cannot be reverted.\n";

        return false;
    }
    */
}
