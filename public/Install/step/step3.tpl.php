<?php include './header.tpl.php';?>
<?php
    $path= ROOT_PATH.DS.'uploads';

    
    
?>


<table>
    <tr>
        <th class="col1">文件名称</th>
        <th class="col2">是否可写</th>
        <th class="col3">要求</th>
      
    </tr>
    <tr>
        <td>/public/uploads</td>
        <td><?php if(can_write($path)) {echo 'yes';}else {echo 'no';}?></td>
        <td>yes</td>    
    </tr>
</table>

<a href="javascript:void(0);" onclick="$('#install').submit();return false;" >下一步</button>>
    <form id="install" action="index.php" method="get">
        <input type="hidden" name="step" value="4">
    </form>
</body>
</html>
<?php
function can_write($path) {
    if (is_writable($path)) {        
        if(is_dir($path)){
            $files = scandir($path);
            if(count($files)!=2){
                foreach ($files as $value) {
                    if($value!='.'&&$value!='..'){
                        if(!can_write($path.DS.$value)){
                            return FALSE; 
                        }                   
                    } else {
                        continue;
                    }                   
                }
                 return TRUE;
            } else {    
                return true;
            }            
        } else {
            if(is_file($path)){
                return TRUE;
            } else {
                return FALSE;
            }             
        }
    } else {
        return FALSE;
    }
   
}
/* 检查那个文件不可写工具
function can_writed($path) {
    echo '........'.$path.'.........</br>';
    if (is_writable($path)) {        
        if(is_dir($path)){
            $files = scandir($path);

            if(count($files)!=2){
                foreach ($files as $value) {
                    if($value!='.'&&$value!='..'){
                        if(can_write($path.DS.$value)){
                             
                        }else{
                            echo $path.'the path can\'not write</br>';
                            return FALSE;   
                        }                       
                    } else {
                        continue;
                    }                   
                }
                echo $path.'dir can write</br>';
                return TRUE;
            } else {                
                echo $path.'dir can write</br>';
                return true;
            }            
        } else {
            if(is_file($path)){
                echo $path.' file can write</br>';
                return TRUE;
            } else {
                echo $path.' I don\'t know what it is</br>';
                return FALSE;
            }             
        }

    } else {
        echo $path.'the path can\'not write</br>';
        return FALSE;
    }
   
}
 * 
 */
?>