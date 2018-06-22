@push('scripts')
<script>
    $(function() {
        //选择项目APP
        $('.select-all').click(function() {
            $(this).parents('.form-group').find(':checkbox').each(function () {
                $(this).prop('checked', 'checked');
            });
            return false;
        });

        $('.select-none').click(function() {
            $(this).parents('.form-group').find(':checkbox').each(function () {
                $(this).prop('checked', false);
            });
            return false;
        });

        $('.scope-projects .select-all').click(function() {
            $(this).parents('.form-group').find(':checkbox').each(function () {
                $(this).prop('checked', 'checked');
            });
            getDataProjectsChecked();
        });

        $('.scope-projects .select-none').click(function() {
            $(this).parents('.form-group').find(':checkbox').each(function () {
                $(this).prop('checked', false);
            });
            getDataProjectsChecked();
        });

        $('.scope-projects :checkbox').change(function() {
            getDataProjectsChecked();
        });

        $(document).on("change", ".select_multiselect", function() {
            var scope_projectIds = $(this).val();
            $('.scope-projects :checkbox').each(function (i, j) {
                var projectId = $(j).attr('value');
                if ($.inArray(projectId, scope_projectIds) !== -1){
                    $(j).prop('checked', true);
                }else{
                    $(j).prop('checked', false);
                }
            });
            getDataProjectsChecked();
        });

        $('.btn-apps').click(function () {
            // 选择渠道
            if ( ! $(this).hasClass('active')) {
                $('.scope-apps .col-sm-10 .row').show();
                $('.scope-apps .btn-select').show();
            } else {
                $('.scope-apps .col-sm-10 .row').hide();
                $('.scope-apps .btn-select').hide();
                $('.scope-apps .select-none').trigger('click');
            }
        });


        $('.app-os').click(function () {
            var os = [];
            if ($(this).hasClass('btn-white')) {
                $(this).removeClass('btn-white').addClass('btn-info');
            } else {
                $(this).removeClass('btn-info').addClass('btn-white');
            }
            $('#app_list_os').find('.btn-info[data-os]').each(function () {
                os.push($(this).attr('data-os'));
            });

            $(this).parents('.form-group').find(':checkbox').each(function () {
                if ($.inArray($(this).attr('data-os'), os) !== -1){
                    $(this).prop('checked', 'checked');
                } else {
                    $(this).prop('checked', false);
                }
            });
        });


        //选择项目APP
        var projectCheck = new Array();
        var appCheck = new Array();

        var getDataProjectsChecked = function() {
            var arr1 = new Array();
            var arr2 = new Array();
            $('.scope-projects :checkbox').each(function() {
                if ($(this).is(':checked')) {
                    arr1.push($(this).val());
                }
            });
            $('.scope-apps :checkbox').each(function() {
                if ($(this).is(':checked')) {
                    arr2.push($(this).val());
                }
            });
            if (arr2.length > 0) {
                appCheck = arr2;
            }
            projectCheck = arr1;
            // 没有选择
            if(jQuery.isEmptyObject(projectCheck)) {
                $('.scope-apps .col-sm-10 .row').html('');
                return false;
            }
            $.getJSON('{{ route('scope.projectApp') }}', {projectId: projectCheck,isOnlyShiYue: '{!! $scope->isOnlyShiYue == true ? 1 : 0  !!}' }, function (res) {
                if (res) {
                    var html = '';
                    $.each(res, function(k, v) {
                        html += '<label class="col-sm-3" style="font-weight: normal;">';
                        if ($.inArray(String(v.id), appCheck) !== -1) {
                            html += '<input type="checkbox" checked value="' + v.id + '" data-os= "'+ v.type +'" name="scope[appIds][]">';
                        } else {
                            html += '<input type="checkbox" value="' + v.id + '" data-os= "'+ v.type +'"  name="scope[appIds][]">';
                        }
                        if(v.on_store == 1){
                            html += v.name + '<font color="#A52A2A">(上架)</font></label>';
                        }else {
                            html += v.name + ' </label>';
                        }
                    });
                    $('.scope-apps .col-sm-10 .row').html(html);
                }
            });
        };

        var init = function() {
            appCheck = {!! json_encode($scope->appIds) !!};
            if (appCheck.length > 0) {
                $('.btn-apps').trigger('click');
            }
            getDataProjectsChecked();
        };
        init();
    });
</script>
@endpush
