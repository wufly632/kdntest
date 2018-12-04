<?php
/**
 * Created by sms.
 * User: Bruce.He
 * Date: 15/11/17
 * Time: 上午1:48
 */

use Illuminate\Support\Facades\Cache;
use Torann\GeoIP\Facades\GeoIP;
/**
 * 判断是否是字符串，空的也返回false
 * @param $str
 * @return bool
 */
function isvalid_string($str){
    if(!isset($str) || empty($str)){
        return false;
    }
   return true;
}

/**
 *当原字符串没设置值时，返回替换字符串
 *
 * @param $origin
 * @param $replace
 * @return mixed
 */
function str_replace_empty($origin,$replace)
{
    if(!isset($origin) || (empty($origin)) && !empty($replace)){
        return $replace;
    }
    return $origin;
}

/**
 * 检查字字符串是否存在，不在存在就返回空字符串
 * @param $str
 * @return mixed
 */
function str_checkreplace($str){
   return str_replace_empty($str,'');
}

/**
 * 解析url的所有参数放到数组里
 * @param $url
 * @return array
 */
function parametersWithURl($url)
{
    if(isvalid_string($url)){
        $queryString = '';
        $flagPos = strpos($url,'?');
        if($flagPos){
            //获取?后面的部分，例如k1=v1&k2=v2部分
            $queryString = substr($url,$flagPos+1);
        }
        if(isvalid_string($queryString)){
            $queryParts = explode('&',$queryString); //采取&分割开
            $parameters = [];
            foreach($queryParts as $p){
                $items = explode('=',$p);
                if(is_array($items)&&count($items)==2){
                    $parameters[$items[0]]=$items[1];
                }
            }
            return $parameters;
        }
    }
    return [];
}

/**
 * 从url中获取key的值，例如http://demo.com?key=value&k1=v1，获取k1的值
 * @param $url
 * @param $key
 * @return string
 */
function parameterWithURl($url,$key){
    if(isvalid_string($key)){
        $parameters = parametersWithURl($url);
        if(array_has($parameters,$key)){
            return $parameters[$key];
        }
    }
    return '';
}

/**
 * round up value, e.g: 12.44->13 12.55->13
 * @param $value
 * @param $places
 * @return float
 */
function round_up($value, $places)
{
    $mult = pow(10, abs($places));
    return $places < 0 ?
        ceil($value / $mult) * $mult :
        ceil($value * $mult) / $mult;
}

/**
 * Check email is valid
 *
 * @param $email
 * @return bool
 */
function is_email($email)
{
    $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
    if (preg_match( $pattern,$email)) return true;
    return false;
}

/**
 * 将stdClass Object转array，如果要转的数据量比较大采用array_object_l方法
 *
 * @param $array
 * @return array
 */
function array_object($array)
{
    if (is_object($array)) {
        $array = (array)$array;
    }
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            $array[$key] = array_object($value);
        }
    }
    return $array;
}

/**
 * 将stdClass Object转array， 对json的特性，只能是针对utf8的，否则得先转码下
 *
 * @param $array
 * @return mixed
 */
function array_object_l($array)
{
    $array = json_decode(json_encode($array), TRUE);
    return $array;
}

function array_checkreplace($arr)
{
    if (!isset($arr)) {
        return [];
    }
    return $arr;
}

/**
 * 获取本地化域名信息
 * @return string
 */
function get_en_locale()
{
    return getenv('APP_EN_LOCALE') ? : 'www';
}

/**
 * 金额格式化
 * @param $var
 * @return mixed
 */
function format_money($var) {
    $varExplode = explode('.', $var);
    if (end($varExplode) == '00'){
        return $varExplode[0];
    }else{
        return $var;
    }
}

/**
 * format price
 * @param $price
 * @return string
 */
function format_price($price,$display_symbol=null,$exchange_rate=null){
    if(!isset($display_symbol)){
        $display_symbol = "$";//currencyDisplaySymbol();
    }
    if(!isset($exchange_rate)){
        $exchange_rate = 1.0;//currencyExchangeRate();
    }
    $price = fetch_number($price);
    $price = sprintf('%.2f', round(floatval($price)*floatval($exchange_rate),2));
    return $display_symbol.$price;
}
/** detect mobile */
function is_mobile(){
    $detect = new Mobile_Detect;
    //isMobile会把ipad也算进去,isTablet判断是否是ipad
    if($detect->isMobile() && !$detect->isTablet()){
        return true;
    }
    return false;
}
/**
 * Fetch number from string, e.g: $4.3443 => 4.3443
 *
 * @param $str
 * @return mixed
 */
