<?php include './header.tpl.php';?>
<div>这是页面</div>

<?php
 echo $license;
?>
<a href="javascript:void(0);" onclick="$('#install').submit();return false;" >下一步</button>>
    <form id="install" action="index.php" method="get">
        <input type="hidden" name="step" value="2">
    </form>
</body>
</html>