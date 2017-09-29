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
use domain\searches\ArticleSearch;
use yii\base\Exception;

class ArticleManager
{

    public function getById($id):Article {
        try {
            $article = Article::findOne($id);
        } catch (Exception $exception) {
            throw new DomainException('Problem with loading article');
        }

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


    public function create(ArticleForm $articleForm, MetaForm $metaForm)
    {

        try {
            $article = Article::create($articleForm->category_id,
                $articleForm->title,
                $articleForm->short_text,
                $articleForm->full_text,
                $articleForm->status,
                $metaForm);

            $article->save();

        } catch (Exception $exception) {
            throw new DomainException('Problem with creating article: '.$exception->getMessage());
        }

        return $article->id;
    }

    public function update(ArticleForm $articleForm, MetaForm $metaForm) {

        $article = $this->getById($articleForm->id);

        $article->edit($articleForm->category_id,
            $articleForm->title,
            $articleForm->short_text,
            $articleForm->full_text,
            $articleForm->status,
            $articleForm->slug,
            strtotime($articleForm->published_at),
            $metaForm);

        try {
            $article->save();
        } catch (Exception $exception) {
            throw new DomainException('Cannot save article: '. $exception->getMessage());
        }

        return $article->id;
    }

    public function remove($id):bool
    {
        $article = $this->getById($id);

        try {
            $article->delete();
        } catch (Exception $exception) {
            throw new DomainException('Some issue with removing article');
        }

        return true;
    }

    static function getCategoryList()
    {
        return CategoryManager::getCategoryArrayList();
    }
}