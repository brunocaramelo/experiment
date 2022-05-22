<?php

/**
 * ####################
 * ###   VALIDATE   ###
 * ####################
 */

/**
 * @param string $email
 * @return bool
 */
function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * @param string $password
 * @return bool
 */
function is_passwd(string $password): bool
{
    if (password_get_info($password)['algo'] || (mb_strlen($password) >= CONF_PASSWD_MIN_LEN && mb_strlen($password) <= CONF_PASSWD_MAX_LEN)) {
        return true;
    }

    return false;
}

/**
 * ##################
 * ###   STRING   ###
 * ##################
 */

/**
 * @param string $string
 * @return string
 */
function str_slug(string $string): string
{
    $string = filter_var(mb_strtolower($string), FILTER_SANITIZE_STRIPPED);
    $formats = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
    $replace = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

    $slug = str_replace(
        ["-----", "----", "---", "--"],
        "-",
        str_replace(
            " ",
            "-",
            trim(strtr(utf8_decode($string), utf8_decode($formats), $replace))
        )
    );
    return $slug;
}

function str_uppercase(string $string): string
{
    $string = strtoupper($string);
    return $string;
}
/**
 * @param string $string
 * @return string
 */
function str_studly_case(string $string): string
{
    $string = str_slug($string);
    $studlyCase = str_replace(
        " ",
        "",
        mb_convert_case(str_replace("-", " ", $string), MB_CASE_TITLE)
    );

    return $studlyCase;
}

/**
 * @param string $string
 * @return string
 */
function str_camel_case(string $string): string
{
    return lcfirst(str_studly_case($string));
}

/**
 * @param string $string
 * @return string
 */
function str_title(string $string): string
{
    return mb_convert_case(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS), MB_CASE_TITLE);
}



/**
 * 
 * @param string $text
 * @return string
 */
function str_textarea(string $text): string
{

    $text = filter_var($text, FILTER_SANITIZE_STRIPPED);

    $arrayReplace = ["&#10;", "&#10;&#10;", "&#10;&#10;&#10;", "&#10;&#10;&#10;&#10;", "&#10;&#10;&#10;&#10;&#10;"];

    return "<p>" . str_replace($arrayReplace, "</p><p>", $text) . "</p>";
}

/**
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_limit_words(string $string, int $limit, string $pointer = "..."): string
{
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    $arrWords = explode(" ", $string);
    $numWords = count($arrWords);

    if ($numWords < $limit) {
        return $string;
    }

    $words = implode(" ", array_slice($arrWords, 0, $limit));
    return "{$words}{$pointer}";
}

/**
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_limit_chars(string $string, int $limit, string $pointer = "..."): string
{
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    if (mb_strlen($string) <= $limit) {
        return $string;
    }

    $chars = mb_substr($string, 0, mb_strrpos(mb_substr($string, 0, $limit), " "));
    return "{$chars}{$pointer}";
}

/**
 * 
 * @param string $price
 * @return string
 */
function str_price(?string $price): string
{
    return number_format((!empty($price) ? $price : 0), 2, ",", ".");
}

/**
 *
 * @param string $price
 * @return string
 */
function str_price_invert(?string $price): string
{

    $price = str_replace(".", "", $price);
    $price = str_replace(",", ".", $price);
    return $price;
}

/**
 * @param string|null $search
 * @return string
 */
function str_search(?string $search): string
{
    if (!$search) {
        return "todos";
    }

    $search = preg_replace("/[^a-z0-9A-Z\@\ ]/", "", $search);
    return (!empty($search) ? $search : "todos");
}

/**
 * remove zero a esquerda
 */
function removeZero($value){
    $str = ltrim($value, '0');
    return $str;
}

/**
 * colocar zero a esquerda nos cpfs
 */
function cpfZeros($cpf)
{

    if (strlen($cpf) < 11) {
        if (strlen($cpf) == 10) {
            return str_pad($cpf, 11, '0', STR_PAD_LEFT);
        }
        if (strlen($cpf) == 9) {
            return str_pad($cpf, 11, '00', STR_PAD_LEFT);
        }
        if (strlen($cpf) == 8) {
            return str_pad($cpf, 11, '000', STR_PAD_LEFT);
        }
        if (strlen($cpf) == 7) {
            return str_pad($cpf, 11, '0000', STR_PAD_LEFT);
        }
        if (strlen($cpf) == 6) {
            return str_pad($cpf, 11, '00000', STR_PAD_LEFT);
        }
        if (strlen($cpf) == 5) {
            return str_pad($cpf, 11, '000000', STR_PAD_LEFT);
        }
    }else{
        return $cpf;
    }
}

