<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>ReportCutStock</title>

  
    <style>
                @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{public_path('fonts/sarabun/THSarabunNew.ttf')}}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/sarabun/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/sarabun/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/sarabun/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }
     
      
      
        .font-lobster-two {
            font-family: 'Lobster Two', cursive;
        }
        .font-sarabun {
            font-family: 'THSarabunNew', sans-serif;
            font-size: 16px;
        }
        h3 {
            text-align: center;
            font-family: 'THSarabunNew', sans-serif;
            font-size: 18px;
           
        }
        .p-center {
            text-align: center;
            font-family: 'THSarabunNew', sans-serif;
            font-size: 16px;
            line-height: 0.5;
        }
        .p-left {
            text-align: left;
            font-family: 'THSarabunNew', sans-serif;
            font-size: 16px;
            line-height: 0.5;
        }
        table {
             width: 100%;
        }
        .footer {  
            position: fixed;  
            left: 10px;  
            bottom: 5px;  
            right: 10px;   
            width: 95%;  
            /* background-color: gray;  
            color: white;  
            text-align: center;   */
        }  
        .footer-page {  
            position: fixed;  
            right: 20px;  
            bottom: 2px;    
           
         
        }  
        .page-number:after {
            text-align: right;
            font-family: 'THSarabunNew', sans-serif;
            font-size: 16px;
            content: "Page: " counter(page)   ;
        }
        .page-break {
            page-break-after: always;
          
        }


    </style>
</head>

<body >
    {{-- <h1>Page 1</h1>
<div class="page-break"></div>
<h1>Page 2</h1> --}}
    <div >
        <h3 class="h3" >รายงานบันทึกการตัดสต๊อกวัสดุ</h3>
        <p class="p-center" >{{$head2}}</p>
        <p class="p-center" >{{$head3}} </p>
    
        <div >
            <table >
                <thead>
                    <tr class="font-sarabun">
                        <th scope="col">ลำดับที่</th>
                        <th scope="col">รหัสวัสดุ</th>
                        <th scope="col">ชื่อวัสดุ</th>
                        <th scope="col">วันที่หมดอายุ</th>
                        <th scope="col">วันที่เบิกจ่าย</th>
                        <th scope="col">จำนวนที่เบิก</th>
                        <th scope="col">ผู้เบิก</th>
                    </tr>
                </thead>
              
                <tbody>
                    @foreach($stock_items ?? '' as  $key => $data)
                    <tr class="font-sarabun">
                        <th>{{ $key+1}}</th>
                        <td scope="col">{{ $data->stockItem?->item_code }}</td>
                        <td scope="col">{{ $data->stockItem?->item_name }}</td>
                        <td scope="col">{{ $data->date_expire_last }}</td>
                        <td scope="col">{{ $data->date_action_show }}</td>
                        <th scope="col">{{ $data->item_count }}</td>
                        <td scope="col">{{ $data->user->name}}</td>
                    </tr>
                        @if( $key % 10 == 0 && $key !=0 )
                        <div class="footer-page">
                            <p class="page-number"><br>   
                        </div>
                            <div class="page-break"></div>
                          
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
      
        <footer class="footer">
            <p class="p-left">{{$date_print}}<br>   
        </footer>
       
    </div>
</body>
</html>