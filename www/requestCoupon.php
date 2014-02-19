<?php
if (!function_exists('json_encode'))
{
    function json_encode($a=false)
    {
        if (is_null($a)) return 'null';
        if ($a === false) return 'false';
        if ($a === true) return 'true';
        if (is_scalar($a))
        {
            if (is_float($a))
            {
                // Always use "." for floats.
                return floatval(str_replace(",", ".", strval($a)));
            }

            if (is_string($a))
            {
                static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
                return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
            }
            else
                return $a;
        }
        $isList = true;
        for ($i = 0, reset($a); $i < count($a); $i++, next($a))
        {
            if (key($a) !== $i)
            {
                $isList = false;
                break;
            }
        }
        $result = array();
        if ($isList)
        {
            foreach ($a as $v) $result[] = json_encode($v);
            return '[' . join(',', $result) . ']';
        }
        else
        {
            foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
            return '{' . join(',', $result) . '}';
        }
    }
}
$connect=mysql_connect("localhost","echo","1351915");
$mysql=mysql_select_db("echo",$connect);
if(!$connect) echo "wrong connect";

$couponType = $_GET["couponType"];
$query = "select * from coupon where (couponType = \"$couponType\" and used = 0)  order by rand() limit 1 ";
$result = mysql_query($query);
$num_rows = mysql_num_rows($result);
if($num_rows > 0){
    $couponNumber1 = 0;
    $couponNumber2 = 0;
    $couponId = 0;

    while($row = mysql_fetch_array($result)){
        $couponNumber1 = $row['couponNumber1'];
        $couponNumber2 = $row['couponNumber2'];
        $couponId = $row['id'];
    }

    $jsonArray = array("couponNumber1"=>$couponNumber1, "couponNumber2"=>$couponNumber2, "couponId"=>$couponId );
    echo json_encode($jsonArray);
}
else{
    echo "noData";
}
?>