<?php

class PerchImage
{
    private $mode = false;
    
    
    function __construct()
    {
        if (extension_loaded('gd')) {
            $this->mode = 'gd';
        }
        
        if (extension_loaded('imagick')) {
            $this->mode = 'imagick';
        }
        
    }
    
    public function resize_image($image_path, $target_w=false, $target_h=false, $suffix=false)
    {
        if ($this->mode === false) return;
        
        PerchUtil::debug('Resizing image... ('.$this->mode.')');
        
        $save_as = $this->get_resized_filename($image_path, $target_w, $target_h, $suffix);
        
        $info = getimagesize($image_path);
        if (!is_array($info)) return false;
        
        
        $image_w = $info[0];
        $image_h = $info[1];
        
        $image_ratio = $image_w/$image_h;
        
        // Constrain by width
        if ($target_w && $image_w>$target_w) {
            $new_w = $target_w;
            $new_h = $target_w/$image_ratio;
        }
        
        // Constrain by height
        if ($target_h && $image_h>$target_h) {
            $new_h = $target_h;
            $new_w = $target_h*$image_ratio;
        }
        
        // Both specified 
        if ($target_w && $target_h) {
            if ($image_w > $image_h) {
                $new_w = $target_w;
                $new_h = $target_w/$image_ratio;
            }
            
            if ($image_h > $image_w) {
                $new_h = $target_h;
                $new_w = $target_h*$image_ratio;
            }
        }
        
        // Default
        if (!isset($new_w)) {
            $new_w = $image_w;
            $new_h = $image_h;
        }
        
        if ($this->mode == 'gd') {
            return $this->resize_with_gd($image_path, $save_as, $new_w, $new_h); 
        }
        
        if ($this->mode == 'imagick') {
            return $this->resize_with_imagick($image_path, $save_as, $new_w, $new_h);
        }
        
        return false;
    }
    
    
    public function get_resized_filename($image_path, $w=0, $h=0, $suffix=false)
    {
        if ($suffix) {
            $suffix = '-'.$suffix;
        }else{
            $suffix = '-';
            if ($w) $suffix .= 'w'.$w;
            if ($h) $suffix .= 'h'.$h;
        }
        
        return preg_replace('/(\.jpg|\.gif|.png)\b/', $suffix.'$1', $image_path);
    }
    
    
    private function resize_with_gd($image_path, $save_as, $new_w, $new_h)
    {
        
        $info = getimagesize($image_path);
        if (!is_array($info)) return false;
        
        PerchUtil::debug($info);
        
        $image_w = $info[0];
        $image_h = $info[1];
        $mime    = $info['mime'];
        
        if (function_exists('imagecreatetruecolor')) {
            $new_image = imagecreatetruecolor($new_w, $new_h);
        }else{
            $new_image = imagecreate($new_w, $new_h);
        }
        
        
        switch ($mime) {
            case 'image/jpeg':
                $orig_image = imagecreatefromjpeg($image_path);
                
                if (function_exists('imagecopyresampled')) {
                    imagecopyresampled($new_image, $orig_image, 0, 0, 0, 0, $new_w, $new_h, $image_w, $image_h);
                }else{
                    imagecopyresized($new_image, $orig_image, 0, 0, 0, 0, $new_w, $new_h, $image_w, $image_h);
                }
                
                imagejpeg($new_image, $save_as, 85);
                break;
                
                
                
                
            case 'image/gif':
                $orig_image = imagecreatefromgif($image_path);
                $this->gd_set_transparency($new_image, $orig_image);
                imagetruecolortopalette($new_image, true, 256);
                
                if (function_exists('imagecopyresampled')) {
                    imagecopyresampled($new_image, $orig_image, 0, 0, 0, 0, $new_w, $new_h, $image_w, $image_h);
                }else{
                    imagecopyresized($new_image, $orig_image, 0, 0, 0, 0, $new_w, $new_h, $image_w, $image_h);
                }

                imagegif($new_image, $save_as);
                
                break;
                
                
                
            case 'image/png':
                $orig_image = imagecreatefrompng($image_path);
                
                imagealphablending($new_image, false);
                imagesavealpha($new_image, true);
                
                if (function_exists('imagecopyresampled')) {
                    imagecopyresampled($new_image, $orig_image, 0, 0, 0, 0, $new_w, $new_h, $image_w, $image_h);
                }else{
                    imagecopyresized($new_image, $orig_image, 0, 0, 0, 0, $new_w, $new_h, $image_w, $image_h);
                }

                imagepng($new_image, $save_as);
                break;
            
            default: 
                $orig_image = imagecreatefromjpeg($image_path);
                break;
        }
        
        imagedestroy($orig_image);
        imagedestroy($new_image);    
        
    }
    
    
    private function gd_set_transparency($new_image, $orig_image)
    {

        $transparencyIndex = imagecolortransparent($orig_image);
        $transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255);

        if ($transparencyIndex >= 0) {
            $transparencyColor = imagecolorsforindex($orig_image, $transparencyIndex);   
        }

        $transparencyIndex = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
        imagefill($new_image, 0, 0, $transparencyIndex);
        imagecolortransparent($new_image, $transparencyIndex);        

    }
    
    
    private function resize_with_imagick($image_path, $save_as, $new_w=0, $new_h=0)
    {
        $image = new Imagick();
        $image->readImage($image_path);
        $image->thumbnailImage($new_w, $new_h);
        $image->writeImage($save_as);
        $image->destroy();        
        return;    
    }
    
}

?>