<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5shiv.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="{{URL::asset('public/static/h-ui/css/H-ui.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('public/static/h-ui.admin/css/H-ui.admin.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('public/lib/Hui-iconfont/1.0.8/iconfont.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('public/static/h-ui.admin/skin/default/skin.css')}}" id="skin" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('public/static/h-ui.admin/css/style.css')}}" />
<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>柱状图统计</title>
</head>
<body>
<div class="page-container">
  <div class="f-14 c-error"></div>
    <div id="container" style="min-width:700px;height:400px"></div>
@include('foot');
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{URL::asset('public/lib/hcharts/Highcharts/5.0.6/js/highcharts.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('public/lib/hcharts/Highcharts/5.0.6/js/modules/exporting.js')}}"></script>
<script type="text/javascript">
$(function () {

$.ajax({
  type: 'GET',
  url: '{{URL('admin/rj')}}',
  dataType: 'json',
  success: function(data){
   
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '近七天各级视频浏览量'
        },
        subtitle: {
            text: 'By 海贝Tv研发部'
        },
        xAxis: {
            categories: [
                '一天前',
                '二天前',
                '三天前',
                '四天前',
                '五天前',
                '六天前',
                '七天前'
   
            ]
        },
        yAxis: {
            min: 0,
            title: {
                text: '浏览人数'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>'+
                '<td style="padding:0"><b>{point.y:1f} 人</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: '2015级视频',
            data: [ data.date_1.vsI, data.date_2.vsI, data.date_3.vsI, data.date_4.vsI, data.date_5.vsI, data.date_6.vsI, data.date_7.vsI ] 

        }, {
            name: '2015级视频',
            data: [ data.date_1.vsII, data.date_2.vsII, data.date_3.vsII, data.date_4.vsII, data.date_5.vsII, data.date_6.vsII, data.date_7.vsII ]

        }, {
            name: '2015级视频',
            data: [ data.date_1.vsI, data.date_2.vsIII, data.date_3.vsIII, data.date_4.vsIII, data.date_5.vsIII, data.date_6.vsIII, data.date_7.vsIII ]

        }]
    });

  },

   error:function(data) {
    console.log(data.msg);
  },

 }); 

});				
</script>
</body>
</html>