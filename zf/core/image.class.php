<?php
/**
 * This file contains image class
 * 
 * @version 1.0, SVN: $Id: image.class.php 27 2009-09-01 22:32:28Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com)
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */

/**
 * Class for dealing with images
 * 
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */
class image
{
    const CUT_TOPLEFT     = 1;
    const CUT_TOPRIGHT    = 2;
    const CUT_BOTTOMRIGHT = 3;
    const CUT_BOTTOMLEFT  = 4;
    const CUT_CENTER      = 5;
	static $check_size    = 0;
    public static $image_error   = '';
	
	static protected function img_cut($isrc, $dWidth, $dHeight, $sWidth = 0, $sHeight = 0, $cut = image::CUT_TOPLEFT)
	{
		if (!$sWidth) $sWidth = imagesx($isrc);
		if (!$sHeight) $sHeight = imagesy($isrc);
        
        $sXPoint = 0;
        $sYPoint = 0;
        
        switch ($cut){
            case image::CUT_TOPRIGHT : 
                $sXPoint = $sWidth >= $dWidth ? $sWidth - $dWidth : 0; 
            break;
            case image::CUT_BOTTOMRIGHT : 
                $sXPoint = $sWidth >= $dWidth ? $sWidth - $dWidth : 0; 
                $sYPoint = $sHeight >= $dHeight ? $sHeight - $dHeight : 0;
            break;
            case image::CUT_BOTTOMLEFT : 
                $sYPoint = $sHeight >= $dHeight ? $sHeight - $dHeight : 0;
            break;
            case image::CUT_CENTER :
            	$sXPoint = $sWidth >= $dWidth ? ($sWidth - $dWidth) / 2: 0;
                $sYPoint = $sHeight >= $dHeight ? ($sHeight - $dHeight) / 2 : 0;
            break;
        }
		
        if ($dWidth > $sWidth) $dWidth = $sWidth; 
		if ($dHeight > $sHeight) $dHeight = $sHeight;
        
		$idest = imagecreatetruecolor($dWidth, $dHeight);
		imagealphablending($idest, false);
		imagesavealpha($idest, true);		
		imagecopyresampled($idest, $isrc, 0, 0, $sXPoint, $sYPoint, $dWidth, $dHeight, $dWidth, $dHeight);
		
        return $idest;
	}