function fetch_number($str)
{
    return preg_replace('/[^\.0123456789]/s', '', $str);
}


/**
 * 判断当前是否https请求
 * @return bool
 */
function is_https()
{
    if ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
    {
        return TRUE;
    }
    elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
    {
        return TRUE;
    }
    elseif ( ! empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off')
    {
        return TRUE;
    }
    return FALSE;
}

/**
 * http转换成https
 * @param $url
 * @return mixed
 */
function http_to_https($url)
{
    return preg_replace("/^http:/i", "https:", $url);
}

/**
 * 字符串中的特殊字符处理
 * @param $str
 * @return mixed
 */
function trim_all($str)
{
    $front = array(" ", "　", "\t", "\n", "\r");
    $behind = array("", "", "", "", "");
    return str_replace($front, $behind, $str);
}

function check_if_from_app()
{
    $bool = false;
    $host = request()->url();
    $sub_domain = \Illuminate\Support\Facades\Config::get('app.new_api_domain');
    if (str_contains($host,$sub_domain)) {
        $bool = true;
    }
    return $bool;
}

function get_abb(){
    return request()->get('abb','en');
}


function tran_checkout_option($option,$params = []){
    $option_txt = trans("checkout.$option",$params,'messages',get_abb());
    if(strpos($option_txt,'checkout.')!==false){
            $option_txt = trans("checkout.$option",$params,'messages','en');
    }
    return $option_txt;
}

/** 替换域名
 * @param $href
 * @return null|string|string[]
 */
function href_replace_domain($href)
{
    return preg_replace('/(http|https):\/\/([^\/]+)/i','',$href);
}



function is_production()
{
	if(env('APP_ENV') == 'staging'){
        return true;
    }
    return false;
}


// 过滤掉emoji表情
function filterEmoji($str)
{
    $str = preg_replace_callback(
        '/./u',
        function (array $match) {
            return strlen($match[0]) >= 4 ? '' : $match[0];
        },
        $str);
    return $str;
}

function get_credit_card_logo($card_type)
{
    switch ($card_type) {
        case "Visa":
            $logo = asset(cdn_url(asset("/assets/img/credit_card_logo/visa.png")));
            break;
        case "American Express":
            $logo = asset(cdn_url(asset("/assets/img/credit_card_logo/amex.png")));
            break;
        case "Diners Club":
            $logo = asset(cdn_url(asset("/assets/img/credit_card_logo/diners_club.png")));
            break;
        case "Discover":
            $logo = asset(cdn_url(asset("/assets/img/credit_card_logo/discover.png")));
            break;
        case "JCB":
            $logo = asset(cdn_url(asset("/assets/img/credit_card_logo/jcb.png")));
            break;
        case "MasterCard":
            $logo = asset(cdn_url(asset("/assets/img/credit_card_logo/mastercard.png")));
            break;
        case "PayPal":
            $logo = asset(cdn_url(asset("/assets/img/credit_card_logo/paypal.png")));
            break;
        case "ApplePay":
            $logo = asset(cdn_url(asset("/assets/img/credit_card_logo/apple_pay.png")));
            break;
        default:
            $logo = asset(cdn_url(asset("/assets/img/credit_card_logo/visa.png")));
            break;
    }
    return $logo;
}


function get_credit_card_type()
{
    return [
        "American Express",
        "Diners Club",
        "Discover",
        "MasterCard",
        "Visa",
        "JCB",
        "Maestro",
        "UnionPay",
        "Unknown"
    ];
}

function std_class_object_to_array($stdclassobject)
{
    $_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;

    foreach ($_array as $key => $value) {
        $value = (is_array($value) || is_object($value)) ? std_class_object_to_array($value) : $value;
        $array[$key] = $value;
    }

    return $array;
}

function get_time_difference($startDate, $endDate){
    $data = array();
    $count_down = '';
    if($startDate && $endDate){
        $time = strtotime($endDate) - strtotime($startDate);
        $data['d'] = floor($time / 86400);
        $time -= $data['d'] * 60 * 60 * 24;
        $data['h'] = floor($time / 60 / 60);
        $time -= $data['h'] * 60 * 60;
        $data['m'] = floor($time / 60);
        $time -= $data['m'] * 60;
        $data['s'] = $time;
        $count_down = // ($data['d']?:'').":".
            str_pad((($data['d']?$data['d']*24:'') + $data['h']?:''),2,'0',STR_PAD_LEFT).":".
            str_pad(($data['m']?:''),2,'0',STR_PAD_LEFT).":".
            str_pad(($data['s']?:''),2,'0',STR_PAD_LEFT);
    }
    return $count_down;
}

function get_card_type_by_number($number)
{
    $number = preg_replace('/[^\d]/', '', $number);
    if (preg_match('/^3[47][0-9]{13}$/', $number)) {
        return 'American Express';
    } elseif (preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/', $number)) {
        return 'Diners Club';
    } elseif (preg_match('/^6(?:011|5[0-9][0-9])[0-9]{12}$/', $number)) {
        return 'Discover';
    } elseif (preg_match('/^(?:2131|1800|35\d{3})\d{11}$/', $number)) {
        return 'JCB';
    } elseif (preg_match('/^5[1-5][0-9]{14}$/', $number)) {
        return 'MasterCard';
    } elseif (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $number)) {
        return 'Visa';
    } else {
        return 'Unknown';
    }
}


