<?php


/*

From
       Name  Sex    Age
       Alex  male   33
       Tom   male   40

To:
      Name
      Alex
      Tom
*/


/*
keys_config can be 
    'name'
or  array('name','sex') 
or  array('name',array('segment'=>'book_info',index=>'sale_price'))
*/

define("VAR_PREFIX",     "#");

function array_retrieve($arr,$keys_config)
{

// debug($arr);
// debug($keys_config);

$result=array();
if(is_array($keys_config))
{
 foreach ($arr as $onearr)
  {
    $tmp=array();
    foreach ($keys_config as $segment_index)
     {
      if(is_array($segment_index))
      {
       $segment= $segment_index['segment'];
       $index = $segment_index['index'];
       $tmp[$index]=$onearr[$segment][$index];
      }
      else
       { 
        $tmp[$segment_index]=$onearr[$segment_index];
       }
     }
    $result[]=$tmp;
  }
}
else
{
 foreach ($arr as $onearr)
  {
    $result[]=$onearr[$keys_config];
  }
}
   return $result;
}


 

//把单维数组变成多维,模拟表格
function array_divd($arr,$colprefix,$num) 
{

        $divd=$num;
        $res=[];
        $key=array_keys($arr[0])[0];
        $divd_index=0;
        $tmp=array();
        $newindex=0;
        for($i=0;$i<count($arr);$i++)
        {
        	
         $res[$newindex][$colprefix.$divd_index]	=$arr[$i][$key];
         $divd_index++;
         if($divd_index==$divd){
        	$divd_index=0;
        	$newindex++;
         }
        }
        return $res;
}

