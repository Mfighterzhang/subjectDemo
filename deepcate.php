<!------>
<!---->
<!---- 数据库: `tree`-->
<!---->
<!------>
<!---->
<!--CREATE DATABASE `tree` DEFAULT CHARACTER SET gb2312 COLLATE gb2312_chinese_ci;-->
<!---->
<!--USE `tree`;-->
<!--2-->
<!---->
<!---->
<!--3	---->
<!---->
<!---- 表的结构 `class`-->
<!---->
<!------>
<!--4-->
<!--5	CREATE TABLE `class` (-->
<!---->
<!--`id` int(11) NOT NULL auto_increment,-->
<!---->
<!--`name` varchar(10) NOT NULL,-->
<!---->
<!--`pid` int(11) NOT NULL,-->
<!---->
<!--`depth` varchar(100) default '0',-->
<!---->
<!--PRIMARY KEY  (`id`)-->
<!---->
<!--) ENGINE=MyISAM  DEFAULT CHARSET=gb2312 AUTO_INCREMENT=30 ;-->


<?php
$link =mysql_connect('localhost','root','root');
mysql_select_db('tree');
mysql_query ( 'set names GBK' );
if($_GET['act']=='add'){
    $name=$_POST['name'];
    if($name=='') exit('name not null');
    $pid=$_POST['pid'];
    if($pid !=0){
        $sql="select * from class where id=".$pid;
        $result =mysql_query($sql);
        $row = mysql_fetch_array($result);
        $depth=$row['depth'].','.mysql_insert_id();//$getID即为最后一条记录的ID
    }else{
        $depth=0;
    }
    $sql="INSERT INTO class(name,pid,depth) VALUES('".$name."','".$pid."','".$depth."')";
    $result =mysql_query($sql);
    if(!$result){
        exit("shibai $sql");
    }else{
        exit("chenggong");
    }
}

?>
<form id="form1" name="form1" method="post" action="?act=add">
    <table width="327" border="1" cellpadding="0" cellspacing="0">
        <tr>
            <td width="97" height="27">名称</td>
            <td width="224"><label for="name"></label>
                <input type="text" name="name" id="name" /></td>
        </tr>
        <tr>
            <td height="30">栏目</td>
            <td><select name="pid" id="pid">
                    <option value="0">-----顶级分类-----</option>
                    <?php
                        sort_s(0);
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td height="35">&nbsp;</td>
            <td><input type="submit" name="button" id="button" value="提交" /></td>
        </tr>
    </table>
</form>
<br />
<br />
<br />
<br />
<?php
sorttree(0);
function sorttree($id){
    $sql="select * from class where pid=".$id;
    $result =mysql_query($sql);
    while($row = mysql_fetch_array($result)){
        $rid=explode(",",$row['depth']);
        $i=count($rid);
        $n = str_pad('',$i,'-',STR_PAD_RIGHT);
        $n = str_replace("-","&nbsp;&nbsp;&nbsp;&nbsp;",$n);
        //print_r($row).'<br>';
        if($row['pid']==0){
            echo $n.'|-----'.$row['name'].'-----|<br>';
        }else{
            echo $n.'&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FF0000">|-</font>'.$row['name'].'<br>';
        }
        sorttree($row['id']);
    }

}
function sort_s($id){
    //if()
    $sql="select * from class where pid=".$id;
    $result =mysql_query($sql);
    while($row = mysql_fetch_array($result)){
        $rid=explode(",",$row['depth']);
        $i=count($rid);
        $n = str_pad('',$i,'-',STR_PAD_RIGHT);
        $n = str_replace("-","&nbsp;&nbsp;&nbsp;&nbsp;",$n);
        if($row['pid']==0){
            echo "<option value=".$row['id']." style='background:#ccc' >".$n.'|------'.$row['name']."-----|</option>rn";
        }else{
            echo "<option value=".$row['id'].">".$n.'&nbsp;&nbsp;&nbsp;&nbsp;|- '.$row['name']."</option>rn";

        }
        sort_s($row['id']);
    }

}

?>