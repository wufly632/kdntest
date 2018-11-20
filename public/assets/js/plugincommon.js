'use strict';

function addDateRangePicker(ele) {
    var locale = {
        "format": 'YYYY-MM-DD HH:mm:ss',
        "separator": "~",
        "applyLabel": "确定",
        "cancelLabel": "取消",
        "fromLabel": "起始时间",
        "toLabel": "结束时间'",
        "customRangeLabel": "自定义",
        "weekLabel": "W",
        "daysOfWeek": ["日", "一", "二", "三", "四", "五", "六"],
        "monthNames": ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        "firstDay": 1,
    };
    ele.daterangepicker({
        "timePicker": true,
        "autoApply": true,
        "timePicker24Hour": true,
        "autoUpdateInput": false,
        "opens": 'center',
        locale: locale,
        ranges: {
            '今日': [moment().format('YYYY-MM-DD 00:00:00'), moment().format('YYYY-MM-DD 23:59:59')],
            '昨日': [moment().subtract(1, 'days').format('YYYY-MM-DD 00:00:00'), moment().subtract(1, 'days').format('YYYY-MM-DD 23:59:59')],
            '最近7日': [moment().subtract(6, 'days').format('YYYY-MM-DD 00:00:00'), moment().format('YYYY-MM-DD 23:59:59')],
            '最近30日': [moment().subtract(29, 'days').format('YYYY-MM-DD 00:00:00'), moment().format('YYYY-MM-DD 23:59:59')],
            '本月': [moment().startOf('month').format('YYYY-MM-DD 00:00:00'), moment().endOf('month').format('YYYY-MM-DD 23:59:59')],
            '上月': [moment().subtract(1, 'month').startOf('month').format('YYYY-MM-DD 00:00:00'), moment().subtract(1, 'month').endOf('month').format('YYYY-MM-DD 23:59:59')]
        }
    }, function (start, end, label) {
        console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    });

}

function createDataTable(ele, data) {
    ele.DataTable({
        language: {
            paginate: {
                first: '首页',
                previous: '上一页',
                next: '下一页',
                last: '末页'
            },
            aria: {
                paginate: {
                    first: 'First',
                    previous: 'Previous',
                    next: 'Next',
                    last: 'Last'
                }
            },
            info: '显示 _START_ 到 _END_ 条，共 300 条'
        },
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false
    });
}

function createDatePicker(ele) {
    $.fn.datepicker.dates['zh-cn'] = {
        days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
        daysShort: ["日", "一", "二", "三", "四", "五", "六"],
        daysMin: ["日", "一", "二", "三", "四", "五", "六"],
        months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        today: "今日",
        clear: "清除",
        weekStart: 0
    };
    ele.datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        language: 'zh-cn'
    });
}

function showInfo(title, content, width = "60%", height = '800px') {
    layer.open({
        type: 2,
        area: [width, height],
        fix: true, //不固定
        shadeClose: true,
        maxmin: true,
        shade: 0.4,
        title: title,
        content: content,
        end: function (layero, index) {

        }
    });
}

function showContent(title, content, area = ['60%', '500px']) {
    layer.open({
        type: 1,
        skin: 'layui-layer-demo', //样式类名
        closeBtn: 0, //不显示关闭按钮
        area: area,
        fix: true, //不固定
        shadeClose: true,
        shade: 0.4,
        title: title,
        content: content,
        end: function (layero, index) {

        }
    });
}