<div class="input-group input-file" name="{{ $file_name ?? 'file' }}">
    <input type="text" class="form-control" placeholder='{{ trans('app.上传文件') }}' />
    <span class="input-group-btn">
        <button class="btn btn-default btn-choose" type="button">Choose</button>
    </span>
    <span class="input-group-btn">
           <button type="reset" class="btn btn-danger">Reset</button>
    </span>
</div>


@push('scripts')
    <script>
        function bs_input_file() {
            $(".input-file").before(
                function() {
                    if ( ! $(this).prev().hasClass('input-ghost') ) {
                        var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                        element.attr("name",$(this).attr("name"));
                        element.change(function(){
                            element.next(element).find('input').val((element.val()).split('\\').pop());
                        });
                        $(this).find("button.btn-choose").click(function(){
                            element.click();
                        });
                        $(this).find("button.btn-reset").click(function(){
                            element.val(null);
                            $(this).parents(".input-file").find('input').val('');
                        });
                        $(this).find('input').css("cursor","pointer");
                        $(this).find('input').mousedown(function() {
                            $(this).parents('.input-file').prev().click();
                            return false;
                        });
                        return element;
                    }
                }
            );
        }
        $(function() {
            bs_input_file();
        });
    </script>
@endpush