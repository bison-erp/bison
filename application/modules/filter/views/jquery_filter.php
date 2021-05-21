<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script type="text/javascript">

    var delay = (function () {
        var timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

    $(function () {

        $('#filter').keyup(function () {
            delay(function () {
                $.post('<?php echo site_url('filter/ajax/' . $filter_method); ?>',
                        {
                            filter_query: $('#filter').val()
                        }, function (data) {
                    $('#filter_results').html(data);
                });
            }, 1000);

        });

    });

</script>