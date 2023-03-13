<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   
    <title>Document</title>

   
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <style>
        .font-lobster-two {
            font-family: 'Lobster Two', cursive;
        }
        .font-sarabun {
            font-family: 'Sarabun', sans-serif;
            font-size: 14px;
        }
        h3 {
            text-align: center;
            font-family: 'Sarabun', sans-serif;
            font-size: 18px;
        }
        p {
            text-align: center;
            font-family: 'Sarabun', sans-serif;
            font-size: 16px;
            line-height: 0.5;
        }
        table {
             width: 100%;
        }
    </style>
</head>

<body >
    <div >
        <h3 class="h3" >รายงานบันทึกการตัดสต๊อกวัสดุ</h3>
        <p class="p " >{{$head2}}</p>
        <p class="p" >{{$head3}}</p>
        <!-- ภาษาไทยต้อง style ด้วย font thai ไม่งั้นไม่แสดง -->
        {{-- <p class="">น้องนีดีใจ ได้ไปคอนเสิร์ตจ้ะ</p>
        <p class="font-sarabun">น้องนีดีใจที่สุดจิ๊จ๊ะ ได้ไปคอนเสิร์ต</p> --}}
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
                        <td scope="col">{{ date('d-m-Y', strtotime($data->date_expire)) }}</td>
                        <td scope="col">{{ Carbon\Carbon::parse($data->date_action)->format('d-m-Y')  }}</td>
                        <th scope="col">{{ $data->item_count }}</td>
                        <td scope="col">{{ $data->user->name}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
     
    </div>
</body>
</html>