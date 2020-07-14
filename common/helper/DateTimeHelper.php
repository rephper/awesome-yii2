<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/7
 * Time: 16:10
 */

namespace common\helper;

class DateTimeHelper
{
    const TIME_ZONE = 8;

    const DAYS_PER_WEEK = 7;
    const DAYS_TWO_WEEK = 14;

    const ONE_MINUTE = 60;
    const ONE_HOUR   = 3600;
    const TWO_HOUR   = 7200;
    const ONE_DAY    = 86400;

    const DIVIDE_TYPE_TOTAL      = 1;
    const DIVIDE_TYPE_MONTH      = 2;
    const DIVIDE_TYPE_HALF_MONTH = 3;
    const DIVIDE_TYPE_WEEK       = 4;


    /**
     * 转换成中国时区的日期
     *
     * @param integer $timestamp
     * @param string  $format
     *
     * @return bool|string
     */
    public static function getCnDate($timestamp = 0, $format = 'Y-m-d')
    {
        $timestamp = self::gmtToCst($timestamp);

        return date($format, $timestamp);
    }

    /**
     * 转换成中国时区的日期时间
     *
     * @param integer $timestamp
     * @param string  $format
     *
     * @return bool|string
     */
    public static function getCnDateTime($timestamp = 0, $format = 'Y-m-d H:i:s')
    {
        $timestamp = self::gmtToCst($timestamp);

        return date($format, $timestamp);
    }

    /**
     * 获取指定日期、时间的 开始时间点
     *
     * @param $date
     *
     * @return string
     */
    public static function getCnDateStart($date)
    {
        return substr($date, 0, 10) . ' 00:00:00';
    }

    /**
     * 获取指定日期、时间的 截止时间点
     *
     * @param $date
     *
     * @return string
     */
    public static function getCnDateEnd($date)
    {
        return substr($date, 0, 10) . ' 23:59:59';
    }

    /**
     * 获取当前的 时间戳+微秒数
     * @return float
     */
    public static function getMicroTime()
    {
        list($usec, $sec) = explode(" ", microtime());

        return ((float)$sec + (float)$usec);
    }

    /**
     * 获取两个时间的月份差 向上取整
     *
     * @param string $date1 日期：YYYY-mm-dd
     * @param string $date2 日期：YYYY-mm-dd   默认为当前日期
     * @param string $tar   分隔符
     *
     * @return number
     */
    public static function getDiffMonths($date1, $date2 = '', $tar = '-')
    {
        if (empty($date2)) {
            $date2 = date('Y-m-d');
        }

        $dateBig   = max($date1, $date2);
        $dateSmall = min($date1, $date2);
        $dateBig   = explode($tar, $dateBig);
        $dateSmall = explode($tar, $dateSmall);

        $diffMonth = ($dateBig[0] - $dateSmall[0]) * 12 + $dateBig[1] - $dateSmall[1];

        if ($dateBig[2] > $dateSmall[2]) {
            $diffMonth += 1;
        }

        return $diffMonth;
    }

    /**
     * 获取两个日期 的天数差 向上取整
     *
     * @param string $date1 日期：YYYY-mm-dd
     * @param string $date2 日期：YYYY-mm-dd 默认为当前日期
     * @param string $tar
     *
     * @return mixed
     * @throws \Exception
     */
    public static function getDiffDays($date1, $date2 = '', $tar = '-')
    {
        if (empty($date2)) {
            $date2 = date('Y-m-d');
        }

        $dateBig   = max($date1, $date2);
        $dateSmall = min($date1, $date2);

        $big   = new \DateTime($dateBig);
        $small = new \DateTime($dateSmall);

        $diff = $big->diff($small)->days;
        $diff += 1;

        return $diff;
    }

    /**
     * 格式化日期时间
     *
     * @param string $dataTime 日期时间格式
     * @param string $format
     *
     * @return false|string
     */
    public static function formatDateTime($dataTime, $format = 'Y-m-d')
    {
        return date($format, strtotime($dataTime));
    }

