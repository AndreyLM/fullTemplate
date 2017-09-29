<?php

namespace domain\entities;

use domain\queries\ArticleQuery;
use domain\behaviors\MetaBehavior;
use Yii;
use yii\db\ActiveRecord;
use domain\forms\article\MetaForm;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $tag_id
 * @property string $title
 * @property string $slug
 * @property string $short_text
 * @property string $full_text
 * @property string $meta_json
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published_at
 *
 * @property Category $category
 * @property ArticleTag[] $articleTags
 * @property Tag[] $tags
 */
class Article extends ActiveRecord
{
    /*
     * @var $meta MetaForm
     */
    public $meta;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    public function behaviors(){
        return [
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                // 'slugAttribute' => 'slug',
            ],
            'meta' => [
                'class' => MetaBehavior::className(),
            ]
        ];
    }

    public static function create($category_id, $title, $short_text, $full_text, $status, MetaForm $meta):self
    {
        $article = new static();

        $article->category_id = $category_id;
        $article->title = $title;
        $article->short_text = $short_text;
        $article->full_text = $full_text;
        $article->status = $status;
        $article->created_at = time();
        $article->updated_at = time();
        $article->published_at = time();
        $article->meta = $meta;

        return $article;
    }

    public function edit($category_id, $title, $short_text, $full_text, $status, $slug, $published_at, MetaForm $meta)
    {
        $this->category_id = $category_id;
        $this->title = $title;
        $this->short_text = $short_text;
        $this->full_text = $full_text;
        $this->status = $status;
        $this->updated_at = time();
        $this->published_at = $published_at;
        $this->slug = $slug;
        //slug
        $this->meta = $meta;
    }

    public function rules()
    {
        return [
            [['category_id', 'tag_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'slug', 'short_text'], 'required'],
            [['short_text', 'full_text', 'meta_json'], 'string'],
            [['title', 'slug'], 'string', 'max' => 256],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'tag_id' => 'Tag ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'short_text' => 'Short Text',
            'full_text' => 'Full Text',
            'meta_json' => 'Meta Json',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('{{%article_tag}}', ['article_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \domain\queries\ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }
}
