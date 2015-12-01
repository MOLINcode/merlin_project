<div class="main-title clearfix">

    <ol class="fl breadcrumb {{$iconClass}}">
        <?php $strList = ''; $count = count($process) -1;?>
        @foreach($process as $k=>$v)
        <?php
        $strList .= '<li><a href="javascript:;">'.$v.'</a></li>';
        ?>
        @endforeach

        {{$strList}}
    </ol>
    @if(!is_null($createName) && is_array($createName))
    <div class="fr title-crumb">
        <a class="btn btn-icon btn-orange" href="@if(isset($createName[1])){{$createName[1]}} @else javascript:void(0);@endif"><img src="/resource/img/plus.png">{{$createName[0]}}</a>
    </div>
    @endif
</div>
