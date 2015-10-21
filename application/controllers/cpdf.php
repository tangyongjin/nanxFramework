<?php 
/*------------------------------------------
/ Author   :
/ DateTime :2012-09-24
------------------------------------------*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cpdf extends CI_Controller {
	function resBillPdf()
  {
  
  $post = file_get_contents('php://input');
  $para = (array )json_decode($post); 	
  
  $pid=$para['pid'];
  $filename=$para['pdfname'];
  
  $sql="select * from  newoss_res_pay_request where pid=$pid ";
  $data=$this->db->query($sql)->result_array();
  $d=$data[0];
  
  $cycle=$d['bill_cycle'];
  $year=date('Y',strtotime($cycle) );
  $month=date('n',strtotime($cycle) );
  $d['year']=$year;
  $d['month']=$month;
  
  $where=array( 'res_uid'=> $d['res_uid'] , 'year'=>$d['year'] ,'month'=> $d['month']  );
  $this->db->where($where);
  $row=$this->db->get('newoss_res_monthly_fee_and_discount')->result_array(); 
  $row= $row[0]; 
 
  $where=array( 'res_vendor' => $d['vendor']);
  $this->db->where($where);
  $bank=$this->db->get('newoss_res_contract')->result_array();
  if (count($bank)==1)
  {
   $bank=$bank[0]; 
  }
  else
  {
    $bank=array(
    'bank'=>'数据错误,请检查资源提供方资料',
    'bank_name'=>'',
    'bank_no'=>''
    );
  } 
 
  
  $where=array( 'res_uid'=> $d['res_uid'] );
  $this->db->where($where);
  $res=$this->db->get('newoss_resource')->result_array();
  $res=$res[0];
  
  $l = Array();
  $l['a_meta_charset'] = 'UTF-8';
  $l['a_meta_dir'] = 'ltr';
  $l['a_meta_language'] = 'cn';
  $l['w_page'] = 'Page';

  $this->load->library('Tcpdf_lib');
  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE , '');
  $pdf->setCellHeightRatio(1.8);
  
  $YAHEI = $pdf->addTTFfont('pdflib/tcpdf/fonts/msyh.ttf');
  $pdf->setHeaderFont(Array('pdfahelveticai', '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array('pdfahelveticai', '', PDF_FONT_SIZE_DATA));

  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

 
  $pdf->SetMargins(PDF_MARGIN_LEFT, 18, PDF_MARGIN_RIGHT);
  $pdf->SetHeaderMargin(4);
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

  $pdf->SetAutoPageBreak(TRUE, 12);
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
  $pdf->setLanguageArray($l);


  $pdf->AddPage();
  $txt = '';

  $pdf->SetFont($YAHEI, '', 18, '','false');
  
  $pdf->Write(0, '付款单号'.$d['req_no'], '', 0, 'L', true, 0, false, false, 0);
  $pdf->SetFont($YAHEI, '', 11, '','false');
    $pdf->Write(0, "资源号: ".$d['res_uid'].$txt, '', 0, 'L', true, 0, false, false, 0);
  $pdf->Write(0, "资源提供方: ".$d['vendor'].$txt, '', 0, 'L', true, 0, false, false, 0);
    $pdf->Write(0, "付款方: ".$d['res_sale'].$txt, '', 0, 'L', true, 0, false, false, 0);
  $pdf->Write(0, "财务编号: ".$res['financial_des'].$txt, '', 0, 'L', true, 0, false, false, 0);
  $pdf->Write(0, "[商务信息]: ".$res['busi_des'].$txt, '', 0, 'L', true, 0, false, false, 0);
  $pdf->Write(0, "[网管信息]: ".$res['noc_des'].$txt, '', 0, 'L', true, 0, false, false, 0);
 $pdf->Write(0, '____________________________________________________________________________________________________','', 0, 'L', true, 0, false, false, 0);

  $pdf->Write(0, '本资源从'.$row['s'].' 到 '.$row['e'].',共使用'.$row['days_diff'].'天,', '', 0, 'L', true, 0, false, false, 0);
  $pdf->Write(0, '当期价格:'.$row['price'], '', 0, 'L', true, 0, false, false, 0);
  $shold_pay=$row['monthly_fee'] - $row['discount_fee'];
  $pdf->Write(0, '理论付款:'.$row['monthly_fee'].'(月租金)-'.$row['discount_fee'].'(扣减)='.$shold_pay   , '', 0, 'L', true, 0, false, false, 0);
  
  $pdf->SetTextColor(50,40,160);
  $pdf->Write(0, '申请付款金额:'.$d['request_money'], '', 0, 'L', true, 0, false, false, 0);
  $pdf->SetTextColor(0,0,0);
  
  $pdf->Write(0, '上月故障情况如下:', '', 0, 'L', true, 0, false, false, 0);
   $pdf->Write(0, "   E1故障时长:".$row['e1_duration']."  扣减".$row['e1_discount'], '', 0, 'L', true, 0, false, false, 0);
   $pdf->Write(0, "   E2故障时长:".$row['e2_duration']."  扣减".$row['e2_discount'], '', 0, 'L', true, 0, false, false, 0);
   $pdf->Write(0, "   E3故障时长:".$row['e3_duration']."  扣减".$row['e3_discount'], '', 0, 'L', true, 0, false, false, 0);
   $pdf->Write(0, "   E4故障时长:".$row['e4_duration']."  扣减".$row['e4_discount'], '', 0, 'L', true, 0, false, false, 0);
   $pdf->Write(0, "   E5故障时长:".$row['e5_duration']."  扣减".$row['e5_discount'], '', 0, 'L', true, 0, false, false, 0);
   
   $pdf->Write(0, '扣款:'.$row['discount_fee'], '', 0, 'L', true, 0, false, false, 0);
   $pdf->Write(0, '备注', '', 0, 'L', true, 0, false, false, 0);
   $pdf->Write(0, '     '.$d['memo'], '', 0, 'L', true, 0, false, false, 0);
   
   $pdf->Write(0, '____________________________________________________________________________________________________','', 0, 'L', true, 0, false, false, 0);
   
   $pdf->Write(0, '开户行:'.$bank['bank'],'', 0, 'L', true, 0, false, false, 0);
   $pdf->Write(0, '户名:'.$bank['bank_name'],'', 0, 'L', true, 0, false, false, 0);
   $pdf->Write(0, '帐号:'.$bank['bank_no'],'', 0, 'L', true, 0, false, false, 0);
   $pdf->Write(0, '____________________________________________________________________________________________________','', 0, 'L', true, 0, false, false, 0);
  
   $pdf->setCellHeightRatio(3.6);
  
   $pdf->Write(0, '网管部门签字:______________________','', 0, 'L', true, 0, false, false, 0);
   $pdf->Write(0, '商务部门签字:______________________','', 0, 'L', true, 0, false, false, 0);
   $pdf->Write(0, '财务部门签字:______________________','', 0, 'L', true, 0, false, false, 0);
   $pdf->Write(0, '总经理签字:______________________','', 0, 'L', true, 0, false, false, 0);
   
   
   $pdf->Output('tmp/'.$filename,'F');
   
         $result = array(
            'success' => true,
            'errmsg' => '',
            'data' => $d,
             'extra'=> $row,
            //'tips'=>'表格建立成功',
            'errno' =>0);
        echo json_encode($result);
  
  }
    }
?>
