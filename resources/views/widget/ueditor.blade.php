
@push('scripts')
{{--百度ueditor编辑器--}}
<script src="{{ asset('js/ueditor/ueditor.config.js') }}"></script>
<script src="{{ asset('js/ueditor/ueditor.all.min.js') }}"></script>

<script>
    $(document).ready(function(){
        //初始化百度富媒体编辑器
        UE.getEditor('editor', {zIndex:999});
    });
</script>

@endpush