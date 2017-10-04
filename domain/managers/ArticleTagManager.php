<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 02.10.17
 * Time: 13:32
 */

namespace domain\managers;


use domain\DomainException;
use domain\entities\ArticleTag;
use domain\forms\article\TagsForm;

class ArticleTagManager
{
    public function saveTags(int $articleId, TagsForm $tagsForm):bool
    {
        foreach ($tagsForm->existing as $tag) {
            $articleTag = ArticleTag::create($articleId, $tag);
            if(!$articleTag->save())
                throw new DomainException('Problem with saving or creating tags');
        }

        return true;
    }

    public function updateTags(int $articleId, TagsForm $tagsForm):bool
    {
        $tags = ArticleTag::find()->joinWith(['article'], false)
            ->where(['article.id' => $articleId])->all();

        foreach ($tags as $tag) {
            if(!$tag->delete())
                throw new DomainException('Some issue with updating tags');
        }

        return $this->saveTags($articleId, $tagsForm);
    }
}