function mask($val, $mask) {
    $maskared = '';
    $k = 0;
    for($i = 0; $i<=strlen($mask)-1; $i++) {
        if($mask[$i] == '#') {
            if(isset($val[$k])) $maskared .= $val[$k++];
        } else {
            if(isset($mask[$i])) $maskared .= $mask[$i];
        }
    }
    return $maskared;
}

/**
 * ###############
 * ### ASSETS ####
 * ###############
 */

/**
 * 
 * @return \Source\Models\User|null
 */
function user(): ?Source\Models\User
{
    return Source\Models\User::UserLog();
}

function fullNameId($id): string {
    return Source\Models\User::fullNameId($id);
}

function returnAttendanceId($id): string {
    return Source\Models\AttendanceReturn::returnAttendanceId($id);
}

function returnScheduling(): ?Source\Models\Scheduling
{
    return Source\Models\Scheduling::returnScheduling();
}
/**
 * @return \Source\Core\Session
 */
function session(): \Source\Core\Session
{
    return new \Source\Core\Session();
}

/**
 * @param string $path
 * @return string
 */
function url(string $path = null): string
{
    if (strpos($_SERVER["HTTP_HOST"], "localhost")) {
        if ($path) {
            return CONF_URL . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL;
    }

    if ($path) {
        return CONF_URL_BASE . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }
    return CONF_URL_BASE;
}

/**
 * 
 * @return string
 */
function url_back(): string
{
    return ($_SERVER['HTTP_REFERER'] ?? url());
}

function UrlAtual(): string
{
    $dominio= $_SERVER['HTTP_HOST'];
    $url = "http://" . $dominio. $_SERVER['REQUEST_URI'];
    return $url;
}

/**
 * 
 * @param type $path
 * @param type $theme
 * @return string
 */
function theme($path = null, string $theme = CONF_VIEW_THEME_ADMIN): string
{
    if (strpos($_SERVER["HTTP_HOST"], "localhost")) {
        if ($path) {
            return CONF_URL_TEST . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_TEST . "/themes/{$theme}";
    }

    if ($path) {
        return CONF_URL_BASE . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }
    return CONF_URL_BASE . "/themes/{$theme}";
}

/**
 * 
 * @param string $image
 * @param int $width
 * @param int $height
 * @return string
 */
function image(?string $image, int $width, int $height = null): ?string
{
    if ($image) {
        return url() . "/" . (new \Source\Support\Thumb())->make($image, $width, $height);
    }

    return null;
}

/**
 * @param string $url
 */
function redirect(string $url): void
{
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit;
    }

    if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
        $location = url($url);
        header("Location: {$location}");
        exit;
    }
}

/**
 * ################
 * ###   DATE   ###
 * ################
 */

/**
 * @param string $date
 * @param string $format
 * @return string
 */
function date_fmt(?string $date, string $format = "d/m/Y H\hi"): string
{

    $date = (empty($date) ? "now" : $date);

    return (new DateTime($date))->format($format);
}

function date_month_year(?string $date, string $format = "m/Y"): string
{

    $date = (empty($date) ? "now" : $date);

    return (new DateTime($date))->format($format);
}

function date_fmt2(?string $date, string $format = "d/m/Y"): string
{

    $date = (empty($date) ? "now" : $date);

    return (new DateTime($date))->format($format);
}

/**
 * @param string $date
 * @return string
 */
function date_fmt_br(?string $date): ?string
{

    if (isset($date)) {
        $date = (empty($date) ? "now" : $date);

        return (new DateTime($date))->format(CONF_DATE_BR);
    } else {
        return null;
    }
}

function date_fmt_br2(?string $date): ?string
{

    if (isset($date)) {
        $date = (empty($date) ? "now" : $date);

        return (new DateTime($date))->format(CONF_DATE_BR2);
    } else {
        return null;
    }
}


/**
 * @param string $date
 * @return string
 */
function date_fmt_my(?string $date): string
{

    $date = (empty($date) ? "now" : $date);

    return (new DateTime($date))->format(CONF_DATE_MY);
}

/**
 * @param string $date
 * @return string
 */
function date_fmt_app(?string $date): string
{

    $date = (empty($date) ? "now" : $date);

    return (new DateTime($date))->format(CONF_DATE_APP);
}

/**
 * 
 * @param string|null $date
 * @return string|null
 */
function date_fmt_back(?string $date): ?string
{

    if (!$date) {
        return null;
    }

    if (strpos($date, " ")) {
        $date = explode(" ", $date);
        return implode("-", array_reverse(explode("/", $date[0]))) . " " . $date[1];
    }

    return implode("-", array_reverse(explode("/", $date)));
}

/**
 * Converter string de data em datetime
 * @param string $start_date
 * @return DateTime
 */
function date_datetime(string $start_date): DateTime
{

    $date_part = substr($start_date, 0, 2);
    $date_part1 = substr($start_date, 3, 2);
    $date_part2 = substr($start_date, 6, 4);

    $start_date_datetime = new \DateTime($date_part2 . '-' . $date_part1 . '-' . $date_part);

    return $start_date_datetime;
}

