<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\ItemTransaction;
use App\Models\LogActivity;
use App\Models\OrderItem;
use App\Models\OrderPurchase;
use App\Models\Stock;
use App\Models\StockItem;
use App\Models\Unit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class PrintFormController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     
    public function index()
    {
       // $pdf = new setasign\Fpdi\Fpdi();
    

        //$pdf = new FPDF();
        $pdf = new FPDI('l');
        $pdf->AddPage();
        $pdf->AddFont('THSarabunNew','','THSarabunNew.php');
        $pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');

        $pdf->SetFont('THSarabunNew','B');
        $pdf->SetFontSize('16'); 

        //title
        $division_name = 'สาขาวิชาการบริบาลผู้ป่วยนอก';
        $head = 'แบบฟอร์มรายการสั่งซื้อวัสดุ(แบบสัญญา)ของ สาขา/หน่วยงาน';
        $title = $head.'  '.$division_name;
        // $pdf->Cell(0,0,'Hello World',0,0,'C');
        // $pdf->Ln(5);
        $pdf->Cell(0,0,iconv('UTF-8', 'cp874', $title),0,0,'C');

        $pdf->SetFont('THSarabunNew');
        $pdf->SetFontSize('16'); 
        $pdf->SetXY(20, 19);
        $pdf->Cell(25,10,iconv('UTF-8', 'cp874', 'รายการที่ 1'));

       // $pdf->SetTitle('แบบฟอร์มรายการสั่งซื้อวัสดุของ สาขา/หน่วยงาน');
       
       
        $pdf->Output('I');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(OrderItem $order)
    {
           //Log::info($order->items);


          $pdf = new FPDI('l');
          $pdf->AddPage();
          $pdf->AddFont('THSarabunNew','','THSarabunNew.php');
          $pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');
  
          // add  image watermark
         // $pdf->Image('https://a7sas.net/wp-content/uploads/2019/07/4060.jpeg',60,30,90,0);
        // $pdf->Image(storage_path('images/logo_med_tranparent.gif'),60,30,90,0,'GIF');
         //$pdf->Image(storage_path('app/public/images/watermark_medstock.png'),20,30,0,0,'png');
          
          //title
          $pdf->SetFont('THSarabunNew','B');
          $pdf->SetFontSize('20'); 
          $unit = Unit::where('unitid',$order->items[0][0]['stock_id'])->first();
        //  Log::info($unit);
          $division_name = $unit->unitname;
          $head = 'แบบฟอร์มบันทึกการรับพัสดุ สาขา/หน่วยงาน';
          $title = $head.'  '.$division_name;
          $pdf->Cell(0,15,iconv('UTF-8', 'cp874', $title),0,0,'C');
  
   
          //head column
          $pdf->SetFont('THSarabunNew','B');
          $pdf->SetFontSize('16'); 
          $pdf->SetXY(18, 25);
         // $pdf->SetLineWidth(2);
          // $pdf->Line(10,50,10,50);
          $pdf->SetLineWidth(1);
          $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'ลำดับ    รหัส              ชื่อ                                               บริษัทผู้ขาย                                               วันที่รับเข้า               จำนวนสั่งซื้อ        คงเหลือ           '),'B');
       
          //list item
          $pdf->SetFont('THSarabunNew');
          $pdf->SetFontSize('16'); 
          $total_all = 0;
          $x=20;
          $y=35;
          $pdf->SetXY($x, $y);
          $pdf->SetLineWidth(0.2);
         // Log::info($order->timeline['checkin_datetime']);
          foreach($order->items as $index=>$item){
              //Log::info('stock_item_id->'.$item['id']);
              $i = $index;
              $index = $index+1;
              if(strlen($item[0]['item_name'])>30){
                $pdf->SetFontSize('12'); 
              }
              $item_print = $index.'. '.$item[0]['sap'].'    '.$item[0]['item_name'];
              $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $item_print),'B');
             
              
              if(strlen($item[0]['business_name'])>100){
                  $pdf->SetFontSize('12'); 
              }
              $pdf->SetXY(110, $y);
              $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $item[0]['business_name']));

              $pdf->SetFontSize('16');
              $pdf->SetXY(200, $y);
              $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $order->timeline['checkin_datetime']));
  
              $pdf->SetFontSize('16');
              $pdf->SetXY(243, $y);
              $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $item[0]['order_input']));

              //จำนวนคงเหลือ
              //$item_sum = StockItem::select('item_sum')->whereId($item[0]['id'])->first();
             // Log::info('item_sum->'.$order->timeline['item_sum_old'][$i]);
              $item_sum = $item[0]['order_input']+$order->timeline['item_sum_old'][$i];
              $pdf->SetXY(268, $y);
              $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $item_sum));

          
            //   $pdf->SetXY(250, $y);
            //   $pdf->Cell(0,10,iconv('UTF-8', 'cp874', number_format($item[0]['total'],2)));
  
              $total_all = $total_all+$item[0]['total'];
              $y = $y+10;
              $pdf->SetXY($x, $y);
          }
  
        //   $pdf->SetXY(225, $y);
        //   $total_all_print = 'รวมเป็นเงิน  '.number_format($total_all,2).'  บาท';
        //   $pdf->SetFont('THSarabunNew','B');
        //   $pdf->SetFontSize('18'); 
        //   $pdf->Cell(0,15,iconv('UTF-8', 'cp874', $total_all_print));
  
          $y = $y+50;
          $pdf->SetFont('THSarabunNew');
          $pdf->SetFontSize('16'); 
          $pdf->SetXY(20, $y);
          $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'ลงชื่อ................................................เจ้าหน้าที่สโตร์/ผู้รับผิดชอบ'));
          $y = $y+10;
          $pdf->SetXY(20, $y);
          $pdf->Cell(0,10,iconv('UTF-8', 'cp874', '      (                                            )'));
          $y = $y+10;
          $pdf->SetXY(20, $y);
          $pdf->Cell(0,10,iconv('UTF-8', 'cp874', '         วันที่......................................'));
  
       
  
          $y = 100;
          $pdf->SetXY(180, $y);
          $pdf->Cell(0,10,iconv('UTF-8', 'cp874', '          ลงนาม................................................หัวหน้าห้องปฎิบัติการ'));
          $y = $y+10;
          $pdf->SetXY(180, $y);
          $pdf->Cell(0,10,iconv('UTF-8', 'cp874', '                  (                                             )'));
          $y = $y+10;
          $pdf->SetXY(180, $y);
          $pdf->Cell(0,10,iconv('UTF-8', 'cp874', '                  วันที่......................................'));
  
          
          // วันเวลาที่พิมพ์
          $mutable = Carbon::now();
          //\Log::info($mutable);
          $tmp_date_now = explode(' ', $mutable);
          $split_date_now = explode('-', $tmp_date_now[0]);
          $year = (int) $split_date_now[0] + 543;
          $thaimonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
          $date_now_show = $split_date_now[2].'  '.$thaimonth[(int) $split_date_now[1]].' '.$year;
  
          $pdf->SetFontSize('14');
          $pdf->SetXY(200,3);
          $date_print = 'วันเวลาที่พิมพ์'.'  '.$date_now_show.'  '.$tmp_date_now[1].' น.';
          $pdf->Cell(0, 10, iconv('UTF-8', 'cp874', $date_print), 0, 0, 'R');

          $pdf->SetXY(10,3);
          $date_print = 'อ้างอิงจากเลขที่ใบสั่งซื้อ:'.'  '.$order['create_no'].'/'.$order['year'];
          $pdf->Cell(0, 10, iconv('UTF-8', 'cp874', $date_print), 0, 0, 'L');
  
          //test font color
          // $pdf->SetFontSize('50');
          // $pdf->SetTextColor(255,192,203);
          // $pdf->SetXY(100,100);
          // $pdf->Cell(0,15,iconv('UTF-8', 'cp874', 'TEST  TEST'));
  
          $pdf->Output('I');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(OrderItem $order)
    {
        
       // Log::info($order);
       // Log::info($order->items);


        $pdf = new FPDI('l');
        $pdf->AddPage();
        $pdf->AddFont('THSarabunNew','','THSarabunNew.php');
        $pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');

        // add  image watermark
       //$pdf->Image(storage_path('app/public/images/watermark_medstock.png'),20,30,0,0,'png');
        
        //title
        $pdf->SetFont('THSarabunNew','B');
        $pdf->SetFontSize('20'); 
        $unit = Unit::where('unitid',$order->items[0][0]['stock_id'])->first();
        //Log::info($unit);
        $division_name = $unit->unitname;
        $head = 'แบบฟอร์มรายการสั่งซื้อวัสดุ(แบบสัญญา)ของ สาขา/หน่วยงาน';
        $title = $head.'  '.$division_name;
        $pdf->Cell(0,15,iconv('UTF-8', 'cp874', $title),0,0,'C');

 
        //head column
        $pdf->SetFont('THSarabunNew','B');
        $pdf->SetFontSize('16'); 
        $pdf->SetXY(18, 25);
        $pdf->SetLineWidth(2);
        // $pdf->Line(10,50,10,50);
        $pdf->SetLineWidth(1);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'ลำดับ    รหัส              ชื่อ                                               บริษัทผู้ขาย                                   จำนวนสั่งซื้อ      มูลค่า(บาท)/หน่วย           รวม'),'B');
     
        //list item
        $pdf->SetFont('THSarabunNew');
        $pdf->SetFontSize('16'); 
        $total_all = 0;
        $x=20;
        $y=35;
        $pdf->SetXY($x, $y);
        $pdf->SetLineWidth(0.1);
        foreach($order->items as $index=>$item){
            $index = $index+1;
            if(strlen($item[0]['item_name'])>30){
                $pdf->SetFontSize('12'); 
            }
            $item_print = $index.'. '.$item[0]['sap'].'    '.$item[0]['item_name'];
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $item_print),'B');
           
            
            if(strlen($item[0]['business_name'])>100){
                $pdf->SetFontSize('12'); 
            }
            $pdf->SetXY(110, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $item[0]['business_name']));

            $pdf->SetFontSize('16');
            $pdf->SetXY(200, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $item[0]['order_input']));
        
            $pdf->SetXY(215, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', number_format($item[0]['price'],2)));

            $pdf->SetXY(250, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', number_format($item[0]['total'],2)));

            $total_all = $total_all+$item[0]['total'];
            $y = $y+10;
            $pdf->SetXY($x, $y);
        }

        $pdf->SetXY(225, $y);
        $total_all_print = 'รวมเป็นเงิน  '.number_format($total_all,2).'  บาท';
        $pdf->SetFont('THSarabunNew','B');
        $pdf->SetFontSize('18'); 
        $pdf->Cell(0,15,iconv('UTF-8', 'cp874', $total_all_print));

        $y = $y+50;
        $pdf->SetFont('THSarabunNew');
        $pdf->SetFontSize('16'); 
        $pdf->SetXY(20, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'ลงชื่อ................................................'));
        $y = $y+10;
        $pdf->SetXY(20, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', '            เจ้าหน้าที่พัสดุสาขา'));

        $y = $y+14;
        $pdf->SetXY(20, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'ลงชื่อ................................................'));
        $y = $y+10;
        $pdf->SetXY(20, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', '            ผู้ตรวจสอบสาขา'));

        $y = 120;
        $pdf->SetXY(180, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', '           ................................................'));
        $y = $y+10;
        $pdf->SetXY(180, $y);
        $approve_name = config('app.APPROVE_NAME');
        $approve_name_print = 'ลงชื่อ  '.$approve_name;
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $approve_name_print));
        $y = $y+10;
        $pdf->SetXY(180, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', '             หัวหน้าภาควิชาอายุรศาสตร์'));

        
        // วันเวลาที่พิมพ์
        $mutable = Carbon::now();
        //\Log::info($mutable);
        $tmp_date_now = explode(' ', $mutable);
        $split_date_now = explode('-', $tmp_date_now[0]);
        $year = (int) $split_date_now[0] + 543;
        $thaimonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        $date_now_show = $split_date_now[2].'  '.$thaimonth[(int) $split_date_now[1]].' '.$year;

        $pdf->SetFontSize('14');
        $pdf->SetXY(200,3);
        $date_print = 'วันเวลาที่พิมพ์'.'  '.$date_now_show.'  '.$tmp_date_now[1].' น.';
        $pdf->Cell(0, 10, iconv('UTF-8', 'cp874', $date_print), 0, 0, 'R');

        $pdf->SetXY(10,3);
        $date_print = 'เลขที่ใบสั่งซื้อ:'.'  '.$order['create_no'].'/'.$order['year'];
        $pdf->Cell(0, 10, iconv('UTF-8', 'cp874', $date_print), 0, 0, 'L');
        //test font color
        // $pdf->SetFontSize('50');
        // $pdf->SetTextColor(255,192,203);
        // $pdf->SetXY(100,100);
        // $pdf->Cell(0,15,iconv('UTF-8', 'cp874', 'TEST  TEST'));

        $pdf->Output('I');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printBudgetOrder($stock_id,$year)
    {
        // Log::info('printBudgetOrder');
        // Log::info($stock_id);
        // Log::info($year);
       // return "printBudgetOrder";

        //$stock = Stock::whereId($stock_id)->get();
        $use_budget=0;
        $balance_budget=0.0;
       
        $budget_year = budget::where('stock_id',$stock_id)
                                            ->where('year',$year)
                                            ->where('status','on')          
                                            ->first();
     
        
        //$pdf = new FPDI('l'); //แนวนอน
        $pdf = new FPDI();
        $pdf->AddPage();
        $pdf->AddFont('THSarabunNew','','THSarabunNew.php');
        $pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');

        // add  image watermark
      // $pdf->Image(storage_path('app/public/images/watermark_medstock.png'),7,15,0,0,'png');
        
        //title
        $pdf->SetFont('THSarabunNew','B');
        $pdf->SetFontSize('18'); 
        $unit = Unit::where('unitid',$stock_id)->first();
        //Log::info($unit);
        $division_name = $unit->unitname;
        $head = 'รายงานการเบิกงบประมาณการสั่งซื้อวัสดุของ สาขา/หน่วยงาน';
        $title = $head.'  '.$division_name;
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $title),0,0,'C');
        
        $pdf->SetXY(18, 15);
        $year_print = $year+543;
        $title2 = 'ปีงบประมาณ  '.$year_print.' ได้รับงบ '.number_format($budget_year->budget_add,2).'  บาท';
        $pdf->Cell(0,15,iconv('UTF-8', 'cp874', $title2),0,0,'C');
 
        //head column
        $pdf->SetFont('THSarabunNew','B');
        $pdf->SetFontSize('16'); 
        $pdf->SetXY(12, 27);
        $pdf->SetLineWidth(1);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'ลำดับ             เลขที่ใบสั่งซื้อ                    วันที่สั่งซื้อ                                      ใช้งบไป(บาท)'),'B');
        
       
        //**************************order list
        $pdf->SetFont('THSarabunNew','U');
        $pdf->SetXY(13, 38);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'ใบสัญญาสั่งซื้อ'),0,0);

        $thaimonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        $y=45;
        $x=15;
        $pdf->SetFont('THSarabunNew');
        $pdf->SetXY($y, $x);
       // $pdf->SetLineWidth(0.1);
        $pdf->SetLineWidth(0.1);
        $stock_orders = OrderItem::where('unit_id',$stock_id)
                                    ->where('year',$year)
                                    ->whereIn('status',['approved','checkin'])
                                    ->orderBy('date_order')
                                    ->get();
      //  if( $stock_orders->count()!=0){
            $seq = 0;
            foreach($stock_orders as $order){
                $seq++;
               // Log::info($order->timeline['approve_budget']);
                $use_budget += $order->timeline['approve_budget'];
                $pdf->SetXY($x, $y);
                $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $seq),'B'); //print line buttom

                $pdf->SetXY(40, $y);
                $order_no = $order->create_no."/".$order->year;
                $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $order_no));

                $pdf->SetXY(85, $y);
                $split_date_order = explode('-', $order->date_order);
                $year_order = (int) $split_date_order[0] + 543;
                $date_order_show = $split_date_order[2].'  '.$thaimonth[(int) $split_date_order[1]].' '.$year_order;
                $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $date_order_show));

                $pdf->SetXY(150, $y);
                $pdf->Cell(0,10, number_format($order->timeline['approve_budget'],2));
               
                $y = $y+10;
                $pdf->SetXY($x, $y);
                // $pdf->SetXY(18, 50);
                // $pdf->SetLineWidth(1);
            }

           
            $pdf->SetFont('THSarabunNew','U');
            $pdf->SetXY(130, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'รวม '));
            $pdf->SetXY(150, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', number_format($use_budget,2).'   บาท'));
           
             //$pdf->Line(10,0,20,0);
        // }else{
        //      $use_budget = 0.0;
        // }

        //**************************purchase order list
        $y = $y+10;
        $pdf->SetFont('THSarabunNew','U');
        $pdf->SetXY(13, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'ใบสั่งซื้อ'),0,0);
        
        $purchase_orders = OrderPurchase::where('unit_id',$stock_id)
                                ->where('year',$year)
                                ->whereIn('status',['approved','checkin','received'])
                                ->orderBy('date_order')
                                ->get();

        $y = $y+10;
        $seq = 0;
        $pdf->SetFont('THSarabunNew');
        $use_budget_purchase = 0;
        foreach($purchase_orders as $porder){
            $seq++;
            // Log::info($order->budget);
            $use_budget_purchase += $porder->budget;
            $pdf->SetXY($x, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $seq),'B'); //print line buttom

            $pdf->SetXY(40, $y);
            if($porder->order_no==0)
                $order_no = "-";
            else
                $order_no = $porder->order_no;
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $order_no));

            $pdf->SetXY(85, $y);
            $split_date_order = explode('-', $porder->date_order);
            $year_porder = (int) $split_date_order[0] + 543;
            $date_porder_show = $split_date_order[2].'  '.$thaimonth[(int) $split_date_order[1]].' '.$year_porder;
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $date_porder_show));

            $pdf->SetXY(150, $y);
            $pdf->Cell(0,10, number_format($porder->budget,2));

            $y = $y+10;
            $pdf->SetXY($x, $y);
            // $pdf->SetXY(18, 50);
            // $pdf->SetLineWidth(1);
        }
     
        $balance_budget = (float)$budget_year->budget_add - (float)$use_budget - (float)$use_budget_purchase;
        $y = $y+10;
        $pdf->SetFont('THSarabunNew','U');
        $pdf->SetXY(130, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'รวม '));
        $pdf->SetXY(150, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', number_format($use_budget_purchase,2).'   บาท'));

        $pdf->SetFont('THSarabunNew');
        $y = $y+10;
        $pdf->SetXY(125, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'งบคงเหลือ '));
        $pdf->SetXY(150, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', number_format($balance_budget,2).'   บาท'));
        $y = $y+8;
        //$pdf->SetXY(145, $y);
        $pdf->Line(125,$y,180,$y);
        $y = $y+1;
        //$pdf->SetXY(145, $y);
        $pdf->Line(125,$y,180,$y);

         // วันเวลาที่พิมพ์
         $mutable = Carbon::now();
         //\Log::info($mutable);
         $tmp_date_now = explode(' ', $mutable);
         $split_date_now = explode('-', $tmp_date_now[0]);
         $year = (int) $split_date_now[0] + 543;
         $thaimonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
         $date_now_show = $split_date_now[2].'  '.$thaimonth[(int) $split_date_now[1]].' '.$year;
 
         $pdf->SetFontSize('12');
         $pdf->SetXY(190,3);
         $date_print = 'ข้อมูล ณ วันเวลาที่พิมพ์'.'  '.$date_now_show.'  '.$tmp_date_now[1].' น.';
         $pdf->Cell(0, 10, iconv('UTF-8', 'cp874', $date_print), 0, 0, 'R');
 
        
        
        $pdf->Output('I');
    }
    public function printBudgetOrderImport($stock_id,$year)
    {
       // Logger('printBudgetOrderImport');
        // Log::info($stock_id);
        // Log::info($year);
       // return "printBudgetOrder";

        //$stock = Stock::whereId($stock_id)->get();
        $use_budget=0;
        $balance_budget=0.0;
       
        $budget_year = budget::where('stock_id',$stock_id)
                                            ->where('year',$year)
                                            ->where('status','on')          
                                            ->first();
     
        
        //$pdf = new FPDI('l'); //แนวนอน
        $pdf = new FPDI();
        $pdf->AddPage();
        $pdf->AddFont('THSarabunNew','','THSarabunNew.php');
        $pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');

        // add  image watermark
       //$pdf->Image(storage_path('app/public/images/watermark_medstock.png'),7,15,0,0,'png');


        // วันเวลาที่พิมพ์
        $mutable = Carbon::now();
        //\Log::info($mutable);
        $tmp_date_now = explode(' ', $mutable);
        $split_date_now = explode('-', $tmp_date_now[0]);
        $year_print = (int) $split_date_now[0] + 543;
        $thaimonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        $thaimonth_short = ['', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        $date_now_show = $split_date_now[2].'  '.$thaimonth[(int) $split_date_now[1]].' '.$year_print;

        $pdf->SetFont('THSarabunNew');
        $pdf->SetFontSize('12');
        $pdf->SetXY(120,3);
        $date_print = 'ข้อมูล ณ วันเวลาที่พิมพ์'.'  '.$date_now_show.'  '.$tmp_date_now[1].' น.';
        $pdf->Cell(0, 10, iconv('UTF-8', 'cp874', $date_print), 0, 0, 'R');

        //title
        $pdf->SetFont('THSarabunNew','B');
        $pdf->SetFontSize('18'); 
        $unit = Unit::where('unitid',$stock_id)->first();

     

        //Log::info($unit);
        $division_name = $unit->unitname;
        $head = 'รายงานการเบิกงบประมาณการสั่งซื้อวัสดุ';
        $title = $head;
        $pdf->SetXY(18, 10);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $title),0,0,'C');

        $pdf->SetXY(18, 18);
        $head2 = 'ของ สาขา/หน่วยงาน';
        $title2 = $head2.'  '.$division_name;
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $title2),0,0,'C');
        
        $pdf->SetXY(18, 23);
        $year_print = $year+543;
        $title2 = 'ปีงบประมาณ  '.$year_print.' ได้รับงบ '.number_format($budget_year->budget_add,2).'  บาท';
        $pdf->Cell(0,15,iconv('UTF-8', 'cp874', $title2),0,0,'C');
 
        //head column
        $pdf->SetFont('THSarabunNew','B');
        $pdf->SetFontSize('16'); 
        $pdf->SetXY(12, 32);
        $pdf->SetLineWidth(1);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'ลำดับ             เลขที่ใบสั่งซื้อ              ประเภท                      วันที่ตรวจรับ                     ใช้งบไป(บาท)'),'B');
        
       
        //**************************order list


        $thaimonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        $y=45;
        $x=15;
        $pdf->SetFont('THSarabunNew');
        $pdf->SetXY($y, $x);
       // $pdf->SetLineWidth(0.1);
        $pdf->SetLineWidth(0.1);

        //--------------------------
        $stock_budget = budget::select('stock_id','budget_add','year')
                                ->where(['stock_id'=>$stock_id,'year'=>$year,'status'=>'on'])
                                ->with('stock:id,stockname,status')
                                ->first();
            $orders = ItemTransaction::select('pur_order')
                                    ->where(['stock_id'=>$stock_id,'year'=>$year,'action'=>'checkin','status'=>'active'])
                                    ->groupBy('pur_order')
                                    ->orderBy('date_action')
                                    ->get();

            /* รวมยอดเงินการสั่งซื้อทีละใบ */
            if($orders)
            {
                $stock_orders = array();
                $budget_used = 0.0;
                $budget_balance = 0.0;

                foreach($orders as $key=>$order){
                 // Logger($order->pur_order);
                    $sum_price = 0.0;
                    $order_items = ItemTransaction::select('id','item_count','price','date_action','order_type')
                                        ->where(['stock_id'=>$stock_id,'year'=>$year,'action'=>'checkin','status'=>'active'])
                                        ->where('pur_order',$order->pur_order)
                                        ->get();

                    foreach($order_items as $key2=>$order_item){
                    // Logger($order_item);
                    $sum_price += (float)$order_item->item_count*(float)$order_item->price;
                    //  Logger((float)$sum_price);
                    }
                    $stock_orders[$key]['pur_order'] = $order->pur_order;
                    $stock_orders[$key]['order_type'] = $order_item->order_type;
                    $stock_orders[$key]['order_type_name'] = $order_item->order_type_name;
                    $stock_orders[$key]['date_action'] = $order_item->date_action;
                    $stock_orders[$key]['sum_price'] = (float)$sum_price;

                    $budget_used += (float)$sum_price;
                  //   Logger($stock_orders);
                }
            }

            $year_budget = (int)$year+543;
            $budget_balance = (int)$stock_budget->budget_add - $budget_used;

        //-------------------------


            $seq = 0;
            $line_per_page = 22;
            //  logger(count($stock_item_checkouts));
            $page_all = ceil(count($stock_orders)/$line_per_page);
            $count_page = 1;
            
            $count_line = 0;
            foreach($stock_orders as $order){
              //  Logger($order);
                $seq++;
             
                $pdf->SetXY($x, $y);
                $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $seq),'B'); //print line buttom

                $pdf->SetXY(30, $y);
                $order_no = $order['pur_order'];
                $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $order_no));

                $pdf->SetXY(75, $y);
                $order_type_name = $order['order_type_name'];
                $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $order_type_name));

                $pdf->SetXY(115, $y);
                $split_date_order = explode('-', $order['date_action']);
                $year_order = (int) $split_date_order[0] + 543;
                $date_order_show = $split_date_order[2].'  '.$thaimonth[(int) $split_date_order[1]].' '.$year_order;
                $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $date_order_show));

                $pdf->SetXY(160, $y);
                $pdf->Cell(0,10, number_format($order['sum_price'],2));
               
                $y = $y+10;
                $pdf->SetXY($x, $y);

                $count_line++;
                if( $count_line==$line_per_page ){
                    $count_line =0;
                    $count_page++;
                    $pdf->SetXY(160, $y);
                    $pdf->SetFontSize('14'); 
                    $pdf->Cell(0,10,'Page '.$pdf->PageNo().'/'.$page_all,0,0,'C');
                    $pdf->AddPage();
                 
                     //head column
                    $pdf->SetFont('THSarabunNew','B');
                    $pdf->SetFontSize('16'); 
                    $pdf->SetXY(12, 16);
                    $pdf->SetLineWidth(1);
                    $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'ลำดับ             เลขที่ใบสั่งซื้อ              ประเภท                      วันที่ตรวจรับ                     ใช้งบไป(บาท)'),'B');
        
                    $y=28;
                    $x=15;
                    $pdf->SetFont('THSarabunNew');
                    $pdf->SetXY($x, $y);
                    $pdf->SetLineWidth(0.1);
                }
               
            }

           
            $pdf->SetFont('THSarabunNew','U');
            $pdf->SetXY(130, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'รวม '));
            $pdf->SetXY(150, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', number_format($budget_used,2).'   บาท'));
           
             //$pdf->Line(10,0,20,0);
        // }else{
        //      $use_budget = 0.0;
        // }

     
     
       

        $pdf->SetFont('THSarabunNew');
        $y = $y+10;
        $pdf->SetXY(125, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'งบคงเหลือ '));
        $pdf->SetXY(150, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', number_format($budget_balance,2).'   บาท'));
        $y = $y+8;
        //$pdf->SetXY(145, $y);
        $pdf->Line(125,$y,180,$y);
        $y = $y+1;
        //$pdf->SetXY(145, $y);
        $pdf->Line(125,$y,180,$y);

        $y = $y+3;
        $pdf->SetXY(160, $y);
        $pdf->SetFontSize('14'); 
        $pdf->Cell(0,10,'Page '.$pdf->PageNo().'/'.$page_all,0,0,'C');

 
         $use_in = Auth::user();
         $msg_notify_test = $use_in->name.'  พิมพ์รายงานสรุปใบสั่งซื้อสำเร็จ ';
         Logger($msg_notify_test);
        /****************  insert log ****************/
           // logger($old_changes);
           // $use_in = Auth::user();

           $detail_log =array();
           $detail_log['year_budget'] = $year_print;
 
   

           $log_activity = LogActivity::create([
               'user_id' => $use_in->id,
               'sap_id' => $use_in->sap_id,
               'function_name' => 'print_report_order',
               'action' => 'print_report_order',
               'detail'=> $detail_log,
           ]);

        $pdf->Output('I');

    }
    public function printPurchaseOrder($purchase_id)
    {
           // Log::info('printPurchaseOrder');

        //$pdf = new FPDI('l'); //แนวนอน
        $pdf = new FPDI();
        $pdf->AddPage();
        $pdf->AddFont('THSarabunNew','','THSarabunNew.php');
        $pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');

        //title
        $pdf->SetFont('THSarabunNew','B');
        $pdf->SetFontSize('18'); 
     

        $pdf->SetXY(170,5);
        $pdf->Cell(0, 10, iconv('UTF-8', 'cp874', "แบบ บก.๐๖"), 0, 0);

        $pdf->SetXY(18, 15);
        $head = 'ตารางแสดงวงเงินงบประมาณที่ได้รับจัดสรรและรายละเอียดค่าใช้จ่าย';
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $head),0,0,'C');

        $pdf->SetXY(18, 25);
        $head2 = 'การจัดซื้อจัดจ้างที่มิใช่งานก่อสร้าง';
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $head2),0,0,'C');

        //body
        $purchase_order = OrderPurchase::find($purchase_id);
      
        $y=32;
        $y = $y+8;
        $pdf->SetFont('THSarabunNew');
        $pdf->SetFontSize('16'); 

        $pdf->SetXY(20, $y);
        $line1 = "๑. ชื่อโครงการ ".$purchase_order->project_name." จำนวน ".count($purchase_order->items)." รายการ";
        $pdf->MultiCell(0,7,iconv('UTF-8', 'cp874', $line1),0,0);

        $y = $y+15;
        $pdf->SetXY(20, $y);
        $line2 = "๒. หน่วยงานเจ้าของโครงการ ".$purchase_order->Unit->unitname." ภาควิชาอายุรศาสตร์ คณะแพทยศาสตร์ศิริราชพยาบาล มหาวิทยาลัยมหิดล";
        $pdf->MultiCell(0,7,iconv('UTF-8', 'cp874', $line2),0,0);

        $y = $y+15;
        $pdf->SetXY(20, $y);
        $line3 = "๓. วงเงินงบประมาณที่ได้รับจัดสรร                        บาท";
        $pdf->Cell(0,7,iconv('UTF-8', 'cp874', $line3),0,0);

        $y = $y+8;
        $pdf->SetXY(20, $y);
        $line4 = "๔. วันที่กำหนดราคากลาง (ราคาอ้างอิง) ณ";
        $pdf->Cell(0,7,iconv('UTF-8', 'cp874', $line4),0,0);

        $y = $y+8;
        $pdf->SetXY(25, $y);
        $line4_1 = "เป็นเงิน ".number_format($purchase_order->budget,2)." บาท";
        $pdf->Cell(0,7,iconv('UTF-8', 'cp874', $line4_1),0,0);

        $y = $y+8;
        $pdf->SetXY(20, $y);
        $line5 = "๕. แหล่งที่มาของราคากลาง (ราคาอ้างอิง) ";
        $pdf->Cell(0,7,iconv('UTF-8', 'cp874', $line5),0,0);

        $tmp_business_name = '';
        $num_thai= ['๐','๑','๒','๓','๔','๕','๖','๗','๘','๙'];
        $i=1;
        foreach($purchase_order->items as $index=>$item){
           // Log::info($item[0]['business_name']);
            
            if($tmp_business_name != $item[0]['business_name'])
            {
                $y = $y+8;
                $pdf->SetXY(25, $y);
                $line5 = "๕.".$num_thai[$i]." ".$item[0]['business_name'];
                $pdf->Cell(0,7,iconv('UTF-8', 'cp874', $line5),0,0);
                $i++;
            }
           
            $tmp_business_name = $item[0]['business_name'];
        }

        $y = $y+8;
        $pdf->SetXY(20, $y);
        $line6 = "๖. รายชื่อเจ้าหน้าที่ผู้กำหนดราคากลาง (ราคาอ้างอิง) ทุกคน ";
        $pdf->Cell(0,7,iconv('UTF-8', 'cp874', $line6),0,0);

        $y = $y+8;
        $pdf->SetXY(25, $y);
        $line6 = "๖.๑ .................................................................................................................. ";
        $pdf->Cell(0,7,iconv('UTF-8', 'cp874', $line6),0,0);

        $y = $y+8;
        $pdf->SetXY(25, $y);
        $line6 = "๖.๒ .................................................................................................................. ";
        $pdf->Cell(0,7,iconv('UTF-8', 'cp874', $line6),0,0);

        $y = $y+8;
        $pdf->SetXY(25, $y);
        $line6 = "๖.๓ .................................................................................................................. ";
        $pdf->Cell(0,7,iconv('UTF-8', 'cp874', $line6),0,0);

        $y = $y+8;
        $pdf->SetXY(25, $y);
        $line6 = "๖.๔ .................................................................................................................. ";
        $pdf->Cell(0,7,iconv('UTF-8', 'cp874', $line6),0,0);

        $y = $y+8;
        $pdf->SetXY(25, $y);
        $line6 = "๖.๕ .................................................................................................................. ";
        $pdf->Cell(0,7,iconv('UTF-8', 'cp874', $line6),0,0);

        $y = $y+30;
        $x = 100;
        $pdf->SetFont('THSarabunNew');
        $pdf->SetFontSize('16'); 
        $pdf->SetXY($x, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', '(ลงชื่อ)..............................................................'));
        $y = $y+10;
        $pdf->SetXY($x, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', '   (                                                       )'));
        $y = $y+10;
        $pdf->SetXY($x, $y);
        $sign_foot = "         หัวหน้า".$purchase_order->Unit->unitname;
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $sign_foot));
   
        $pdf->Output('I');
    }
    public function printPurchaseOrderItem($purchase_id)
    {
        //Log::info('printPurchaseOrderItem');
        $pdf = new FPDI('l'); //แนวนอน
        
        $pdf->AddPage();
        $pdf->AddFont('THSarabunNew','','THSarabunNew.php');
        $pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');

        //title
        $pdf->SetFont('THSarabunNew','B');
        $pdf->SetFontSize('18'); 

        // วันเวลาที่พิมพ์
        $mutable = Carbon::now();
        //\Log::info($mutable);
        $tmp_date_now = explode(' ', $mutable);
        $split_date_now = explode('-', $tmp_date_now[0]);
        $year = (int) $split_date_now[0] + 543;
        //$thaimonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        //$date_now_show = $split_date_now[2].'  '.$thaimonth[(int) $split_date_now[1]].' '.$year;


        $purchase_order = OrderPurchase::find($purchase_id);
      
        $pdf->SetXY(14, 15);
        $head = 'วัสดุวิทยาศาสตร์ สารเคมี ทางการแพทย์ และวัสดุอื่นๆ ภ.อายุรศาสตร์ '.$year;
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $head),0,0,'C');

        $pdf->SetXY(14, 23);
       // $head = 'สาขา'.$purchase_order->Unit->unitname;
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $purchase_order->Unit->unitname),0,0,'C');

         //head column
        $pdf->SetFont('THSarabunNew','B');
        $pdf->SetFontSize('16'); 
        $pdf->SetXY(12, 32);
        $pdf->SetLineWidth(1);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'ลำดับที่             รายการ                          Material      จำนวน      หน่วยนับ      ราคา/หน่วย        ราคารวม                             บริษัท            '),'B');
       
        //body  list item

        $y=45;
        $x=15;
        $pdf->SetFont('THSarabunNew');
        $pdf->SetXY($x, $y);
       // $pdf->SetLineWidth(0.1);
        $pdf->SetLineWidth(0.1);
       
      //  if( $stock_orders->count()!=0){
            $seq = 0;
            $total_budget = 0.0;
        foreach ($purchase_order->items as $item) {
            $seq++;
           // Log::info($item);
            $pdf->SetFontSize('16'); 
          
            // $pdf->SetXY($x, $y);
            // $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $seq),'B'); //print line buttom

            $pdf->SetXY($x, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $seq));

            $pdf->SetXY(23, $y);
            $pdf->SetFontSize('14'); 
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $item[0]['item_name']));

            $pdf->SetFontSize('16'); 
            $pdf->SetXY(83, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $item[0]['material']));

            $pdf->SetXY(110, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $item[0]['order_input']));

            $pdf->SetXY(126, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $item[0]['unit_count']));

            $pdf->SetXY(148, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874',  number_format($item[0]['price'],2)));

            $pdf->SetXY(174, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874',  number_format($item[0]['total'],2)));

            $pdf->SetXY(200, $y);
            $pdf->SetFontSize('14'); 
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $item[0]['business_name']));

            $total_budget += $item[0]['total'];
             $y = $y+10;
             $pdf->SetXY($x, $y);
        

        }
        $y=$y-5;
        $pdf->SetXY($x, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', ''),'B'); //print line buttom

        $y = $y+10;
        $pdf->SetXY(160, $y);
        $pdf->SetFont('THSarabunNew','B');
        $pdf->SetFontSize('16'); 
        $total_all_print = 'รวมเป็นเงิน    '.number_format($total_budget,2).'  บาท';
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874',  $total_all_print));

        $pdf->Output('I');
       
    }

    public function printCutStock(int $stock_id,int $year,int $month)
    {
      //  logger('printCutStock');
         $pdf = new FPDI('l'); //แนวนอน
        
        $pdf->AddPage();
        $pdf->AddFont('THSarabunNew','','THSarabunNew.php');
        $pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');

        //title
        $pdf->SetFont('THSarabunNew','B');
        $pdf->SetFontSize('18'); 

        // วันเวลาที่พิมพ์
        $mutable = Carbon::now();
        //\Log::info($mutable);
        $tmp_date_now = explode(' ', $mutable);
        $split_date_now = explode('-', $tmp_date_now[0]);
        $year_print = (int) $split_date_now[0] + 543;
        $thaimonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        $thaimonth_short = ['', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        $date_now_show = $split_date_now[2].'  '.$thaimonth[(int) $split_date_now[1]].' '.$year_print;

        $pdf->SetFontSize('14');
        $pdf->SetXY(200,3);
        $date_print = 'วันเวลาที่พิมพ์'.'  '.$date_now_show.'  '.$tmp_date_now[1].' น.';
        $pdf->Cell(0, 10, iconv('UTF-8', 'cp874', $date_print), 0, 0, 'R');


         $stock = Stock::find($stock_id);
      
        $pdf->SetXY(14, 13);
        $head = 'รายงานบันทึกการตัดสต๊อกวัสดุ ';
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $head),0,0,'C');

        $pdf->SetXY(14, 20);
        $head2 = $stock->stockname."  ภาควิชาอายุรศาสตร์";
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $head2),0,0,'C');

        $pdf->SetXY(14, 27);
        $head3 = "เดือน".$thaimonth[(int) $month]."  ปี ".$year+543;
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $head3),0,0,'C');

         //head column
        $pdf->SetFont('THSarabunNew','B');
        $pdf->SetFontSize('16'); 
        $pdf->SetXY(12, 37);
        $pdf->SetLineWidth(1);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'ลำดับที่      รหัสวัสดุ                         ชื่อวัสดุ                          วันที่หมดอายุ          วันที่เบิกจ่าย            จำนวน                ผู้เบิก              คงเหลือ ณ ปัจจุบัน            '),'B');
       
        //     //body  list item

        $stock_item_checkouts = ItemTransaction::where(
                                                        [   'stock_id'=>$stock_id,
                                                            'year'=>$year,
                                                            'month'=>$month,
                                                            'action'=>'checkout',
                                                            'status'=>'active'
                                                        ])
                                                        ->with('stockItem:id,item_name,item_code,item_sum')
                                                        ->with('user:id,name')
                                                        ->orderBy('stock_item_id')->get();
        $y=48;
        $x=15;
        $pdf->SetFont('THSarabunNew');
        $pdf->SetXY($x, $y);
       // $pdf->SetLineWidth(0.1);
        $pdf->SetLineWidth(0.1);
       

            $seq = 0;
            $tmp_item_code = '0';
            $line_per_page = 13;
          //  logger(count($stock_item_checkouts));
            $page_all = ceil(count($stock_item_checkouts)/$line_per_page);
            $count_page = 1;
           
            $count_line = 0;
        foreach ($stock_item_checkouts as $item) {
            $seq++;
            //Log::info($item);
            $pdf->SetFontSize('16'); 
          
            // $pdf->SetXY($x, $y);
            // $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $seq),'B'); //print line buttom

            $pdf->SetXY($x, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $seq));

            if (strcmp($tmp_item_code, $item->stockItem['item_code']) !=0) {
                $pdf->SetXY(23, $y);
                $pdf->SetFontSize('14'); 
                $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $item->stockItem['item_code']));

                $pdf->SetFontSize('16'); 
                $pdf->SetXY(41, $y);
                $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $item->stockItem['item_name']));
            }
 
            if(strlen($item->date_expire)==0){
                $date_expire_show= "-";
                $pdf->SetXY(125, $y);
                $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $date_expire_show));
            }else{
                $split_date_expire = explode('-', $item->date_expire);
                $year_print = (int) $split_date_expire[0] + 543;
                $date_expire_show = $split_date_expire[2].'  '.$thaimonth_short[(int) $split_date_expire[1]].' '.$year_print;       
                $pdf->SetXY(112, $y);
                $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $date_expire_show));
            }
                   
            

            $pdf->SetXY(147, $y);
            $split_date_action = explode('-', $item->date_action);
            $year_print = (int) $split_date_action[0] + 543;
            $date_action_show = $split_date_action[2].'  '.$thaimonth_short[(int) $split_date_action[1]].' '.$year_print;
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874', $date_action_show));

            $pdf->SetXY(186, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874',  $item->item_count));

            $pdf->SetXY(199, $y);
            $pdf->Cell(0,10,iconv('UTF-8', 'cp874',  $item->user['name']));

            if (strcmp($tmp_item_code, $item->stockItem['item_code']) !=0) {
                $pdf->SetXY(255, $y);
                $pdf->SetFontSize('14');
                $pdf->Cell(0, 10, iconv('UTF-8', 'cp874', number_format($item->stockItem['item_sum'],0) ));
            }
          
            $tmp_item_code = $item->stockItem['item_code'];

            // $total_budget += $item[0]['total'];
            $y = $y+10;
            $count_line++;
           // logger('count line=>');
           // logger($count_line);
            //addNewPage
            if( $count_line==$line_per_page ){
                $count_line =0;
                $count_page++;
                $pdf->SetXY(255, $y);
                $pdf->Cell(0,10,'Page '.$pdf->PageNo().'/'.$page_all,0,0,'C');
                $pdf->AddPage();
                 //head column
                $pdf->SetFont('THSarabunNew','B');
                $pdf->SetFontSize('16'); 
                $pdf->SetXY(12, 17);
                $pdf->SetLineWidth(1);
                $pdf->Cell(0,10,iconv('UTF-8', 'cp874', 'ลำดับที่      รหัสวัสดุ                         ชื่อวัสดุ                          วันที่หมดอายุ          วันที่เบิกจ่าย            จำนวน                ผู้เบิก              คงเหลือ ณ ปัจจุบัน            '),'B');
                $y=28;
                $x=15;
                $pdf->SetFont('THSarabunNew');
                $pdf->SetXY($x, $y);
               // $pdf->SetLineWidth(0.1);
                $pdf->SetLineWidth(0.1);
            }


              
            
          
          //  $pdf->SetXY($x, $y);
          
        }

      
        $y=$y-5;
        $pdf->SetXY($x, $y);
        $pdf->Cell(0,10,iconv('UTF-8', 'cp874', ''),'B'); //print line buttom

        $pdf->SetXY(255, 175);
        $pdf->SetFontSize('14'); 
        $pdf->Cell(0,10,'Page '.$pdf->PageNo().'/'.$page_all,0,0,'C');

        $use_in = Auth::user();
        $msg_notify_test = $use_in->name.'  พิมพ์รายงานการตัดสต๊อก '.$stock->stockname.' สำเร็จ';
        Logger($msg_notify_test);

         /****************  insert log ****************/
           // logger($old_changes);
           // $use_in = Auth::user();

           $detail_log =array();
           $detail_log['stock_id'] = $stock->stockname;
           $detail_log['year'] = $year;
           $detail_log['month'] = $month;
   

       //  dd($detail_log);

           $log_activity = LogActivity::create([
               'user_id' => $use_in->id,
               'sap_id' => $use_in->sap_id,
               'function_name' => 'print_report_cut_stock',
               'action' => 'print_report_cut_stock',
               'detail'=> $detail_log,
           ]);

        $pdf->Output('I');
       
    }

    function Header()
    {
        // Logo
        $this->Image('logo.png',10,6,30);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'Title',1,0,'C');
        // Line break
        $this->Ln(20);
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    public function printCutStockTest(int $stock_id,int $year,int $month)
    {
        $pdf = new FPDI('l'); //แนวนอน
       // $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times','',12);
        for($i=1;$i<=40;$i++)
            $pdf->Cell(0,10,'Printing line number '.$i,0,1);
        $pdf->Output();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
