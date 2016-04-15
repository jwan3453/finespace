<div id="productDetialFields">
    <div class="f-left"  style="margin-right:20px;">
        <div class="common-input-box" >
            <label>分类:</label>
            {{--<input class="transparent-input" type="text" value="{{$product->category_id}}" />--}}
            <select class="ui dropdown select-cat ">
                <option value="">选择种类</option>
                @foreach($categories  as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach

            </select>
        </div>
        <div class="common-input-box">
            <label>品牌:</label>
            {{--<input class="transparent-input" type="text" value="{{$product->brand_id}}"/>--}}
            <select class="ui dropdown select-brand ">
                <option value="">选择品牌</option>
                @foreach($brands  as $brand)
                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                @endforeach

            </select>
        </div>
        <div class="common-input-box">
            <label>产品码:</label>
            <input class="transparent-input"  type="text"  name="sku" value="{{$product->sku}}"/>
        </div>
        <div class="common-input-box">
            <label>名称:</label>
            <input class="transparent-input"  type="text"  name="name" value="{{$product->name}}"/>
        </div>
        <div class="common-input-box">
            <label>库存:</label>
            <input class="transparent-input" type="text" name="inventory" id="inventory" value="{{$product->inventory}}"/>
        </div>
        <div class="common-input-box">
            <label>库存警报:</label>
            <input class="transparent-input" type="text" name="stockAlarm" id="stockAlarm" value="{{$product->inventory}}"/>
        </div>
        <div class="common-input-box">
            <label>价格(￥):</label>
            <input class="transparent-input" type="text" name="price" id="price" value="{{$product->price}}"/>
        </div>
        <div class="common-input-box">
            <label>促销价格:</label>
            <input class="transparent-input" type="text" name="promotePrice" id="promotePrice" value="{{$product->promote_price}}"/>
        </div>
        <div class="common-input-box">
            <label>促销开始时间:</label>
            <input class="transparent-input" type="text"  name="promoteStartDate" value="{{$product->promote_start_date}}"/>
        </div>
        <div class="common-input-box">
            <label>促销结束时间:</label>
            <input class="transparent-input" type="text"  name="promoteEndDate" value="{{$product->promote_end_date}}"/>
        </div>


    </div>

    <div class="f-left" >

        <div class="common-input-box">
            <label>商品关键词(用  ' | '  隔开):</label>
            <input class="transparent-input" type="text"  name="keyWords" value="{{$product->keywords}}"/>
        </div>
        <div class="common-input-box">
            <label>商品简介</label>
            <textarea class="transparent-input" type="text" name="brief" >{{$product->brief}}</textarea>
        </div>

        <div class="common-input-box">
            <label>商品详情</label>
            <textarea class="transparent-input" type="text" name="desc" >{{$product->desc}}</textarea>
        </div>


        <div class="product-spec">

        </div>


        <div class="common-input-box">
            <div class="ui checkbox">
                <input type="checkbox" name="status" id="status"  >
                <label>是否上线</label>
            </div>
            <div class="ui checkbox">
                <input type="checkbox" name="promoteStatus" id="promoteStatus" >
                <label>是否促销</label>
            </div>
        </div>
    </div>
</div>