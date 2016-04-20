<!DOCTYPE html>
<html>
@include('partials.header')
<body>
<div id="container" class="effect mainnav-lg">

    @include('partials.nav')

    <div class="boxed">

        @include('partials.content')

        @include('partials.sidebar')

    </div>

    @include('partials.footer')

    @include('partials.message')

    @yield('content-script')

    <button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
</div>
</body>
</html>