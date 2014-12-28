<?php

class MFile extends CI_Model
{

  function getFSGridFields()
  {
    
    $header=array(
    'filename'=>0
    );

    return array($header);
  }

function forbiddenFiles()
{
  $forbidden=array();
  return $forbidden;
}

   

function fs2array()
  { 
     $para = (array )json_decode(file_get_contents('php://input'));
     $os_path=$para['os_path'];
     $this->load->model('MFile');
     $media_type=$para['media_type'];
     $files=$this->MFile->getFileList($os_path,$media_type);
     
     if($media_type=='img')
     {
         $file_trunk=$para['file_trunk'];
         $picArray=$this->picFile2Array($files,$file_trunk,$_GET);
         echo $picArray;
         return;
     }

     $result=array();
     $result['rows']=$files;
     $result['total']=count($files);
     $result['table']='vstable';
     $json = json_encode($result,JSON_UNESCAPED_UNICODE);
     echo $json;
  }


  function picFile2Array($rawfiles,$file_trunk,$get)
  {
      $files=array();
      $bs_url=$this->config->item('base_url');
      foreach ($rawfiles as $one_file) {
              $image_properties = array(
                'src' => $bs_url.'/imgs/'.$one_file['Filename'],
                'class' =>'img_max_48'
                );
                $img_html=img($image_properties);
                $files[]=$img_html.'<br/>'.$one_file['Filename'];
      }  
 
      $result=array();
      $tr=array_chunk($files,$file_trunk);

      if(isset($get['start']))
       {
        $start = $get['start'];
        $limit = $get['limit'];
        $segment=array_slice($tr,$start,$limit);
       }
         else
         {
         $segment=$tr;
        }

     $result['rows']=$segment;
     $result['total']=count($tr);
     $result['table']='vstable';
     $json = json_encode($result,JSON_UNESCAPED_UNICODE);
     return $json;
  }
  
    function getFilenameInZip($fname)
    {
        $zip = zip_open($fname);
        $dirs = $files = array();
        if ($zip)
        {
            while ($zip_entry = zip_read($zip))
            {
                $zen = zip_entry_name($zip_entry);
                $is_dir = substr($zen, -1) == DIRECTORY_SEPARATOR;
                $zen_splitted = explode(DIRECTORY_SEPARATOR, $zen);
                if ($is_dir)
                {
                    $dirs[] = $zen_splitted[count($zen_splitted) - 2];
                } else
                {
                    $files[] = $zen_splitted[count($zen_splitted) - 1];
                }
            }
            zip_close($zip);
        }
        return ($files[0]);
    }


   function getUnpathedName($upload_file)
    {
        $stripped = preg_replace('/^.+[\\\\\\/]/', '', $upload_file);
        return $stripped;
    }



    function getUploadFileName($upload_file)
    {
        $stripped = preg_replace('/^.+[\\\\\\/]/', '', $upload_file);
        $stripped = $this->getFilename4OS($stripped);
        return $stripped;
    }