/**
 * Verificar se a data é válida
 * @param string $date
 * @return bool
 */
function validate_date(string $date): bool
{

    $date_part = substr($date, 0, 2);
    $date_part1 = substr($date, 3, 2);
    $date_part2 = substr($date, 6, 4);
    return checkdate($date_part1, $date_part, $date_part2);
}

/**
 * converte data de reajuste
 * @param string $date
 * @return string
 */
function return_date_convert(string $date): string
{

    $date_part = substr($date, 0, 2);
    $date_part1 = substr($date, 3, 4);

    return $date_part1 . "-" . $date_part . "-01";
}

/**
 * converte data de reajuste
 * @param string $date
 * @return string
 */
function return_date_renovation(string $date): string
{

    $date_part = substr($date, 0, 2);
    $date_part1 = substr($date, 3, 4);


    //return cal_days_in_month(CAL_GREGORIAN, $date_part , $date_part1);
    return $date_part1 . "-" . $date_part . "-" . cal_days_in_month(CAL_GREGORIAN, $date_part, $date_part1);
}

function return_age($dataNascimento)
{
    $data = new DateTime($dataNascimento);
    $resultado = $data->diff(new DateTime(date('Y-m-d')));
    echo $resultado->format('%Y');
}

function return_age2($dataNascimento)
{
    $dataNascimento = date_fmt_back($dataNascimento);
    $data = new DateTime($dataNascimento);
    $resultado = $data->diff(new DateTime(date('Y-m-d')));
    echo $resultado->format('%Y');
}

function diffMinutesSession($date_atual,$date_base){
    $dateTimeObject1 = date_create($date_base); 
    $dateTimeObject2 = date_create($date_atual); 

    $difference = date_diff($dateTimeObject1, $dateTimeObject2); 

    $minutes = $difference->days * 24 * 60;
    $minutes += $difference->h * 60;
    $minutes += $difference->i;
    return $minutes;
}

function calculaDiffDate($date){
        $dateStart = date("Y-m-d");
        $dateNow   = $date;

        $dif = strtotime($dateNow) - strtotime($dateStart);

        $meses = floor($dif / (60 * 60 * 24 * 30));
        return $meses+1;
}
/**
 * ####################
 * ###   PASSWORD   ###
 * ####################
 */

/**
 * @param string $password
 * @return string
 */