    /**
     * 按周期分割时间 倒序显示,默认整个时段 不拆分
     *
     * @param string $start
     * @param string $end
     * @param integer $type
     * @param string $format
     *
     * @return array
     * @throws \Exception
     */
    public static function divideDate($start, $end, $type = self::DIVIDE_TYPE_TOTAL, $format = 'md')
    {
        $periodList = [];

        switch ($type) {
            case self::DIVIDE_TYPE_WEEK:
                //  周日——周六 为一个周期  获取最后一周的周日，减去7天就是上1周的周日，
                $diffDays = self::getDiffDays($start, $end);
                $weekNums = ceil($diffDays / self::DAYS_PER_WEEK);

                $weekDayNo    = date('w', strtotime($end));
                $startStamp   = strtotime($end . ' -' . $weekDayNo . ' day');
                $weekStart    = date('Y-m-d', $startStamp);
                $periodList[] = [
                    'start' => self::formatDateTime($weekStart, $format),
                    'end'   => self::formatDateTime($end, $format),
                ];

                for ($i = 1; $i <= $weekNums; $i++) {
                    $endStamp   = $startStamp - 1;
                    $end        = date('Y-m-d', $endStamp);
                    $startStamp -= self::DAYS_PER_WEEK * self::ONE_DAY;

                    $weekStart = date('Y-m-d', $startStamp);
                    if ($weekStart <= $start) {
                        $periodList[] = [
                            'start' => self::formatDateTime($start, $format),
                            'end'   => self::formatDateTime($end, $format),
                        ];
                        break;
                    }
                    else {
                        $periodList[] = [
                            'start' => self::formatDateTime($weekStart, $format),
                            'end'   => self::formatDateTime($end, $format),
                        ];
                    }
                }
                break;
            case self::DIVIDE_TYPE_HALF_MONTH:
                //  1-15 为上半月，16-月底为下半月
                $monthDiff = self::getDiffMonths($start, $end);

                //  php 函数 算上个月 遇到2月份 有漏洞，这个月的开始(1号) -1天 得到上个月的月底
                $endStamp         = strtotime($end);
                $monthMiddleStart = date('Y-m-16', $endStamp);
                $lastMonthStart   = date('Y-m-01', $endStamp);
                //  首月
                if ($end >= $monthMiddleStart) {
                    //  首月下半月
                    $periodList[] = [
                        'start' => self::formatDateTime($monthMiddleStart, $format),
                        'end'   => self::formatDateTime($end, $format),
                    ];

                    //  首月上半月
                    $periodList[] = [
                        'start' => self::formatDateTime($lastMonthStart, $format),
                        'end'   => self::formatDateTime($end, str_replace('d', 15, $format)),
                    ];
                }
                else {
                    $periodList[] = [
                        'start' => self::formatDateTime($lastMonthStart, $format),
                        'end'   => self::formatDateTime($end, $format),
                    ];
                }

                for ($i = 0; $i <= $monthDiff; $i++) {
                    $endStamp         = strtotime($lastMonthStart . ' -1 day');
                    $end              = date('Y-m-d', $endStamp);
                    $monthMiddleStart = date('Y-m-16', $endStamp);
                    $lastMonthStart   = date('Y-m-01', $endStamp);

                    if ($start > $end) {
                        break;
                    }

                    if ($monthMiddleStart <= $start) {
                        $periodList[] = [
                            'start' => self::formatDateTime($start, $format),
                            'end'   => self::formatDateTime($end, $format),
                        ];
                        break;
                    }
                    else {
                        $periodList[] = [
                            'start' => self::formatDateTime($monthMiddleStart, $format),
                            'end'   => self::formatDateTime($end, $format),
                        ];

                        if ($lastMonthStart <= $start) {
                            $lastMonthStart = $start;
                            $periodList[]   = [
                                'start' => self::formatDateTime($lastMonthStart, $format),
                                'end'   => self::formatDateTime($end, 'm15'),
                            ];
                            break;
                        }
                        else {
                            $periodList[] = [
                                'start' => self::formatDateTime($lastMonthStart, $format),
                                'end'   => self::formatDateTime($end, 'm15'),
                            ];
                        }
                    }
                }
                break;
            case self::DIVIDE_TYPE_MONTH:
                $monthDiff = self::getDiffMonths($start, $end);

                //  php 函数 算上个月 遇到2月份 有漏洞，这个月的开始(1号) -1天 得到上个月的月底
                $lastMonthStart = date('Y-m-01', strtotime($end));

                $periodList[] = [
                    'start' => self::formatDateTime($lastMonthStart, $format),
                    'end'   => self::formatDateTime($end, $format),
                ];

                for ($i = 0; $i <= $monthDiff; $i++) {
                    $end            = date('Y-m-d', strtotime($lastMonthStart . ' -1 day'));
                    $lastMonthStart = date('Y-m-01', strtotime($end));

                    if ($start > $end) {
                        break;
                    }

                    if ($lastMonthStart <= $start) {
                        $periodList[] = [
                            'start' => self::formatDateTime($start, $format),
                            'end'   => self::formatDateTime($end, $format),
                        ];
                        break;
                    }
                    else {
                        $periodList[] = [
                            'start' => self::formatDateTime($lastMonthStart, $format),
                            'end'   => self::formatDateTime($end, $format),
                        ];
                    }
                }
                break;
            case self::DIVIDE_TYPE_TOTAL:
            default :
                $periodList[] = [
                    'start' => self::formatDateTime($start, $format),
                    'end'   => self::formatDateTime($end, $format),
                ];
        }

        return $periodList;
    }

    /**
     * 获得当前格林威治时间的时间戳
     *
     * @return  integer
     */
    public static function gmtime()
    {
        return (time() - date('Z'));
    }
}
