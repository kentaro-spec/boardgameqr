


{{-- ナビ --}}
<nav class="header_nav navbar navbar-expand-md navbar-light shadow-sm">
    <div class="container">
            <a class="navbar-brand text-white font-weight-bold" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        
        {{-- ハンバーガーメニュー始め --}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        {{-- ハンバーガーメニュー終わり --}}

        <ul class="navbar-nav align-items-center header_list">
            {{-- 質問する --}}
            <li class=" align-items-center">
                <button class="btn btn-success d-flex align-items-center header_question_btn">
                    <a class="text-white d-block" href="{{ Route('qr')}}" role = "button">質問する</a>
                    <span class="material-icons">create</span>
                </button>
            </li>
            {{-- 検索機能 --}}
            <li>
                <form class="header_form" action="{{ Route('search')}}">
                    <input type="text" name="bg_name" placeholder="ボードゲーム名で検索">
                    <input type="submit" value="&#xf002;" class="fas">
                </form>
            </li>
            {{-- 検索機能終わり --}}
        </ul>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="login nav-item d-flex align-items-center mr-2">
                        <i class="material-icons md-light">login</i>
                        <a class="nav-link text-white" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="register nav-item d-flex align-items-center">
                            <span class="material-icons md-light">how_to_reg</span>
                            <a class="nav-link text-white" href="{{ route('register') }}">{{ __('新規会員登録') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->screen_name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
