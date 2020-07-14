<?php

namespace common\helper;

use yii\web\Response;
use \Yii;

class OfficeHelper
{
    /**
     * 导出Excel表格
     *
     * @param string $file_name   文件名
     * @param string $data_array  数据
     * @param string $style_array 样式
     * @param string $sheetTitle
     * @param bool   $defaultFormat
     *
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Writer_Exception
     */
    public static function excelExport(
        $file_name = '',
        $data_array = '',
        $style_array = '',
        $sheetTitle = '',
        $defaultFormat = true
    ) {
        Yii::trace(__FUNCTION__ . '导出用户列表——调用导出开始');
        $objectPHPExcel = new \PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);
        $cacheMethod = \PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
        \PHPExcel_Settings::setCacheStorageMethod($cacheMethod);
        Yii::trace(__FUNCTION__ . '导出用户列表——创建 $objectPHPExcel 对象成功');
        $row = 1;
        foreach ($data_array as $data) {
            $col = 0;
            foreach ($data as $item) {
                $item = trim($item);
                if ($defaultFormat) {
                    $objectPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $item,\PHPExcel_Cell_DataType::TYPE_STRING );
                }
                //excel大于11位会变成科学技术法 这里是兼容处理 条码一般都是多位数 所以这里转换下
                if($item > 10000000000){
                    $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($col);
                    $coordinate = $columnLetter . $row;
                    $objectPHPExcel->getActiveSheet()->setCellValueExplicit($coordinate, $item,\PHPExcel_Cell_DataType::TYPE_STRING );
                }
                $col++;
            }
            $row++;
        }

        if (!empty($sheetTitle)) {
            $objectPHPExcel->getActiveSheet()
                ->setTitle($sheetTitle);
        }

        ob_end_clean();
        ob_start();
        Yii::trace(__FUNCTION__ . '导出用户列表——填充excel表格成功');
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-Type', 'application/msexcel');
        Yii::$app->response->headers->set('Access-Control-Expose-Headers', 'Content-Disposition');
        header('Content-Disposition:attachment;filename=' . $file_name . '.xlsx');
        $objWriter = new \PHPExcel_Writer_Excel2007($objectPHPExcel);
        $objWriter->save('php://output');
        Yii::trace(__FUNCTION__ . '导出用户列表——输出excel表格成功');
    }

    public static function excelExportPurchaseOrder(
        $file_name = '',
        $data_array = '',
        $style_array = '',
        $sheetTitle = '',
        $defaultFormat = true
    ) {
        Yii::trace(__FUNCTION__ . '导出用户列表——调用导出开始');
        $objectPHPExcel = new \PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);

        if (!empty($style_array['row'])) {
            foreach ($style_array['row'] as $cell) {
                $objectPHPExcel->getActiveSheet()
                    ->getRowDimension($cell)
                    ->setRowHeight($style_array['height']);
            }
        }

        if (!empty($style_array['col'])) {
            foreach ($style_array['col'] as $cell) {
                $objectPHPExcel->getActiveSheet()
                    ->getColumnDimension($cell)
                    ->setAutoSize($style_array['width']);
            }
        }

        if (!empty($style_array['cell'])) {
            foreach ($style_array['cell'] as $cell) {
                $objectPHPExcel->getActiveSheet()
                    ->getStyle($cell)
                    ->getAlignment()
                    ->setWrapText(true);
            }
        }

        if (!empty($style_array['bindCell'])) {
            foreach ($style_array['bindCell'] as $cell) {
                $objectPHPExcel->getActiveSheet()
                    ->mergeCells($cell);
            }
        }

        $cacheMethod = \PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
        \PHPExcel_Settings::setCacheStorageMethod($cacheMethod);
        Yii::trace(__FUNCTION__ . '导出用户列表——创建 $objectPHPExcel 对象成功');
        $row = 1;
        foreach ($data_array as $data) {
            $col = 0;
            foreach ($data as $item) {
                if ($defaultFormat) {
                    $objectPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow($col, $row, $item);
                }
                else {
                    $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($col);
                    $coordinate   = $columnLetter . $row;
                    $objectPHPExcel->getActiveSheet()
                        ->setCellValueExplicit($coordinate, $item);
                }
                $col++;
            }
            $row++;
        }

        if (!empty($sheetTitle)) {
            $objectPHPExcel->getActiveSheet()
                ->setTitle($sheetTitle);
        }

        ob_end_clean();
        ob_start();
        Yii::trace(__FUNCTION__ . '导出用户列表——填充excel表格成功');
        header('Content-Type : application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename=' . $file_name . '.csv');
        $objWriter = new \PHPExcel_Writer_Excel2007($objectPHPExcel);
        $objWriter->save('php://output');
        Yii::trace(__FUNCTION__ . '导出用户列表——输出excel表格成功');
    }

    /**
     * 导出CSV 格式
     * @param array  $data
     * @param string $fileName
     * @param array  $headerList
     * @param array  $tmp
     */
    public static function exportCsv($data = [], $fileName = '', $headerList = [], $tmp = [])
    {
        //文件名称转码
        $fileName = iconv('UTF-8', 'GBK', $fileName);
        //设置header头
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-Type', 'application/msexcel');
        Yii::$app->response->headers->set('Access-Control-Expose-Headers', 'Content-Disposition');
        header('Content-Disposition: attachment;filename=' . $fileName . '.csv');
        header('Cache-Control: max-age=0');
        //打开PHP文件句柄,php://output,表示直接输出到浏览器
        $fp = fopen("php://output", "a");
        //备用信息
        foreach ($tmp as $key => $value) {
            $tmp[$key] = iconv("UTF-8", 'GBK', $value);
        }
        //使用fputcsv将数据写入文件句柄

        fputcsv($fp, $tmp);
        //输出Excel列表名称信息
        foreach ($headerList as $key => $value) {
            $headerList[$key] = iconv('UTF-8', 'GBK', $value);//CSV的EXCEL支持BGK编码，一定要转换，否则乱码
        }
        //使用fputcsv将数据写入文件句柄
        fputcsv($fp, $headerList);
        //计数器
        $num = 0;
        //每隔$limit行，刷新一下输出buffer,不要太大亦不要太小
        $limit = 100000;
        //逐行去除数据,不浪费内存
        $count = count($data);
        ob_clean();
        for ($i = 0; $i < $count; $i++) {
            $num++;
            //刷新一下输出buffer，防止由于数据过多造成问题
            if ($limit == $num) {
                ob_flush();
                flush();
                $num = 0;
            }
            $row = $data[$i];
            foreach ($row as $key => $value) {
                $row[$key] = iconv('utf-8', 'gbk//TRANSLIT//IGNORE', $value);
            }
            fputcsv($fp, $row);
        }
    }

}
