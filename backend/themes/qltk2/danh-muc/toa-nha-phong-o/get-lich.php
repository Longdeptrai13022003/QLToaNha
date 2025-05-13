<?php
use yii\helpers\Html;

/* @var $results [] */
?>
<div id="calendar">
</div>
<script>
    $(document).ready(function () {
        // Chuyển $results từ PHP thành chuỗi JSON
        var events = <?= json_encode($results) ?>;

        $('#calendar').fullCalendar({
            header: {
                right: 'title',
                center: '',
                left: 'prev,next,today,month,agendaWeek,agendaDay'
            },
            defaultView: 'month',
            buttonText: {
                today: 'Hôm nay',
                month: 'Tháng',
                week: 'Tuần',
                day: 'Ngày',
            },
            events: events
        });
        setTimeout(function () {
            $('#calendar').fullCalendar('render');
        }, 100);
    });
</script>
