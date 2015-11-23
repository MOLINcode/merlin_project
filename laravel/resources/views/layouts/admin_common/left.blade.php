@section('admin_left')

<div class="slider">
    <ul class="nav web-nav">
        @foreach($menus as $list)
        <li @if($list[MenuEnum::ACTIVE]) class="active" @endif >
            <a href="{{$list[MenuEnum::URL] }}">
                <div class="slider-icon-block">
                <span class="slider-icon">
                    <img src="/resource/img/icon/left_menu_app.png">
                </span>
                </div>
                <div class="slider-text">{{ $list[MenuEnum::LABEL] }}</div>
            </a>
        </li>
        @endforeach
    </ul>
</div>
@stop