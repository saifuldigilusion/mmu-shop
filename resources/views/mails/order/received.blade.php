<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css" rel="stylesheet" media="all">
/* Media Queries */
@media only screen and (max-width: 500px) {
.button {
width: 100% !important;
}
}
</style>
</head>
<?php
$style = [
/* Layout ------------------------------ */
'body' => 'margin: 0; padding: 0; width: 100%; background-color: #093990;',
'email-wrapper' => 'width: 100%; margin: 0; padding: 0; background-color: #093990;',
/* Masthead ----------------------- */
'email-masthead' => 'padding: 25px 0; text-align: center;color: white;font-weight:bold;',
'email-masthead_name' => 'font-size: 16px; font-weight: bold; color: #2F3133; text-decoration: none; text-shadow: 0 1px 0 white;',
'email-body' => 'width: 100%; margin: 0; padding: 0; border-top: 1px solid #EDEFF2; border-bottom: 1px solid #EDEFF2; background-color: #FFF;',
'email-body_inner' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0;',
'email-body_cell' => 'padding: 35px;',
'email-footer' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0; text-align: center; color: white;',
'email-footer_cell' => 'color: white; padding: 35px; text-align: center;',
/* Body ------------------------------ */
'body_action' => 'width: 100%; margin: 30px auto; padding: 0; text-align: center;',
'body_sub' => 'margin-top: 25px; padding-top: 25px; border-top: 1px solid #EDEFF2;',
'table_border' => 'border: 1px solid black;border-collapse: collapse;',
'table_padding' => 'padding: 8px;',
/* Type ------------------------------ */
'anchor' => 'color: #3869D4;',
'header-1' => 'margin-top: 0; color: #2F3133; font-size: 19px; font-weight: bold; text-align: left;',
'paragraph' => 'margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;',
'paragraph-sub' => 'margin-top: 0; color: #74787E; font-size: 12px; line-height: 1.5em;',
'paragraph-center' => 'text-align: center;',
/* Buttons ------------------------------ */
'button' => 'display: block; display: inline-block; width: 200px; min-height: 20px; padding: 10px;
background-color: #3869D4; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px;
text-align: center; text-decoration: none; -webkit-text-size-adjust: none;',
'button--green' => 'background-color: #22BC66;',
'button--red' => 'background-color: #dc4d2f;',
'button--blue' => 'background-color: #3869D4;',
];
?>
<?php $fontFamily = 'font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;'; ?>
<body style="{{ $style['body'] }}">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td style="{{ $style['email-wrapper'] }}" align="center"><table width="100%" cellpadding="0" cellspacing="0">
<!-- Logo -->
<tr>
<td style="{{ $fontFamily }} {{ $style['email-masthead'] }} border-bottom:3px solid red;"><a style="{{ $style['email-masthead_name'] }}" href="{{ url('/') }}" target="_blank"> <img src="{{ $message->embed(storage_path('app/public/mmu-cnergy-white.png')) }}" height="40px"/>
<!--{{ config('app.name') }}-->
</a></td>
</tr>
<!-- Email Body -->
<tr>
<td style="{{ $style['email-body'] }}" width="100%"><table style="{{ $style['body_action'] }}" align="center" width="100%" cellpadding="0" cellspacing="0">
<tr>
    <td align="center" style="{{ $fontFamily }} {{ $style['table_padding'] }}">
        We have succesfully received your order.
    </td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
<td align="center">

    <table style="{{ $fontFamily }} min-width:600px;border-collapse: collapse;">
        <tr>
            <td style="{{ $style['table_padding'] }} {{ $style['table_border'] }} color:white;background-color:black; ">
                Order No: {{ $order->orderid }}
            </td>
            <td style="{{ $style['table_padding'] }} {{ $style['table_border'] }} color:white;background-color:black; ">
                Date: {{ $order->date }}
            </td>
        </tr>
    </table>

</td>
</tr>

<tr>
    <td align="center">
    
        <table style="{{ $fontFamily }} min-width:600px;border-collapse: collapse;">
            <tr>
                <td style="{{ $style['table_padding'] }}">
                    Amount Paid: RM{{ $order->total }}
                </td>
                <td style="{{ $style['table_padding'] }}">
                    Payment Channel: {{ $order->payment_channel }}
                </td>
            </tr>
            <tr>
                <td style="{{ $style['table_padding'] }}">
                    Transaction No: {{ $order->payment_transactionid }}
                </td>
                <td style="{{ $style['table_padding'] }}">
                    Timestamp: {{ $order->payment_timestamp }}
                </td>
            </tr>
            <tr>
                <td style="{{ $style['table_padding'] }}">
                    Name: {{ $order->name }}
                </td>
                <td style="{{ $style['table_padding'] }}">
                    Phone: {{ $order->phone }}
                </td>
            </tr>
            <tr>
                <td style="{{ $style['table_padding'] }}">
                    Email: {{ $order->email }}
                </td>
                <td style="{{ $style['table_padding'] }}">
                    Info: {{ $order->studentid }}
                </td>
            </tr>
        </table>
    
    </td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
    <td align="center">
    
        <table style="{{ $fontFamily }} min-width:600px;border-collapse: collapse;">
            <tr>
                <td style="{{ $style['table_padding'] }} background-color: #ccc;">
                    Items
                </td>
                <td style="{{ $style['table_padding'] }} background-color: #ccc;">
                    Qty
                </td>
                <td style="{{ $style['table_padding'] }} background-color: #ccc;">
                    Price
                </td>
            </tr>
            @foreach($orderItems as $item)
            <tr>
                <td style="{{ $style['table_padding'] }}">
                    {{ $item->name }}
                </td>
                <td style="{{ $style['table_padding'] }}">
                   {{ $item->qty }}
                </td>
                <td style="{{ $style['table_padding'] }}">
                    {{ $item->price }}
                 </td>
            </tr>
            @endforeach
            <tr>
                <td style="{{ $style['table_padding'] }} background-color: #ccc;">
                    &nbsp;
                </td>
                <td style="{{ $style['table_padding'] }} background-color: #ccc;">
                    &nbsp;
                </td>
                <td style="{{ $style['table_padding'] }} background-color: #ccc;">
                    &nbsp;
                </td>
            </tr>
        </table>
    
    </td>
</tr>


</table></td>
</tr>
<!-- Footer -->
<tr>
<td><table style="{{ $style['email-footer'] }}" align="center" width="570" cellpadding="0" cellspacing="0">
<tr>
<td style="{{ $fontFamily }} {{ $style['email-footer_cell'] }}"><p>Copyright &copy; {{ date('Y') }} MMU Cynergy</p></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
</body>
</html>