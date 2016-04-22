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
                224
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
                100
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
                123
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
                200234+
            </div>
        </div>

    </div>

    <div class="f-left right-side-panel-Chart">
        <div id="main" class="chart-main" ></div>
    </div>

   



@stop

@section('script')
    <script type="text/javascript">
        // $(document).ready(function(){

        //     $('.angle.down').click(function(){
        //         $(this).siblings('.sub-menu').slideToggle(300);
        //     })
        // })

        require.config({
            paths: {
                echarts: 'http://echarts.baidu.com/build/dist'
            }
        });
        require(
            [
                'echarts',
                'echarts/chart/line',   // 按需加载所需图表，如需动态类型切换功能，别忘了同时加载相应图表
            ],
            function (ec) {
                var myChart = ec.init(document.getElementById('main'));
                var option = {
                    tooltip : {
                        trigger: 'axis'
                    },
                    legend: {
                        data:['邮件营销','联盟广告','视频广告','直接访问','搜索引擎']
                    },
                    toolbox: {
                        show : true,
                        feature : {
                            mark : {show: true},
                            dataView : {show: true, readOnly: false},
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
                            data : ['1','2','3','4','5','6','7','8','9','10']
                        }
                    ],
                    yAxis : [
                        {
                            type : 'value'
                        }
                    ],
                    series : [
                        {
                            name:'邮件营销',
                            type:'line',
                            stack: '总量',
                            data:[120, 132, 101, 134, 90, 230, 210,180,175,140]
                        },
                        {
                            name:'联盟广告',
                            type:'line',
                            stack: '总量',
                            data:[220, 182, 191, 234, 290, 330, 310,274,190,312]
                        },
                        {
                            name:'视频广告',
                            type:'line',
                            stack: '总量',
                            data:[150, 232, 201, 154, 190, 330, 410,222,298,453]
                        },
                        {
                            name:'直接访问',
                            type:'line',
                            stack: '总量',
                            data:[320, 332, 301, 334, 390, 330, 320]
                        },
                        {
                            name:'搜索引擎',
                            type:'line',
                            stack: '总量',
                            data:[820, 932, 901, 934, 1290, 1330, 1320]
                        }
                    ]
                };
                myChart.setOption(option);
            }
        );

        
    </script>
@stop