function passwd(string $password): string
{

    if (!empty(password_get_info($password)["algo"])) {
        return $password;
    }

    return password_hash($password, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
}

/**
 * @param string $password
 * @param string $hash
 * @return bool
 */
function passwd_verify(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}

/**
 * @param string $hash
 * @return bool
 */
function passwd_rehash(string $hash): bool
{
    return password_needs_rehash($hash, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
}

/**
 * ###################
 * ###   REQUEST   ###
 * ###################
 */

/**
 * @return string
 */
function csrf_input(): string
{
    $session = new \Source\Core\Session();
    $session->csrf();
    return "<input type='hidden' name='csrf' value='" . ($session->csrf_token ?? "") . "'/>";
}

/**
 * @param $request
 * @return bool
 */
function csrf_verify($request): bool
{
    $session = new \Source\Core\Session();
    if (empty($session->csrf_token) || empty($request['csrf']) || $request['csrf'] != $session->csrf_token) {
        return false;
    }
    return true;
}

/**
 * 
 * @return string|null
 */
function flash(): ?string
{
    $session = new \Source\Core\Session();
    if ($flash = $session->flash()) {
        return $flash;
    }
    return null;
}

/**
 * 
 * @param string $key
 * @param int $limit
 * @param int $seconds
 * @return bool
 */
function request_limit(string $key, int $limit = 5, int $seconds = 60): bool
{

    $session = new \Source\Core\Session();

    if ($session->has($key) && $session->$key->time >= time() && $session->$key->requests < $limit) {
        $session->set($key, [
            "time" => time() + $seconds,
            "requests" => $session->$key->requests + 1
        ]);

        return false;
    }

    if ($session->has($key) && $session->$key->time >= time() && $session->$key->requests >= $limit) {
        return true;
    }

    $session->set($key, [
        "time" => time() + $seconds,
        "requests" => 1
    ]);

    return false;
}

/**
 * @param string $field
 * @param string $value
 * @return bool
 */
function request_repeat(string $field, string $value): bool
{
    $session = new \Source\Core\Session();
    if ($session->has($field) && $session->$field == $value) {
        return true;
    }

    $session->set($field, $value);
    return false;
}

/**
 * 
 * @param type $count_day
 * @param type $start_date
 * @return type
 */
function countDate($count_day, $start_date)
{

    $data = explode("/", $start_date);

    $newData = date("Y-m-d", mktime(0, 0, 0, $data[1] + $count_day, $data[0], $data[2]));

    return $newData;
}

function returnPhone($phone)
{

    if ($phone != 0) {
        $tamanho = strlen($phone);

        if ($tamanho == 11) {
            $date_part = substr($phone, 0, 2);
            $date_part1 = substr($phone, 2, 5);
            $date_part2 = substr($phone, 7, 4);

            return "({$date_part})$date_part1-$date_part2";
        } else {
            $date_part = substr($phone, 0, 2);
            $date_part1 = substr($phone, 2, 4);
            $date_part2 = substr($phone, 6, 4);

            return "({$date_part})$date_part1-$date_part2";
        }
    } else {
        return "";
    }
}
function returnState(string $state): string
{
    if ($state == "ACRE") {
        return "AC";
    }
    if ($state == "ALAGOAS") {
        return "AL";
    }
    if ($state == "AMAPA") {
        return "AP";
    }
    if ($state == "AMAZONAS") {
        return "AM";
    }
    if ($state == "BAHIA") {
        return "BA";
    }
    if ($state == "CEARA") {
        return "CE";
    }
    if ($state == "ESPIRITO SANTO") {
        return "ES";
    }
    if ($state == "GOIAS") {
        return "GO";
    }
    if ($state == "MARANHAO") {
        return "MA";
    }
    if ($state == "MATO GROSSO") {
        return "MT";
    }
    if ($state == "MATO GROSSO DO SUL") {
        return "MS";
    }
    if ($state == "MINAS GERAIS") {
        return "MG";
    }
    if ($state == "PARA") {
        return "PA";
    }
    if ($state == "PARAIBA") {
        return "PB";
    }
    if ($state == "PARANA") {
        return "PR";
    }
    if ($state == "PERNAMBUCO") {
        return "PE";
    }
    if ($state == "PIAUI") {
        return "PI";
    }
    if ($state == "RIO DE JANEIRO") {
        return "RJ";
    }
    if ($state == "RIO GRANDE DO SUL") {
        return "RS";
    }
    if ($state == "RIO GRANDE DO NORTE") {
        return "RN";
    }
    if ($state == "RONDONIA") {
        return "RO";
    }
    if ($state == "RORAIMA") {
        return "RR";
    }
    if ($state == "SANTA CATARINA") {
        return "SC";
    }
    if ($state == "SAO PAULO") {
        return "SP";
    }
    if ($state == "SERGIPE") {
        return "SE";
    }
    if ($state == "TOCATINS") {
        return "TO";
    }
    if ($state == "DISTRITO FEDERAL") {
        return "DF";
    }
    if ($state == "TOCANTINS") {
        return "TO";
    }
}

/**
 * Retrieves the best guess of the client's actual IP address.
 * Takes into account numerous HTTP proxy headers due to variations
 * in how different ISPs handle IP addresses in headers between hops.
 */
function get_ip_address() {
	// check for shared internet/ISP IP
	if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
		return $_SERVER['HTTP_CLIENT_IP'];
	}

	// check for IPs passing through proxies
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		// check if multiple ips exist in var
		if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
			$iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			foreach ($iplist as $ip) {
				if (validate_ip($ip))
					return $ip;
			}
		} else {
			if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
	}
	if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
		return $_SERVER['HTTP_X_FORWARDED'];
	if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
		return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
	if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
		return $_SERVER['HTTP_FORWARDED_FOR'];
	if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
		return $_SERVER['HTTP_FORWARDED'];

	// return unreliable ip since all else failed
	return $_SERVER['REMOTE_ADDR'];
}

/**
 * Ensures an ip address is both a valid IP and does not fall within
 * a private network range.
 */
function validate_ip($ip) {
	if (strtolower($ip) === 'unknown')
		return false;

	// generate ipv4 network address
	$ip = ip2long($ip);

	// if the ip is set and not equivalent to 255.255.255.255
	if ($ip !== false && $ip !== -1) {
		// make sure to get unsigned long representation of ip
		// due to discrepancies between 32 and 64 bit OSes and
		// signed numbers (ints default to signed in PHP)
		$ip = sprintf('%u', $ip);
		// do private network range checking
		if ($ip >= 0 && $ip <= 50331647) return false;
		if ($ip >= 167772160 && $ip <= 184549375) return false;
		if ($ip >= 2130706432 && $ip <= 2147483647) return false;
		if ($ip >= 2851995648 && $ip <= 2852061183) return false;
		if ($ip >= 2886729728 && $ip <= 2887778303) return false;
		if ($ip >= 3221225984 && $ip <= 3221226239) return false;
		if ($ip >= 3232235520 && $ip <= 3232301055) return false;
		if ($ip >= 4294967040) return false;
	}
	return true;
}