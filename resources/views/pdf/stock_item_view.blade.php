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
            font-size: 20px;

        }
        .p-center {
            text-align: center;
            font-family: 'THSarabunNew', sans-serif;
            font-size: 18px;
            line-height: 0.5px;
        }
        .p-left {
            text-align: left;
            font-family: 'THSarabunNew', sans-serif;
            font-size: 16px;
            line-height: 0.5;
        }
        .p-right {
            text-align: right;
            font-family: 'THSarabunNew', sans-serif;
            font-size: 16px;

        }
        table {
             width: 100%;
        }

        .th-bg-color {
            padding-top: 8px;
            padding-bottom: 8px;
            background-color: #EAE8EA;

        }
        .footer {
            position: fixed;
            bottom: 5px;
            left: 0px;
            right: 0px;
            width: 100%;
            line-height: 35px;
            border-top:1px solid #000000;
            font-size: 17px;
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
          //  content: "Page: " counter(page) ' of '  ;
        }
        .page-break {
            /* page-break-after: always; */
            page-break-before:always;
        }
        table {
            page-break-inside: avoid !important;
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
                    <tr class="font-sarabun ">
                        <th scope="col" class="th-bg-color">ลำดับที่</th>
                        <th scope="col" class="th-bg-color">รหัสวัสดุ</th>
                        <th scope="col" class="th-bg-color">ชื่อวัสดุ</th>
                        <th scope="col" class="th-bg-color">วันที่หมดอายุ</th>
                        <th scope="col" class="th-bg-color">วันที่เบิกจ่าย</th>
                        <th scope="col" class="th-bg-color">จำนวนที่เบิก</th>
                        <th scope="col" class="th-bg-color">จำนวนคงเหลือ</th>
                        <th scope="col" class="th-bg-color">ผู้เบิก</th>
                    </tr>
                </thead>
                <div class="th-line"></div>
                <tbody>
                    @php
                        $row = 0;
                        $my_page=1;
                    @endphp
                    @foreach($stock_items ?? '' as  $key => $data)
                    <tr class="font-sarabun">
                        @php
                            $row++;

                        @endphp
                        <th>{{$key+1}} </th>
                        <td scope="col">{{ $data->stockItem?->item_code }}</td>
                        <td scope="col">{{ $data->stockItem?->item_name }}</td>
                        <td scope="col">{{ $data->date_expire_last }}</td>
                        <td scope="col">{{ $data->date_action_show }}</td>
                        <td scope="col">{{ $data->item_count }}</td>
                        <td scope="col">{{ $data->item_balance }}</td>
                        <td scope="col">{{ $data->user->name}}</td>
                    </tr>

                        @if( $row == 15 )
                            {{-- <div class="footer-page">
                                <p class="page-number">
                            </div> --}}

                            <div class="footer-page">
                                <p class="p-right">Page: {{$my_page}} / {{$pages}} </p>
                            </div>
                            <footer class="footer">
                                <p class="p-left">{{$date_print}}<br>
                            </footer>
                            <div class="page-break"></div>

                            @php
                                $row = 0;
                                $my_page++;
                            @endphp

                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="footer-page">
                <p class="p-right">Page: {{$my_page}} / {{$pages}} </p>
            </div>
            <footer class="footer">
                <p class="p-left">{{$date_print}}<br>
            </footer>
        </div>




    </div>
</body>
</html>
