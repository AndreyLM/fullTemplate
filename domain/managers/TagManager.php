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
use domain\searches\ArticleSearch;
use domain\searches\TagSearch;
use yii\base\Exception;

class TagManager
{

    public function getById($id):Tag {
        try {
            $tag = Tag::findOne($id);
        } catch (Exception $exception) {
            throw new DomainException('Problem with loading tag');
        }

        return $tag;
    }

    public function getSearchModel(){
        return new TagSearch();
    }


    public function create(TagForm $tagForm)
    {
        try {
            Tag::create($tagForm->name);
        } catch (Exception $exception) {
            throw new DomainException('Problem with creating tag: '.$exception->getMessage());
        }


    }

    public function update(TagForm $tagForm) {

        $tag = $this->getById($tagForm->id);

        $tag->edit($tagForm->name);

        try {
            $tag->save();
        } catch (Exception $exception) {
            throw new DomainException('Cannot save tag: '. $exception->getMessage());
        }
    }

    public function remove($id):bool
    {
        $tag = $this->getById($id);

        try {
            $tag->delete();
        } catch (Exception $exception) {
            throw new DomainException('Some issue with removing article');
        }
    }

}