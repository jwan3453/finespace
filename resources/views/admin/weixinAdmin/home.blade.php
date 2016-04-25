@extends('admin.adminMaster')




@section('resources')


    <script type="text/javascript" src="http://echarts.baidu.com/build/dist/echarts.js"></script>
    <!-- <script type="" src="http://echarts.baidu.com/build/dist/echarts.js"></script> -->


@stop

@section('content')


    <div class="f-left right-side-panel">

        <div class="statistic-box green-28b779">

            <div class="icon-report">
                <i class="add to cart icon icon-big"></i>
            </div>

            <div class="title">
                今日订单总数
            </div>
            <div class="content">
                {{$todayordercount}}
            </div>
        </div>
        <div class="statistic-box blue-27a9e3">

            <div class="icon-report">
                <i class="add user icon icon-big"></i>
            </div>
            
            <div class="title">
                今日新增用户
            </div>
            <div class="content">
                {{$todayusercount}}
            </div>
        </div>
        <div class="statistic-box purple-852b99">

            <div class="icon-report">
                <i class="grid layout icon icon-big"></i>
            </div>

            <div class="title">
                产品总数
            </div>
            <div class="content">
                {{$productcount}}
            </div>
        </div>
        <div class="statistic-box yellow-ffb848">

            <div class="icon-report">
                <i class="yen icon icon-big"></i>
            </div>

            <div class="title">
                总流水
            </div>
            <div class="content">
                {{$todayincomesum}}
            </div>
        </div>

    </div>

    <div class="f-left right-side-panel-Chart">
        <div id="main" class="chart-main" ></div>
    </div>

   



@stop

@section('script')
    <script type="text/javascript">
        $.ajax({
            type: 'POST',
            url: '/weixin/admin/homeController/getChartData',
            data: {},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
                var date = [];
                var SevenDayIncome = [];
                var SevenDayOrder = [];
                var SevenDayUser = [];
                console.log(data);
                // for (var i = 0; i < data['SevenDay'].length; i++) {
                //     // console.log(data['SevenDay'][i]);
                //     date.push(data['SevenDay'][i]);
                // }

                $.each(data.SevenDay, function(i, item){     
                    date.push(item);
                });
                
                // for (var i = 0; i < data['SevenDayIncome'].length; i++) {
                //     // console.log(data['SevenDayIncome'][i].sum);
                //     SevenDayIncome.push(data['SevenDayIncome'][i].sum);
                // }

                // for (var i = 0; i < data['SevenDayOrder'].length; i++) {
                //     // console.log(data['SevenDayOrder'][i].count);
                //     SevenDayOrder.push(data['SevenDayOrder'][i].count);
                // }

                // for (var i = 0; i < data['SevenDayUser'].length; i++) {
                //     SevenDayUser.push(data['SevenDayUser'][i].count)
                // }

                $.each(data.SevenDayIncome, function(i, item){     
                    SevenDayIncome.push(item.sum);
                });

                $.each(data.SevenDayOrder, function(i, item){     
                    SevenDayOrder.push(item.count);
                });

                $.each(data.SevenDayUser, function(i, item){     
                    SevenDayUser.push(item.count);
                });

                require(
                [
                    'echarts',
                    'echarts/chart/line',
                    'echarts/chart/bar'
                       // 按需加载所需图表，如需动态类型切换功能，别忘了同时加载相应图表
                ],
                function (ec) {
                    var myChart = ec.init(document.getElementById('main'));
                    var option = {
                        backgroundColor: '#FFFFFF',
                        tooltip : {
                            trigger: 'axis'
                        },
                        legend: {
                            data:['订单','用户','收入']
                        },
                        toolbox: {
                            show : true,
                            feature : {
                                mark : {show: true},
                                dataView : {show: true,    readOnly : false},
                                magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                                restore : {show: true},
                                saveAsImage : {show: true}
                            }
                        },
                        calculable : true,
                        xAxis : [
                            {
                                type : 'category',
                                boundaryGap : false,
                                data : date
                            }
                        ],
                        yAxis : [
                            {
                                type : 'value'
                            }
                        ],
                        series : [
                            {
                                name:'订单',
                                type:'line',
                                stack: '总量',
                                data:SevenDayOrder
                            },
                            {
                                name:'用户',
                                type:'line',
                                stack: '总量',
                                data:SevenDayUser
                            },
                            {
                                name:'收入',
                                type:'line',
                                stack: '总量',
                                data:SevenDayIncome
                            }
                        ]
                    };
                    myChart.setOption(option);
                }
            );
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });
        require.config({
            paths: {
                echarts: 'http://echarts.baidu.com/build/dist'
            }
        });
        

        
    </script>
@stop