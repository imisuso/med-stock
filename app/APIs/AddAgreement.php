<?php
namespace App\APIs;

use App\Models\Agreement;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AddAgreement
{
 public  function newAgreement($fileName){
        Log::info('into loadData filename='.$fileName);
        $agreements = loadCSV($fileName);
        Log::info('===== start add new agreement at =====>'.date('Y-m-d H:i:s'));
        $count_row = 0;
   
        foreach($agreements as $index => $agreement){
            $content_detail = array();
            try {
                 //Log::info($agreement);
                $agreement_new = new Agreement();
                $agreement_new->date_effected = now();
                $agreement_new->title = $agreement['title'];
                $content = $agreement_new->contents;
                $tmp_detail = explode('|',$agreement['detail']);
                foreach ($tmp_detail as $detail) {
                  //  Log::info($detail);
                    array_push( $content_detail, $detail);
                }
                $content['detail'] = $content_detail;
                $agreement_new->contents = $content;
             
                $agreement_new->save();
            
            } catch (\Error $e) {
              
                Log::info($e->getMessage());
            } catch (\Exception $e) {
             
                Log::info($e->getMessage());
                  
            } catch (\Throwable $t) {
                Log::info($t->getMessage());
            }
            $count_row++;
        }
        Log::info('agreement count row in file==>'.$count_row);
        Log::info('agreement count row  ==>'.Agreement::count());
        Log::info('===== End migrate agreement at =====>'.date('Y-m-d H:i:s'));
    }
}