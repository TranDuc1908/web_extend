function removeTagBr($str){$str = str_replace("<br />", "", $str);return $str;}

function phoneFilter($phone){ // return phone +84
	if (!$phone) return ['res' => 'warning', 'status' => 'Thiếu thông tin'];
	$phone = trim($phone);
	$count = strlen($phone);
	#
	$form = ltrim($phone, $phone[0]);
    if($count < 9 || $count > 13 || !is_numeric($form)) return ['res' => 'warning', 'status' => 'Số điện thoại không đúng định dạng'];

	#
    if(substr($phone,0,1) == "1"){
        return $phone;
    }elseif (substr($phone,0,1) == "0") {
        return "+84".substr($phone,1);
    }elseif (substr($phone,0,2) == "84") {
       return "+".$phone;
    }elseif (substr($phone,0,3) == "+84") {
       return $phone;
    }elseif(substr($phone,0,1) != "0") {
        return "+84".$phone;
    }else{
        return false;
    }
}

function returnAPI($res, $status="", $data=""){
    if($res == "fail" && !$status && !$data) die(json_encode(["res" => $res, "status" => "Lỗi kỹ thuật"]));
    if($res == "user_lvl" && !$status && !$data) die(json_encode(["res" => "warning", "status" => "Không đủ quyền hạn"]));
    if($res == "locked" && !$status && !$data) die(json_encode(["res" => "warning", "status" => "Cộng đồng tạm thời đã bị khóa"]));
    die(json_encode(["res" => $res, "status" => $status, "data" => $data]));
}

function uploadBase64Image($arrImages){
    $arrImage = str_replace("\\", "", $arrImages);
    $arrImage = json_decode($arrImage,true);

    $res = [];
    foreach ($arrImage as $image) {
        $file_link = uniqid().'.jpg';
        $fileName = 'uploads/'.$file_link;
        $imageData = base64_decode($image);
        if(file_put_contents($fileName, $imageData)){
            $result = $this->moveMedia($file_link,'comment');
            if($result) $res[] = $result;
            else return false;
        } else return false;
    }
    return $res;
}


function execCURL($type, $url, $arr = []){
    $curl = curl_init();

    if($type == "post"){
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $arr,
        ));
    } else {
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
    }

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if($err) {echo $err;die;}
    return $response;
}


function strip_onlyTag($inp, $arr){
    $allow = "<h1><h2><h3><h4><h5><img><picture><figure><small><p><strong><a><div><section>";
    foreach($arr as $string){
        $allow = str_replace($string, "", $allow);
    }
    return strip_tags($inp, $allow);
}

function navigate($mod, $act="", $params=[]){
    $link = "/?mod=".$mod;
    if($act) $link .= "&act=".$act;
    if($params) foreach($params as $k => $v){$link .="&".$k."=".$v;}
    header("location: ".$link);
    die;
}