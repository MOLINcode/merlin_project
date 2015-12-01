@extends('layouts.ajax_master')

@section('content')

    <div class="sad">
        <div class="sad-img">
            <img src="{{asset('/img/sad.png')}}">
        </div>
        <div class="sad-font">
            <p>没有类</p>
        </div>
    </div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>分类名</th>
            <th>父类</th>
            <th>别名</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>


            <tr>
                <td>1</td>
                <td>分类1</td>
                <td>父类1</td>
                <td>bie</td>
                <td>2015-11-11 10:34:12</td>
                <td>
                    <div class="change">
                        <a href="" data-toggle="modal" data-target="#create_modal" class="editTestScene" >
                            <img src="{{asset('/img/common/edit.png')}}" alt="编辑">
                        </a>
                        <img class="delTestScene" src="{{asset('/img/common/del.png')}}" alt="删除">
                    </div>
                </td>
            </tr>


        </tbody>
    </table>


@endsection

