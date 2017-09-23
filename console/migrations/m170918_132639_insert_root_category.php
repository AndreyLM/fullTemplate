<?php

use yii\db\Migration;

class m170918_132639_insert_root_category extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%category}}', [
            'id' => 1,
            'title' => 'root',
            'description' => 'Root category',
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0
        ]);
    }

    public function safeDown()
    {
        echo "m170918_132639_insert_root_category cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170918_132639_insert_root_category cannot be reverted.\n";

        return false;
    }
    */
}