    function getFileType($filename)
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        return $ext;
    }

    
    function getFilename4OS($fname)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
        {
            $os_filename = iconv("utf-8", "gbk", $fname);
        } else
        {
            $os_filename = $fname;
        }
        return $os_filename;
    }
    
    
    function getFilename4Client($fname)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
        {
            $os_filename = iconv("gbk", "utf-8", $fname);
        } else
        {
            $os_filename = $fname;
        }
        return $os_filename;
    }
    

    function checkWriteAble($path)
    {
        $this->load->helper('file');
        list($msec, $sec) = explode(' ', microtime());
        $fname = (float)$sec;
        $data = 'X';
        if (!write_file("$path/$fname", $data))
        {   
            return false;
        } else
        {   
            unlink("$path/$fname");
            return true;
        }
    }


    function write_os_file($actcfg, $fname, $content)
    {
        $os_filename = $this->getFilename4OS($fname);
        $this->load->helper('file');
        $code = write_file($os_filename, $content);
        if ($code)
        {
            $res = array(
                'success' => true,
                'fname' => $fname,
                'msg' => $this->lang->line($actcfg['successmsg']),
                'opcode' => $actcfg['opcode'],
                'errmsg' => '');
        } else
        {
            $res = array(
                'success' => false,
                'opcode' => $actcfg['opcode'],
                'msg' => $this->lang->line('write_file_failed'),
                'errmsg' => $this->lang->line('write_file_failed'));
        }
        return $res;
    }


    function writeThumb($fname)
    {    
        $this->load->model('MFile');
        $fname = $this->MFile->getFilename4OS($fname);
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'imgs/' . $fname;
        $config['create_thumb'] = true;
        $config['maintain_ratio'] = true;
        $config['width'] = 14;
        $config['height'] = 14;
        $this->load->library('image_lib', $config);
        $write_file_result= $this->image_lib->resize();   //create file as XXXX_thumb.ext
        $f = spathinfo($fname);
        if ( ! $this->image_lib->resize())
        {
         return false;
        }


        $src = 'imgs/' . $f['filename'] . '_thumb.' . $f['extension'];
        $dest = 'imgs/thumbs/' . $fname;
        rename($src, $dest);
        return true;
    }
    
    


   // array_push($col_cfg, array('field_e'=>'pid','display_cfg'=>array('field_c'=>'pid','value'=>'pid')));
   //                     array_push($col_cfg, array('field_e'=>'Filename','display_cfg'=>array('field_c'=>'Filename','value'=>'Filename')));
   //                     array_push($col_cfg, array('field_e'=>'Size','display_cfg'=>array('field_c'=>'Size','value'=>'Size')));
   //                     array_push($col_cfg, array('field_e'=>'Date','display_cfg'=>array('field_c'=>'Date','value'=>'Date')));



    function getFiles($data) {

    //define the path as relative
    $path = $data->path;
    
    //using the opendir function
    if(false === ($dir_handle = @opendir($path))) 
      return array("totalCount"=>0,"rows"=>array());// or die("Unable to open $path");
    
    $rows = array();
    while (false !== ($file = readdir($dir_handle))) {
      if ($file != "." && $file != "..") {
        $filename = $path . '/' . $file;
          $row = array();
          $row['filename']  = $file;
          $row['filepath']  = $filename;
          $row['base_path'] = $data->base_path;
          $row['relative_filepath']= substr($filename,strlen($data->base_path));
          $row['filesize']  = (is_dir($filename)?$this->_getdirsize($filename):filesize($filename));
          $row['filetype']  = (is_dir($filename)?'dir':substr(strrchr($file, '.'), 1));
          $row['cls']     = (is_dir($filename)?'dir':substr(strrchr($file, '.'), 1));
          $row['date_modified'] = date ("Y-m-d H:i:s A", filemtime($filename));
          $rows[]       = $row;
      }
    }
  
    //closing the directory
    closedir($dir_handle);  

    $result = array(
      "totalCount" => sizeof($rows),
      "rows" => $rows
    );

    return $result;
  }
  

   
     function getFileList($path,$ftype='all')
    { 
       $p='/'.$path.'/';
    	 $path= (dirname(dirname(dirname(__FILE__)))).$p;
    	 if($ftype=='img')
    	 {
    	 $ext = '{*.jpg,*.JPG,*.bmp,*.BMP,*.gif,*.GIF,*.png,*.PNG}';
    	 }
    	else
    	{
    	  $ext='{*.'.$ftype.'}';
    	}
    	   
       $files  = glob($path.$ext, GLOB_BRACE);
      
       
       $rows=array();
       $pid=0;
       foreach($files  as $file)
             {
                $tmp=array();
               	$shortname=str_replace($path,'',$file);

              	$realname=$this->getFilename4Client($file);
                $tmp['pid']= $pid;
                $tmp['Filename']= $shortname; 
                $tmp['Size']=  filesize($realname);   
                $tmp['Date']= date ("Y-m-d H:i:s A", filemtime($realname));
                $rows[]=$tmp;
                $pid++;
             } 

        return $rows;
    }
    
     
    
    
    function backupsystem($fname)
  {
  $cfg=array(
   array(
   'dest'=>'js',
   'path'=>'js/upload',
   'name_prefix'=>'',
   'ext'=>'js'
   ),
   array(
   'dest'=>'imgs',
   'path'=>'imgs',
   'name_prefix'=>'',
   'ext'=>'all'
   ),
   
    array(
   'dest'=>'controllers',
   'path'=>'application/controllers',
   'name_prefix'=>'nanxplug_',
    'ext'=>'php'
   ),
  
   array(
   'dest'=>'models',
   'path'=>'application/models',
   'name_prefix'=>'mnanxplug_',
    'ext'=>'php'
   ),
  
   array
  (
  'dest'=>'uploads',
  'path'=>'uploads',
  'name_prefix'=>'',
  'ext'=>'all'
  )
  );
  
  $this->load->helper('file');
  $this->load->model('MFile');
  foreach($cfg as $backup_item)
   {
    delete_files("tmp/4backup/".$backup_item['dest']);
    $files=$this->MFile->getFileList2($backup_item['path'],$backup_item['ext']);
    foreach($files as $src_file)
    { 
       $fn_nopath=$this->MFile->getUnpathedName($src_file);
       $destfile="tmp/4backup/".$backup_item['dest']."/".$fn_nopath;
       if(strlen($backup_item['name_prefix'])>0)
       {
        if(0===strpos($fn_nopath,$backup_item['name_prefix']))
        {
         copy($src_file,$destfile);
        }
       }
       else
        {
          copy($src_file,$destfile);
        }
    }
   }
   $fname=$this->zipall('tmp/4backup/',$fname);
   return array('success'=>true,'fname'=> $fname);  
  }

  function zipall($path,$fname)
  { 
    $today = date("Ymd");
    $this->load->model('MSystempara');
    $this->load->library('zip');
    $this->zip->read_dir($path); 
    $this->zip->archive('tmp/'.$fname);
    return $fname; 
  }
}

?>