function jsonstr2arr($str)
{
	  $json_str = str_replace("'",'"',$str ); 
	  $json_arr = json_decode($json_str,true); 
	  return $json_arr;
	  
}



 function array2groupstr($arr)
 {
  if(sizeof($arr)>0)
 {
      
   $one=$arr[0];
   $keys=array_keys($one);
   $str=json_encode($arr);
   $str=str_replace('{','[',$str);
   $str=str_replace('}',']',$str);
   foreach($keys as $onekey)
  { 
  	//È¥µô key:
  	$kstr='"'.$onekey.'":';
  	$str=str_replace($kstr,'',$str);
  }
   $str=str_replace('"',"'",$str);
   return $str;
  }
  else
  {return '[]';}  
 }

 
 
   function array2comastr($array)
  {
  $string1 = "";
  foreach ($array as $string) $string1 .= $string.",";
  $string1 = substr( $string1,0,-1);
  return  $string1;
  
  }
  


 function arrayfilter($arr,$key,$values)
 {
 	if(!is_array($values)){$values=array($values);}
  $result=array();
  foreach ($arr as $onearr)
    {
	   foreach ($values as $value)
	   {
	    if($onearr[$key]==$value){$result[]=$onearr;}
     }
    }
 return $result;
 
 }
 
 function arraychangekey($array,$oldkey,$newkey)
 {
 $ret=array();
 foreach ($array as $arr)
  {
  $arr[$newkey] = $arr[$oldkey];
  unset($arr[$oldkey]);
  $ret[]=$arr;
  }
  return $ret;
 }


 function arrayinsertkv($array,$k,$v)
 {
 $ret=array();
 foreach ($array as $arr)
  {
  $arr[$k] = $v;
  $ret[]=$arr;
  }
  return $ret;
 }
  
 //去除全空的行 
 function arrayzip($arr) 
 {
 	$ziped=array();
 	for($i=0;$i<  count($arr);$i++)
 	{
 	  $keys=array_keys($arr[$i]);
 	  $vals='';
 	  for($j=0; $j< count($keys); $j++)
 	  {
 	  $vals.=$arr[$i][$keys[$j]];	
 	  }
 	  if(strlen($vals) >0 )
 	  {		array_push($ziped,$arr[$i]);
 	  }
 	  
 	}
 	return $ziped;
 } 
  
   function strMarcoReplace($str,$kv)
  {
  	if(is_array($kv)){
  	$k_v=$kv;
  	}
  	else{
  	$k_v=(array)($kv);	
  	}
    while(list($key,$val)= each($k_v))
    {
      $str= str_replace(VAR_PREFIX.$key,"'".$val."'", $str);
    }
   	return $str;
  }
  
  function getLayoutFields($arr)
  {

  //  debug($arr); 
  
  	$max=0;
  	$cols=array();
  	$lines=count($arr);
  	//$data=array('0'=>array('col_0'=>11,'col_1'=>22),'1'=>array('col_0'=>11,'col_1'=>22));
  	$data=array();
  
  	foreach ($arr as $row)
  	{
  	$fields=explode(",",$row['field_list']);
  	$count=count($fields);
  	if($count>$max){$max=$count;}	
  	
  	}
    
    for($i=0;$i< $max;$i++)
    {
     array_push($cols,'col_'.$i);
    }
    
    reset($arr);
     
    for($i=0;$i< $lines;$i++)
    {
       $tmp=array();
       for($j=0;$j< $max;$j++)
        {
         $tmp['col_'.$j]=$j;	
        }
    
    	 $fields=explode(",",$arr[$i]['field_list']);
       $fds=count($fields);
       for($k=0;$k< $fds;$k++)
        {
         $v=$fields[$k];
         if($fields[$k]=='NULL') {$v='';}
         $tmp['col_'.$k]=$v;
        }
    
       
       $data[$i]=$tmp;
    }
    return array('cols'=> $cols, 'data'=> $data);
  }
  
  
  function a2s($arr)
  {
    $ret='';
    foreach ($arr as $key => $value) 
    {
      
      $ret.=$key.':'.$value.',';
    }
    $ret=substr($ret,0,-1);
    return "[$ret]";
  }
  
  function array2string($Array)
 {  
    
    if(!is_array($Array))
    {
      return $Array;
    }
    $ret='';
    $NullValue='NULL';
    foreach ($Array as $key => $value) 
    {
        if(is_array($value))
            {
            $ReturnValue= a2s($value);
            }
        else
            {
            $ReturnValue=(strlen($value)>0)? $value:$NullValue;
            }
        $ret.=$key.':' .$ReturnValue.',';
    }
     return  substr($ret,0,-1);
 }

  function cartesian($array)
    {
        $all_possible = array();
        $dims = array_reverse($array);

        foreach ($dims as $dim_name => $dim) {
            $buf = array();
            foreach ($dim as $val) {
                $buf[] = array($dim_name => $val);
            }

            if (!count($all_possible)) {
                $all_possible = $buf;
            } else {
                $tmp = array();
                foreach ($buf as $el_buf)
                    foreach ($all_possible as $el_ap)
                        $tmp[] = array_merge($el_buf, $el_ap);
                $all_possible = $tmp;
            }
        }
        return $all_possible;
    }
	  //assoc(
	  
  function singlearray_join_assocarray($single,$assoc)
  {
   $result=array();
   $count=count($assoc);
   for($i=0;$i< $count;$i++)
     {
       $item= $assoc[$i];
       if(!(is_array($item))){ $item=(array)$item; }
       $tmp=$single;
       
       
       while(list($key)=each($item)){  
        $tmp[$key]=$item[$key];
       } 
      $result[]=$tmp;
     }
    return $result;
  }
  
  
  function sbasename($filename) {
   return preg_replace('/^.+[\\\\\\/]/', '', $filename);
   }

function spathinfo($filepath)   
{   
    $path_parts = array();   
    $path_parts ['dirname'] = rtrim(substr($filepath, 0, strrpos($filepath, '/')),"/")."/";   
    $path_parts ['basename'] = ltrim(substr($filepath, strrpos($filepath, '/')),"/");   
    $path_parts ['extension'] = substr(strrchr($filepath, '.'), 1);   
    $path_parts ['filename'] = ltrim(substr($path_parts ['basename'], 0, strrpos($path_parts ['basename'], '.')),"/");   
    return $path_parts;   
}    



?>