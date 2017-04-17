<?php
/**
 * 原理 ：1.打开图片，将图片载入到画布中
 *        2. 新建画布2，将画布一某些矩形区域，copy放到当前画布,设定宽高
 *          3.画布二保存为文件
 */

/**
 * 制作缩略图，制作图片水印
 * Class ImageZoom
 */
class ImageZoom{
    function getImageInfo($imgfile){
        $imgfile = "./public/uploads/".$imgfile;
        $arr = getimagesize($imgfile);
        $width = $arr[0];
        $height = $arr[1];
        $type_code = $arr[2];
        $arr_type  =array("","GIF","JPEG","PNG");
        $type = $arr_type[$type_code];     // 类型名 gif
        return array($width,$height,$type);
    }

    /**
     * 将图片取出，copy到另一个图片位置上，并对其设定透明度
     * imageCopyMerge(目标画布,水印画布,目标位置x,目标位置y,水印画布x,水印画布y
     *  水印画布采样区域宽，水印画布采样区域高)
     * @param $imgfile
     * @return string
     */
    function getimageStamp($imgfile){
        /**
         * 同时给三个变量赋值
         */
        list($width,$height,$type) = $this->getImageInfo($imgfile);
        $imgfile = "./public/uploads/".$imgfile;
        // 载入要进行加水印图片，得到画布
        $imgfunc = "imageCreateFrom" . $type;
        $img = $imgfunc($imgfile);

//        载入要当做水印的图，得到画布
        $img2 = imagecreatefromjpeg("./stamp.jpg");
        $width2 = imagesx($img2);       // 宽度
        $height2 = imagesy($img2);       // 高度
        imageCopyMerge($img,$img2,$width-$width2,$height-$height2,
            0,0,$width2,$height2,50);

        $file2 = $this->get_stamp_file($imgfile);
//        die('出错啦');
        $outFunc = "image" . $type;   // 要使用的输出函数名
        // 可变函数  imagegif   imagejpeg imagepng
        $outFunc($img,$file2);                      // 返回原图

        return $file2;

    }
    /**
     * @param $imgfile （原始图片路径）
     * @return string (对应小图路径)
     */
    function getimageZoom($imgfile){
        if($imgfile == ""){
            return "";
        }
        list($width,$height,$type) = $this->getImageInfo($imgfile);
        $imgfile = "./public/uploads/".$imgfile;
//        $img = imageCreateFromJpeg($imgfile);
        // 可变函数
        // 载入原始图，得到画布img
        $imgfunc = "imageCreateFrom" . $type;
        $img = $imgfunc($imgfile);


        //创建新画布2
        // 根据旧尺寸获得新的尺寸 数组
        $w_h_2 = $this->GetNewSize($width,$height);
        $width2 = $w_h_2[0];        // 新宽
        $height2 = $w_h_2[1];       // 新高
        $img2 = imagecreatetruecolor($width2,$height2);
        // 缩放
        // (目标画布,原画布,目标位置x，目标位置y,原图位置x,原图位置y)
        // (目标区域宽，高，原图区域宽高)
        imagecopyresampled($img2,$img,
        0,0,0,0,
        $width2,$height2,$width,$height);

        //
        $file2 =  $this->get_small_file($imgfile);
        //echo $file2;die;
        /*
        if($type == "GIF"){
            imagegif($img2,$file2);
        }elseif ($type == "JPEG"){
            imagejpeg($img2,$file2);
        }elseif($type == "PNG"){
            imagepng($img2,$file2);
        }
        */
        $outFunc = "image" . $type;   // 要使用的输出函数名
        // 可变函数  imagegif   imagejpeg imagepng
        $outFunc($img2,$file2);

        return $file2;

    }
    // 根据原始图获取新尺寸
    private function GetNewSize($w,$h){
        //todo
        if($w<=100 && $h<=100){
            return array($w,$h);
        }
        $radio = $w/$h; // 原始宽高比
        if($radio>=1){  // 此时宽度最后缩小为100
            $ratio_w = 100/$w;      // 假设$w =500
            $h_new = $h*$ratio_w;
            return array(100,$h_new);
        }else{          // 高度缩小为100
            $radio_h = 100/$h;
            $w_new = $w*$radio_h;
            return array($w_new,100);
        }

    }
    // 源文件 a.jpg ->a_samll.jpg
    private function get_small_file($file1){
        $pos = strrpos($file1,".");   // 获取最后一个点位置
        //    echo $pos;
        $qian = substr($file1,0,$pos); // 取.之前所有字符
        $hou = strrchr($file1,".");   // 返回后缀包括点
        $file2 = $qian."_small".$hou;                   // 区分源文件 加small
        return $file2;
    }
    private function get_stamp_file($file1){
        $pos = strrpos($file1,".");   // 获取最后一个点位置
        //    echo $pos;
        $qian = substr($file1,0,$pos); // 取.之前所有字符
        $hou = strrchr($file1,".");   // 返回后缀包括点
        $file2 = $qian."_stamp".$hou;                   // 区分源文件 加small
        return $file2;
    }
}

