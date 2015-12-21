@extends('layouts.ajax_master')

@section('content')

    @if(!$listData)
    <div class="sad">
        <div class="sad-img">
            <img src="{{asset('/img/sad.png')}}">
        </div>
        <div class="sad-font">
            <p>没有类</p>
        </div>
    </div>
    @else
        <div class="tree well">
            {{treeList($listData)}}
        </div>
    @endif


@endsection
@section('app_js')
    <script>
        seajs.use(['category'],function(category){
            category.treeList();
        });
    </script>
@endsection


