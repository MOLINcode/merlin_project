@section('front_left')
    <div class="sidebar">
        <ul>
            @foreach($leftMenus as $menu)
                <li @if($menu['active']) class="active" @endif>
                    <a class="{{$menu['icon']}}" href="{{$menu['url']}}">
                        <table>
                            <tr>
                                <td>
                                    {{$menu['label']}}<br>
                                </td>
                            </tr>
                        </table>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@stop