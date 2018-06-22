@include('widget.layer')

@push('scripts')
<script>
    jQuery.fn.iframe =function(opt){
        var defaults = {
            url: null, //请求url
            type:2,
            width:'700px',
            height:"530px",
            fixed: false,
            moveType: 0,
            resize:false,
            start:function () {
                return true;
            },
        };
        var opt = jQuery.extend(defaults,opt);

        return this.each(function(){
            for(var i = 0;i < 1;i++){
                if (opt.url === null) return false;

                var cont =  opt.start();
                if(!cont){
                    return false;
                }
                layer.open({
                    type: opt.type,
                    area: [opt.width, opt.height],
                    fixed: opt.fixed,
                    moveType: opt.moveType,
                    resize: opt.resize,
                    content: [opt.url, 'no'],
                });
            }
        })
    }

</script>
@endpush
