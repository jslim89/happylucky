<?php

/**
 * Banner_Model 
 * 
 * @package 
 * @version $Id$
 * @copyright Copyright (C) 2011-2012 Jeong-Sheng, Lim, TARC. All rights reserved.
 * @author Jeong-Sheng, Lim <jslim89@gmail.com> 
 * @license GPL Version 3 {@link http://www.gnu.org/licenses/gpl.html}
 */
class Banner_Model {

    /**
     * Return the upload path for this particular amulet 
     * 
     * @return mixed
     */
    public function get_upload_path() {
        $path_to_banner = "images/slideshows/";
        $abs_path = absolute_path().$path_to_banner;

        if(!file_exists($abs_path)) {
            // umask is to revoke permission
            // i.e. chmod('file', 0777)
            //      umask(0022)
            //      file permission will be 0755
            umask(0000);
            mkdir($abs_path, 0777);
        }
        return $abs_path;
    }

    /**
     * Get the path for download image base on a particular amulet object 
     * 
     * @return string
     */
    public function get_download_path() {
        $path_to_banner = "images/slideshows/";
        $relative_path = base_url().$path_to_banner;
        return $relative_path;
    }

    /**
     * get_all 
     * 
     * @return array
     */
    public function get_all() {
        $files = glob($this->get_upload_path().'*');
        $images = array();
        foreach($files as $file) {
            // filter only jpg, jpeg, png files out
            if(preg_match_all('/.jpe?g|.png$/', $file, $temp))
                $images[] = $this->get_download_path().basename($file);
        }
        return $images;
    }

    /**
     * delete 
     * 
     * @param mixed $image 
     * @return bool
     */
    public function delete($image) {
        return unlink($this->get_upload_path().$image);
    }
}