    /**
     * Returns False on error and true on success
     *
     * @static
     * @param $src
     * @param $dest
     * @param $dWidth
     * @param $dHeight
     * @param int $chmod
     * @param string $use_ratio
     * @param int $cut
     * @param int $quality
     * @param int $rgb
     * @return bool
     */
	static public function img_resize($src, $dest, $dWidth, $dHeight, $chmod = 0777, $use_ratio = 'max', $cut = 0, $quality=100, $rgb=0xffffff, $watermark_img = 0)
	{
		if (!file_exists($src)) {
            image::$image_error = 'No Src file exist. '.$src;
            return false;
        }
		$size = getimagesize($src);
		if ($size === false) {
            image::$image_error = 'No image size available.';
            return false;
        }
		if (!$dWidth && !$dHeight) {
			if ($rgb == 'grayscale') self::copyGrayscale($src, $dest, $size, $quality);
			else copy($src, $dest);
			if ($chmod) chmod($dest, $chmod);
			return true;
		}
		if (!$dWidth || !$dHeight) {
			image::$image_error = 'No destination sizes.';  
            return false;
		}
        if($watermark_img){
            self::watermark_image($src, $src, $watermark_img);
        }
		
//		if (file_exists($dest)) {
//			$old_size = getimagesize($dest);
//			if ($dWidth == $old_size[0] && $dHeight == $old_size[1] && image::$check_size) return true;
//		} else {
			$old_size = array();
//		}

		$format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
		$icfunc = "imagecreatefrom" . $format;
			
		if (!function_exists($icfunc)) {
            image::$image_error = 'No function '.$icfunc.' exist';
            return false;
        }
		
		$sWidth  = $size[0];
		$sHeight = $size[1];
				
		switch ($use_ratio) {
			case 'max':
				if ($sWidth > $sHeight) {
					$ratio = $dWidth / $sWidth;
				} else {
					$ratio = $dHeight / $sHeight;
				}
			break;
			
			case 'x':
				$ratio = $dWidth / $sWidth;
			break;
			
			case 'y':
				$ratio = $dHeight / $sHeight;
			break;
			
			case 'equal':
				$ratio = max($dWidth / $sWidth, $dHeight / $sHeight);
                if ($ratio > 1) $ratio = 1;
                if ($cut === 0) $cut   = 1;
			break;

			case 'fit':
                if ($dWidth / $sWidth < $dHeight / $sHeight) {
                    $ratio = $dWidth / $sWidth;
                } else {
                    $ratio = $dHeight / $sHeight;
                }
                if ($ratio > 1) $ratio = 1;
			break;
		}

		$dWidth1  = round($sWidth * $ratio);
		$dHeight1 = round($sHeight * $ratio);
		
        if ($sWidth <= $dWidth && $sHeight <= $dHeight) {
        	if ($rgb == 'grayscale') self::copyGrayscale($src, $dest, $size, $quality);
			else copy($src, $dest);
            return true;
        }
        
		if ($old_size && $dWidth1 == $old_size[0] && $dHeight1 == $old_size[1] && image::$check_size) return true;
		
		$idest2 = 0;

		$isrc  = $icfunc($src);
		$idest = imagecreatetruecolor($dWidth1, $dHeight1);
		if ($format == 'png') {
			$quality = max(0, 9 - (int)($quality / 11.1));
			imagealphablending($idest2 ? $idest2 : $idest, false );
			imagesavealpha($idest2 ? $idest2 : $idest, true);
		}
//		imagefill($idest, 0, 0, $rgb);
		
		imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $dWidth1, $dHeight1, $sWidth, $sHeight);
		
		$idest2 = ($cut && $use_ratio != 'max') ? image::img_cut($idest, $dWidth, $dHeight, $dWidth1, $dHeight1, $cut === true ? 1 : $cut) : 0;
		
		if ($rgb == 'grayscale') {
			if ($idest2) {
				imagefilter($idest2, IMG_FILTER_BRIGHTNESS, 20);
				imagefilter($idest, IMG_FILTER_CONTRAST, 5);
				imagefilter($idest2, IMG_FILTER_GRAYSCALE);
			}
			else {
				imagefilter($idest, IMG_FILTER_BRIGHTNESS, 20);
				imagefilter($idest, IMG_FILTER_CONTRAST, 5);
				imagefilter($idest, IMG_FILTER_GRAYSCALE);
			}
		}
		$outfunc = "image$format";
		if ($idest2) {
			$outfunc($idest2, $dest, $quality);
			imagedestroy($idest2);
		} else {
			$outfunc($idest, $dest, $quality);
		}

