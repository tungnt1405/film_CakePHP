<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
// use Cake\Core\Configure;
class VNPAYComponent extends Component
{
    protected $_defaultConfig = [
        'vnp_TmnCode'=>"HG4DTXOD",
        'vnp_HashSecret'=>"FOENIGYLEYYLJTOIPAQCBTLWROMHZMVH",
        'vnp_Url'=>"https://sandbox.vnpayment.vn/paymentv2/vpcpay.html",
        'vnp_Returnurl'=> BASE_URL.'/result',
        'vnp_apiUrl'=>"http://sandbox.vnpayment.vn/merchant_webapi/merchant.html",
    ];

    public function inputData(Array $list)
    {
        // $fullName = trim($list['full_name']);
        // if (isset($fullName) && trim($fullName) != '') {
        //     $name = explode(' ', $fullName);
        //     $vnp_Bill_FirstName = array_shift($name);
        //     $vnp_Bill_LastName = array_pop($name);
        // }

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $this->_defaultConfig['vnp_TmnCode'],
            "vnp_Amount" => $list['payment-amount'] * 100,//giá
            "vnp_Command" => "pay",//phương thức
            "vnp_CreateDate" => date('YmdHis'),//ngày tạo
            "vnp_CurrCode" => "VND",//tiền tệ
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],//địa chỉ web ip
            "vnp_Locale" => 'vn',// ngôn ngữ hiển thị
            "vnp_OrderInfo" => $list['payment-note'],//nội dung thanh toán
            // "vnp_OrderType" => 'topup',
            "vnp_ReturnUrl" => $this->_defaultConfig['vnp_Returnurl'],
            "vnp_TxnRef" => date('YmdHis'),//id thanh toán
            // "vnp_ExpireDate"=> date('YmdHis'),
            // "vnp_Bill_Mobile"=>$list['phone_number'],
            // "vnp_Bill_Email"=>$list['email'],
            // "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
            // "vnp_Bill_LastName"=>$vnp_Bill_LastName,
            // "vnp_Bill_Address"=>$list['address'],
            // "vnp_Bill_City"=>$list['city'],
            // "vnp_Bill_Country"=>$list['country'],
        );
        if (!empty($list['bank_code'])) {
            $inputData['vnp_BankCode'] = $list['bank_code'];
        }
        if (!empty($list['txt_bill_state'])) {
            $inputData['vnp_Bill_State'] = $list['txt_bill_state'];
        }
        return $inputData;
    }

    public function resultQuery($inputData)
    {
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode((String) $value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode((String) $value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode((String) $value) . '&';
        }

        $vnp_Url = $this->_defaultConfig['vnp_Url'] . "?" . $query;
        if (isset($this->_defaultConfig['vnp_HashSecret'])) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $this->_defaultConfig['vnp_HashSecret']);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            // if (isset($_POST['redirect'])) {
            //     header('Location: ' . $vnp_Url);
            //     die();
            // } else {
            //     echo json_encode($returnData);
            //     die();
            // }

        return $vnp_Url;
    }
}
