<?php 
namespace Api\Plugin;
class Tableddlget {
    /**
     * 广播表语句
     */
    public static function broadcastTableDdl($tbname) {
        if(!$tbname) return false;
        $sql = "CREATE TABLE if not exists `{$tbname}` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                  `fromuser` varchar(32) NOT NULL,
                  `touser` text NOT NULL,
                  `touserTitle` varchar(500) NOT NULL,
                  `title` varchar(200) NOT NULL,
                  `content` varchar(1000) NOT NULL,
                  `time` int(11) NOT NULL,
                  PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        return $sql;
    }
    /**
     * 创建消息表语句
     * @param string $tbname
     */
    public static function msgTableDdl ($tbname) {
        if(!$tbname) return false;
        $sql = "CREATE TABLE if not exists `{$tbname}` (
        ".self::msgFieldStr()."
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
        return $sql;
    }
    
    /**
     * 创建的merge引擎 消息表的sql
     */
    public static function msgMergeTableDdl($tbname, array $unionTables) {
        if(!$tbname) return false;
        $sql = "CREATE TABLE if not exists `{$tbname}` (
        ".self::msgFieldStr()."
        ) ENGINE=MRG_MyISAM union=(".implode(',', $unionTables).") insert_method 0 DEFAULT CHARSET=utf8";
        return $sql;
    }
    /**
     * msgtable表的字段sql
     */
    private static function msgFieldStr() {
        return "`id` int(11) NOT NULL AUTO_INCREMENT,
              `chatid` char(32) NOT NULL COMMENT '用户间聊天的唯一标示（根据该标识可以查出属于此id的用户们），用来查询历史记录',
              `fromuser` varchar(30) NOT NULL,
              `message` varchar(500) NOT NULL,
              `time` int(11) NOT NULL,
              `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:聊天 1：广播 2：图片 3：附件',
              PRIMARY KEY (`id`),
              KEY `chatidindex` (`chatid`),
              KEY `timeindex` (`time`)";
    }
    
}
?>