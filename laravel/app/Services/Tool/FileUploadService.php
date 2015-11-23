<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 15-8-7
 * Time: 上午9:11
 */
namespace App\Services\Tool;
use App\Services\BaseService;
class FileUploadService extends BaseService
{
    /**
     * @var FileUploadService
     */
    private static $self = NULL;

    static public function instance()
    {
        if (is_null(self::$self)) {
            self::$self = new self();
        }
        return self::$self;
    }

    private $fileName;

    private $fileSize;

    private $errorMsg;

    /**
     * 获取上传文件路径和名称
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * 获取文件上传大小 单位是“字节”
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * 获取错误内容
     */
    public function getError()
    {
        return $this->errorMsg;
    }

    /**
     * 上传文件
     * @param $formFileName form表单的属性名称
     * @param $realPath 要上传的目录
     * @param $allowType 允许的文件类型
     * @param $allowSize 单位是 M
     * @return bool
     */
    public function uploadFile($formFileName, $realPath, array $allowType, $allowSize)
    {
        $file = Input::file($formFileName);
        //检查文件类型
        $suffix = $file->getClientOriginalExtension();
        if (!in_array($suffix, $allowType)) {
            $this->errorMsg = Lang::get('common.file_upload.file_type_not_allow');
            return false;
        }

        //检查文件大小
        $size = $file->getSize(); //文件大小单位是bit(字节)
        if ($size > $allowSize * 1024 * 1024) {
            $this->errorMsg = Lang::get('common.file_upload.file_size_limit') . $allowSize . 'M';
            return false;
        }

        //检查是否存在上传的目录
        if (!file_exists($realPath)) {
            $this->errorMsg = Lang::get('common.file_upload.file_dir_not_exists');
            return false;
        }

        //移动文件到真实目录中
        $newName = time() . '_' . mt_rand(1000, 9999) . '.' . $suffix;
        try{
            $file->move($realPath, $newName);
        }catch (Exception $e){
            return $e->getMessage();
            $this->errorMsg = Lang::get('common.file_upload.upload_file_fail');
            return false;
        }


        $this->fileName = $newName;
        $this->fileSize = $size;;
        return true;

    }


} 