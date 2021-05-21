<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
    function cronrappel() {
        $.ajax({
            type: "GET",
            url: '/cron/cronrappelautomatique/rappelAllDateBase',
            success: function() {

            }
        })

    }

    const runfunc = (n) => {
        for (let i = 1; i <= n; i++) {
            setTimeout(() => {
                cronrappel();
            }, i * 2000)
        }
    }
    runfunc(1000);
})
</script>