<?php
/**
 * Provides access to some common static functions that can be used anywhere.
 * User: Garth
 */
class CommonFunctions
{
    public static function stripFormatting($str)
    {
        return str_replace(array(',', '$', '%'), '', $str);
    }

    /**
     * @static Checks whether the user can perform ANY of the passed in permissions.  If the array is empty, this function returns false.
     * @param array $params The array of permissions to check against
     * @return bool true if the user can access ANY of the specified items (and the array is not empty), false otherwise.
     */
    public static function userCanAccessAny($params = array())
    {
        foreach ($params as $permission) {
            if (Yii::app()->user->checkAccess($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @static Checks whether the user can perform ALL of the passed in permissions.  If the array is empty, this function returns false.
     * @param array $params The array of permissions to check against
     * @return bool true if the user can access ALL of the specified items (and the array is not empty), false otherwise.
     */
    public static function userCanAccessAll($params = array())
    {
        if (count($params) == 0) return false;
        foreach ($params as $permission) {
            if (!Yii::app()->user->checkAccess($permission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @static Checks whether any of the items in the array have a 'visible' attribute, AND its
     * set to true.
     * @param array $params Array of menu items.
     * @return bool true if any of the menu items are 'visible', otherwise false.
     */
    public static function anyVisible($params = array())
    {
        foreach ($params as $item) {
            if (array_key_exists('visible', $item) && $item['visible'] === true) {
                return true;
            }
        }

        return false;
    }

    public static function delete_all_between($beginning, $end, $string) {
        $beginningPos = strpos($string, $beginning);
        $endPos = strpos($string, $end);
        if (!$beginningPos || !$endPos) {
            return $string;
        }

        $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

        return str_replace($textToDelete, '', $string);
    }


    /**
     * [truncate description]
     * @param  [type] $name   [description]
     * @param  [type] $length [description]
     * @return [type]         [description]
     */
    public static function truncate($name, $length){
        if(strlen($name) > $length){
            return trim(substr($name, 0, $length)).'...';
        }else{
            return $name;
        }
    }

    /**
     * [format_phone description]
     * @param  [type] $phone [description]
     * @return [type]        [description]
     */
    public static function format_phone($phone){
        $phone = preg_replace("/[^0-9]/", "", $phone);
        switch(strlen($phone)){
            case 11:
                return preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1($2) $3-$4", $phone);
                break;
            case 7:
                return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
                break;
            case 10:
                return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
                break;
        }
        return $phone;
    }

    /**
     * Replaces all but the last for digits with x's in the given credit card number
     * @param int|string $cc The credit card number to mask
     * @return string The masked credit card number
     */
    public static function maskCreditCard($cc){
        // Get the cc Length
        $cc_length = strlen($cc);
        // Replace all characters of credit card except the last four and dashes
        for($i=0; $i<$cc_length-4; $i++){
            if($cc[$i] == '-'){continue;}
            $cc[$i] = 'X';
        }
        // Return the masked Credit Card #
        return $cc;
    }

    /**
     * Add dashes to a credit card number.
     * @param int|string $cc The credit card number to format with dashes.
     * @return string The credit card with dashes.
     */
    public static function formatCreditCard($cc){
        // Clean out extra data that might be in the cc
        $cc = str_replace(array('-',' '),'',$cc);
        // Get the CC Length
        $cc_length = strlen($cc);
        // Initialize the new credit card to contian the last four digits
        $newCreditCard = substr($cc,-4);
        // Walk backwards through the credit card number and add a dash after every fourth digit
        for($i=$cc_length-5;$i>=0;$i--){
            // If on the fourth character add a dash
            if((($i+1)-$cc_length)%4 == 0){
                $newCreditCard = '-'.$newCreditCard;
            }
            // Add the current character to the new credit card
            $newCreditCard = $cc[$i].$newCreditCard;
        }
        // Return the formatted credit card number
        return $newCreditCard;
    }

    /**
     * encryptCard function.
     *
     * avaliable to encrypt card information.
     *
     * @access private
     * @param mixed $card
     * @return void
     */
    public static function encryptCard($card){
        if(empty($card)){
            return '';
        }
        return base64_encode(Yii::app()->getSecurityManager()->encrypt($card, Yii::app()->params['encryptKey']));
    }

    /**
     * decryptCard function.
     *
     * avaliable to decrypt card information.
     *
     * @access public
     * @param mixed $card
     * @return void
     */
    public static function decryptCard($card){
        if(empty($card)){
            return '';
        }
        return Yii::app()->getSecurityManager()->decrypt(base64_decode($card), Yii::app()->params['encryptKey']);
    }

    /**
     * Returns the region string for jquery money formatter
     * @return string
     */
    public static function jqMoneyRegion(){

        $forced_currency = !empty($designGenreModel->force_currency) ? $designGenreModel->force_currency : 'USD';

        switch($forced_currency){
            case 'EUR':
                $jqregion = 'ga-IE';
                break;
            case 'GBP':
                $jqregion = 'cy-GB';
                break;
            default:
                $jqregion = 'en-US';
                break;
        }
        return $jqregion;
    }

    /**
     * Returns the key of the value or false
     * @return string
     */
    public static function recursiveArraySearch($needle,$haystack) {
        foreach($haystack as $key=>$value) {
            $current_key=$key;
            if($needle===$value OR (is_array($value) && self::recursiveArraySearch($needle,$value) !== false)) {
                return $current_key;
            }
        }
        return false;
    }

    /**
     * Pass in an object, recieve a recrusivly convert array
     *
     * @show_source() http://ben.lobaugh.net/blog/567/php-recursively-convert-an-object-to-an-array
     * @param  mixed $obj
     * @return array
     */
    public static function objectToArray($obj) {
        if (is_object($obj)) {
            $obj = (array) $obj;
        }

        if (is_array($obj)) {
            $new = array();
            foreach ($obj as $key => $val) {
                $new[$key] = CommonFunctions::objectToArray($val);
            }
        } else {
            $new = $obj;
        }

        return $new;       
    }
    /**
     * Sorts a multidimensional array according to a given key index.   Adapted from:
     * http://php.net/manual/en/function.sort.php#104464
     */
    public static function sortmulti($array, $index, $order)
    {
        if (is_array($array) && count($array) > 0) {
            foreach (array_keys($array) as $key)
                $temp[$key] = $array[$key][$index];

            if ($order == 'asc') {
                asort($temp);
            } else {
                arsort($temp);
            }

            foreach (array_keys($temp) as $key)
                if (is_numeric($key)) {
                    $sorted[] = $array[$key];
                } else {
                    $sorted[$key] = $array[$key];
                }

            return $sorted;
        }

        // fall through and just return whatever we were given
        return $array;
    }

    /**
     * Multi dimensional array comparing
     * 
     * @author  mhitza
     * @source http://stackoverflow.com/questions/3876435/recursive-array-diff
     * @param array $aArray1
     * @param array $aArray2
     * @return  array
     */
    public static function arrayRecursiveDiff($aArray1, $aArray2) {
        $aReturn = array();

        foreach ($aArray1 as $mKey => $mValue) {
            if (array_key_exists($mKey, $aArray2)) {
                if (is_array($mValue)) {
                    $aRecursiveDiff = CommonFunctions::arrayRecursiveDiff($mValue, $aArray2[$mKey]);
                    
                    if (count($aRecursiveDiff)) {
                        $aReturn[$mKey] = $aRecursiveDiff;
                    }
                } else {
                    if ($mValue != $aArray2[$mKey]) {
                        $aReturn[$mKey] = $mValue;
                    }
                }
            } else {

              $aReturn[$mKey] = $mValue;
            }
        }
        return $aReturn;
    } 

    /**
     * [calc_brightness description]
     * @param  [type] $rgb [description]
     * @return [type]      [description]
     */
    public static function calc_brightness($rgb) {
        // $rgb = hex2RGB($color);
        return sqrt(
            $rgb["red"] * $rgb["red"] * .299 +
            $rgb["green"] * $rgb["green"] * .587 +
            $rgb["blue"] * $rgb["blue"] * .114);
    }

    /**
     * [hex2RGB description]
     * @param  [type]  $hexStr         [description]
     * @param  boolean $returnAsString [description]
     * @param  string  $seperator      [description]
     * @return [type]                  [description]
     */
    public static function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
        $hexStr     = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
        $rgbArray   = array();
        if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
            $colorVal = hexdec($hexStr);
            $rgbArray['red']    = 0xFF & ($colorVal >> 0x10);
            $rgbArray['green']  = 0xFF & ($colorVal >> 0x8);
            $rgbArray['blue']   = 0xFF & $colorVal;
        } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
            $rgbArray['red']    = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
            $rgbArray['green']  = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
            $rgbArray['blue']   = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
        } else {
            return false; //Invalid hex color code
        }
        return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
    }
    
    /**
     * [curlInit description]
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    public static function curlInit($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        
        if($response === false){
            throw new Exception('Curl error: ' . curl_error($ch));
        }
        
        curl_close ($ch);
        return $response;
    }
    
    /**
     * [curlPost description]
     * @param  [type] $url           [description]
     * @param  [type] $postVariables [description]
     * @return [type]                [description]
     */
    public static function curlPost($url, $postVariables){
        
        //open connection
        $ch = curl_init();
        
        $postFields = '';
        foreach($postVariables as $key=>$value) {
            $postFields .= $key.'='.$value.'&';
        }
        rtrim($postFields,'&'); 
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST,count($postVariables));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$postFields);
        //execute post
        $result = curl_exec($ch);
        
        if($response === false){
            throw new Exception('Curl error: ' . curl_error($ch));
        }
        
        //close connection
        curl_close($ch);
        
        // display result
        return $result;
    }
    
    /**
     * For simplified POST requests this sends RAW POST data via curl
     *
     * @author David J Eddy <me@davidjeddy.com>
     * @param  string $_url required
     * @param  mixed $_param_data required
     * @param  mixed $_mime_type optional
     * @return mixed
     */
    public static function curlPostRaw($_url, $_param_data, $_mime_type = null) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,            $_url );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $_param_data ); 
        curl_setopt($ch, CURLOPT_HTTPHEADER,     $_mime_type); 

        return curl_exec ($ch);
    }

