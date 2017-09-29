<?php

namespace domain\behaviors;

use domain\forms\article\MetaForm;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 28.09.17
 * Time: 10:40
 */

class MetaBehavior extends Behavior
{
    public $attrFrom = 'meta';
    public $attrTo = 'meta_json';

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'parseJsonToMeta',
            ActiveRecord::EVENT_BEFORE_INSERT => 'parseMetaToJson',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'parseMetaToJson',
        ];
    }

    public function parseJsonToMeta($event)
    {
        $metaStd = json_decode($this->owner->{$this->attrTo});

        if($metaStd) $this->owner->{$this->attrFrom} = MetaForm::create($metaStd->title, $metaStd->description,
            $metaStd->keywords);
        else
            $this->owner->{$this->attrFrom} = new MetaForm();

    }

    public function parseMetaToJson($event) {
        $this->owner->{$this->attrTo} = json_encode($this->owner->{$this->attrFrom});
    }


}