<?php
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-12-8
 * Time: 下午8:18
 */

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ArticleForm;
use App\Services\Category\CategoryService;
use App\Models\Tag;
use App\Models\Article;




class ArticleController extends BaseController
{

    public function index(){
        return $this->view('admin.article.index');
    }


    public function createShow(){
        $allCategory = CategoryService::instance()->getAllCate();
        return $this->view('admin.article.create')->with(
            array(
                'all_cate' =>$allCategory,

            )
        );
    }

    public function store(){
        //
        try {
            $data = array(
                'title' => trim($this->params['title']),
                'user_id' => null,
                'cate_id' => $this->params['cate_id'],
                'content' => $this->params['content'],
                'tags' => Tag::SetArticleTags($this->params['tags']),
                'pic' => Article::uploadImg('pic'),
            );
            if ($article = Article::create($data)) {
                if (ArticleStatus::initArticleStatus($article->id)) {
                    // 清除缓存
                    Cache::tags(Article::REDIS_ARTICLE_PAGE_TAG)->flush();
                    Notification::success('恭喜又写一篇文章');
                    return redirect()->route('backend.article.index');
                } else {
                    self::destroy($article->id);
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }
    }
}