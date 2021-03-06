<?php

class SV_UserMergeSearchUpdate_Installer
{
    public static function install($existingAddOn, array $addOnData, SimpleXMLElement $xml)
    {
        $version = isset($existingAddOn['version_id']) ? $existingAddOn['version_id'] : 0;

        $db = XenForo_Application::getDb();

        $db->query("
            CREATE TABLE IF NOT EXISTS xf_sv_user_merge_queue
            (
                `queue_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `target` int(10) unsigned NOT NULL,
                `source` int(10) unsigned NOT NULL,
                PRIMARY KEY (`queue_id`),
                UNIQUE KEY `change_set` (`target`,`source`)
            ) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci
        ");

        XenForo_Application::defer('SV_UserMergeSearchUpdate_Deferred_SearchIndex', array(), 'user_merge');
    }

    public static function uninstall()
    {
        $db = XenForo_Application::getDb();

        $db->query("
            DROP TABLE IF EXISTS xf_sv_user_merge_queue;
        ");
        return true;
    }
}