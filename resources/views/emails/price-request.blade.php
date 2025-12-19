<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Price request from https://etrade-ag.com</title>
    <style>
        body {
            background-color: #f6f6f6;
            font-family: sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        dt {
            width:15em;
            font-weight: bold;
        }
        dd {
            width: 40em;
        }
        .date {
            opacity: 0.7
        }
    </style>
</head>
<body>
<h3>Price request</h3>

<a href="https://etrade-ag.com">etrade-ag.com</a>
<span class="date">{{ date('Y-m-d H:i') }}</span>

<dl>
    <dt>Code: </dt> <dd>{{$msg->code}}</dd>
    <dt>Author: </dt> <dd>{{$msg->author}}</dd>
    <dt>Contacts: </dt> <dd>{{$msg->contact}}</dd>
    <dt>Message:</dt> <dd>{{$msg->message}}</dd>
</dl>

Products:
<table>
    <thead>
        <tr>
            <th style="text-align: right">#</th>
            <th style="width:20em">sku</th>
            <th>product</th>
            <th style="width:8em;text-align: right">qty</th>
            <th style="width:10em;text-align: right">price</th>
            <th style="width:10em;text-align: right">sum</th>
        </tr>
    </thead>
    <tbody>
@forelse ($msg->params as $product)
    <tr>
        <td style="text-align: right">{{$loop->iteration}}</td>
        <td style="padding-left: 1em">{{$product['sku']}}</td>
        <td style="padding-left: 1em"></td>
        <td style="text-align: right">{{$product['qty'] ?? ''}}</td>
        <td style="text-align: right">{{$product['price'] ?? ''}}</td>
        <td style="text-align: right"></td>
    </tr>
@empty
    <tr><td colspan="6">no products in request</td></tr>
@endforelse
    </tbody>
</table>