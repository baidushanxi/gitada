@push('scripts')
<script src="{{ asset('js/plugins/clipboard/clipboard.min.js') }}"></script>
<script>
    $(function (t) {
        t(function () {
            t(".markdown-body > pre").each(function () {
                t(this).before('<button class="bd-clipboard btn btn-xs btn-success"><sapn class="btn-clipboard copy_text" title="{!!trans("app.复制到剪切板")!!}" >{!!trans("app.复制")!!}</sapn></button>'),
                    t(".copy_text").tooltip({
                        container: "body"
                    })
            });
            var o = new Clipboard(".btn-clipboard", {
                text: function (t) {
                    return $(t.parentNode.nextElementSibling).context.innerText;
                }
            });
            o.on("success",
                function (o) {
                    t(o.trigger).attr("title", "{!!trans('app.已复制!')!!}").tooltip("fixTitle").tooltip("show").attr("title", "{!!trans('app.复制到剪切板')!!}").tooltip("fixTitle"),
                        o.clearSelection()
                }),
            o.on("error",
                function (o) {
                     alert("{!!trans('app.复制失败，请更换其他浏览器！')!!}");
                })
        });
    });
</script>
@endpush