function secure_route($route_name,$parameters = [])
{
    if(env('OC_HTTPS', false)){
        return http_to_https(route($route_name,$parameters));
    }else{
        return route($route_name,$parameters);
    }
}




/**
 * 通过价格计算满返的金额
 */
function getReturn($price, $promotions)
{
    //消费金额
    $consumeAmount = isset($promotions->consume) ? $promotions->consume : 0;
    //满返规则
    $rule = isset($promotions->rule) ? $promotions->rule : '';
    if (empty($rule)) return False;
    $rule = json_decode($rule);
    //是否满足活动要求
    $isSatisfy = FALSE;
    //满返说明
    $returnMsg = '';
    //如果购买的价格<满返金额
    if ($price < $consumeAmount) {
        //$returnMsg = '再购¥'.bcsub($consumeAmount, $price, 2).',可享受【满'.$consumeAmount.'元返'.$rule->value.'元现金券】';
        $returnMsg = '再买'.bcsub($consumeAmount, $price, 2).'元,可享【满'.$consumeAmount.'元返'.$rule->value.'元】';
    } else {
        //$returnMsg = '已享受【满'.$consumeAmount.'元返'.$rule->value.'元现金券】';
        $returnMsg = '已享【满'.$consumeAmount.'元返'.$rule->value.'元】';
        $isSatisfy = TRUE;
    }

    return array('returnMsg' => $returnMsg, 'isSatisfy' => $isSatisfy);
}

/**
 * 通过促销商品数量、价格计算多件多折优惠金额
 */
function getDiscount($goodTotal, $price, $promotions)
{
    //多件多折规则
    $rule = isset($promotions->rule) ? $promotions->rule : '';
    if (empty($rule)) return False;
    $rule = json_decode($rule);
    //是否满足活动要求
    $isSatisfy = FALSE;
    //折扣金额
    $discount = '0.00';
    //多件多折说明
    $discountMsg = '';
    //多件多折内容
    $discountContent = '';
    foreach ($rule as $val) {
        //如果购买的数量>=多件数量
        if ($goodTotal >= $val->num) {
            $discount = bcsub($price, bcmul($price, $val->discount / 10, 2), 2);
            //$discountContent = '满'.$val->num.'件'.$val->discount.'折';
            $discountContent = $val->num.'件'.$val->discount.'折';
            $isSatisfy = TRUE;
        } else {
            //$discountMsg = '再购'.bcsub($val->num, $goodTotal, 0).'件,可享受【满'.$val->num.'件'.$val->discount.'折】';
            $discountMsg = $val->num.'件'.$val->discount.'折,只差'.bcsub($val->num, $goodTotal, 0).'件';
            break;
        }
    }
    if ( ! $discountMsg && $discountContent) {
        //$discountMsg = '已享受【'.$discountContent.'】';
        $discountMsg = '已享【'.$discountContent.'】';
    }

    return array('discount' => $discount, 'discountMsg' => $discountMsg, 'isSatisfy' => $isSatisfy);
}

/**
 * 通过促销商品数量、促销商品价格和购买数量计算X元n件优惠金额
 */
