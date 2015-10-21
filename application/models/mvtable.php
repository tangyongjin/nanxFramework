<?php 

class MVtable extends CI_Model{

  public function __construct()
    {
        parent::__construct();
    }
    
  public function init($arr)
    {
        $this->arr= $arr;
    }
  
  function debug()
  {
  debug($this->arr);
  }
  
  function count()
  {
  return count($this->arr);
  }
   
  function selectall()
  {
  return $this->arr;
  }    
  
  function select_part($start,$limit)
  {
  $res=array();
  for($i=0;$i< $limit, $==)
   {
   	$res[]=$arr[$start+$i];
   }
  return $res;
  
  }


}
 
?>
