<?php
/**
 * Created by PhpStorm.
 * User: guest123
 * Date: 2019/9/20
 * Time: 17:34
 */
namespace common\traits;

/**
 * Trait MigrationOptionsTrait 获取数据库 表引擎 对应的 options
 * @package common\traits
 */
trait MigrationOptionsTrait
{
    public function getOptions($engine = '')
    {
        switch ($this->db->driverName) {
            case 'mysql':
                return $this->getMysqlOptions($engine);
            case '':
            default :
                return null;
        }
    }

    /**
     * 获取MySQL表的options
     * @param $engine
     *
     * @return string|null
     */
    private function getMysqlOptions($engine)
    {
        switch ($engine) {
            case 'InnoDB':
                $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                break;
            case 'MyISAM':
                $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=MyISAM';
                break;
            case 'MEMORY':
                $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=MEMORY';
                break;
            case 'CSV':
                $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=CSV';
                break;
            default:
                $options = null;
                break;
        }

        return $options;
    }
}
