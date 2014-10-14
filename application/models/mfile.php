<?php

class MFile extends CI_Model
{
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
        $src = 'imgs/' . $f['filename'] . '_thumb.' . $f['extension'];
        $dest = 'imgs/thumbs/' . $fname;
        rename($src, $dest);
    }
    
    
   
     function getFileList($path,$ftype='all')
    { 
       $p='/'.$path.'/';
    	 $path= (dirname(dirname(dirname(__FILE__)))).$p;
    	 if($ftype=='all')
    	 {
    	 $ext = '{*.jpg,*.JPG,*.bmp,*.BMP,*.gif,*.GIF,*.png,*.PNG}';
    	 }
    	else
    	{
    	  $ext='{*.'.$ftype.'}';
    	}
    	   
       $files  = glob($path.$ext, GLOB_BRACE);
       
       $this->load->model('MFile');
       $bs_url=$this->config->item('base_url');
       $rows=array();
       foreach($files  as $file)
             {
              	$tmp=array();
              	$realname=str_replace($path,'',$file);
              	$realname=$this->MFile->getFilename4Client($realname);
             		$image_properties = array(
               'src' => $bs_url.'/imgs/'.$realname,
               'class' =>'img_max_48'
                );
              	$img_html=img($image_properties);
                $rows[]=$img_html.'<br/>'.$realname;
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