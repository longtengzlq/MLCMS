<docutype html>
<html>
    <head>
        <script src="jquery.js"></script>
        <title></title>
        
    </head>
    <body>
        <div id="contents">content</div>
        <div id="dosubmit">dosubmit</div>
    </body>
    <script type="text/javascript">
        var n=-1;
        $.ajaxSetup({cache:false});
        var data="data";
        
        
        function reloads(n){
           
            var url =  "<?php echo $_SERVER['PHP_SELF']; ?>?step=4&install=1&n="+n;
            $.ajax({
            type: "POST",		
            url: url,
            data: data,
            dataType: 'json',
            beforeSend:function(){
            },
            success: function(msg){
                if(msg.n=='999999'){
                    $('#dosubmit').attr("disabled",false);
                    $('#dosubmit').removeAttr("disabled");				
                    $('#dosubmit').removeClass("nonext");
                    setTimeout('gonext()',2000);
                }
                if(msg.n>=0){
                    $('#contents').append(msg.msg);	
                    reloads(msg.n);	
                }else{
                    //alert('指定的数据库不存在，系统也无法创建，请先通过其他方式建立好数据库！');
                    alert(msg.msg);
                }			 
            }
        });
    }
        $(function(){reloads(n);});
    
    </script>
</html>