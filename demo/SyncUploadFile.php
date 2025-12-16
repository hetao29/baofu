<?php

/**
 * 资质文件上传接口
 * https://doc.mandao.com/docs/bct/bct-1gbbtmk773oah
 */
try {
    require_once 'init.php';
    $OrderType = "0";
    $filezip = "/Users/hetal/Downloads/test.zip";

    $PostParm = []; // 提交参数
    $PostParm["memberId"] = $GLOBALS["Member_Id"];
    $PostParm["terminalId"] = $GLOBALS["Terminal_Id"];
    $PostParm["orderType"] = $OrderType;

    $DataParm = [];
    $DataParm["accType"] = "2";
    $DataParm["transSerialNo"] = Baofu\Util\Tools::getTransid("TSN");
    $DataParm["businessParams"] = "LN17464143403681"; // Ordertype 0 :自定义唯一标识，示例：登录号
    //$DataParm["noticeUrl"] = ""; // 回调地址
    Baofu\Util\Log::EchoFormat("上传流水号：" . $DataParm["transSerialNo"]);
    $File101 = [];
    $File101["fileType"] = "101";
    $File101["fileName"] = "business_license.png";

    $File102 = [];
    $File102["fileType"] = "102";
    $File102["fileName"] = "acc_open_license.png";

    $File104 = [];
    $File104["fileType"] = "104";
    $File104["fileName"] = "id_front.png";

    $File111 = [];
    $File111["fileType"] = "111";
    $File111["fileName"] = "id_reverse.png";

    $FileNameMaps = [];
    $FileNameMaps[] = $File101;
    $FileNameMaps[] = $File102;
    $FileNameMaps[] = $File104;
    $FileNameMaps[] = $File111;

    $DataParm["fileNameMap"] = $FileNameMaps;

    Baofu\Util\Log::EchoFormat("上传文件：" . realpath($filezip) . "," . mime_content_type($filezip) . "," . basename($filezip));
    $sufJson = json_encode($DataParm);
    Baofu\Util\Log::EchoFormat("JSON序列化：" . $sufJson);
    $PostParm["content"] = Baofu\Security\RSA::encryptByPFXFile($sufJson, $GLOBALS["PFX_FILE_PATH"], $GLOBALS["Key_Pwd"]);
    Baofu\Util\Log::EchoFormat("请求参数" . json_encode($PostParm));

    $multipart = [];
    foreach ($PostParm as $k => $v) {
        $multipart[] = [
            "name" => $k,
            "contents" => $v,
        ];
    }
    $multipart[] = [
        'name'     => 'file', // The name of the form field the API expects
        'contents' => fopen($filezip, 'r'), // Use fopen for efficient streaming
        'filename' =>  basename($filezip), // Optional: provides a filename to the API
    ];
    print_r($multipart);
    $client = new \GuzzleHttp\Client();
    $res = $client->request('POST', "https://vgw.baofoo.com/baofu-upload-trade/trade/syncUploadFile", [
        'multipart' => $multipart,
    ]);

    $returnstr = (string)$res->getBody();

    Baofu\Util\Log::EchoFormat("返回报文：" . $returnstr);
    if (empty($returnstr)) throw new Exception("请求返回为空！");
    $debyresult = Baofu\Security\RSA::decryptByCERFile($returnstr, $GLOBALS["CER_FILE_PATH"]);
    Baofu\Util\Log::EchoFormat("解密：" . $debyresult);
    $resultObj = json_decode($debyresult, true);
    if ($resultObj["success"]) {
        Baofu\Util\Log::EchoFormat("流水号：" . $resultObj["result"]["transSerialNo"]);
        foreach ($resultObj["result"]["dfsFileNotifyList"] as $item) {
            Baofu\Util\Log::EchoFormat("文件：" . json_encode($item));
        }
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
