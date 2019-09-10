<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/17
 * Time: 15:43
 * 图片上传类
 */

namespace libs;


class Upload
{
    //默认上传文件大小
    private $fileMaxSize = '';

    /**
     * @return float|int|string
     */
    public function getfileMaxSize()
    {
        return $this->fileMaxSize;
    }

    /**
     * @param float|int|string $fileMaxSize
     */
    private function setfileMaxSize($fileMaxSize)
    {
        $this->fileMaxSize = $fileMaxSize;
    }

    /**
     * @return array
     */
    public function getAllows()
    {
        return $this->allows;
    }

    /**
     * @param array $allows
     */
    private function setAllows($allows)
    {
        $this->allows = $allows;
    }

    //默认上传限制文件类型
    private $allows = array('image/jpeg', 'image/png');

    public function __construct($fileMaxSize = 2 * 1024 * 1024, $allows = array('image/jpeg', 'image/png'))
    {
        $this->fileMaxSize = $fileMaxSize;
        $this->allows = $allows;
    }

    /*
     * @param file 文件
     * @param path 文件存放路径
     * @param array json 文件路径信息 状态码
     * editor图片上传方法
     */
    public function uploadEditor($file, $path)
    {
        //获取图片

        if ($file['error'] > 0) {
            exit(json_encode(array('errno' => 1, 'data' => array())));
        }

        if (!$this->vertifyType($file, $this->allows)) {
            return (json_encode(['errno' => 1, 'data' => array()]));
        }
        //限制文件大小
        if ($file['size'] > ($this->fileMaxSize)) {
            exit(json_encode(['errno' => 1, 'data' => array()]));
        }

        //图片上传到服务器
        if (move_uploaded_file($file['tmp_name'], $path . '/' . date('Ymd His', time()) . $file['name'])) {
            exit(json_encode(array('errno' => 0, 'data' => [$path . '/' . date('Ymd His', time()) . $file['name']])));
        } else {
            exit(json_encode(['errno' => 1, 'data' => array()]));
        }
    }

    /*
     * @param File file 上传图片文件
     * @param string path 图片文件类型
     * @return array|boolean 上传状态码以及错误信息 1代表成功  0代表失败 -1代表未修改头像
     */
    public function uploadImg($file, $path)
    {
        $msg = '上传过程发生错误,错误原因:';
        $code = '';
        $url = '';
        if ($file['error'] != 0) {
            $code = 0;
            if ($file['error'] == 1) $msg .= '上传文件超出服务器限制值';
            if ($file['error'] == 2) $msg .= '上传文件超出表单限制值';
            if ($file['error'] == 3) $msg .= '上传文件只有部分被上传';
            if ($file['error'] == 4) {
                $msg .= '没有任何上传文件';
                $code = -1;
            }
            if ($file['error'] > 4) $msg .= '上传过程发生未知错误';
        } else {
            //验证类型
            if (!$this->vertifyType($file, $this->allows)) {
                $msg .= '上传文件类型不允许！';
                $code = 0;
                return ['code' => $code, 'msg' => $msg, 'url' => $url];
            }
            //验证上传文件大小
            if ($file['size'] > $this->fileMaxSize) {
                $msg .= '上传文件过大！';
                $code = 0;
                return ['code' => $code, 'msg' => $msg, 'url' => $url];
            }
            //图片上传到服务器
            if (move_uploaded_file($file['tmp_name'], $path . '/' . date('Ymd His', time()) . $file['name'])) {
                $code = 1;
                $msg = '上传成功';
                $url = $path . '/' . date('Ymd His', time()) . $file['name'];
            } else {
                $code = 0;
                $msg .= '上传服务器失败！';
            }
        }

        return ['code' => $code, 'msg' => $msg, 'url' => $url];

    }

    /*
     * 验证格式
     * @param array 上传文件是否在合法类型中
     * @return boolean
     */
    private function vertifyType($file, $allows)
    {
        $fi = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $fi->file($file['tmp_name']);
        if (in_array($mimeType, $this->allows)) return true;
        return false;
    }

}