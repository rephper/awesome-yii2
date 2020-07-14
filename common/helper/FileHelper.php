<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/15 0015
 * Time: 15:14
 */

namespace common\helper;

use moonland\phpexcel\Excel;
use Yii;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

class FileHelper extends \yii\helpers\FileHelper
{
    public static function clearDirectory($dir, $options = [])
    {
        $keepDir = false;
        if (!is_dir($dir)) {
            return;
        }
        if (isset($options['traverseSymlinks']) && $options['traverseSymlinks'] || !is_link($dir)) {
            if (!($handle = opendir($dir))) {
                return;
            }

            while (($file = readdir($handle)) !== false) {
                if ($file === '.' || $file === '..') {
                    continue;
                }
                if ($file == '.gitignore') {
                    $keepDir = true;
                    continue;
                }
                $path = $dir . DIRECTORY_SEPARATOR . $file;
                if (is_dir($path)) {
                    static::clearDirectory($path, $options);
                    if (count(scandir($path)) == 2) {
                        rmdir($path);
                    }
                }
                else {
                    try {
                        unlink($path);
                    }
                    catch (ErrorException $e) {
                        if (DIRECTORY_SEPARATOR === '\\') {
                            // last resort measure for Windows
                            $lines = [];
                            exec("DEL /F/Q \"$path\"", $lines, $deleteError);
                        }
                        else {
                            throw $e;
                        }
                    }
                }
            }

            closedir($handle);
        }
    }

    /**
     * 复制文件
     *
     * @param $source
     * @param $dest
     *
     * @return bool
     */
    public static function copyFile($source, $dest)
    {
        if (empty($dest)) {
            echo '目标地址不能为空 $source = ' . $source . PHP_EOL;

            return false;
        }

        $realpathSource = realpath($source);
        if (empty($realpathSource)) {
            echo '原始文件不存在 $source = ' . $source . PHP_EOL;

            return false;
        }

        return copy($realpathSource, $dest);
    }

    /**
     * 下载文件
     *
     * @param string $file     要下载的文件
     * @param string $fileName 下载后显示的文件名
     *
     * @throws BadRequestHttpException
     */
    public static function download($file, $fileName)
    {
        $file = self::normalizePath($file);
        $file = iconv('UTF-8', 'GB2312', $file);
        if (!file_exists($file)) {
            throw new BadRequestHttpException('指定的文件' . $file . '不存在', 2);
        }

        $buffer   = 1024;
        $fp       = fopen($file, 'rb');
        $fileSize = filesize($file);

        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length: " . $fileSize);
        Header("Content-Length: " . $fileSize);
        Header("Content-Disposition: attachment; filename=" . $fileName);

        $fileCount = 0;
        ob_clean();
        flush();
        while (!feof($fp) && $fileCount < $fileSize) {
            $file_con  = fread($fp, $buffer);
            $fileCount += $buffer;
            echo $file_con;
        }
        fclose($fp);
    }

    /**
     * 导入文件
     *
     * @return string
     * @throws BadRequestHttpException
     */
    public static function import()
    {
        $file = UploadedFile::getInstanceByName('file');

        if (empty($file)) {
            throw new BadRequestHttpException('导入文件不存在');
        }

        if ($file->extension != 'xlsx' && $file->extension != 'xls') {
            throw new BadRequestHttpException('导入文件是存在Excel格式');
        }
        $time = date('Ymd-His');

        $filePath = 'uploads/' . $time . $file->baseName . '.' . $file->extension;

        Yii::warning('filePath' . VarDumper::dumpAsString($filePath), __METHOD__);
        $file->saveAs($filePath);
        $data = Excel::import($filePath);
        unlink($filePath);

        return $data;
    }

    /**
     * 通用文件上传
     * @param string $dir
     * @param string $imgName
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public static function commonUploadFile($dir = '', $imgName = '')
    {

        $allowImgExt = ['doc', 'docx', 'pdf', 'jpg', 'jpeg', 'png', 'bmp'];
        $allowImgType = [
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/pdf',
            'image/jpg',
            'image/jpeg',
            'image/png',
            'image/pjpeg',
            'image/gif',
            'image/bmp',
            'image/x-png',
            'bmp' => 'image/bmp',
        ];

        $file = UploadedFile::getInstanceByName('file');
        if (empty($file)) {
            $errMsg = '上传的文件不存在';
            Yii::warning($errMsg, __METHOD__);
            throw new BadRequestHttpException($errMsg, 1);
        }

        $fileType = strtolower($file->type);
        if (!in_array($fileType, $allowImgType)) {
            $errMsg = '文件格式不正确，当前只支持' . implode(',', $allowImgExt);
            Yii::warning($errMsg, __METHOD__);
            throw new BadRequestHttpException($errMsg, 2);
        }

        if (!in_array($file->extension, $allowImgExt)) {
            $errMsg = '您只能上传以下类型文件' . implode(',', $allowImgExt);
            Yii::warning($errMsg, __METHOD__);
            throw new BadRequestHttpException($errMsg, 3);
        }

        $baseDir = '/alidata/www/m.xiaomei360.com/';
        if (empty($dir)) {
            $extDir = 'data/attached/contract-file/' . date('Ymd');
        } else {
            $extDir = 'data/attached/' . $dir;
        }

        $pathname  = $baseDir . $extDir;
        if (!is_dir($pathname)) {
            mkdir($pathname, 0777, true);
        }
        if (empty($imgName)) {
            $savePath = $extDir . '/' . time() . rand(100000, 999999) . '.' . $file->extension;
        } else {
            $savePath = $extDir . '/' . $imgName . '.' . $file->extension;
        }

        if (!$file->saveAs($baseDir . $savePath)) {
            Yii::warning('文件保存失败' . VarDumper::dumpAsString($file), __METHOD__);
            throw new ServerErrorHttpException('文件保存失败', 4);
        }

        //  TODO fileResource 记录入库
        $fileResourceId= 1;

        return [
            'id' => $fileResourceId,
            'url' => sefl::getFileUrl($savePath),
        ];
    }

    /**
     * 获取文件的访问地址
     * @param $filePath
     *
     * @return string|string[]
     */
    public function getFileUrl($filePath)
    {
        return str_replace(Yii::getAlias('@imgRoot'), 'https://img.xiaomei360.com', $filePath);
    }
}
