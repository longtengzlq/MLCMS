<?php

@set_time_limit(1000);
require '../../thinkphp/base.php';
if(phpversion() < '5.6.0')exit ('您的php版本低于5.6.0，请您更换php平台'); 
define('INSTALL_MODULE',true);
$steps= include 'step.ini.php';
if(strrpos(strtolower(PHP_OS),"win") === FALSE) {
	define('ISUNIX', TRUE);
} else {
	define('ISUNIX', FALSE);
}

$mode = 0777;
use think\Request;
use think\Db;
use think\Config;
$rq= Request::instance();
$step = trim($rq->param('step')) ? trim($rq->param('step')) : 1;
$sqlstr = file_get_contents('mlcms.sql');
//整理创建数据库文件
//$sqlstr = file_get_contents('phpcms_db.sql');
$sqlarr = explode(';', substr($sqlstr, 0,strrpos($sqlstr,';')));
//$str1= str_ireplace(' IF NOT EXISTS', '', $sqlarr[1]);
//echo $str1.'</br>';
//echo strpos($str1, "`",0).'---1</br>';
//echo strpos($str1, "`",15).'--2</br>';
//$tableName= substr($str1, strpos($str1, "`",0)+1, strpos($str1, "`",strpos($str1, "`",0)+1)-strpos($str1, '`',0)-1);
//echo $tableName;

////$m=1;
////echo $sqlarr[$m];
//preg_match_all('/CREATE TABLE .*`/', $sqlstr,$tables);
//$table= preg_replace('/ IF NOT EXISTS/', '', $tables[0]);
//测试数据库创建表是否正确
//$db_dsn = "mysql://root:root@localhost:3306/mlcms#utf8";
 //$db = Db::connect($db_dsn);
 //echo $sqlarr[1];
 //$result = $db->execute($sqlarr[1]);
