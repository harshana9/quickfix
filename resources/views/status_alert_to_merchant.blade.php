<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        body{
            font-size:16px;
        }
    </style>
</head>
<body>
<h3>{{ $title }}</h3>
<p>Dear {{ $breakdown['merchant'] }},<br/><br/>
Your complaint to People's Card Center regarding a breakdown has been updated to following status<br/>
<b>Complaint ID : </b> {{ $breakdown['id'] }}<br/>
<b>Complaint Status : </b> {{ $status['status_name'] }}<br/>
<br/>
<u>Your Deatils</u><br/>
<b>MID : </b> {{ $breakdown['mid'] }}<br/>
<b>TID : </b> {{ $breakdown['tid'] }}<br/>
<b>MERCHANT : </b> {{ $breakdown['merchant'] }}<br/>
<br/>
<u>Product Vendor</u><br/>
<b>Product : </b>{{ $breakdown['product']['name'] }}<br/>
<b>Contact : </b>{{ $breakdown['product']['vendor']['contact_1'] }}<br/>

</p>
<br/>
<font color="blue">
    <p>
    Thanks & Best Regards<br/>

    Computer Generated Email by <i>PCC QuickFix Brakdown Management System</i><br/>
    User: <i>{{ $user }}</i><br/><br/>
    People’s Card Centre<br/>
    No. 1166, Maradana Road,<br/>
    Colombo 08.<br/><br/>
    Tel. : +94 11 2490 400<br/>
    Fax : +94 11 2169 023<br/>
    Email : amilai@peoplesbank.lk
    </p>
    <img src="cid:SIGNATURE_CID" alt="signature"/>
</font>
</body>
</html>