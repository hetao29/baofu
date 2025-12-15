<?php

/**
 * @Desc:
 * @author dasheng@baofu.com(大圣)
 * @datetime 2025/05/05
 */
try {
    require_once "../Init/init.php";
    $OrderType = "0";
    $filezip = "H:\\pic\\idphoto.zip";

    $PostParm =[];// 提交参数
    $PostParm["memberId"] = $GLOBALS["Member_Id"];
    $PostParm["terminalId"] = $GLOBALS["Terminal_Id"];
    $PostParm["orderType"] = $OrderType;

    $DataParm = [];
    $DataParm["accType"] = "2";
    $DataParm["transSerialNo"] = Tools::getTransid("TSN");
    $DataParm["businessParams"] = "LN17464143403681"; // Ordertype 0 :自定义唯一标识，示例：登录号
    //$DataParm["noticeUrl"] = ""; // 回调地址
    Log::EchoFormat("上传流水号：".$DataParm["transSerialNo"]);
    $File101 = [];
    $File101["fileType"] = "101";
    $File101["fileName"] = "business_license";

    $File102 = [];
    $File102["fileType"] = "102";
    $File102["fileName"] = "acc_open_license";

    $File104 = [];
    $File104["fileType"] = "104";
    $File104["fileName"] = "id_front";

    $File111 = [];
    $File111["fileType"] = "111";
    $File111["fileName"] = "id_reverse";

    $FileNameMaps = [];
    $FileNameMaps[] = $File101;
    $FileNameMaps[] = $File102;
    $FileNameMaps[] = $File104;
    $FileNameMaps[] = $File111;

    $DataParm["fileNameMap"] = $FileNameMaps;

    Log::EchoFormat("上传文件：".realpath($filezip).",".mime_content_type($filezip).",".basename($filezip));
    $sufJson = json_encode($DataParm);
    Log::EchoFormat("JSON序列化：".$sufJson);
    $PostParm["content"] = NewRsaUtil::encryptByPfx($sufJson,$GLOBALS["PFX_FILE_PATH"],$GLOBALS["Key_Pwd"]);
    Log::EchoFormat("请求参数".json_encode($PostParm));

    if(!empty($filezip)){// 文件上传
        if(!file_exists($filezip))  throw new \Exception("上传文件不存在！路径：".$filezip);
        $PostParm["file"] = new CURLFile(realpath($filezip),mime_content_type($filezip),basename($filezip));
    }

    $returnstr = HttpClient::MultiPost($PostParm,"https://vgw.baofoo.com/baofu-upload-trade/trade/syncUploadFile",$filezip);
    Log::EchoFormat("返回报文：".$returnstr);
    if(empty($returnstr)) throw new Exception("请求返回为空！");
    $debyresult = NewRsaUtil::decrptByPub($returnstr,$GLOBALS["CER_FILE_PATH"]);
    Log::EchoFormat("解密：".$debyresult);
    $resultObj = json_decode($debyresult,true);
    if($resultObj["success"])
    {
        Log::EchoFormat("流水号：".$resultObj["result"]["transSerialNo"]);
        foreach ($resultObj["result"]["dfsFileNotifyList"] as $item)
        {
            Log::EchoFormat("文件：".json_encode($item));
        }
    }
}catch (Exception $ex){
    echo $ex->getMessage();
}
