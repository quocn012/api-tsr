<?php
/*
CODE ĐƯỢC VIẾT BỞI CHÂU CHÍ QUỐC
ZALO : 01684853992
thằng nào đem bán tao đá thục mỗm :(
*/
header("Content-type: application/json; charset=utf-8");
$days = '10000';
$date = date('d-m-Y',strtotime('-'.(int)$days.' days'));
        $now = date('d-m-Y');
$link = "https://thesieure.com/wallet/history/vnd?search=&fromdate=$date&todate=$now&submit=filter";
function chauchiquoc($link1){
$cookie = ""; // sửa thông tin ở đây
$useragent = "";// sửa thông tin ở đây
$curl = curl_init();
$option = [
    CURLOPT_URL=>trim($link1),
    CURLOPT_COOKIE=>$cookie,
    CURLOPT_USERAGENT=>$useragent,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_CONNECTTIMEOUT => 60,
    CURLOPT_HTTPHEADER => array(
        "Host: thesieure.com",
        "sec-fetch-dest: document",
        "sec-fetch-site: same-origin",
        "sec-fetch-mode: navigate",
        "sec-fetch-user: ?1",
        "save-data: on",
        "referer: https://thesieure.com"),
    CURLOPT_COOKIEJAR=>'cookie.txt',
    CURLOPT_COOKIEFILE=>'cookie.txt',
    CURLOPT_FOLLOWLOCATION=>false,
    CURLOPT_RETURNTRANSFER=>true,
];
curl_setopt_array($curl,$option);
return curl_exec($curl);
}
function loc($string)
{
    $thay = ['đ',',','-','|'];
    $thay1 = ['','','',''];
    return str_replace($thay, $thay1, $string);
}
$name = chauchiquoc($link);
$dom = new \DOMDocument();
$dom->loadHTML($name);
$table = $dom->getElementsByTagName('table');
$title = $dom->getElementsByTagName("title")->nodeValue;
if(strstr($title,"Redirecting")){
    echo json_encode(array(
                'status'=>"error",
                "message"=>"THẤT BẠI COOKIE ĐÃ BỊ SAI "
            ),JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
            die;
        }
$paragraphs = $dom->getElementsByTagName('td');
$magd = $paragraphs->item(0)->nodeValue;
$paragraphs = $dom->getElementsByTagName('td');
$truocgd = $paragraphs->item(1)->nodeValue;
$paragraphs = $dom->getElementsByTagName('td');
$sotien = $paragraphs->item(2)->nodeValue;
$paragraphs = $dom->getElementsByTagName('td');
$saugd = $paragraphs->item(3)->nodeValue;
$paragraphs = $dom->getElementsByTagName('td');
$time = $paragraphs->item(5)->nodeValue;
$paragraphs = $dom->getElementsByTagName('td');
$noidung = $paragraphs->item(6)->nodeValue;
$quocdz['ma_gd'] = loc(trim($magd));
$quocdz['truoc_gia_dich'] = loc(trim($truocgd));
$quocdz['sau_gia_dich'] = loc(trim($saugd));
$quocdz['sotien'] = loc(trim($sotien));
//$quocdz['loai'] = trim($io);
$quocdz['thoi_gian'] = trim($time);
$quocdz['noidung'] = loc(trim($noidung));
echo json_encode($quocdz,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
