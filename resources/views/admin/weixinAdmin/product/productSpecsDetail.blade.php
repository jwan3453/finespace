
<div class="product-specs-table">
    <table class="ui primary striped selectable table ">
        <thead>
        <tr>
            <th>商品属性</th>
            <th>属性内容</th>
        </tr>
        </thead>
        <tbody>

            @foreach($specs as $spec)
                <tr>
                    <td>{{$spec->name}}</td>
                    <td>
                        <input  type="text"  name="{{$spec->id}}"  value="{{$spec->value}}" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="table-content">
    </div>
</div>