		if ($chmod) chmod($dest, $chmod);
		imagedestroy($isrc);
		imagedestroy($idest);
		return true;
	}
	
        /**
     * Наложение водяного знака в виде изображения
     * @param $oldimage_name - исходное изображение
     * @param $new_image_name - выходное изображение
     * @return Boolean
     */
    static public function watermark_image($oldimage_name, $new_image_name, $watermark_image, $position = null)
    {
        // получаем размеры исходного изображения
        list($owidth,$oheight) = getimagesize($oldimage_name);
        // задаем размеры для выходного изображения 
        list($width, $height) = getimagesize($oldimage_name);
        // создаем выходное изображение размерами, указанными выше
        //$im = imagecreatetruecolor($width, $height);
        //$im = imagecreate($width, $height);
        
        $image = imagecreatetruecolor($width, $height);
        imagealphablending($image, false);
        $col=imagecolorallocatealpha($image,255,255,255, 127);
        imagefilledrectangle($image,0,0,$width, $height,$col);
        imagealphablending($image,true);
        
        $im = $image;
        
        $imgBlob = file_get_contents($oldimage_name);
        $img_src = imagecreatefromstring($imgBlob);
        unset($imgBlob);
        
        // наложение на выходное изображение, исходного
        imagecopyresampled($im, $img_src, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
        $watermark = imagecreatefrompng($watermark_image);
        // получаем размеры водяного знака
        list($w_width, $w_height) = getimagesize($watermark_image);
        // ресайзим ватермарку если она больше чем рисунок
        if($width < $w_width || $height < $w_height){
            // задание максимальной ширины и высоты
            $new_w_width = $width;
            $new_w_height = $height;
            // получение новых размеров
            $ratio_orig = $w_width/$w_height;
            if ($new_w_width/$new_w_height > $ratio_orig) {
               $new_w_width = $new_w_height*$ratio_orig;
            } else {
               $new_w_height = $new_w_width/$ratio_orig;
            }
            // ресэмплирование  
            $watermark_temp = imagecreate($new_w_width, $new_w_height);          
            imagecopyresampled($watermark_temp, $watermark, 0, 0, 0, 0, $new_w_width, $new_w_height, $w_width, $w_height);
            $watermark = $watermark_temp;
            $w_width = $new_w_width;
            $w_height = $new_w_height;
        }  
        // определяем позицию расположения водяного знака 
        switch ($position){
            case null:
            default:
                $pos_x = ($width - $w_width)/2; 
                $pos_y = ($height - $w_height)/2;
                break;
        }
        //debug::dump($pos_x);
        //debug::dump($pos_y);
        // накладываем водяной знак
        imagecopy($im, $watermark, $pos_x, $pos_y, 0, 0, $w_width, $w_height);
        imagealphablending($im,true);
        // сохраняем выходное изображение, уже с водяным знаком в формате jpg и качеством 100
        unlink($oldimage_name);
        if(strpos($oldimage_name, '.png')){
            imagesavealpha($im,true);
            imagepng($im, $new_image_name);
        }
        else{
            imagejpeg($im, $new_image_name, 100);
        }
        // уничтожаем изображения
        imagedestroy($im);
        //imagedestroy($watermark_temp);
        //unlink($oldimage_name);
        return true;
    }
    
	static private function copyGrayscale($src, $dest, $size, $quality) 
	{
		$format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
		$icfunc = "imagecreatefrom" . $format;		
		if (!function_exists($icfunc)) return false;
		$sWidth  = $size[0];
		$sHeight = $size[1];
		$isrc  = $icfunc($src);
		$idest = imagecreatetruecolor($sWidth, $sHeight);
		imagecopymerge($idest, $isrc, 0, 0, 0, 0, $sWidth, $sHeight, 100);
		imagefilter($idest, IMG_FILTER_GRAYSCALE);
		$outfunc = "image$format";
		if ($format == 'png') {
			$quality = ceil($quality/100)-1;
		}
		$outfunc($idest, $dest, $quality);
		imagedestroy($isrc);
		imagedestroy($idest);
		return true;
	}
	
	static public function img_1resize($src, $dest, $width, $height, $chmod = 0777, $use_ratio = 'max', $cut = 0, $quality=100, $rgb=0xffffff)
	{
		if (!file_exists($src)) return false;
		$size = getimagesize($src);
		if ($size === false) return false;
		if (!$width && !$height) {
			copy($src, $dest);
			if ($chmod) chmod($dest, $chmod);
			return true;
		}
		if (!$width || !$height) {
			  return false;
		}
		$format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
		$icfunc = "imagecreatefrom" . $format;

		if (!function_exists($icfunc)) return false;
		
		$isrc  = $icfunc($src);
		if ($use_ratio == 'equal') return image::img_resize_equal($isrc, $format, $dest, $size[0], $size[1], $width, $height, $chmod, $quality, $rgb);
		
		if ($use_ratio == 'min' || $use_ratio == 'max') {
			$ratio = $use_ratio($size[0]/$width, $size[1]/$height);
		} elseif ($use_ratio == 'x') {
			$ratio = $size[0]/$width;
		} elseif ($use_ratio == 'y') {
			$ratio = $size[1]/$height;
		}
		
		$new_width  = round($size[0]/$ratio);
		$new_height = round($size[1]/$ratio);
		
		if ($new_width > $size[0] || $new_height > $size[1]) {
			copy($src, $dest);
			if ($chmod) chmod($dest, $chmod);
			return true;
		}
		
		$idest = imagecreatetruecolor($new_width, $new_height);
		imagefill($idest, 0, 0, $rgb);
		imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $new_width, $new_height, $size[0], $size[1]);
		
		if ($use_ratio != 'max' && $cut) {
			$width  = min($width, $new_width);
			$height = min($height, $new_height);
			$idest2 = imagecreatetruecolor($width, $height);
			imagecopyresampled($idest2, $idest, 0, 0, 0, 0, $width, $height, round($new_width / $ratio), round($new_height / $ratio));
		}
		
		$outfunc = "image$format";

		if (isset($idest2)) {
			$outfunc($idest2, $dest, $quality);
			imagedestroy($idest2);
		} else {
			$outfunc($idest, $dest, $quality);
		}

		if ($chmod) chmod($dest, $chmod);
		imagedestroy($isrc);
		imagedestroy($idest);
		return true;
	}
	
	static public function img_resize_equal($isrc, $format, $dest, $sWidth, $sHeight, $dWidth, $dHeight, $chmod = 0777, $quality=100, $rgb =0xffffff)
	{
		$ratio = min($sWidth / $dWidth, $sHeight / $dHeight);
		$idest = imagecreatetruecolor($dWidth, $dHeight);
		imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $dWidth, $dHeight, $dWidth * $ratio, $dHeight * $ratio);
		$outfunc = "image$format";
		$outfunc($idest, $dest, $quality);
		if ($chmod) chmod($dest, $chmod);
	}
    
    /** Функция вырезает кусок изображения из $src и сохраняет в $dest
     *
     * $area обязательно должна содержать координаты левого верхнего угла и либо высоту/ширину либо координаты правого нижнего угла.<br/>
     * Координаты задаются в виде x1, y1 и x2, y2
     *
     * @static
     * @string $src
     * @string $dest
     * @array $area
     * @return bool
     */
    static public function img_crop($src, $dest, $area)
    {
        if (!file_exists($src)) return false;
        $size = getimagesize($src);
        if ($size === false) return false;
                
        $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
        $icfunc = "imagecreatefrom" . $format;

        if (!function_exists($icfunc)) return false;
                
        if (!empty($area['width']) && is_numeric($area['width'])) {
            $dWidth = $area['width'];
        } else {
            $dWidth = $area['x2'] - $area['x1'];
        }

        if (!empty($area['height']) && is_numeric($area['height'])) {
            $dHeight = $area['height'];
        } else {
            $dHeight = $area['y2'] - $area['y1'];
        }

        $isrc  = $icfunc($src);
        $idest = imagecreatetruecolor($dWidth, $dHeight);
        if ($format == 'png') {
            $quality = max(0, 9 - (int)(100 / 11.1));
            imagealphablending($idest, false );
            imagesavealpha($idest, true);
        }
        imagecopyresampled($idest, $isrc, 0, 0, $area['x1'], $area['y1'], $dWidth, $dHeight, $dWidth, $dHeight);
        $outfunc = "image$format";
        $quality = 100;
        if ($format == 'png') {
            $quality = max(0, 9 - (int)($quality / 11.1));
            $quality = ceil($quality/100)-1;
        }
        $outfunc($idest, $dest, $quality);
        imagedestroy($isrc);
        imagedestroy($idest);
        
        return true;
    }
}
?>