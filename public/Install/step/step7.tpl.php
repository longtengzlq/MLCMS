<?php include './header.tpl.php';?>

</head>
    <body>
          <a href="javascript:void(0);" onclick="$('#install').submit();return false;" >下一步</a>>
    <form id="install" action="index.php" method="post">
        <input type="hidden" name="step" value="install">
        <input type="hidden" name="n" value="1">
    </form>
        <div id="contents"><a href="/" >主页</a></div>
        <div id="dosubmit"><a href="/admin.php" >后台</a></div>
    </body>
   
</html>