function getWholesale($goodTotal, $prices, $promotionsGood, $promotions)
{
    $price = array();
    //参加X元n件促销活动的商品价格和购买数量
    if ( ! is_array($promotionsGood)) return False;
    foreach ($promotionsGood as $good) {
        for ($i = 0; $i < $good['num']; $i++) {
            $price[] = $good['price'];
        }
    }

    //X元n件规则
    $rule = isset($promotions->rule) ? $promotions->rule : '';
    if (empty($rule)) return False;
    $rule = json_decode($rule);
    //是否满足活动要求
    $isSatisfy = FALSE;
    //优惠金额
    $wholesale = '0.00';
    //X元n件说明
    $wholesaleMsg = '';
    //获取计算出来的最大的优惠金额
    $wholesaleMax = array();
    foreach ($rule as $key => $val) {
        //规则价格,每循环一次重获取价格一次
        $rulePrice = $price;
        //如果购买的数量<n件
        if ($goodTotal < $val->wholesale) {
            //$wholesaleMsg = '再购'.bcsub($val->wholesale, $goodTotal, 0).'件,可享受【'.$val->money.'元任选'.$val->wholesale.'件】';
            $wholesaleMsg = $val->money.'元'.$val->wholesale.'件,只差'.bcsub($val->wholesale, $goodTotal, 0).'件';
            break;
        } else {
            //如果购买的数量=n件
            if ($goodTotal == $val->wholesale) {
                $wholesaleMax[] = bcsub($prices, $val->money, 2);
                //$wholesaleMsg = '已享受【'.$val->money.'元任选'.$val->wholesale.'件】';
                $wholesaleMsg = '已享【'.$val->money.'元'.$val->wholesale.'件】';
                $isSatisfy = TRUE;
            }
            //如果购买的数量>n件
            if ($goodTotal > $val->wholesale) {
                //如果能被整除
                if ($goodTotal % $val->wholesale == 0) {
                    $wholesaleMax[] = bcsub($prices, bcmul($val->money, floor($goodTotal / $val->wholesale), 2), 2);
                    //$wholesaleMsg = '已享受【'.$val->money.'元任选'.$val->wholesale.'件】';
                    $wholesaleMsg = '已享【'.$val->money.'元'.$val->wholesale.'件】';
                    $isSatisfy = TRUE;
                } else {//如果不能整除
                    //获取余数
                    $remainder = $goodTotal % $val->wholesale;
                    //获取要减掉的最小价格的商品的价格(如果余数为1,就减掉1个最小价格的商品;如果余数为2,就减掉2个最小价格的商品)
                    $outPrice = 0;
                    //根据余数获取最小价格商品
                    for ($j = 0; $j < $remainder; $j++) {
                        //获取最小值的键名(array_search函数在数组中搜索某个键值，并返回对应的键名)
                        $pos = array_search(min($rulePrice), $rulePrice);
                        $outPrice = bcadd($outPrice, $rulePrice[$pos], 2);
                        unset($rulePrice[$pos]);
                    }
                    //减掉余数个最小价格的商品，用剩余的价格计算优惠金额
                    $remainderPrice = bcsub($prices, $outPrice, 2);
                    $wholesaleMax[] = bcsub($remainderPrice, bcmul($val->money, floor(count($rulePrice) / $val->wholesale), 2), 2);
                    //$wholesaleMsg = '已享受【'.$val->money.'元任选'.$val->wholesale.'件】';
                    $wholesaleMsg = '已享【'.$val->money.'元'.$val->wholesale.'件】';
                    $isSatisfy = TRUE;
                }
            }
        }
    }
    //最终获取优惠金额
    if ($wholesaleMax) $wholesale = max($wholesaleMax);

    return array('wholesale' => $wholesale, 'wholesaleMsg' => $wholesaleMsg, 'isSatisfy' => $isSatisfy);
}

/**
 * 通过购买数量计算买n免一优惠金额
 */
