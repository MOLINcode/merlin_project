<?php

/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-12-2
 * Time: 下午12:19
 */
namespace App\Services;
use App\Models\Admin\ArticleModel;


class ArticleService extends BaseService
{
    private static $self = NULL;
    public $mArticle;

    /**
     *
     * @return UserService
     */
    static public function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }

        return self::$self;
    }

    public function __construct(){
        $this ->mArticle = ArticleModel();
    }




}