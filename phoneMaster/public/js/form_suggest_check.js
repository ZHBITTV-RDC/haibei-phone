//网页加载
window.onload=function(){
	//获取标签名为textarea的集合
	var txt = document.getElementsByTagName('textarea');
	//第一个为文本内容
	var oTxt = txt[0];
	//获取字数变化提醒的标签
	var num = document.getElementById('num');
	//定义一个字数的全局变量
	var number_length = 0;
	//定义一个求长度的函数
	function getLength(str){
		//将汉字定位一字符，本身两个字符
		return str.replace(/[^\x00-xff]/g,"j").length;
	}

	//键盘输入字数时
	oTxt.onkeyup = function(){
		number_length = getLength(this.value);
		num.innerHTML = number_length;
		//反正sql插入
		var re = /\binsert\b|\bupdate\b|\bdelect\b|\bselect\b|\bmysql\b/gi;
		if(re.test(this.value)){
			alert("请不要输入敏感字符");
		}
		else if(number_length>150){
			alert("亲，简洁点就行");
		}
	}
}