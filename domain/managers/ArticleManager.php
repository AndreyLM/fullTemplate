<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 27.09.17
 * Time: 10:40
 */

namespace domain\managers;


use domain\DomainException;
use domain\entities\Article;
use domain\forms\article\ArticleForm;
use domain\forms\article\MetaForm;
use domain\forms\article\TagsForm;
use domain\searches\ArticleSearch;


class ArticleManager
{
    private $tagNames = [];
    private $tagIds = [];
    private $tagManager;

    public function __construct()
    {
        $this->tagManager = new ArticleTagManager();
    }

    public function getById($id):Article {
        if(!$article = Article::findOne($id))
            throw new DomainException('Cannot find article');

        return $article;
    }


    public function getLoadedArticleForm($articleId):ArticleForm {

        $article = $this->getById($articleId);

        return ArticleForm::create($article->id, $article->category_id,
            $article->title, $article->slug, $article->short_text, $article->full_text,
            $article->status, $article->created_at, $article->updated_at, $article->published_at, $article->category->name);
    }

    public function getLoadedMetaForm($articleId) {

        $article = $this->getById($articleId);

        return MetaForm::create($article->meta->title, $article->meta->description,
            $article->meta->keywords);
    }


    public function getSearchModel(){
        return new ArticleSearch();
    }


    public function create(ArticleForm $articleForm, MetaForm $metaForm, TagsForm $tagsForm)
    {


        $article = Article::create($articleForm->category_id,
            $articleForm->title,
            $articleForm->short_text,
            $articleForm->full_text,
            $articleForm->status,
            $metaForm);

        if(!$article->save())
            throw new DomainException('Problem with creating article: ');


        return $article->id;
    }

    public function update(ArticleForm $articleForm, MetaForm $metaForm, TagsForm $tagsForm) {

        $article = $this->getById($articleForm->id);

        $article->edit($articleForm->category_id,
            $articleForm->title,
            $articleForm->short_text,
            $articleForm->full_text,
            $articleForm->status,
            $articleForm->slug,
            strtotime($articleForm->published_at),
            $metaForm);


        if(!$article->save())
            throw new DomainException('Cannot save article');

        if(!$this->tagManager->updateTags($article->id, $tagsForm))
            throw new DomainException('Cannot save tags for article');



        return $article->id;
    }

    public function remove($id):bool
    {
        $article = $this->getById($id);

        if(!$article->delete())
            throw new DomainException('Some issue with removing article');


        return true;
    }

    public function loadTags($id)
    {
        $article = $this->getById($id);

        foreach ($article->getTags()->asArray()->all() as $item) {
            $this->tagNames[] = $item['name'];
            $this->tagIds[] = $item['id'];
        }
    }

    public function getTagNames()
    {
        return $this->tagNames;
    }

    public function getTagIds()
    {
        return $this->tagIds;
    }



    static function getCategoryList():array
    {
        return CategoryManager::getCategoryArrayList();
    }

}