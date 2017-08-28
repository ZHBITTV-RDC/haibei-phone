     $('form :input').blur(function(){
             // var $parent = $(this).parent();
             // $parent.find(".formtips").remove();
          
             //验证名称
               if( $(this).is('#Name') ){
                    if( this.value=="" || this.value.length >11){
                        var errorMsg = '名称最大长度为11个汉字或数字.';
                        $('#Name').val("");
                        $('#Name').attr('placeholder',errorMsg);
                    }else{
                        var okMsg = '输入正确.';
                        // $parent.append('<span class="formtips onSuccess">'+okMsg+'</span>');
                    }
             }


                //验证手机号码
             if( $(this).is('#phone') ){
                    if( this.value=="" || this.value.length !=11||isNaN(this.value)){
                        var errorMsg = '请输入正确11位数.';
                        $('#phone').val("");
                        $('#phone').attr('placeholder',errorMsg);
                    }else{
                        var okMsg = '输入正确.';
                        // $parent.append('<span class="formtips onSuccess">'+okMsg+'</span>');
                    }
             }
  
  
                //验证详情
               if( $(this).is('#data') ){
                    if( this.value=="" || this.value.length >200){
                        var errorMsg = '最多输入200个字数描述.';
                        $('#data').val("");
                        $('#data').attr('placeholder',errorMsg);
                    }else{
                        var okMsg = '输入正确.';
                        // $parent.append('<span class="formtips onSuccess">'+okMsg+'</span>');
                    }
             }
        });
     //详情监听
        $('#data').on('input',function(){
            var num=this.value.length;
            if($('#numCheck span').html()<=200){
                $('#numCheck span').html(num);
            }else{
                $('#numCheck span').html('200');
                $("#data").val( $("#data").val().substring(0,200) );
            }
            
        });

        //内容监听
        var NameCheck='Name';
        var phoneCheck='phone';
        checkNum(phoneCheck,11);
        checkNum(NameCheck,11);
        //监听方法
        function checkNum(id,num){
             $('#'+id).on('input',function(){
            var length=this.value.length;
            if(length>num){
                $('#'+id).val( $('#'+id).val().substring(0,num) );
            }else{
               var okMsg = '输入正确.';
            }
            
        });
        }