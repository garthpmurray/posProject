<?php
/**
 * @author Borales <bordun.alexandr@gmail.com>
 * @package YiiDebugToolbar
 */
class YiiDebugToolbarPanelVarDumper extends YiiDebugToolbarPanel
{
    const SECTION_MESSAGE = 0;
    const SECTION_LINES = 10;
    const SECTION_TIME = 11;

    private $_logs;

    public function getMenuTitle() {
        return YiiDebug::t("VarDumper");
    }

    public function getMenuSubTitle() {
        return false;
    }

    public function getTitle() {
        return YiiDebug::t('VarDumper output');
    }

    public function getSubTitle() {
        return false;
    }


    private function filterLogs() {
        $logs = array();
        foreach ($this->owner->getLogs() as $entry)
        {
            if ($entry[1] == 'varDumper')
            {
                if( strpos($entry[0], '</code>') ) {
                    $_entry = explode('</code>', $entry[0], 2);
                    if( $_entry[1] ) {
                        $entry[0] = str_replace($_entry[1], "<pre>{$_entry[1]}</pre>", $entry[0]);
                        $entry[ self::SECTION_LINES ] = $_entry[1];
                    }
                }


                $logs[ $entry[2] ][] = $entry;
            }
        }
        return $logs;
    }

    public function getLogs() {
        if (null === $this->_logs)
        {
            $this->_logs = $this->filterLogs();
        }
        return $this->_logs;
    }

    public function run() {
        $this->render('var_dumper');
    }
}
