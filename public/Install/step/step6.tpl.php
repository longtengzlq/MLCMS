<?php include './header.tpl.php';?>

</head>
<body>
    <a href="javascript:void(0);" onclick="$('#install').submit();return false;" >下一步</a>>
    <form id="install" action="index.php" method="post">
        <input type="hidden" name="step" value="7">
        <input type="hidden" name="n" value="1">
    </form>
    <div id="contents">content</div>
    <div id="dosubmit">dosubmit</div>

</body>
    <script type="text/javascript">
        var n=-1;
        $.ajaxSetup({cache:false});
        var data={
            dbhost:'localhost',
            dbusername:'root',
            dbpsw:'root',
            dbport:'3306',
            dbname:'mlcms',
        }
        function reloads(n){
            url =  "<?php echo $_SERVER['PHP_SELF']; ?>?step=install&n="+n;
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
                 //   setTimeout('gonext()',2000);
                }
                if(msg.n>=0&&msg.n!=999999){
                    $('#contents').append(msg.msg);	
                    reloads(msg.n);	
                }else{
                    //alert('指定的数据库不存在，系统也无法创建，请先通过其他方式建立好数据库！');
                   
                   $('#contents').append(msg.msg);
                }			 
            },
            error:function(xhr,text,tt){console.log(text); console.log(tt); console.log(xhr);}
        });
    }
        $(function(){reloads(n);});
    
    </script>
</html>