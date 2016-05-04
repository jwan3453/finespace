


<table class="ui primary striped selectable table ">
    <thead>
        <tr>
            <th>用户ID</th>
            <th>用户号</th>
            <th>用户电话</th>
            <th>创建时间</th>
            <th>状态</th>
            <th>操作</th>

        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->mobile}}</td>
            <td>{{$user->created_at}}</td>
            <td>激活</td>
            <td>
                <a href="{{url('/weixin/admin/user/').'/'.$user->id}}" class="ui basic  button ">详情</a>
                <a href="{{url('/weixin/admin/user/').'/'.$user->id}}" class="ui basic  button ">锁定</a>
            </td>
        </tr>
        @endforeach
        <tr>

            <th colspan="2" style="padding:5px;">
                <div class="ui small  teal button"></div>
                <div class="ui small  teal button"></div>
            </th>
            <th></th>
            <th></th>
            <th></th>
            <th colspan="3" style="padding:2px;">
                <div>{!! $users->appends(['seachData'=>$seachData])->render() !!}</div>
            </th>
            <th></th>
        </tr>
    </tbody>
</table>