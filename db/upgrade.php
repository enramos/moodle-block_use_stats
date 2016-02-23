<?php
// This file keeps track of upgrades to 
// the online_users block
//
// Sometimes, changes between versions involve
// alterations to database structures and other
// major things that may break installations.
//
// The upgrade function in this file will attempt
// to perform all the necessary actions to upgrade
// your older installtion to the current version.
//
// If there's something it cannot do itself, it
// will tell you what you need to do.
//
// The commands in here will all be database-neutral,
// using the functions defined in lib/ddllib.php

defined('MOODLE_INTERNAL') || die();

/**
 * @package   block_use_stats
 * @category  blocks
 * @copyright 2012 Valery Fremaux
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Standard uprade callback.
 * This function does anything necessary to upgrade
 * older versions to match current functionality
 */
function xmldb_block_use_stats_upgrade($oldversion = 0) {

    global $CFG, $DB;

    $result = true;

    $dbman = $DB->get_manager();

    if ($result && $oldversion < 2013040900) { //New version in version.php

        $lasttime = 0;

    // Pre Moodle 2

        $table = new xmldb_table('use_stats_log');
        if ($dbman->table_exists($table)) {
            $dbman->rename_table($table, 'block_use_stats_log');

            $table = new xmldb_table('use_stats');
            $dbman->rename_table($table, 'block_use_stats');

            $table = new xmldb_table('use_stats_userdata');
            if ($dbman->table_exists($table)) {
                $dbman->drop_table($table);
            }
        } else {

            // Define table use_stats_log to be created
            $table = new xmldb_table('block_use_stats_log');
    
            if (!$dbman->table_exists($table)) {
                // Adding fields to table use_stats
                $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null, null, null);
                $table->add_field('logid', XMLDB_TYPE_INTEGER, '11', XMLDB_UNSIGNED, null, null, null, null, '0');
                $table->add_field('gap', XMLDB_TYPE_INTEGER, '11', XMLDB_UNSIGNED, null, null, null, null, '0');
                $table->add_field('userid', XMLDB_TYPE_INTEGER, '11', XMLDB_UNSIGNED, null, null, null, null, '0');
                $table->add_field('time', XMLDB_TYPE_INTEGER, '11', XMLDB_UNSIGNED, null, null, null, null, '0');
                $table->add_field('course', XMLDB_TYPE_INTEGER, '11', XMLDB_UNSIGNED, null, null, null, null, '0');
                $table->add_field('customtag1', XMLDB_TYPE_CHAR, '20', null, null, null, null, null, '');
                $table->add_field('customtag2', XMLDB_TYPE_CHAR, '20', null, null, null, null, null, '');
                $table->add_field('customtag3', XMLDB_TYPE_CHAR, '20', null, null, null, null, null, '');
                $table->add_field('customtag4', XMLDB_TYPE_CHAR, '30', null, null, null, null, null, '');
                $table->add_field('customtag5', XMLDB_TYPE_CHAR, '30', null, null, null, null, null, '');
                $table->add_field('customtag6', XMLDB_TYPE_CHAR, '30', null, null, null, null, null, '');

                // Adding keys to table use_stats
                $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
                $table->add_key('ix_logid_unique', XMLDB_KEY_UNIQUE, array('logid'));

                // Launch create table for use_stats
                $dbman->create_table($table);
            }
        }

        // feed the table with log gaps
        $previouslog = array();
        $rs = $DB->get_recordset('log', array(), 'time', 'id,time,userid,course');
        if ($rs) {

            $r = 0;

            $starttime = time();

            while ($rs->valid()) {
                $log = $rs->current();
                $gaprec = new StdClass;
                $gaprec->logid = $log->id;
                $gaprec->time = $log->time;
                $gaprec->course = $log->course;

                for ($ci = 1 ; $ci <= 6; $ci++) {
                    $key = "customtag".$ci;
                    $gaprec->$key = '';
                    // Beware : at this epoch, the configuration is still centric.
                    if (!empty($CFG->block_use_stats_enablecompilecube)) {
                        $customselectkey = "block_use_stats_customtag{$ci}select";
                        if (!empty($CFG->$customselectkey)){
                            $customsql = str_replace('<%%LOGID%%>', $log->id, stripslashes($CFG->$customselectkey));
                            $customsql = str_replace('<%%USERID%%>', $log->userid, $customsql);
                            $customsql = str_replace('<%%COURSEID%%>', $log->course, $customsql);
                            $customsql = str_replace('<%%CMID%%>', $log->cmid, $customsql);
                            $gaprec->$key = $DB->get_field_sql($customsql, array());
                        }
                    }
                }

                $gaprec->gap = 0;
                if (!$DB->record_exists('block_use_stats_log', array('logid' => $log->id))) {
                    $DB->insert_record('block_use_stats_log', $gaprec);
                }
                if (array_key_exists($log->userid, $previouslog)) {
                    $DB->set_field('block_use_stats_log', 'gap', $log->time - $previouslog[$log->userid]->time, array('logid' => $previouslog[$log->userid]->id));
                }
                $previouslog[$log->userid] = $log;
                $lasttime = $log->time;
                $r++;
                if ($r %10 == 0) {
                    $processtime = time();
                    if (($processtime > $starttime + HOURSECS) || $r > 100000) {
                        break; // if compilation is too long, let cron continue processing untill all done
                    }
                }
                $rs->next();
            }
            $rs->close();

            // register las logtime for cron further updates
            mtrace("$r logs gapped");
            // Beware : at this epoch, the configuration is still centric.
            $CFG->use_stats_last_log = $lasttime;
        }

        // use_stats savepoint reached
        upgrade_block_savepoint($result, 2013040900, 'use_stats');
     }

     // Moodle 2

    if ($result && $oldversion < 2013060900) {

        // transfer the last compile time in new config variable
        // Beware : at this epoch, the configuration is still centric.
        set_config('block_use_stats_lastcompiled', $CFG->use_stats_last_log);
        set_config('use_stats_last_log', NULL);

        // use_stats savepoint reached
        upgrade_block_savepoint($result, 2013060900, 'use_stats');
     }

    // Moodle 2.7
    if ($result && $oldversion < 2015062500) {

        // Transfer old settings values to component scope.
        $settingkeys = preg_grep('/^block_use_stats_/', array_keys((array)$CFG));
        foreach ($settingkeys as $settingkey) {
            $newkey = str_replace('block_use_stats_', '', $settingkey);
            set_config($newkey, $CFG->$settingkey, 'block_use_stats');
            // Remove from central config.
            set_config($settingkey, null);
        }

        // Use_stats savepoint reached.
        upgrade_block_savepoint($result, 2015062500, 'use_stats');
     }

    if ($oldversion < 2016012100) {

        // Define index ix_logid (unique) to be added to block_use_stats_log.
        $table = new xmldb_table('block_use_stats_log');
        $index = new xmldb_index('ix_logid', XMLDB_INDEX_UNIQUE, array('logid'));

        // Conditionally launch add index ix_logid.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        $index = new xmldb_index('ix_userid', XMLDB_INDEX_NOTUNIQUE, array('userid'));

        // Conditionally launch add index ix_userid.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        $index = new xmldb_index('ix_course', XMLDB_INDEX_NOTUNIQUE, array('course'));

        // Conditionally launch add index ix_course.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        $index = new xmldb_index('ix_customtag1', XMLDB_INDEX_NOTUNIQUE, array('customtag1'));

        // Conditionally launch add index ix_customtag1.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        $index = new xmldb_index('ix_customtag2', XMLDB_INDEX_NOTUNIQUE, array('customtag2'));

        // Conditionally launch add index ix_customtag2.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        $index = new xmldb_index('ix_customtag3', XMLDB_INDEX_NOTUNIQUE, array('customtag3'));

        // Conditionally launch add index ix_customtag3.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        // Use_stats savepoint reached.
        upgrade_block_savepoint(true, 2016012100, 'use_stats');
    }

    if ($oldversion < 2016020600) {
        $table = new xmldb_table('use_stats_userdata');

        $field = new xmldb_field('compiletime');
        $field->set_attributes(XMLDB_TYPE_INTEGER, '11', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null, null, '0', 'events');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Use_stats savepoint reached.
        upgrade_block_savepoint(true, 2016020600, 'use_stats');
    }

    return $result;
}
