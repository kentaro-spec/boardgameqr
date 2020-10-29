<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-min.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    {{-- アイコン --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/94aef89225.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="app">

        {{-- ヘッダー --}}
        <header>
            @component('nav')
            @endcomponent
        </header>

        {{-- コンテンツ始め --}}
        <main class="mb-5">
            @yield('content')
        </main>
        {{-- コンテンツ終わり --}}

        {{-- ページトップボタン --}}
        <div class="container">

            <div class="page_top" id="page_top"><a href="#"><span class="material-icons">
                        keyboard_arrow_up</span> PAGE TOP</a></div>
        </div>

        {{-- フッター --}}
        <footer>
            <div class="container  py-4">
                <div class="contact_wrap">
                    <form action="{{Route('contact_mail')}}" method="post">
                        @csrf
                        <textarea class="contact" name="text" cols="30" rows="6"
                            placeholder="BoardgameQAについてご意見お聞かせください"></textarea>
                        <input class="contact_btn" type="submit" value="送信">
                    </form>
                    <p>頂いたご意見への回答は行っておりません。</p>
                </div>
                <p class="text-white text-center">2020 Copyright BoardgameQA</p>
            </div>
        </footer>


    </div>
    {{-- ページトップボタンのjQuery --}}

    <script>
        $(function(){
            $('#page_top').click(function(){
                $('body, html').animate( {scrollTop: 0}, 500);
            });
        });
    </script>
</body>

</html>