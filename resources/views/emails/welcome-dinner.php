<?php /** @noinspection PhpUndefinedVariableInspection */ ?>
<html>
<head>
    <!--[if gte mso 9]>

    <style type="text/css">

        body, table, th, td, span, ol, ul, li {
            font-family: Verdana, sans-serif !important;
        }

    </style>

    <![endif]-->
    <link href="https://fonts.googleapis.com/css?family=Arimo" rel="stylesheet">
</head>
<body style="font-family: 'Arimo', sans-serif;">
<h1>CGCU Welcome Dinner Ticket</h1>
<h2>27th October 2018 - 6pm</h2>
<p>Dear <?php echo $ticket->purchaser->first_name . " " . $ticket->purchaser->last_name; ?>,</p>

<p>
    This is your ticket for the CGCU Welcome Dinner.
</p>
<p>
    Please have this ready when you're entering the venue.
</p>
<p>
    If this ticket is on your phone, please turn your brightness up and zoom into the QR Code below:
</p>
<img width="400" src="<?php echo $message->embedData($qr->get(), 'ticket_qr.png', $qr->getContentType()); ?>">
<p>Ticket number: <?php echo $ticket->qr; ?></p>
<h2>Information for the night</h2>
<ul>
    <li>Location <a href="https://goo.gl/maps/k8MAJNSz7F52">Millenium Gloucester Hotel</a></li>
    <li>Time: Please arrive between 18:30 and 19:00. Don't be late otherwise you miss might out on your arrival drink!
    </li>
    <li>Dress Code: Black Tie</li>
    <li>A cash/card bar with drinks is available with student prices (although we would recommend bringing cash)</li>
    <li>A free cloakroom is available all night (ladies you might want to bring flats as you won't be allowed barefoot
        on the dancefloor)
    </li>
</ul>
<p>
    This event will end late, please stay safe and plan your journey home.
</p>
<p>
    Looking forward to seeing you there!
</p>
<p>
    CGCU Committee
</p>
</body>
</html>