<?php



$html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title></title>
</head>
<body>
<table border="0">
  <tr>
    <td><b>Siklus Bisnis</b></td> 
    <td>:</td> 
    <td>Pendapatan</td>
  </tr>
 
  <tr>
    <td><b>Sub Siklus Bisnis</b></td> 
    <td>:</td> 
    <td>Pendapatan Interkoneksi, Transponder &amp; SL</td>
  </tr>
 
  <tr>
    <td><b>Proses Bisnis</b></td> 
    <td>:</td> 
    <td>A.05.06 - Billing Interkoneksi</td>
  </tr>
 
  <tr>
    <td><b>Nama Dok</b></td> 
    <td>:</td> 
    <td>C02 - Review Pelaksanaan Tahapan Proses Summary (IC)</td>
  </tr>
 
  <tr>
    <td><b>Versi Dok</b></td> 
    <td>:</td> 
    <td>testing</td>
  </tr>
 
  <tr>
    <td><b>Periode Trafik</b></td> 
    <td>:</td> 
    <td></td>
  </tr>
</table>
<br>

<table border="1">
  <tr>
    <th scope="col">Proses</th>
 
    <th scope="col">Status</th>
 
    <th scope="col">First<br>
    Processing Time</th>
 
    <th scope="col">Last<br>
    Processing Time</th>
 
    <th scope="col">Total</th>
  </tr>
 
  
  <tr>
    <td nowrap>00.CDR_NYEBRANG</td> 
    <td nowrap>Finish</td> 
    <td nowrap>2016-02-10 08:00:39</td> 
    <td nowrap>2016-02-11 07:11:53</td> 
    <td style="TEXT-ALIGN: right" nowrap>1.00</td>
  </tr>
 
  <tr>
    <td nowrap>01.CDR_PROCESSING</td> 
    <td nowrap>Finish</td> 
    <td nowrap>2016-02-09 09:35:35</td> 
    <td nowrap>2016-03-02 10:20:29</td> 
    <td style="TEXT-ALIGN: right" nowrap>20,234.00</td>
  </tr>
 
  <tr>
    <td nowrap>02.RECYCLE</td> 
    <td nowrap>Finish</td> 
    <td nowrap>2016-02-09 14:32:00</td> 
    <td nowrap>2016-03-01 07:05:48</td> 
    <td style="TEXT-ALIGN: right" nowrap>414.00</td>
  </tr>
 
  <tr>
    <td nowrap>03.FINAL_RECYCLE</td> 
    <td nowrap>Finish</td> 
    <td nowrap>2016-02-15 07:41:47</td> 
    <td nowrap>2016-03-02 10:34:31</td> 
    <td style="TEXT-ALIGN: right" nowrap>6,015.00</td>
  </tr>
 
  <tr>
    <td nowrap>04.SUMMARY_PER_BATCH</td> 
    <td nowrap>Finish</td> 
    <td nowrap>2016-02-15 10:16:59</td> 
    <td nowrap>2016-03-02 10:35:53</td> 
    <td style="TEXT-ALIGN: right" nowrap>20,234.00</td>
  </tr>
 
  <tr>
    <td nowrap>05.GENERATE_FACT</td> 
    <td nowrap>Finish</td> 
    <td nowrap>2016-03-02 10:36:55</td> 
    <td nowrap>2016-03-02 10:55:14</td> 
    <td style="TEXT-ALIGN: right" nowrap>1.00</td>
  </tr>
 
  <tr>
    <td nowrap>06.SUMMARY_COMMITMENT</td> 
    <td nowrap>Finish</td> 
    <td nowrap>2016-03-02 11:09:39</td> 
    <td nowrap>2016-03-02 11:17:00</td> 
    <td style="TEXT-ALIGN: right" nowrap>1.00</td>
  </tr>
 
  <tr>
    <td nowrap>07.SUMMARY_SAP</td> 
    <td nowrap>Finish</td> 
    <td nowrap>2016-03-02 11:27:54</td> 
    <td nowrap>2016-03-02 11:35:54</td> 
    <td style="TEXT-ALIGN: right" nowrap>1.00</td>
  </tr>
 
  <tr>
    <td nowrap>08.INTERFACE_SAP</td> 
    <td nowrap>Finish</td> 
    <td nowrap>2016-03-02 11:37:54</td> 
    <td nowrap>2016-03-02 11:37:54</td> 
    <td style="TEXT-ALIGN: right" nowrap>1.00</td>
  </tr>
 
  
</table>
<br>
</body>
</html>

';

//==============================================================
//==============================================================
//==============================================================
include("../mpdf.php");

$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13); 

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html,2);

$mpdf->Output('mpdf.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================


?>