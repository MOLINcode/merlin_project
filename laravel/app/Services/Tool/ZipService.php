<?php
/**
 * @author ciogao@gmail.com
 * Date: 14-7-25 下午2:57
 */
class ZipService extends BaseService
{
    private static $self = NULL;

    /**
     *
     * @return ZipService
     */
    static public function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }

        return self::$self;
    }

    private $relativePath = NULL;
    private $rawPath = NULL;
    private $rawPathLength = 0;

    /**
     * 压缩目录
     * @param $path
     * @param $sZipFilePath
     * @param $relativePath
     * @param array $aOerWriteFile
     * @throws Exception
     * @return bool
     */
    public function zip($path, $sZipFilePath, $relativePath, $aOerWriteFile = array())
    {
        if (file_exists($sZipFilePath)) {
            return TRUE;
        }

        $this->relativePath  = $relativePath;
        $this->rawPath       = $path;
        $this->rawPathLength = strlen($path);

        try {
            $zip = new ZipArchive();
            if ($zip->open($sZipFilePath, ZipArchive::OVERWRITE) === TRUE) {
                self::addFileToZip($path, $zip);

                if (is_array($aOerWriteFile) && count($aOerWriteFile) > 0) {
                    foreach ($aOerWriteFile as $fileName => $fileContent) {
                        self::addFileFromString($zip, $fileName, $fileContent);
                    }
                }

                $zip->close();
            } else {
                return FALSE;
            }
        } catch (Exception $e) {
            //@todo log it
            throw $e;
        }

        return TRUE;
    }

    /**
     * 向压缩包中创建一个新文件
     * @param $zip
     * @param $sFileName
     * @param $sFileContent
     * @return bool
     * @throws Exception
     */
    public function addFileFromString(&$zip, $sFileName, $sFileContent)
    {
        try {
            $zip->addFromString($sFileName, $sFileContent);
        } catch (Exception $e) {
            //@todo log it
            throw $e;
        }

        return TRUE;

    }

    /**
     * 解压一个zip到指定文件夹
     * @param $sZipFilePath
     * @param $sExtractTo
     * @return bool
     * @throws Exception
     */
    public function unzip($sZipFilePath, $sExtractTo)
    {
        if (!file_exists($sZipFilePath)) {
            return FALSE;
        }

        try {
            $zip = new ZipArchive();
            $zip->open($sZipFilePath);
            $zip->extractTo($sExtractTo);
            $zip->close();

        } catch (Exception $e) {
            //@todo log it
            throw $e;
        }

        return TRUE;
    }

    /**
     * 从压缩包中读取文件内容
     *
     * 先尝试读取根目录下的sReadFilePath, 如空, 再尝试读取根目录下与压缩包的同名目录下的sReadFilePath
     *
     * @param $sZipFilePath
     * @param $sReadFilePath
     * @return bool|mixed
     * @throws Exception
     */
    public function getFileContentByName($sZipFilePath, $sReadFilePath)
    {
        if (!file_exists($sZipFilePath)) {
            return FALSE;
        }

        try {
            $zip = new ZipArchive();
            $zip->open($sZipFilePath);

            $content = $zip->getFromName($sReadFilePath);

            if (!$content || empty($content)) {
                $aPathInfo     = pathinfo($sZipFilePath);
                $sReadFilePath = $aPathInfo['filename'] . '/' . $sReadFilePath;

                $content = $zip->getFromName($sReadFilePath);

            }

            $zip->close();

        } catch (Exception $e) {
            //@todo log it
            throw $e;
        }

        return $content;
    }

    private function processRelativeName($pathOrFileName)
    {
        $pathOrFileName = substr($pathOrFileName, $this->rawPathLength);

        return $this->relativePath . $pathOrFileName;
    }

    private function addFileToZip($path, &$zip)
    {
        $handler = opendir($path);
        while (($filename = readdir($handler)) !== FALSE) {
            if ($filename != "." && $filename != "..") {
                $rawPath = $path . "/" . $filename;
                if (is_dir($rawPath)) {
                    $zip->addEmptyDir($this->processRelativeName($rawPath));
                    self::addFileToZip($rawPath, $zip);
                } else {
                    $zip->addFile($rawPath, $this->processRelativeName($rawPath));
                }
            }
        }
        @closedir($path);
    }

}