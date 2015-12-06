<?php
class Order extends CI_Controller {

	function __construct() {
		parent::__construct();
      $this->load->library('redsys');
      /* URL Helper best in autoload */
      $this->load->helper('url');
  }

  public function pagoTPV($total, $order_id) {
    $this->load->library('redsys');
    $redsys = new Redsys;

    $redsys->setParameter("DS_MERCHANT_AMOUNT",$total*100);
    $redsys->setParameter("DS_MERCHANT_ORDER",strval('YOUR DS_MERCHANT_ORDER'.$order_id));
    $redsys->setParameter("DS_MERCHANT_MERCHANTCODE", 'YOUR DS_MERCHANT_MERCHANTCODE');
    $redsys->setParameter("DS_MERCHANT_CURRENCY", 978);
    $redsys->setParameter("DS_MERCHANT_TRANSACTIONTYPE", 0);
    $redsys->setParameter("DS_MERCHANT_TERMINAL",1);
    $redsys->setParameter("DS_MERCHANT_MERCHANTURL", base_url() . "order/redsys_callback");
    $redsys->setParameter("DS_MERCHANT_URLOK",base_url() . 'order/redsys_ok');
    $redsys->setParameter("DS_MERCHANT_MERCHANTNAME", 'YOUR DS_MERCHANT_MERCHANTNAME');
    $redsys->setParameter("DS_MERCHANT_URLKO",base_url() . 'order/redsys_ko');

    $version="HMAC_SHA256_V1";
    $kc = 'YOUR KEY';
    $params = $redsys->createMerchantParameters();
    $signature = $redsys->createMerchantSignature($kc);
    $this->load->view('redsys/tpv_form_view', compact('params' , 'signature' , 'version'));
  }

  public function redsys_callback() {


    $redsys           = new Redsys;
    $version          = $_POST['Ds_SignatureVersion'];
    $parameters       = $_POST['Ds_MerchantParameters'];
    $signatureReceive = $_POST['Ds_Signature'];

    $decodec    = $redsys->decodeMerchantParameters($parameters);
    $decodec    = json_decode($decodec , true);
    $order_id   = $decodec['Ds_Order'];
    $kc         = 'YOUR KEY';
    $signature  = $redsys->createMerchantSignatureNotif($kc,$parameters);
    if ($signature === $signatureReceive){
      if($decodec['Ds_Response'] < 100){
        // Process order
      }else{
        // Error order
      }
    }else{
      show_404();
    }
  }
  public function redsys_ok(){
    echo 'OK';
  }

  public function redsys_ko(){
    echo 'KO';
  }
}
