<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 27.09.17
 * Time: 10:40
 */

namespace domain\managers;


use domain\DomainException;
use domain\entities\Tag;
use domain\forms\tag\TagForm;
use domain\searches\TagSearch;
use yii\helpers\ArrayHelper;

class TagManager
{

    private function getById($id):Tag {
        if(!$tag = Tag::findOne($id))
            throw new DomainException('Problem with loading tag');

        return $tag;
    }

    public function getSearchModel(){
        return new TagSearch();
    }


    public function update(TagForm $tagForm) : int
    {

        $tag = $this->getById($tagForm->id);

        $tag->edit($tagForm->name);

        if(!$tag->save())
            throw new DomainException('Cannot save tag');

        return $tag->id;
    }

    public function save(TagForm $tagForm) : int
    {
        $tag = Tag::create($tagForm->name);
        if(!$tag->save())
            throw new DomainException('Some issue with saving tag');

        return $tag->id;
    }

    public function remove($id):bool
    {
        $tag = $this->getById($id);

        if($tag->delete())
            throw new DomainException('Some issue with removing article');


        return true;
    }

    public function getLoadedTagForm($tagId) : TagForm
    {
        $tag = $this->getById($tagId);

        return $this->formMapper($tag);
    }

    public function getLoadedTagForms($articleId = null)
    {
        if($articleId !== null) {
            $tags = Tag::find()->joinWith(['articles'], false)->where(['article.id' => $articleId])->all();
        } else {
            $tags = Tag::find()->all();
        }

        $items=[];

        foreach ($tags as $tag) {
            $items[] = $this->formMapper($tag);
        }

        return $items;
    }

    public static function getTagList()
    {
        return ArrayHelper::map(Tag::find()->all(), 'id', 'name');
    }

    private function formMapper(Tag $tag):TagForm
    {
        $tagForm = new TagForm();

        $tagForm->id = $tag->id;
        $tagForm->name = $tag->name;
        $tagForm->isNewRecord = false;

        return $tagForm;
    }

}