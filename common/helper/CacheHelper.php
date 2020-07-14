<?php

namespace common\helper;

use Yii;

class CacheHelper
{
    const REDIS_EXPIRE_DEFAULT = '1800';

    const REDIS_AA_TO_BB_MAP = 'aaToBbMap';

    /**
     * 设置redis缓存
     *
     * @param $cacheKey
     * @param $data
     * @param $expiredTime
     */
    public static function setRedisCache($cacheKey, $data, $expiredTime)
    {
        $redis = Yii::$app->redis;
        if ($redis->getIsActive()) {
            $redis->set($cacheKey, serialize($data));
            $redis->expire($cacheKey, $expiredTime);
        }
        else {
            Yii::error('redis is not active', __METHOD__);
        }
    }

    /**
     * 获取缓存
     *
     * @param string $cacheKey
     *
     * @return array|mixed
     */
    public static function getRedisCache($cacheKey)
    {
        $redis = Yii::$app->redis;
        $data  = [];

        //  兼容 redis 连接失败
        if (!$redis->getIsActive()) {
            return $data;
        }

        $redisData = $redis->get($cacheKey);
        if ($redisData) {
            $data = unserialize($redisData);
        }

        return $data;
    }

    /**
     * 获取缓存
     *
     * @param string     $cacheKey
     * @param int|string $index
     *
     * @return string|mixed
     */
    public static function getRedisCacheValue($cacheKey, $index)
    {
        $data = self::getRedisCache($cacheKey);

        return isset($data[$index]) ? $data[$index] : '-';
    }

    /**
     * 获取 Ab => Bb 映射集
     *
     * @param null|int|string $index
     * @param bool            $reset
     *
     * @return array|mixed|string
     */
    public static function getAaToBbMap($index = null, $reset = false)
    {
        $cacheKey = self::REDIS_AA_TO_BB_MAP;
        $data     = self::getRedisCache($cacheKey);

        if (empty($data) || $reset) {
            //  没有缓存则设置缓存
            $data = ['获取缓存的数据源'];

            self::setRedisCache($cacheKey, $data, self::REDIS_EXPIRE_DEFAULT);
        }

        return $data;
    }

}
