<?php
header("Cache-Control: no-cache");

$serverdate = date("Y-m-d h:i:s", time()); 
date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d h:i:s", time());

$checkDate = date("D", time());

if($checkDate === 'Sat' || $checkDate === 'Sun') {
  exit;
} else if($checkDate === 'Mon') {
  $searchParam = date('Y-m-d',strtotime("-3 days"));
} else {
  $searchParam = date('Y-m-d',strtotime("-1 days"));
}

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require (__DIR__ . '../../../mailer/vendor/phpmailer/phpmailer/src/PHPMailer.php');
require (__DIR__ . '../../../mailer/vendor/phpmailer/phpmailer/src/Exception.php');
require (__DIR__ . '../../../mailer/vendor/phpmailer/phpmailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require (__DIR__ . '../../../mailer/vendor/autoload.php');

require(__DIR__ . '../../../dbconnect/db.php');

$sql = "SELECT
pk.ProductCode,
p.ProductDescription,
pk.OrderQuantity,
pk.PickedQty,
pk.OrderQuantity - pk.PickedQty as 'ShortSupply',
pk.ReasonCode,
pk.PickedBy,
pk.SalesOrderNumber,
pk.PickedOn
from INB_COMPLETED_PICKS pk
left outer join (SELECT pm.ProductCode, pm.ProductDescription FROM INB_PRODUCT_MASTER pm) as p on p.ProductCode=pk.ProductCode
where pk.PickedQty < pk.OrderQuantity and pk.PickedOn like '%".$searchParam."%'
group by pk.ProductCode
order by pk.PickedOn DESC";

$stmt = $conn->prepare($sql);
// $stmt->bind_param("s", $search);
// $search = $findOrder;
$stmt->execute();
$result = $stmt->get_result();

if (mysqli_num_rows($result) > 0) {
    $results = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
    <html xmlns='http://www.w3.org/1999/xhtml' xmlns:o='urn:schemas-microsoft-com:office:office' style='width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0'>
    
    <head>
        <meta charset='UTF-8'>
        <meta content='width=device-width, initial-scale=1' name='viewport'>
        <meta name='x-apple-disable-message-reformatting'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta content='telephone=no' name='format-detection'>
        <title>New message 2</title><!--[if (mso 16)]><style type='text/css'> a {text-decoration: none;} </style><![endif]--><!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--><!--[if !mso]><!-- -->
        <link href='href=' https: fonts.googleapis.com css?family='Montserrat:500,700,800&display=swap' rel='stylesheet'><!--<![endif]--><!--[if !mso]><!-- -->
        <link href='href=' https: fonts.googleapis.com css?family='Montserrat:500,700,800&display=swap' rel='stylesheet'><!--<![endif]--><!--[if !mso]><!-- -->
        <link href='href=' https: fonts.googleapis.com css?family='Montserrat:500,700,800&display=swap' rel='stylesheet'><!--<![endif]--><!--[if gte mso 9]><xml> <o:OfficeDocumentSettings> <o:AllowPNG></o:AllowPNG> <o:PixelsPerInch>96</o:PixelsPerInch> </o:OfficeDocumentSettings> </xml><![endif]-->
       

        <style>
        table.greyGridTable {
            font-family: Arial, Helvetica, sans-serif;
            border: 2px solid #C0C0C0;
            background-color: #EEEEEE;
            width: 80%;
            text-align: left;
            border-collapse: collapse;
            margin-left: auto;  
            margin-right: auto;  
          }
          table.greyGridTable td, table.greyGridTable th {
            border: 1px solid #C8C8C8;
            padding: 3px 4px;
          }
          table.greyGridTable tbody td {
            font-size: 13px;
          }
          table.greyGridTable td:nth-child(even) {
            background: #EBEBEB;
          }
          table.greyGridTable thead {
            background: #FFFFFF;
          }
          table.greyGridTable thead th {
            font-size: 15px;
            font-weight: bold;
            color: #535353;
            text-align: left;
          }
          table.greyGridTable tfoot {
            font-size: 14px;
            font-weight: normal;
          }
          table.greyGridTable tfoot td {
            font-size: 14px;
          }
          .footertxt{
            font-size:11px;
            color: 'gray';
          }
          .titlecontainer{
            width: 100%;
            text-align: center; 
            margin-top: 20px;
          }
        </style>
    </head>
    
    <body>
        <div class='es-wrapper-color' style='background-color:#F7F7F7'><!--[if gte mso 9]><v:background xmlns:v='urn:schemas-microsoft-com:vml' fill='t'> <v:fill type='tile' color='#F7F7F7'></v:fill> </v:background><![endif]-->
        <div class='titlecontainer'><h2 style='text-align: center'>Daily Out of Stock Report - ".$searchParam."</h2></div>
        <br>
        <div style='text-align:center'>
        <table class='greyGridTable'>
            <thead>
            <tr>
            <th>Code</th>
            <th>Description</th>
            <th>Order&nbsp;Qty</th>
            <th>Picked&nbsp;Qty</th>
            <th>Short&nbsp;Supply</th>
            <th>Reason&nbsp;Code</th>
            <th>Picked&nbsp;By</th>
            <th>Sales&nbsp;Order&nbsp;Number</th>
            </tr>
            </thead><tbody>";

    while ($row = $result->fetch_assoc()) {
        //   echo '<a>' . $row["ProductCode"] . '</a>';
        $results .= "<tr>
        <td><p>" . $row["ProductCode"] . "</p></td>
        <td><p>" . $row["ProductDescription"] . "</p></td>
        <td style='text-align: center;'><p>" . $row["OrderQuantity"] . "</p></td>
        <td style='text-align: center;'><p>" . $row["PickedQty"] . "</p></td>                        
        <td style='text-align: center;'><p>" . $row["ShortSupply"] . "</p></td>
        <td><p>" . $row["ReasonCode"] . "</p></td>
        <td style='text-align: center;'><p>" . $row["PickedBy"] . "</p></td>
        <td><p>" . $row["SalesOrderNumber"] . "</p></td>
    </tr>";
    }
    $results .= "
    </tbody>
    </table>
    </div>
    <div style='text-align:center'>
    <p class='footertxt'>
    You are receiving this email because your administrator have subscribed you for this information. Should you wish to discontinue receipt of this email, please contact your systems administrator.</p>
    <hr>
    <p class='footertxt'>
    Help Desk : support@inbracket.com
    </p>
    </div>
</div>
</body>

</html>";
} else {
    echo "error";
}

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.inbracket.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'support@inbracket.com';                     //SMTP username
    $mail->Password   = 'Mandela@123!';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('no-reply@inbracket.com', 'Inbracket Insights');
    // $mail->addAddress('tony@grwills.com.au', 'Tony Virgen');     //Add a recipient
    $mail->addAddress('Jacques@grwills.com.au', 'Jacques Breedt'); 
    $mail->addAddress('Tony@grwills.com.au', 'Tony Virgen'); 
    $mail->addAddress('Michelle@grwills.com.au', 'Michelle Hogan');  
    $mail->addAddress('clothing@grwills.com.au', 'Jess Patch'); 
    $mail->addAddress('ben@grwills.com.au', 'Benjamin Blake');  
    $mail->addAddress('darwinwarehouseorders@grwills.com.au', 'Bruce Packham'); 
    $mail->addAddress('mohan@grwills.com.au', 'Mohan Wijesena');
                 //Name is optional
    // $mail->addReplyTo('support@inbracket.com', 'Information');
    $mail->addCC('mohan@inbracket.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    $mailContent = $results;
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Daily out of stock report';
    $mail->Body = $mailContent;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->ErrorInfo;
    $mail->send();

    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
