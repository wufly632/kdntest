<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/18 上午1:38
 */

/**
 * js提交表单数据提示。
 * @param string $error
 * @param string $url
 */
function jsonMessage($error, $url='')
{
    header('Access-Control-Allow-Origin:*');
    if (!empty($error)) {
        if (is_array($error)) {
            $json = array('status'=>false, 'messages'=>implode('\\n', $error));
        } else {
            $json = array('status'=>false, 'messages'=>$error);
        }
    } else {
        $json = array('status'=>true, 'messages'=>$url);
    }

    return response()->json($json);
}

/**
 * @function 显示切割图
 * @param $url
 * @param $size
 * @return string
 */
function ImgResize($url, $size)
{
    return $url.'?x-oss-process=style/'.$size.'-'.$size;
}