/**
 *
 * @description: 修改表格td
 * @author:  xiaoqing Email: liuxiaoqing437@gmail.com
 *
 * @example: $('.xxx').on("click", function() {
 *           opt = {
 *               url: http://xxxx/,
 *               end: 请求结束原始回调函数
 *           }
 *            $(this).editTable(opt);
 *          )};
 *
 */

jQuery.fn.editTable =function(opt){
    var defaults = {
        url: null, //请求url
        idName: 'id',
        data: {}, //请求参数
        start :function () {

        },
        end: function (res) { //请求结束原始回调函数
            html = (res.error == 0) ? res.content + '<i style="padding-left:10px;padding-right:10px;" class="fa fa-pencil text-success"></i></span>' : window.org;
            window.node.innerHTML = html;
            console.log(res.message)
            if(res.message != ''){
                alert(res.message)
            }
        }
    };

    opt = $.extend(defaults, opt);
    if (opt.url === null) return false;

    return this.each(function(){
        for(var i = 0;i < 1;i++){
            //获取修改id
            var id = $(this).attr(opt.idName);
            window.node = this;

            var tag = this.firstChild.tagName;

            if (typeof(tag) != "undefined" && tag.toLowerCase() == "input") {
                return;
            }

            /* 保存原始的内容 */
            window.org = this.innerHTML;

            var val = this.innerText;

            /* 创建一个输入框 */
            var txt = document.createElement("INPUT");
            txt.value = (val == 'N/A') ? '' : val;
            txt.style.width = (this.offsetWidth + 4) + "px";

            /* 隐藏对象中的内容，并将输入框加入到对象中 */
            this.innerHTML = "";
            this.appendChild(txt);
            txt.focus();

            /* 编辑区输入事件处理函数 */
            txt.onkeypress = function (e) {
                var evt = (typeof e == "undefined") ? window.event : e;
                if (typeof e == "undefined") e = window.event;
                var obj = document.all ? e.srcElement : e.target;
                if (evt.keyCode == 13) {
                    this.blur();
                    return false;
                }
                if (evt.keyCode == 27) {
                    this.parentNode.innerHTML = org;
                }
            }

            /* 编辑区失去焦点的处理函数 */
            txt.onblur = function (e) {
                var txtValue = txt.value;

                if (typeof(txtValue) == "string") {
                    txtValue = txtValue.replace(/^\s*|\s*$/g, "");
                }
                if (txtValue.length > 0) {
                    opt.start();
                    $.getJSON(opt.url, $.extend({id: id, val: txtValue}, opt.data), opt.end);
                } else {
                    this.innerHTML = org + '<i style="padding-left:10px;padding-right:10px;" class="fa fa-pencil text-success"></i></span>';
                }
            }
        }
    })
}
