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
<title>视频列表</title>
<link rel="stylesheet" href="{{URL::asset('public/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css')}}" type="text/css">

<style type="text/css">
        #pull_right{
            text-align:center;
        }
        .pull-right {
            /*float: left!important;*/
        }
        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
        }
        .pagination > li {
            display: inline;
        }
        .pagination > li > a,
        .pagination > li > span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #428bca;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        .pagination > li:first-child > a,
        .pagination > li:first-child > span {
            margin-left: 0;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }
        .pagination > li:last-child > a,
        .pagination > li:last-child > span {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        .pagination > li > a:hover,
        .pagination > li > span:hover,
        .pagination > li > a:focus,
        .pagination > li > span:focus {
            color: #2a6496;
            background-color: #eee;
            border-color: #ddd;
        }
        .pagination > .active > a,
        .pagination > .active > span,
        .pagination > .active > a:hover,
        .pagination > .active > span:hover,
        .pagination > .active > a:focus,
        .pagination > .active > span:focus {
            z-index: 2;
            color: #fff;
            cursor: default;
            background-color: #428bca;
            border-color: #428bca;
        }
        .pagination > .disabled > span,
        .pagination > .disabled > span:hover,
        .pagination > .disabled > span:focus,
        .pagination > .disabled > a,
        .pagination > .disabled > a:hover,
        .pagination > .disabled > a:focus {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
            border-color: #ddd;
        }
        .clear{
            clear: both;
        }
    </style>



</head>
<body class="pos-r">
<div class="pos-a" style="width:200px;left:0;top:0; bottom:0; height:100%; border-right:1px solid #e5e5e5; background-color:#f5f5f5; overflow:auto;">
	<ul id="treeDemo" class="ztree"></ul>
</div>
<div style="margin-left:200px;">
		<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel(this)" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius" onclick="product_add('添加产品','{{URL('admin/listAdd')}}')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加视频</a></span> <span class="r">共有数据：<strong>{{$total}}</strong> 条</span> </div>
		<div class="mt-20">
			<table class="table table-border table-bordered table-bg table-hover table-sort">
				<thead>				
			    	<tr class="text-c">
						<th width="40"><input name="" type="checkbox" value=""></th>
						<th width="40">ID</th>
						<th width="60">缩略图</th>
						<th width="100">视频标题</th>
						<th>简介</th>
						<th width="60">发布状态</th>
						<th width="40">浏览量</th>
						<th width="100">操作</th>
					</tr>
				</thead>
			   <tbody>
          @if($total!=0)
					@foreach($p as $v)
					<tr class="text-c va-m">
						<td><input name="box" type="checkbox" value="{{$v->content_id}}"></td>
						<td>{{$v -> content_id}}</td>
						<td><a onClick="product_show('{{$v->content_title}}','{{URL('admin/dataShow')}}/','{{$v->content_id}}')" href="javascript:;"><img width="60" class="product-thumb" src="{{env("_PUBLIC_")}}{{$v -> content_cover}}"></a></td>
						<td class="text-l"><a style="text-decoration:none" onClick="product_show('{{$v->content_title}}','{{URL('admin/dataShow')}}/','{{$v->content_id}}')" href="javascript:;"> <b class="text-success">{{$v -> content_title}}</b> </a></td>
						<td class="text-l">{{$v -> content_abstract}}</td>

						<td class="td-status">
						 @if($v->content_status==1)
						  <span class="label label-success radius">
						  已发布
						 </span></td>
						  @endif

						  @if($v->content_status==0)
						   <span class="label label-defaunt radius">
						  已下架
						 </span></td>
						  @endif
                         
                       <td>{{$v -> content_visitors}}</td>

			             <td class="td-manage">
							@if($v->content_status==1)
							<a style="text-decoration:none" onClick="product_stop(this,'{{$v -> content_id}}')" href="javascript:;" title="下架">
							@endif
							
							@if($v->content_status==0)
							  <a style="text-decoration:none" onClick="product_start(this,{{$v -> content_id}})" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>
							 @endif	
								<i class="Hui-iconfont">&#xe6de;</i></a> <a style="text-decoration:none" class="ml-5" onClick="product_edit('编辑','{{URL('admin/editList').'/'.$v -> content_id}}','10001')" href="javascript:;" title="编辑">
							<i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="product_del(this,'{{$v -> content_id}}')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
						</td>
					</tr>         
				</tbody>
			        @endforeach	         
			      @endif
			</table>
			 
     <div id="pull_right">
       <div class="pull-right">
          {!! $p->render() !!}
       </div>
   </div>
 		@if($total==0)
				    <div style="width:100%; color:black; margin-left:500px; margin-top:100px;">
				    	<spand stlye="margin-left:500px;">暂无内容</spand>
				    </div>
                   @endif
			 
		</div>
	</div>
</div>

@include('foot');

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{URL::asset('public/lib/zTree/v3/js/jquery.ztree.all-3.5.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('public/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script> 
<script type="text/javascript" src="{{URL::asset('public/lib/laypage/1.2/laypage.js')}}"></script>
<script type="text/javascript">
var setting = {
	view: {
		dblClickExpand: false,
		showLine: false,
		selectedMulti: false
	},
	data: {
		simpleData: {
			enable:true,
			idKey: "id",
			pIdKey: "pId",
			rootPId: ""
		}
	},
	callback: {
		beforeClick: function(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("tree");
			if (treeNode.isParent) {
				zTree.expandNode(treeNode);
				return false;
			} else {
				//demoIframe.attr("src",treeNode.file + ".html");
				return true;
			}
		}
	}
};

var zNodes =[
	{ id:1, pId:0, name:"视频分类", open:true},
	{ id:11, pId:1, name:"2015级", url:"{{URL('admin/show2015')}}", target:'_self',},
	{ id:12, pId:1, name:"2016级", url:"{{URL('admin/show2016')}}", target:'_self',},
	{ id:12, pId:1, name:"2017级", url:"{{URL('admin/show2017')}}", target:'_self',},
];

$(document).ready(function(){
	var t = $("#treeDemo");
	t = $.fn.zTree.init(t, setting, zNodes);
	//demoIframe = $("#testIframe");
	//demoIframe.on("load", loadReady);
	var zTree = $.fn.zTree.getZTreeObj("tree");
	//zTree.selectNode(zTree.getNodeByParam("id",'11'));
});

$('.table-sort').dataTable({
	"aaSorting": [[ 1, "desc" ]],//默认第几个排序
	"bStateSave": true,//状态保存
	"aoColumnDefs": [
	  {"orderable":false,"aTargets":[0,7]}// 制定列不参与排序
	]
});		
		
/*产品-编辑*/
function product_edit(title,url,id){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}

/*产品-添加*/
function product_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
/*产品-查看*/
function product_show(title,url,id){
	var index = layer.open({
		type: 2,
		title: title,
		content: url+id
	});
	layer.full(index);
}

/*产品-下架*/
function product_stop(obj,id){
	layer.confirm('确认要下架吗？',function(index){       
         $.ajax({
			type: 'POST',
			url: "{{URL('admin/down')}}",
			dataType: 'json',
			data:{'id':id, '_token':"{{ csrf_token()}}" },
			success:function(data){                
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="product_start(this, @if($total!=0) {{$v->content_id}} @endif)" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>');
					$(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已下架</span>');
		            $(obj).remove();
		            layer.msg(data.msg,{icon: 5,time:1000});
			},
	        error:function(data){
               console.log(data.msg);
	        },

	       });
	});
}

/*产品-发布*/
function product_start(obj,id){
	layer.confirm('确认要发布吗？',function(index){
		$.ajax({
			type:'POST',
			url:"{{URL('admin/up')}}",
			dataType:'json',
			data:{'id':id, '_token':"{{ csrf_token()}}"},
			success:function(data){
                 
                 $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="product_stop(this,  @if($total!=0) {{$v->content_id}} @endif )" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>');
		         $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
		         $(obj).remove();
		         layer.msg('已发布!',{icon: 6,time:1000});
			},

			error:function(data){
               console.log(data.msg);
			},

		});
	});
}

/*产品-删除*/
function product_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: "/phoneMaster/admin/delete",
			dataType: 'json',
			data:{'id':id, '_token':"{{ csrf_token()}}" },
			success: function(data){
				$(obj).parents("tr").remove();
				 layer.msg('删除成功',{icon:1,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});	
	});
}

/*批量删除*/
function datadel(){
	var box=document.getElementsByName("box"); 
	var id="";
	
	
     for (var i =0; i<box.length; i++) {
     	 if (box[i].checked) {
            id=id + "," + box[i].value;          
     	 };

     };
	  
	layer.confirm('确认要删除吗？',function(index){
		  $.ajax({
			type: 'POST',
			url: "{{URL('admin/datadel')}}",
			dataType: 'json',
			data:{'id':id, '_token':"{{ csrf_token()}}" },
			success: function(data){		
				  //layer.msg('删除成功',{icon:1,time:3000});
				   window.location.reload();
			},
			error:function(data) {
				console.log(data.msg);
			},
		});	
	});

}
</script>
</body>
</html>