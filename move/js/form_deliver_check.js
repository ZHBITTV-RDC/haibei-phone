//页面form_deliver.html加载代码
window.onload=function(){
	//获取form_deliver.html中的input标签
	var aInput = document.getElementsByTagName('input');
	var name = document.getElementById("name");
	var phone = document.getElementById("phone");
	//检测input的个数
	//alert(aInput.length);
	//改变第一个input的setAttribute为placeholder的内容。
	var oName = aInput[0];
	var oPhone = aInput[1];
	var oYanzhen = aInput[2];
	var oAddress = aInput[3];
	var name_length = 0;
	var phone_length = 0;
	//aInput[1].setAttribute("placeholder","你想修改的内容");
	//alert(aInput[4].value);从第五个开始。下标为4开始的为单选按钮的input标签，不用改
	//测试js 
	//alert("测试");
	//js内置对象RegExp实例化正则表达式(新建正则表达式)
	//var re = new RegExp("a","i");//i表示忽略大小写，“a”为配备内容,g全局匹配
	//或者用var re = /a/i;
	//获取长度
	function getLength(str){
		return str.replace(/[^\x00-xff]/g,"jj").length;//[^\x00-xff]这个正则表示双字符的汉字替换成jj
	}
	//用户名验证
	//数字，字母(不区分大小写)，汉字，下划线 
	// \w  ,i                , \u4e00-\u9fa5
	//1-10个字符（一个汉字两个字符），推荐使用中文
	//var re = /[^\w\u4e00-\u9fa5]/g;
	//用户交互设计（让用户快速得到信息）
	//oName聚焦时，开启函数(触发一个动作)

	//手机号码验证
		//oName聚焦时，开启函数(触发一个动作)
	oName.onfocus = function(){
		oName.setAttribute("title","1-10个字符，建议用汉字");
	}
	//键盘在上部时
	oName.onkeyup = function(){
		name_length = getLength(this.value);
		//alert(name_length);
		if(name_length>10){
			oName.setAttribute("title","用户名太长啦，亲");
			//alert("用户名太长啦，亲");
		}
		// if(name_length=0){
		// 	alert("用户名太长啦，亲");
		// }

	} 
	//当失去焦点时
	oName.onblur = function(){
		name_length = getLength(this.value);
		//非法字符
		var re = /[^\w\u4e00-\u9fa5]/g;
		if(re.test(this.value)){
			alert("含非法字符，重新输入");
		}
		//用户名不能为空
		else if(this.value==""){
			alert("用户名不用为空");
		}
		//长度超过10
		else if(name_length>10){
			alert("用户名太长啦，亲");
		}

		else{
			//alert(name);
			name.innerHTML = this.value + '<p style="float:right;"><i class="weui-icon-success"></i></p>';
		}
	}

	//手机号码验证
	//聚焦时，执行一个动作
	oPhone.onfocus = function(){
		oPhone.setAttribute("title","请输入正确的手机号码");
	}
	oPhone.onkeyup = function(){
		phone_length = getLength(this.value);
		//alert(name_length);
		//长度检验
		if(phone_length>11){
			alert("phone填写错误，请检验");
		}
		// //特殊字符检验
		// var re = /[^\w]/g;
		// if(re.test(this.value)){
		// 	alert("phone格式错误");
		// }
		
	}
	//失去焦点时
	oPhone.onblur = function(){
				//非法字符
		var re = /\W/g;
		if(re.test(this.value)){
			alert("phone格式错误");
		}
		//用户名不能为空
		else if(this.value==""){
			alert("手机号不能为空");
		}
		//长度不超过11
		else if(phone_length<11){
			alert("请检查是否填写正确");
		}
		else{

		}
		//alert("ss");
	} 

	//服务地址验证
	//聚焦时，执行一个动作
	oAddress.onfocus = function(){
		oPhone.setAttribute("title","请填写正确地址");
	}
	
	//失去焦点时
	oAddress.onblur = function(){
				
		if(this.value ==""){
			alert("地址不能为空");
		}
		//alert("ss");
	} 
}