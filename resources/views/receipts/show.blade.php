<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventory | Receipt print</title>
    <link rel="stylesheet" href="/css/print.css">
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime&display=swap" rel="stylesheet">
    <script src="/js/print.js" defer></script>
</head>
<body>
    <div>
        <div>-  --  --  --  --  --  --  --  --  --  --  --  --  --  --  --  --  -</div>
        <h2 style="text-transform:uppercase;"> Official Receipt</h2>
        
        <table style="text-transform:uppercase;text-align:left">
            <tr>
                <th>
                    Name
                </th>
                <td>
                    {{$receipt->customer_name}}
                </td>
            </tr>
            <tr>
                <th>
                    Date
                </th>
                <td>
                    {{$receipt->created_at->format('m/d/Y')}}
                </td>
            </tr>
            @php
                $products = explode('/',$receipt->details);
                array_pop($products);
            @endphp
            <tr>
                <th>
                    No. Item
                </th>
                <td>
                    {{count($products)}}
                </td>
            </tr>
            @foreach ($products as $product)
            <tr>
                <td></td>
                <td>
                    {{$product}}
                </td>
            </tr>
            @endforeach
            <tr>
                <th>
                    Total
                </th>
                <td>
                    P   {{number_format($receipt->total_cost,2)}}
                </td>
            </tr>
            <tr>
                <th>
                    Tender
                </th>
                <td>
                    P   {{number_format($receipt->tender,2)}}
                </td>
            </tr>
            <tr>
                <th>
                    Change
                </th>
                <td>
                    P   {{number_format($receipt->change,2)}}
                </td>
            </tr>
        </table>
    </div>
    <div id="bottom">-  --  --  --  --  --  --  --  --  --  --  --  --  --  --  -</div>
</body>
</html>