switch ($step) {
    case 1:
        $license = file_get_contents("license.txt");		
	include "step/step".$step.".tpl.php";
        break;
    case 2://环境检测 (FTP帐号设置）        
        $PHP_GD='';
        if(extension_loaded('gd')){
            if(function_exists('imagepng')){$PHP_GD .= 'png';}
            if(function_exists('imagejpeg')){$PHP_GD .= ' jpeg';}
            if(function_exists('imagegif')){$PHP_GD .= ' gif';}
        } 
        $PHP_JSON= FALSE;
        if(extension_loaded('json')){    
            if(function_exists('json_decode') && function_exists('json_encode')) $PHP_JSON = TRUE;
        }
        //新加fsockopen 函数判断,此函数影响安装后会员注册及登录操作。
	if(function_exists('fsockopen')) {
		$PHP_FSOCKOPEN = TRUE;
	}
        if(preg_match('/^([0-9]{1,3}.){1,3}[0-9]{1,3}/',@gethostbyname('www.hz5a.com')))$PHP_DNS=TRUE;       
	include "step/step".$step.".tpl.php";
        break;
    case 3:
        require 'modules.inc.php';
	include "step/step".$step.".tpl.php";
        break;
    
    case 4:
        $dbcfg= Config::get('database');        
        extract($dbcfg);
        include "step/step".$step.".tpl.php";
        break;
      
    case 5: //配置帐号 （MYSQL帐号、管理员帐号、）
		$info=$rq->param();
                print_r($info);
                //extract($info);
                $dbcfg_file_path='../../application/dbtest.php';
                $arrfirst=array();
                $arrsecond=array();
                $dbcfg_str= file_get_contents($dbcfg_file_path);
                $filehandle= fopen($dbcfg_file_path, 'w+');
                foreach ($info as $infokey => $infovalue) {
                    $str1='/\'.*'.$infokey.'.*\'.*'.'=>'.'.*,/';
                    array_push($arrfirst, $str1);
                    $str2='\''.$infokey.'\''.'=>'.'\''.$infovalue.'\',';
                    array_push($arrsecond, $str2);
                }
                print_r($arrfirst);
                print_r($arrsecond);
                $value=preg_replace($arrfirst, $arrsecond, $dbcfg_str);
                echo '</br>'.$dbcfg_str.'</br>';
                echo '</br>'.$value.'</br>';
                fwrite($filehandle, $value);
                fclose($filehandle);
                include "step/step".$step.".tpl.php";    
        break; 
    case 6:
        include "step/step" . $step . ".tpl.php";
        break;
    case 'install': //安装详细过程  
       // $tablelength=count($table);
        $length= count($sqlarr);
        $dbhost = $rq->post('dbhost');
        $dbusername = $rq->post('dbusername');
        $dbpsw = $rq->post('dbpsw');
        $dbport = $rq->post('dbport');
        $dbname = $rq->post('dbname');
        $db_dsn = "mysql://" . trim($dbusername) . ':' . trim($dbpsw) . '@' . trim($dbhost) . ':' . $dbport . "/".$dbname . '#utf8';
        $arr['n']=$_GET['n'];
        
        try {
            if ($arr['n'] < $length-1) {
                $arr['n'] += 1;
                $db = Db::connect($db_dsn);
                try {
                    if ($sqlarr[$arr['n']] != ' ') {
                        $result = $db->execute($sqlarr[$arr['n']]);
                        if ($result === 0) {
                            if (substr_count($sqlarr[$arr['n']], 'CREATE TABLE') != 0) {
                                $str1 = str_ireplace(' IF NOT EXISTS', '', $sqlarr[$arr['n']]);
                                $tableName = substr($str1, strpos($str1, "`", 0) + 1, strpos($str1, "`", strpos($str1, "`", 0) + 1) - strpos($str1, '`', 0) - 1);
                                $arr['msg'] = '...数据表' .$tableName . '已经成功安装...</br>';
                            }
                        } else {
                           // $arr['msg'] = '...ss ' . $result . '...</br>';
                        }
                    }
                } catch (Exception $exc) {
                    $arr['msg'] .= '...' . $exc->getTraceAsString(). '...</br>';
                     
                } finally {
                   echo json_encode($arr);
                    exit; 
                }                
            } else {
                $arr['n'] = 999999;
                $arr['msg'] = 'done sqlarrlength=' . count($sqlarr) . 'table length=' . $length;
                echo json_encode($arr);
                exit;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        } finally {
            
        }
        break;
    case 7: //完成安装
        //安装完成后新建install.lock文件
        $installfile = fopen('install.lock', 'w+') or die('unopen the file');
        fwrite($installfile, '');
        fclose($installfile);
        include "step/step" . $step . ".tpl.php";
        break;
    case 'testdb':
        $arr = Array();
        $arr['n'] = 0;
        $dbhost = $rq->post('dbhost');
        $dbname = $rq->post('dbname');
        $dbpsw = $rq->post('dbpsw');
        $dbport = $rq->post('dbport');
        if ($dbhost == '' || $dbname == '' || $dbpsw == '') {
            $arr['n'] = 000000;
            $arr['msg'] = 'not connected';
            echo json_encode($arr);
            exit;
        }
        if (trim($dbport) == '')
            $dbport = 3306;
        $db_dsn = "mysql://" . trim($dbname) . ':' . trim($dbpsw) . '@' . trim($dbhost) . ':' . $dbport . "/information_schema" . '#utf8';
        try {
            $db = Db::connect($db_dsn);
            $result = $db->query('SHOW TABLES');
            $arr['n'] = 999999;
            $arr['msg'] = 'connected';
            echo json_encode($arr);
            exit;
        } catch (Exception $exc) {
            $arr['n'] = 000000;
            $arr['msg'] = 'not connected';
        } finally {
            echo json_encode($arr);
            exit;
        }
        break;

//检测数据库是否存在，若不存在则创建，若存在则询问用户是否覆盖数据       
    case 'dbexites':
        $arr = Array();
        $arr['n'] = 0;
        $dbhost = $rq->post('dbhost');
        $dbusername = $rq->post('dbusername');
        $dbpsw = $rq->post('dbpsw');
        $dbport = $rq->post('dbport');
        $dbname = strtolower($rq->post('dbname'));
        if($dbport==''){$dbport=3306;}
        try {
            $dblink = mysqli_connect($dbhost . ':' . $dbport, $dbusername, $dbpsw);
        } catch (Exception $exc) {
            $arr['msg'] =  $exc->getTraceAsString();
            echo json_encode($arr);
            exit;
        } finally {

            if (!$dblink) {
                $arr['msg'] = 'connect false';
            } else {
                $qstr = 'show databases';
                $resultdb = mysqli_query($dblink, $qstr);
                $dbs = mysqli_fetch_all($resultdb);
                $dbarray = array();
                foreach ($dbs as $key => $value) {
                    array_push($dbarray, $value[0]);
                }
                if (in_array($dbname, $dbarray)) {
                    $arr['n'] = 1;
                    $arr['msg'] = 'database exites';
                } else {
                    $qstr = "CREATE DATABASE ".$dbname;
                    if(mysqli_query($dblink, $qstr)){
                        $arr['msg'] = 'dbhost='.$dbhost.'&dbusernmae='.$dbusername.'&dbpsw='.$dbpsw.'&dbport='.$dbport.'&dbname='.$dbname.'&数据库创建成功';
                    }else{
                        $arr['msg'] = 'dbhost='.$dbhost.'&dbusernmae='.$dbusername.'&dbpsw='.$dbpsw.'&dbport='.$dbport.'&dbname='.$dbname.'&数据库创建失败';
                    }
                }
            }
            mysqli_close($dblink);
            echo json_encode($arr);  
            exit;  
        }
        break;
    default:
        break;
}





/*
//安装完成后新建install.lock文件
$installfile=fopen('install.lock','w+') or die('unopen the file');
fwrite($installfile, '');
fclose($installfile);

 * //header("location:../index.php");
 */
function format_textarea($string) {
	$chars = 'utf-8';
	if(CHARSET=='gbk') $chars = 'gb2312';
	return nl2br(str_replace(' ', '&nbsp;', htmlspecialchars($string,ENT_COMPAT,$chars)));
}

function _sql_execute($link,$sql,$r_tablepre = '',$s_tablepre = 'phpcms_') {
    $sqls = _sql_split($link,$sql,$r_tablepre,$s_tablepre);
	if(is_array($sqls))
    {
		foreach($sqls as $sql)
		{
			if(trim($sql) != '')
			{
				mysqli_query($link,$sql);
			}
		}
	}
	else
	{
		mysqli_query($link,$sqls);
	}
	return true;
}

function _sql_split($link,$sql,$r_tablepre = '',$s_tablepre='phpcms_') {
	global $dbcharset,$tablepre;
	$r_tablepre = $r_tablepre ? $r_tablepre : $tablepre;
	if(mysqli_get_server_info($link) > '4.1' && $dbcharset)
	{
		$sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=".$dbcharset,$sql);
	}
	
	if($r_tablepre != $s_tablepre) $sql = str_replace($s_tablepre, $r_tablepre, $sql);
	$sql = str_replace("\r", "\n", $sql);
	$ret = array();
	$num = 0;
	$queriesarray = explode(";\n", trim($sql));
	unset($sql);
	foreach($queriesarray as $query)
	{
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		$queries = array_filter($queries);
		foreach($queries as $query)
		{
			$str1 = substr($query, 0, 1);
			if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
		}
		$num++;
	}
	return $ret;
}

function dir_writeable($dir) {
	$writeable = 0;
	if(is_dir($dir)) {  
        if($fp = @fopen("$dir/chkdir.test", 'w')) {
            @fclose($fp);      
            @unlink("$dir/chkdir.test"); 
            $writeable = 1;
        } else {
            $writeable = 0; 
        } 
	}
	return $writeable;
}

function writable_check($path){
	$dir = '';
	$is_writable = '1';
	if(!is_dir($path)){return '0';}
	$dir = opendir($path);
 	while (($file = readdir($dir)) !== false){
		if($file!='.' && $file!='..'){
			if(is_file($path.'/'.$file)){
				//是文件判断是否可写，不可写直接返回0，不向下继续
				if(!is_writable($path.'/'.$file)){
 					return '0';
				}
			}else{
				//目录，循环此函数,先判断此目录是否可写，不可写直接返回0 ，可写再判断子目录是否可写 
				$dir_wrt = dir_writeable($path.'/'.$file);
				if($dir_wrt=='0'){
					return '0';
				}
   				$is_writable = writable_check($path.'/'.$file);
 			}
		}
 	}
	return $is_writable;
}

function set_config($config,$cfgfile) {
	if(!$config || !$cfgfile) return false;
	$configfile = CACHE_PATH.'configs'.DIRECTORY_SEPARATOR.$cfgfile.'.php';
	if(!is_writable($configfile)) showmessage('Please chmod '.$configfile.' to 0777 !');
	$pattern = $replacement = array();
	foreach($config as $k=>$v) {
			$v = trim($v);
			$configs[$k] = $v;
			$pattern[$k] = "/'".$k."'\s*=>\s*([']?)[^']*([']?)(\s*),/is";
        	$replacement[$k] = "'".$k."' => \${1}".$v."\${2}\${3},";							
	}
	$str = file_get_contents($configfile);
	$str = preg_replace($pattern, $replacement, $str);
	return file_put_contents($configfile, $str);		
}

function set_sso_config($config,$cfgfile) {
	if(!$config || !$cfgfile) return false;
	$configfile = PHPCMS_PATH.'phpsso_server'.DIRECTORY_SEPARATOR.'caches'.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.$cfgfile.'.php';
	if(!is_writable($configfile)) showmessage('Please chmod '.$configfile.' to 0777 !');
	$pattern = $replacement = array();
	foreach($config as $k=>$v) {
			$v = trim($v);
			$configs[$k] = $v;
			$pattern[$k] = "/'".$k."'\s*=>\s*([']?)[^']*([']?)(\s*),/is";
        	$replacement[$k] = "'".$k."' => \${1}".$v."\${2}\${3},";							
	}
	$str = file_get_contents($configfile);
	$str = preg_replace($pattern, $replacement, $str);
	return file_put_contents($configfile, $str);		
}

function remote_file_exists($url_file){
	$headers = get_headers($url_file);
	if (!preg_match("/200/", $headers[0])){
		return false;
	}
	return true;
}
function delete_install($dir) {
	$dir = dir_path($dir);
	if (!is_dir($dir)) return FALSE;
	$list = glob($dir.'*');
	foreach($list as $v) {
		is_dir($v) ? delete_install($v) : @unlink($v);
	}
    return @rmdir($dir);
}
