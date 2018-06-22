@include('widget.layer')

@push('scripts')
<script src="{{ asset('js/plugins/waterfall/src/waterfall.js') }}"></script>
<script>
    $(function(){
        $('#waterfall').waterfall({
            itemCls:'.water-item',   // 子元素id/class, 可留空
            columnWidth:250,              // 列宽度, 纯数字, 可留空
            isResizable:false
        });

        $('.img').on('click',function() {
            var json = {
                'data':[]
            };
            var img = $(this).attr('data-img').split(',');
            $.each(img,function(i,n){
                var _d = {
                    'alt':'',
                    'pid':i,
                    'src':n,
                    'thumb':''
                };
                json.data.push(_d);
            });
            layer.photos({
                photos: json,
                anim: 0
            });
        });
    });
</script>
@endpush