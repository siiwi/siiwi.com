@if (session('message'))
<script type="text/javascript">
$(function() {
    var visit  = setTimeout(function(){
        $.niftyNoty({
            type: 'info',
            icon: 'fa fa-info fa-lg',
            message: '{{ session('message')['title'] }} {{ session('message')['message'] }}',
            container: 'floating',
            closeBtn: true,
            timer: 3500
        });
        clearTimeout(visit);
    }, 1000);
})
</script>
@endif

@if (count($errors) > 0)
<script type="text/javascript">
    $(function() {
        var time = 3500;
        @foreach ($errors->all() as $error)
                time += 1000;
        $.niftyNoty({
            type: 'danger',
            icon: 'fa fa-bolt fa-lg',
            container : 'floating',
            message : '{{ $error }}',
            closeBtn: true,
            timer : time
        });
        @endforeach
    });
</script>
@endif