function getGive($goodTotal, $promotionsGood, $promotions)
{
    $price = array();
    //参加买n免一促销活动的商品价格和购买数量
    if ( ! is_array($promotionsGood)) return False;
    foreach ($promotionsGood as $good) {
        for ($i = 0; $i < $good['num']; $i++) {
            $price[] = $good['price'];
        }
    }
    //按照键值对关联数组进行降序排序
    arsort($price);
    //如果您仅向array_merge()函数输入一个数组,且键名是整数,则该函数将返回带有整数键名的新数组,其键名以0开始进行重新索引
    $price = array_merge($price);

    //买n免一规则
    $rule = isset($promotions->rule) ? $promotions->rule : '';
    if (empty($rule)) return False;
    //是否满足活动要求
    $isSatisfy = FALSE;
    //优惠金额
    $give = '0.00';
    //X元n件说明
    $giveMsg = '';
    //获取余数为n-1的商品价格
    $giveMin = array();
    //如果购买的数量<n件
    if ($goodTotal < $rule) {
        //$giveMsg = '再购'.bcsub($rule, $goodTotal, 0).'件,可享受【买'.$rule.'免1】';
        $giveMsg = '买'.$rule.'免1,只差'.bcsub($rule, $goodTotal, 0).'件';
    } else {
        //如果购买的数量=n件
        if ($goodTotal == $rule) {
            //$giveMsg = '已享受【买'.$rule.'免1】';
            $giveMsg = '已享【买'.$rule.'免1】';
            $give = min($price);
            $isSatisfy = TRUE;
        }
        //如果购买的数量>n件
        if ($goodTotal > $rule) {
            foreach ($price as $key => $value) {
                //如果键值余数等于n-1,就获取价格
                if (bcmod($key, $rule) == bcsub($rule, 1, 0)) {
                    $giveMin[] = $value;
                }
            }
            $give = array_sum($giveMin);
            //$giveMsg = '已享受【买'.bcmul($rule, bcdiv($goodTotal, $rule, 0), 0).'免'.bcmul(1, bcdiv($goodTotal, $rule, 0), 0).'】';
            $giveMsg = '已享【买'.bcmul($rule, bcdiv($goodTotal, $rule, 0), 0).'免'.bcmul(1, bcdiv($goodTotal, $rule, 0), 0).'】';
            $isSatisfy = TRUE;
        }
    }
    return array('give' => $give, 'giveMsg' => $giveMsg, 'isSatisfy' => $isSatisfy);
}

/**
 * 生成券码
 */
function makeCouponCode($coupon_id)
{
    $length = 11; //总长11位数
    $couponIdLen = strlen($coupon_id);//券ID位数
    $couponLen = bcsub($length, bcadd($couponIdLen, 1, 0), 0); //随机数长度=总长-(券ID位数+1).1表示券ID位数(目前只有个位数)

    $str = '';
    $couponStr = '';
    $pool = '0123456789';
    for ($i = 0; $i < $couponLen; $i++)
    {
        $str .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
    }
    $couponStr = $couponIdLen.$coupon_id.$str;

    return $couponStr;
}

/**
 * @function 时间范围转换
 * @param $date_range
 * @return array
 */
function get_time_range($date_range)
{
    if (!$date_range) {
        return [null, null];
    }
    $array = explode('~', $date_range);
    list($start_at, $end_at) = $array;
    return [$start_at, $end_at];
}

function getPathCate($uri)
{
    if (!$uri || empty($uri)) return '';
    $path = [];
    $path[$uri][] = "<li><a href='javascript:void(0)'>Home</a></li>";
    $templates = config('template');
    foreach ($templates['menus'] as $key => $menus) {
        if (is_array($menus['menus']) && !empty($menus['menus'])) {
            foreach ($menus['menus'] as $k => $menu) {
                if ($menu['link'] == $uri) {
                    $path[$uri][] = "<li><a href='javascript:void(0)'>" . trans("template." . $menus['title']) . "</a></li>";
                    $path[$uri][] = "<li><a href={$menu['link']}  class='active'><strong>" . trans("template." . $menu['title']) . "</strong></a></li>";
                    break 2;
                }
            }
        }
    }
    return implode('', $path[$uri]);
}

/**
 * @function cdn加速
 * @param $url
 * @param bool $is_https
 * @return \Illuminate\Contracts\Routing\UrlGenerator|mixed|string
 */
function cdnUrl($url,$is_https=true)
{
    if(!$url || empty($url) || env('APP_ENV', 'local') == 'local')return $url;

    $cdn_image_url = env('CDN_IMAGE_URL','');
    $cdn_skins_url = env('CDN_SKINS_URL','');
    $cdn_infos = [
        "weiweimao-image.oss-ap-south-1.aliyuncs.com" => $cdn_image_url,
        "cucoe.oss-us-west-1.aliyuncs.com" => $cdn_image_url,
        "admin.waiwaimall.com" => $cdn_skins_url,
        "seller.waiwaimall.com" => $cdn_skins_url,
        "seller.dev.waiwaimall.com" => $cdn_skins_url
    ];

    foreach (array_keys($cdn_infos) as $index=>$origin_host){
        if(str_contains($url,$origin_host) && !empty($cdn_infos[$origin_host])){
            $url=str_replace($origin_host,$cdn_infos[$origin_host],$url);
            break;
        }
    }
    return $url;
}

function cdn_asset($path, $secure = null)
{
    return cdnUrl(app('url')->asset($path, $secure));
}