<?php
# ========================================================================#
#
#  Author:    Jarrod Oberto
#  Version:	 1.0
#  Date:      17-Jan-10
#  Purpose:   Resizes and saves image
#  Requires : Requires PHP5, GD library.
#  Usage Example:
#                     include("classes/resize_class.php");
#                     $resizeObj = new resize('images/cars/large/input.jpg');
#                     $resizeObj -> resizeImage(150, 100, 0);
#                     $resizeObj -> saveImage('images/cars/large/output.jpg', 100);
#
#
# Modified:	Chris Howard
# Changes:	Added crop vertical alignment
# 			Added crop horizontal alignment
#			Added image quality option
#			Added image background colour
#			Added centre image when smaller than frame
#			Added memory bumping
#			Added maximum image dimensions
#			Added focal point respect
# ========================================================================#

  if (!class_exists('jo_resize')) {


    Class jo_Resize
    {
      // *** Class variables
      private $image;
      public $width;
      public $height;
      private $imageResized;
      private $memory_limit;
      private $extension;

      function __construct($fileName)
      {
        // Increase memory!
        $this->memory_limit = ini_get('memory_limit');
        ini_set('memory_limit', ((defined(WP_MAX_MEMORY_LIMIT)) ? WP_MAX_MEMORY_LIMIT : '256M'));

        // *** Open up the file
        $this->image = $this->openImage($fileName);

        if (!$this->image) {return false;}

        // *** Get width and height
        $this->width  = imagesx($this->image);
        $this->height = imagesy($this->image);
      }

      ## --------------------------------------------------------

      private function openImage($file)
      {
        // *** Get extension
        $this->extension = strtolower(strrchr($file, '.'));
        switch ($this->extension) {
          case '.jpg':
          case '.jpeg':
            $img = @imagecreatefromjpeg($file) ;//or die('Couldn\'t open source image');
            break;
          case '.gif':
            $img = @imagecreatefromgif($file) or die('Couldn\'t open source image');
            break;
          case '.png':
            $img = @imagecreatefrompng($file) or die('Couldn\'t open source image');
            break;
          default:
            $img = false;
            break;
        }
        return $img;
      }

      ## --------------------------------------------------------

      public function resizeImage(
          $newWidth,
          $newHeight,
          $resizingType = "crop",
          $vcrop_align = "center",
          $hcrop_align = "center",
          $img_bg_color = "#FFFFFF",
          $centre_image = true,
          $max_image_dim,
          $focal_point = false
      ) {

        if (($this->height > $max_image_dim || $this->width > $max_image_dim) && $max_image_dim) {
          $this->imageResized = imagecreatetruecolor($newWidth, $newHeight) or die('Couldn\'t create temp image');
          $color = imagecolorallocate($this->imageResized, 240, 240, 240);
          imagefill($this->imageResized, 0, 0, $color);
        } else {
          $resizingType = (!$resizingType) ? 'crop' : $resizingType;

          $vcrop_align = (!$vcrop_align) ? "center" : $vcrop_align;
          $hcrop_align = (!$hcrop_align) ? "center" : $hcrop_align;

          // var_dump($newWidth);
          // *** Get optimal width and height - based on $resizingType
          $resizingTypeArray = $this->getDimensions($newWidth, $newHeight, $resizingType);
          $optimalWidth      = $resizingTypeArray[ 'optimalWidth' ];
          $optimalHeight     = $resizingTypeArray[ 'optimalHeight' ];


          // *** Resample - create image canvas of x, y size
          $start_dst_x = 0;
          $start_dst_y = 0;
          $start_src_x = 0;
          $start_src_y = 0;
          //		echo '<br/><br/>';
          if ($focal_point) {
            $focal_points = explode(',', $focal_point);
            //if source image is bigger than new image...
            //			if ($newHeight < $optimalHeight) {
            $opt_y_fp    = $optimalHeight * ($focal_points[ 1 ] / 100);
            $new_y_fp    = $newHeight * ($focal_points[ 1 ] / 100);
            $start_src_y = $opt_y_fp - $new_y_fp;
            //			}
            //			if ($newWidth < $optimalWidth) {
            $opt_x_fp    = $optimalWidth * ($focal_points[ 0 ] / 100);
            $new_x_fp    = $newWidth * ($focal_points[ 0 ] / 100);
            $start_src_x = $opt_x_fp - $new_x_fp;
//            var_dump(array(
//                         'image_width'    => $this->width,
//                         'image_height'   => $this->height,
//                         '$optimalWidth'  => (int)$optimalWidth,
//                         '$optimalHeight' => (int)$optimalHeight,
//                         '$opt_x_fp'      => (int)$opt_x_fp,
//                         '$opt_y_fp'      => (int)$opt_y_fp,
//                         '$start_dst_x'   => (int)$start_dst_x,
//                         '$start_dst_y'   => (int)$start_dst_y,
//                         '$start_src_x'   => (int)$start_src_x,
//                         '$start_src_y'   => (int)$start_src_y,
//                         '$new_x_fp'      => (int)$new_x_fp,
//                         '$new_y_fp'      => (int)$new_y_fp,
//                         '$newWidth'      => (int)$newWidth,
//                         '$newHeight'     => (int)$newHeight,
//                         '$focal_point'   => $focal_point,
//                     )
//            );
            //			}
          }
          switch ($resizingType) {
            case 'exact':
              $this->imageResized = imagecreatetruecolor($newWidth, $newHeight);
              break;
            case 'portrait':
              $this->imageResized = imagecreatetruecolor($newWidth, $optimalHeight);
              $start_dst_x        = $newWidth / 2 - $optimalWidth / 2;
              break;
            case 'landscape':
              $this->imageResized = imagecreatetruecolor($optimalWidth, $newHeight);
              $start_dst_y        = $newHeight / 2 - $optimalHeight / 2;
              break;
            case 'auto':
              if ($this->width <= $newWidth && $this->height <= $newHeight) {
                // Don't resize
                $optimalWidth  = $this->width;
                $optimalHeight = $this->height;
                $start_dst_x   = $newWidth / 2 - $this->width / 2;
                $start_dst_y   = $newHeight / 2 - $this->height / 2;
              } elseif ($this->width > $newWidth && $this->height > $newHeight) {
                // Standard resize
                $start_dst_x = $newWidth / 2 - $optimalWidth / 2;
                $start_dst_y = $newHeight / 2 - $optimalHeight / 2;
              } elseif ($this->width <= $newWidth && $this->height > $newHeight) {
                // Scale width, resize height
                $optimalWidth = $this->width * ($newHeight / $this->height);
                $start_dst_x  = $newWidth / 2 - ($this->width * ($newHeight / $this->height) / 2);
                $start_dst_y  = $newHeight / 2 - $optimalHeight / 2;
              } elseif ($this->width > $newWidth && $this->height <= $newHeight) {
                // Resize width, scale height
                $optimalHeight = $this->height * ($newWidth / $this->width);
                $start_dst_y   = $newHeight / 2 - ($this->height * ($newWidth / $this->width) / 2);
                $start_dst_x   = $newWidth / 2 - $optimalWidth / 2;
              }

              $this->imageResized = imagecreatetruecolor($newWidth, $newHeight);
              break;
            case 'crop':
              $this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
              break;
            case 'scaletowidth':
              $this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight) or die('Couldn\'t create temp image');
              break;
            case 'scaletoheight':
              $this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight) or die('Couldn\'t create temp image');
              break;
          }
          // Setup transparency if required, otherwise, setup bg colour.
          // if it's a png,preserve transparency 28/7/13

          if (!$img_bg_color || $img_bg_color == 'transparent' || strtolower($this->extension) == '.png') {
            imagealphablending($this->imageResized, false);
            imagesavealpha($this->imageResized, true);
            $color = imagecolorallocatealpha($this->imageResized, 0, 200, 0, 127);
            imagefill($this->imageResized, 0, 0, $color);
          } else {
            $img_bg_color = (substr($img_bg_color, 0, 1) != '#') ? '#' . $img_bg_color : $img_bg_color;
            $img_bg_color = (strlen($img_bg_color) == 4) ? ('#' . $img_bg_color{1} . $img_bg_color{1} . $img_bg_color{2} . $img_bg_color{2} . $img_bg_color{3} . $img_bg_color{3}) : $img_bg_color;
            $img_bg_color = (strlen($img_bg_color) != 7) ? '#FFFFFF' : $img_bg_color;
            $color        = imagecolorallocate($this->imageResized, hexdec('0x' . $img_bg_color{1} . $img_bg_color{2}), hexdec('0x' . $img_bg_color{3} . $img_bg_color{4}), hexdec('0x' . $img_bg_color{5} . $img_bg_color{6}));
            imagefill($this->imageResized, 0, 0, $color);
          }

          // imagealphablending($this->imageResized, true);
          imagecopyresampled($this->imageResized, $this->image,
                             $start_dst_x, $start_dst_y,
                             0, 0,
                             $optimalWidth, $optimalHeight,
                             $this->width, $this->height);

          // *** if option is 'crop', then crop too
          if ($resizingType == 'crop') {
            $this->crop($optimalWidth, $optimalHeight,
                        $newWidth, $newHeight,
                        $vcrop_align, $hcrop_align,
                        $focal_point, $start_src_x, $start_src_y);
          }
        }
      }

      ## --------------------------------------------------------

      private function getDimensions($newWidth, $newHeight, $resizingType)
      {
        switch ($resizingType) {
          case 'exact':
            $optimalWidth  = $newWidth;
            $optimalHeight = $newHeight;
            break;
          case 'portrait':
            $optimalWidth  = $this->getSizeByFixedHeight($newHeight);
            $optimalHeight = $newHeight;
            break;
          case 'landscape':
            $optimalWidth  = $newWidth;
            $optimalHeight = $this->getSizeByFixedWidth($newWidth);
            break;
          case 'auto':
            $optionArray   = $this->getSizeByAuto($newWidth, $newHeight);
            $optimalWidth  = $optionArray[ 'optimalWidth' ];
            $optimalHeight = $optionArray[ 'optimalHeight' ];
            break;
          case 'crop':
            $optionArray   = $this->getOptimalCrop($newWidth, $newHeight);
            $optimalWidth  = $optionArray[ 'optimalWidth' ];
            $optimalHeight = $optionArray[ 'optimalHeight' ];
            break;
          case 'scaletowidth':
            // Reduce height proportionately
            if ($newWidth > $this->width) {
              $optimalWidth  = $this->width;
              $optimalHeight = $this->height;
            } else {
              $optimalHeight = $newWidth / $this->width * $this->height;
              $optimalWidth  = $newWidth;
            }
            break;
          case 'scaletoheight':
            // Reduce width proportionately
            $optimalWidth  = $newHeight / $this->height * $this->width;
            $optimalHeight = $newHeight;
            if ($optimalWidth > $this->width) {
              $optimalWidth  = $this->width;
              $optimalHeight = $this->height;
            }
            break;
        }
        //	var_dump($optimalWidth);
        //	var_dump($optimalHeight);


        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
      }

      ## --------------------------------------------------------

      private function getSizeByFixedHeight($newHeight)
      {
        $ratio    = $this->width / $this->height;
        $newWidth = $newHeight * $ratio;

        return $newWidth;
      }

      private function getSizeByFixedWidth($newWidth)
      {
        $ratio     = $this->height / $this->width;
        $newHeight = $newWidth * $ratio;

        return $newHeight;
      }

      private function getSizeByAuto($newWidth, $newHeight)
      {
        if ($this->height < $this->width) // *** Image to be resized is wider (landscape)
        {
          $optimalWidth  = $newWidth;
          $optimalHeight = $this->getSizeByFixedWidth($newWidth);
        } elseif ($this->height > $this->width) // *** Image to be resized is taller (portrait)
        {
          $optimalWidth  = $this->getSizeByFixedHeight($newHeight);
          $optimalHeight = $newHeight;
        } else // *** Image to be resizerd is a square
        {
          if ($newHeight < $newWidth) {
            $optimalWidth  = $newWidth;
            $optimalHeight = $this->getSizeByFixedWidth($newWidth);
          } else {
            if ($newHeight > $newWidth) {
              $optimalWidth  = $this->getSizeByFixedHeight($newHeight);
              $optimalHeight = $newHeight;
            } else {
              // *** Sqaure being resized to a square
              $optimalWidth  = $newWidth;
              $optimalHeight = $newHeight;
            }
          }
        }

        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
      }

      ## --------------------------------------------------------

      private function getOptimalCrop($newWidth, $newHeight)
      {

        $heightRatio = $this->height / $newHeight;
        $widthRatio  = $this->width / $newWidth;

        if ($heightRatio < $widthRatio) {
          $optimalRatio = $heightRatio;
        } else {
          $optimalRatio = $widthRatio;
        }

        $optimalHeight = $this->height / $optimalRatio;
        $optimalWidth  = $this->width / $optimalRatio;

        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
      }

      ## --------------------------------------------------------

      private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight, $vcrop_align, $hcrop_align, $focal_point, $start_src_x, $start_src_y)
      {
        if (!empty($focal_point)) {
          $cropStartX = $start_src_x;
          $cropStartY = $start_src_y;
        } else {
          switch ($vcrop_align) {
            case "center":
            case "centre":
              $cropStartY = (int)(($optimalHeight / 2) - ($newHeight / 2));
              break;
            case "top":
              $cropStartY = 0;
              break;
            case "topquarter":
              $cropStartY = (int)(($newHeight >= $optimalHeight) ? 0 : $optimalHeight * .25);
              break;
            case "bottom":
              $cropStartY = (int)($optimalHeight - $newHeight);
              break;
            case "bottomquarter":
              $cropStartY = (int)(($newHeight >= $optimalHeight) ? ($optimalHeight - $newHeight) : ($optimalHeight - $newHeight - $optimalHeight * .25));
              break;

          }
          switch ($hcrop_align) {
            case "center":
            case "centre":
              $cropStartX = (int)(($optimalWidth / 2) - ($newWidth / 2));
              break;
            case "left":
              $cropStartX = 0;
              break;
            case "leftquarter":
              $cropStartX = (int)(($newWidth >= $optimalWidth) ? 0 : $optimalWidth * .25);
              break;
            case "right":
              $cropStartX = (int)($optimalWidth - $newWidth);
              break;
            case "rightquarter":
              $cropStartX = (int)(($newWidth >= $optimalWidth) ? ($optimalWidth - $newWidth) : ($optimalWidth - $newWidth - $optimalWidth * .25));
              break;
          }
        }
        // Tidy up an exceeding of boundaries.
        $cropStartY = ($cropStartY + $newHeight > $optimalHeight) ? $optimalHeight - $newHeight : $cropStartY;
        $cropStartY = ($cropStartY < 0) ? 0 : $cropStartY;
        $cropStartX = ($cropStartX + $newWidth > $optimalWidth) ? $optimalWidth - $newWidth : $cropStartX;
        $cropStartX = ($cropStartX < 0) ? 0 : $cropStartX;

        $crop = $this->imageResized;
        //imagedestroy($this->imageResized);

        // *** Now crop from center to exact requested size but preserve any transparency!
        $this->imageResized = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($this->imageResized, false);
        imagesavealpha($this->imageResized, true);
        $color = imagecolorallocatealpha($this->imageResized, 0, 200, 0, 127);
        imagecopyresampled($this->imageResized, $crop,
                           0, 0,
                           $cropStartX, $cropStartY,
                           $newWidth, $newHeight,
                           $newWidth, $newHeight);

      }

      ## --------------------------------------------------------

      public function saveImage($savePath, $imageQuality = "100")
      {
        // *** Get extension
        $extension = strrchr($savePath, '.');
        $extension = strtolower($extension);

        switch ($extension) {
          case '.jpg':
          case '.jpeg':
            if (imagetypes() & IMG_JPG) {
              imagejpeg($this->imageResized, $savePath, $imageQuality) or die('Unable to save new image');
            }
            break;

          case '.gif':
            if (imagetypes() & IMG_GIF) {
              imagegif($this->imageResized, $savePath) or die('Unable to save new image');
            }
            break;

          case '.png':
            // *** Scale quality from 0-100 to 0-9
            $scaleQuality = round(($imageQuality / 100) * 9);

            // *** Invert quality setting as 0 is best, not 9
            $invertScaleQuality = 9 - $scaleQuality;

            if (imagetypes() & IMG_PNG) {
              imagealphablending($this->imageResized, false);
              imagesavealpha($this->imageResized, true);
              imagepng($this->imageResized, $savePath, $invertScaleQuality) or die('Unable to save new image');
            }
            break;

          // ... etc

          default:
            // *** No extension - No save.
            break;
        }

      }

      function __destruct()
      {
        if (!empty($this->imageResized)) {
          imagedestroy($this->imageResized);
        }
        //reset memory
        ini_set('memory_limit', $this->memory_limit);
      }


      ## --------------------------------------------------------

    }
  }