    /**
     * Multiple curl calls at the same time
     *
     * @source  http://www.phpied.com/simultaneuos-http-requests-in-php-with-curl/
     * 
     * @param  array $data rray if URLs to request
     * @param  array  $options Array of curl_setopt's
     * @return array
     */
    public static function curlMulti($data, $options = array()) {

        // array of curl handles
        $curly = array();
        // data to be returned
        $result = array();

        // multi handle
        $mh = curl_multi_init();

        // loop through $data and create curl handles
        // then add them to the multi-handle
        foreach ($data as $id => $d) {

            $curly[$id] = curl_init();

            $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
            curl_setopt($curly[$id], CURLOPT_URL,            $url);
            curl_setopt($curly[$id], CURLOPT_HEADER,         0);
            curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);

            // post?
            if (is_array($d)) {
                if (!empty($d['post'])) {
                    curl_setopt($curly[$id], CURLOPT_POST,       1);
                    curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
                }
            }

            // extra options?
            if (!empty($options)) {
                curl_setopt_array($curly[$id], $options);
            }

            curl_multi_add_handle($mh, $curly[$id]);
        }

        // try to execute the calls
        try {
            // execute the handles
            $running = null;
            do {
                curl_multi_exec($mh, $running);
            } while($running > 0);
        } catch (Excpetion $e) {

            return $e;
        }


