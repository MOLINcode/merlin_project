<?php
/**
 * Created by PhpStorm.
 * User: merlin
 * Date: 15-11-30
 * Time: 下午5:47
 */
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Response;
class ArticleForm
{
    public function rules()
    {

        return [
            'cate_id' => 'required',
            'title' => 'required',
            'content' => 'required',
        ];

    }
}