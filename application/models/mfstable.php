<?php

class MFstable extends CI_Model
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

}
?>