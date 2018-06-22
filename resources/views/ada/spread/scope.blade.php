<div class="form-group">
    <input type="text" name="scope[shop_name]" value="{{ $scope->shopName }}" class="form-control col-xs-6"
           placeholder="店铺名称">
</div>
<div class="input-group">
    @include('widget.select-single', ['name' => 'scope[platform]', 'lists' =>['' => trans('app.选择渠道')] + \App\Models\AdaShop::$platform,  'selected' =>$scope->platform])
</div>