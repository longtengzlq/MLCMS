<?php include './header.tpl.php';?>
<script type="text/javascript">
    $(function(){console.log('aaaaaaa');})();
</script>
<div>
    这是页面<?php echo '2';?>
</div>
<table>
    <tr>
        <th class="col1">检查项目</th>
        <th class="col2">当前环境</th>
        <th class="col3">系统建议</th>
        <th class="col4">功能影响</th>
    </tr>
    <tr>
        <td>操作系统</td>
        <td><?php if(stripos(PHP_OS,"WIN")!==FALSE){echo 'Windows';}else {    echo PHP_OS;} ?></td>
        <td>Windows_NT/Linux/Freebsd</td>
        <td>yes</td>
    </tr>
    <tr>
        <td>WEB 服务器</td>
        <td><?php echo $_SERVER['SERVER_SOFTWARE'];?></td>
        <td>IIS/Apache/Nginx</td>
        <td>yes</td>
    </tr>
    <tr>
        <td>PHP 版本</td>
        <td><?php echo PHP_VERSION ?></td>
        <td>>5.6.0</td>
        <td>yes</td>
    </tr>
    <tr>
        <td>MYSQLI 扩展</td>
        <td><?php if(extension_loaded('mysqli')){    echo 'yes';}else{echo 'no';}?></td>
        <td>yes</td>
        <td>yes</td>
    </tr>
    <tr>
        <td>ICONV/MB_STRING 扩展</td>
        <td><?php if(extension_loaded('mbstring')){    echo 'yes';}else{echo 'no';}?></td>
        <td>yes</td>
        <td>yes</td>
    </tr>
    <tr>
        <td>JSON扩展</td>
        <td><?php if(extension_loaded('json')){    echo 'yes';}else{echo 'no';}?></td>
        <td>yes</td>
        <td>yes</td>
    </tr>
    <tr>
        <td>GD 扩展</td>
        <td><?php if(extension_loaded('gd')){    echo 'yes';}else{echo 'no';}?></td>
        <td>yes</td>
        <td><?php if(extension_loaded('mysqli')){    echo 'yes';}else{echo 'no';}?></td>
    </tr>
    <tr>
        <td>ZLIB 扩展</td>
        <td><?php if(extension_loaded('zlib')){    echo 'yes';}else{echo 'no';}?></td>
        <td>yes</td>
        <td><?php if(extension_loaded('zilib')){    echo 'yes';}else{echo 'no';}?></td>
    </tr>
    <tr>
        <td>FTP 扩展</td>
        <td><?php if(extension_loaded('ftp')){    echo 'yes';}else{echo 'no';}?></td>
        <td>yes</td>
        <td><?php if(extension_loaded('ftp')){    echo 'yes';}else{echo 'no';}?></td>
    </tr>
    <tr>
        <td>allow_url_fopen</td>
        <td><?php if(ini_get('allow_url_fopen')){echo 'yes';}else {echo 'no';}?></td>
        <td>yes<?php ini_set('allow_url_fopen', 'Off');?></td>
        <td><?php if(ini_get('allow_url_fopen')){echo ' yes';}else {echo 'no';}?></td>
    </tr>
    <tr>
        <td>fsockopen</td>
        <td><?php if(function_exists('fsockopen')) {echo 'yes';} else {
    
    echo 'no';}?></td>
        <td>yes</td>
        <td>yes</td>
    </tr>
    <tr>
        <td>DNS解析</td>
        <td><?php if(preg_match('/(\d{1,3}\.){3}\d{1,3}/', gethostbyname('www.hz5a.com'))){echo 'yes';}else{echo 'no';}?></td>
        <td>yes</td>
        <td>建议正确解析DNS</td>
    </tr>
</table>
<a href="javascript:void(0);" onclick="$('#install').submit();return false;" >下一步</button>>
    <form id="install" action="index.php" method="get">
        <input type="hidden" name="step" value="3">
    </form>
</body>
</html>