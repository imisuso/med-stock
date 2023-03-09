<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div >
        <h2 >Laravel 10 HTML to PDF Example</h2>
       
      
        {{-- @foreach($stock_items ?? '' as $data) --}}
             {{-- <li>{{$data}}</li>
             <li>{{$data['date_action']}}</li>
             <li>{{$data['item_code']}}</li>
             <li>{{$data['item_name']}}</li>
             <li>{{$data['item_count']}}</li>
             <li>{{$data['name']}}</li> --}}
             {{-- <li>{{$data['test']['a']}}</li> --}}
             {{-- <li>{{$data->date_action}}</li> --}}
             {{-- <li>{{$data['stock_item']['item_code']}}</li> --}}
        {{-- @endforeach --}}
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
                    <td>{{ $data['item_code'] }}</td>
                    <td>{{ $data['item_name'] }}</td>
                    <td>{{ $data['date_expire_last'] }}</td>
                    <td>{{ $data['date_action'] }}</td>
                    <td>{{ $data['item_count'] }}</td>
                    <td>{{ $data['name'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>