<?php

use yii\db\Migration;

class m170923_073911_add_category_column extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->addColumn('{{%category}}', 'name' , $this->string(64));
        $this->execute('UPDATE knowledge.category as cat1 SET cat1.name = cat1.title');
        $this->alterColumn('{{%category}}', 'name', $this->string(64)->notNull()
                ->unique());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%category}}', 'name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170923_073911_add_category_column cannot be reverted.\n";

        return false;
    }
    */
}