        // get content and remove handles
        foreach($curly as $id => $c) {
            $result[$id] = curl_multi_getcontent($c);
            curl_multi_remove_handle($mh, $c);
        }

        // all done
        curl_multi_close($mh);

        return $result;
    }

    public static function sha256Hash($file){
        return hash_file('sha256', $file);
    }
    
    static public function orderTimeDifference($times){
        $timeIncrements = Yii::app()->params['timeIncrements'];
        $data = array();
        foreach($timeIncrements as $k => $v){
            $data[$k] = 0;
        }
        foreach($times as $t){
            foreach($timeIncrements as $k => $v){
                $check = eval($v['eval']);
                if($check){
                    $data[$k]++;
                }
            }
        }
        
        return $data;
    }
    
    public static function zeros($num){
        $padded="0000".$num."0000";
        if (($dotpos = strpos($padded, ".")) !== FALSE) {
            $result = substr($padded, $dotpos-2, 2).".".substr($padded, $dotpos+1, 2);
        } else {
            $result = sprintf("%02s", $num);
        }
        return $result;
    }
    
    static public function isJson($string) {
        json_decode($string);
        
        if($error = json_last_error_msg() && json_last_error() !== JSON_ERROR_NONE){
            if(strlen($string) > 50){
                $string = substr($string, 0, 50).'...';
            }
            throw new CHttpException(400, sprintf("Failed to parse json string '%s', error: '%s'", $string, $error));
        }
        return true;
    }
    
    static public function jsonInputs($data){
        
        $cs = Yii::app()->getClientScript();
        $cs->registerScript("inlineFancyBox", '$(document).ready(function() {
            
            $(".assetChoiceLink").on("click", function(){
                $("#hiddenAssetId").data("link-id", $(this).data("link-id"));
                console.log($(this).data("link-id"));
            });
            
            $(".inlineFancy").fancybox({
                fitToView   : true,
                closeClick  : false,
                openEffect  : "none",
                closeEffect : "none",
                beforeOpen  : function(){
                    
                }
            });
            
        });', CClientScript::POS_HEAD);
        
        return Yii::app()->JsonTable->setFormat(1)->formatJson($data);
    }
    
    /**
     * Create the UUID from the RUI
     *
     * @author  David Eddy <me@davidjeddy.com>
     * @todo ...accaptance tests for both excursions and tables - DJE : 2014-12-29
     * @version  0.1.3
     * @since  0.1.3
     * @param  string $_url
     * @return  boolean
     */
    static function generateUUID($_param_data = null)
    {
        if ($_param_data == null && isset($_SERVER['REQUEST_URI'])) {
            $_param_data = $_SERVER['REQUEST_URI'];
        }
        
        $_method_data = md5($_param_data);
        $_method_data = substr($_method_data, 0, 8 ) .'-'.
        substr($_method_data, 8,  4) .'-'.substr($_method_data, 12, 4) .'-'.
        substr($_method_data, 16, 4) .'-'.substr($_method_data, 20);
        
        return strtolower($_method_data);;
    }
    
    static function uuid_make($string){
        $string = substr($string, 0, 8 ) .'-'.
        substr($string, 8, 4) .'-'.
        substr($string, 12, 4) .'-'.
        substr($string, 16, 4) .'-'.
        substr($string, 20);
        return $string;
    }
    
    static public function getModels(){
        $endSet = array();
        $startSet = CFileHelper::findFiles(Yii::getPathOfAlias("application.models"), array ( 
            'fileTypes'     => array('php'),
            'exclude'       => array(
                'ReportsScreen.php',
                'UserLimitedData.php',
                'UserLimitedModel.php',
                'Site.php',
            ),
            'absolutePaths' => false,
        ));
        foreach($startSet as $key => $value){
            $endSet[str_replace('.php', '', $value)] = str_replace('.php', '', $value);
        }
        $filenames['base'] = $endSet;
        
        $filenames['modules'] = CommonFunctions::getModulesModels();
        
        return $filenames;
    }
    
    static public function getModulesModels(){
        $fileNames = array();
        $modulePath = Yii::getPathOfAlias('common.modules');
        $moduleDirectory = scandir($modulePath);
        foreach( $moduleDirectory as $entry ){
            if( substr($entry, 0, 1)!=='.' && $entry!=='rights' ){
                $subModulePath = $modulePath.DIRECTORY_SEPARATOR.$entry;
                if( file_exists($subModulePath)===true ){
                    $endSet = array();
                    $startSet = CFileHelper::findFiles($subModulePath.DIRECTORY_SEPARATOR.'models', array ( 
                        'fileTypes'     => array('php'),
                        'exclude'       => array(
                            'Site.php',
                            '_base',
                            'core',
                        ),
                        'absolutePaths' => false,
                    ));
                    foreach($startSet as $key => $value){
                        $endSet[$entry.'.models.'.str_replace('.php', '', $value)] = str_replace('.php', '', $value);
                    }
                    $fileNames[$entry] = $endSet;
                }
            }
        }
        return $fileNames;
    }
    
    static public function validateDate($date, $format = 'Y-m-d H:i:s'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    /**
    * A sweet interval formatting, will use the two biggest interval parts.
    * On small intervals, you get minutes and seconds.
    * On big intervals, you get months and days.
    * Only the two biggest parts are used.
    *
    * @param DateTime $start
    * @param DateTime|null $end
    * @return string
    */
    static public function formatDateDiff($start, $end=null) {
        if(!($start instanceof DateTime)) {
            $start = new DateTime($start);
        }
        
        if($end === null) {
            $end = new DateTime();
        }
        
        if(!($end instanceof DateTime)) {
            $end = new DateTime($start);
        }
        
        $interval = $end->diff($start);
        $doPlural = function($nb,$str){return $nb>1?$str.'s':$str;}; // adds plurals
       
        $format = array();
        if($interval->y !== 0) {
            $format[] = "%y ".$doPlural($interval->y, "year");
        }
        if($interval->m !== 0) {
            $format[] = "%m ".$doPlural($interval->m, "month");
        }
        if($interval->d !== 0) {
            $format[] = "%d ".$doPlural($interval->d, "day");
        }
        if($interval->h !== 0) {
            $format[] = "%h ".$doPlural($interval->h, "hour");
        }
        if($interval->i !== 0) {
            $format[] = "%i ".$doPlural($interval->i, "minute");
        }
        if($interval->s !== 0) {
            if(!count($format)) {
                return "less than a minute ago";
            } else {
                $format[] = "%s ".$doPlural($interval->s, "second");
            }
        }
        
        // We use the two biggest parts
        if(count($format) > 1) {
            $format = array_shift($format)." and ".array_shift($format);
        } else {
            $format = array_pop($format);
        }
        
        // Prepend 'since ' or whatever you like
        return $interval->format($format);
    }
    
    /**
     * Return the http status message based on integer status code
     * @param  int    $status HTTP status code
     * @return string status message
     * @source: https://gist.github.com/cherifGsoul/3180857
     */
    static public function getStatusCodeMessage($_status)
    {
        $codes = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            550 => '3rd party application server offline'
        );

        return (isset($codes[$_status])) ? $codes[$_status] : $codes[204];
    }
    
}
