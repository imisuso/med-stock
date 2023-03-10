<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,300;1,300&display=swap" rel="stylesheet">
</head>
<style>
 
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: 200;
            font-display: swap;
            src: url("{{ asset('fonts/sarabun/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url("{{ asset('fonts/sarabun/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url("{{ asset('fonts/sarabun/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url("{{ asset('fonts/sarabun/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }
     

body{
    font-family: 'THSarabunNew';
    font-weight: 400;
    font-size: 16px;
}
    
</style>
<body >
    <div >
        <h2 >Laravel 10 HTML to PDF Example ทดสอบ</h2>
      
        <table >
            <thead>
                <tr >
                    <th scope="col">#</th>
                    <th scope="col">item_code</th>
                    <th scope="col">item_name</th>
                    <th scope="col">date_expire</th>
                    <th scope="col">date_action</th>
                    <th scope="col">checkout</th>
                    <th scope="col">user</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stock_items ?? '' as  $key => $data)
                <tr>
                    <th >{{ $key+1}}</th>
                    <td>{{ $data->stockItem?->item_code }}</td>
                    <td>{{ $data->stockItem?->item_name }}</td>
                    <td>{{ $data->date_action }}</td>
                    {{-- <td>{{ $data['date_expire_last'] }}</td>
                    <td>{{ $data['date_action'] }}</td>
                    <td>{{ $data['item_count'] }}</td>
                    <td>{{ $data['name'] }}</td>  --}}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>