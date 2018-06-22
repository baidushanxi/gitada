$(document).ready(function () {
    $('.fa-trash').click(confirmInfo);

    $('a.metrics-helper-btn').popover({
        title: '数据指标说明',
        html: true,
        placement: 'left',
        container: "body",
        template: '<div class=\"popover popoer-metrics-help\" role=\"tooltip\"><div class=\"arrow\"></div><h3 class=\"popover-title\"></h3><div class=\"popover-content\"><div class=\"data-content\"></div></div></div>',
        content: function () {
            var t = $('<table></table>').addClass('table table-condensed table-striped table-metrics-help');
            t.append($('<tbody></tbody>'));
            $.each($(this).data('metric'), function (n, text) {
                t.children('tbody').append($('<tr></tr>').append($('<td width="72px;"></td>').text(n)).append($('<td class=\'text-muted\'></td>').text(text)));
            });
            return t.prop('outerHTML');
        }
    });

    /**
     * check 全选／全不选
     */
    $('#check-all').click(function () {
        if ($(this).prop('checked')) {
            $("input[type=checkbox]").each(function () {
                $(this).prop("checked", 'checked');
            });
        } else {
            $("input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
        }
    });
});

//确认封装，方便//清除绑定，如：$('.fa-trash').unbind('click', confirmInfo);
var confirmInfo = function () {
    var s = $(this).attr('confirm-info');
    if (!confirm(s)) {
        return false;
    }
};
