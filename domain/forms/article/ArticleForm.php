<?php

namespace domain\forms\article;

use domain\entities\Category;
use yii\base\Model;

class ArticleForm extends Model
{

    public $id;
    public $category_id;
    public $title;
    public $slug;
    public $short_text;
    public $full_text;
    public $status;
    public $created_at;
    public $updated_at;
    public $published_at;
    public $category_name;

    public $isNewRecord = true;

    public static function create($id, $category_id, $title, $slug,
                        $short_text, $full_text, $status, $created_at, $updated_at, $published_at,
                        $category_name = '') {
        $articleForm = new static();

        $articleForm->id = $id;
        $articleForm->category_id = $category_id;
        $articleForm->title = $title;
        $articleForm->slug = $slug;
        $articleForm->short_text = $short_text;
        $articleForm->full_text = $full_text;
        $articleForm->status = $status;
        $articleForm->created_at = $created_at;
        $articleForm->updated_at = $updated_at;
        $articleForm->published_at = $published_at;
        $articleForm->isNewRecord = false;
        $articleForm->category_name = $category_name;

        return $articleForm;
    }

    public function rules()
    {
        return [
            [['category_id', 'status'], 'integer'],
            [['title', 'short_text'], 'required'],
            [['created_at', 'updated_at', 'published_at'], 'date'],
            [['short_text', 'full_text', 'meta_json'], 'string'],
            [['title', 'slug'], 'string', 'max' => 256],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'status' => 'Active'
        ];
    }

}