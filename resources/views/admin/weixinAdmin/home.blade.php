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

    <div class="f-left right-side-panel-Chart2">
        <div id="main2" class="chart-main" ></div>
    </div>

    <div class="f-left right-side-panel-Chart3">
        <div id="main3" class="chart-main" ></div>
    </div>

   



@stop

@section('script')
    <script type="text/javascript">
        $.ajax({
            type: 'POST',
            url: '/weixin/admin/getChartData',
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

                $.each(data.SevenDay, function(i, item){     
                    date.push(item);
                });

                $.each(data.SevenDayIncome, function(i, item){     
                    SevenDayIncome.push(item.sum);
                });
                //(     数据源，     X轴数据，类型，名称，divID)
                echarts(SevenDayIncome,date,'line','收入','main');

                $.each(data.SevenDayOrder, function(i, item){     
                    SevenDayOrder.push(item.count);
                });

                echarts(SevenDayOrder,date,'bar','订单','main2');

                $.each(data.SevenDayUser, function(i, item){     
                    SevenDayUser.push(item.count);
                });

                echarts(SevenDayUser,date,'line','用户','main3');

                
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


        function echarts(data,date,type,name,divId) {
            require(
                [
                    'echarts',
                    'echarts/chart/line',
                    'echarts/chart/bar'
                       // 按需加载所需图表，如需动态类型切换功能，别忘了同时加载相应图表
                ],
                function (ec) {
                    var myChart = ec.init(document.getElementById(divId));
                    var option = {
                        backgroundColor: '#FFFFFF',
                        tooltip : {
                            trigger: 'axis'
                        },
                        legend: {
                            data:[name]
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
                                name:name,
                                type:type,
                                stack: '总量',
                                data:data
                            },
                            
                        ]
                    };
                    myChart.setOption(option);
                }
            );
        }
        

        
    </script>
@stop