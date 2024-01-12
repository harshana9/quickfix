<!DOCTYPE html>
<html>
<head>
    <title>Purchase Note</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        td{
            vertical-align: top;
        }
    </style>
</head>
<body>
    <h1>PEOPLE'S CARD CENTRE</h1>
    <h2>{{ $title }}</h2>
    <p><b>Date : </b>{{ $date }}</p>
    <div class="table-responsive" style="margin-top:25px;">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>MID</th>
                    <th>MERCHANT</th>
                    <th>TID</th>
                    <th>PRODUCT</th>
                    <th>VENDOR</th>
                    <th>ERROR</th>
                </tr>
            </thead>
            <tbody>
            @foreach($dataset as $item)
                <tr>
                    <td>{{ $item['id'] }}</td>
                    <td>{{ $item['mid'] }}</td>
                    <td>{{ $item['merchant'] }}</td>
                    <td>{{ $item['tid'] }}</td>
                    <td>{{ $item['product']['name'] }}</td>
                    <td>{{ $item['product']['vendor']['name'] }}</td>
                    <td>{{ $item['error'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


</body>

</html>