<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require '../../mailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../mailer/vendor/phpmailer/phpmailer/src/Exception.php';
require '../../mailer/vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../mailer/vendor/autoload.php';

require(__DIR__ . '../../../dbconnect/db.php');

$sql = "SELECT
                      p.SalesOrderNumber, 
                      p.ProductCode,
                      (SELECT distinct(pm.ProductDescription) FROM INB_PRODUCT_MASTER pm WHERE pm.ProductCode=p.ProductCode) as 'desc',
                      p.OrderQuantity,
                      p.PickedQty,
                      p.PickedOn,
                      p.PickedBy
                      FROM INB_COMPLETED_PICKS p 
                      WHERE p.PickedQty=0 AND p.PickedOn like '%2023-01-23%'
                      ORDER BY p.ProductCode ASC";

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
        <style type='text/css'>
            .section-title {
                padding: 5px 10px;
                background-color: #f6f6f6;
                border: 1px solid #dfdfdf;
                outline: 0;
            }
    
            .amp-form-submit-success .hidden-block {
                display: none;
            }
    
            #outlook a {
                padding: 0;
            }
    
            .ExternalClass {
                width: 100%;
            }
    
            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }
    
            .es-button {
                mso-style-priority: 100 !important;
                text-decoration: none !important;
            }
    
            a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: none !important;
                font-size: inherit !important;
                font-family: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
            }
    
            .es-desk-hidden {
                display: none;
                float: left;
                overflow: hidden;
                width: 0;
                max-height: 0;
                line-height: 0;
                mso-hide: all;
            }
    
            a.es-button:hover {
                border-color: #2CB543 !important;
                background: #2CB543 !important;
            }
    
            a.es-secondary:hover {
                border-color: #ffffff !important;
                background: #ffffff !important;
            }
    
            .es-button-border:hover a.es-button,
            .es-button-border:hover button.es-button {
                background: #56d66b !important;
                border-color: #56d66b !important;
            }
    
            .es-button-border:hover {
                border-color: #42d159 #42d159 #42d159 #42d159 !important;
                background: transparent !important;
            }
    
            [data-ogsb] .es-button {
                border-width: 0 !important;
                padding: 12px 40px 13px 40px !important;
            }
    
            td .es-button-border:hover a.es-button-1 {
                background: #edce48 !important;
                border-color: #edce48 !important;
            }
    
            td .es-button-border-2:hover {
                background: #edce48 !important;
            }
    
            @media only screen and (max-width:600px) {
    
                p,
                ul li,
                ol li,
                a {
                    line-height: 150% !important
                }
    
                h1,
                h2,
                h3,
                h1 a,
                h2 a,
                h3 a {
                    line-height: 120% !important
                }
    
                h1 {
                    font-size: 26px !important;
                    text-align: center
                }
    
                h2 {
                    font-size: 22px !important;
                    text-align: center
                }
    
                h3 {
                    font-size: 18px !important;
                    text-align: left
                }
    
                u+#body {
                    width: 100vw !important
                }
    
                h1 a {
                    text-align: center
                }
    
                .es-header-body h1 a,
                .es-content-body h1 a,
                .es-footer-body h1 a {
                    font-size: 26px !important
                }
    
                h2 a {
                    text-align: center
                }
    
                .es-header-body h2 a,
                .es-content-body h2 a,
                .es-footer-body h2 a {
                    font-size: 22px !important
                }
    
                h3 a {
                    text-align: left
                }
    
                .es-header-body h3 a,
                .es-content-body h3 a,
                .es-footer-body h3 a {
                    font-size: 18px !important
                }
    
                .es-menu td a {
                    font-size: 16px !important
                }
    
                .es-header-body p,
                .es-header-body ul li,
                .es-header-body ol li,
                .es-header-body a {
                    font-size: 12px !important
                }
    
                .es-content-body p,
                .es-content-body ul li,
                .es-content-body ol li,
                .es-content-body a {
                    font-size: 14px !important
                }
    
                .es-footer-body p,
                .es-footer-body ul li,
                .es-footer-body ol li,
                .es-footer-body a {
                    font-size: 13px !important
                }
    
                .es-infoblock p,
                .es-infoblock ul li,
                .es-infoblock ol li,
                .es-infoblock a {
                    font-size: 12px !important
                }
    
                *[class='gmail-fix'] {
                    display: none !important
                }
    
                .es-m-txt-c,
                .es-m-txt-c h1,
                .es-m-txt-c h2,
                .es-m-txt-c h3 {
                    text-align: center !important
                }
    
                .es-m-txt-r,
                .es-m-txt-r h1,
                .es-m-txt-r h2,
                .es-m-txt-r h3 {
                    text-align: right !important
                }
    
                .es-m-txt-l,
                .es-m-txt-l h1,
                .es-m-txt-l h2,
                .es-m-txt-l h3 {
                    text-align: left !important
                }
    
                .es-m-txt-r img,
                .es-m-txt-c img,
                .es-m-txt-l img {
                    display: inline !important
                }
    
                .es-button-border {
                    display: block !important
                }
    
                a.es-button,
                button.es-button {
                    font-size: 13px !important;
                    display: block !important;
                    border-left-width: 0px !important;
                    border-right-width: 0px !important
                }
    
                .es-btn-fw {
                    border-width: 10px 0px !important;
                    text-align: center !important
                }
    
                .es-adaptive table,
                .es-btn-fw,
                .es-btn-fw-brdr,
                .es-left,
                .es-right {
                    width: 100% !important
                }
    
                .es-content table,
                .es-header table,
                .es-footer table,
                .es-content,
                .es-footer,
                .es-header {
                    width: 100% !important;
                    max-width: 600px !important
                }
    
                .es-adapt-td {
                    display: block !important;
                    width: 100% !important
                }
    
                .adapt-img {
                    width: 100% !important;
                    height: auto !important
                }
    
                .es-m-p0 {
                    padding: 0px !important
                }
    
                .es-m-p0r {
                    padding-right: 0px !important
                }
    
                .es-m-p0l {
                    padding-left: 0px !important
                }
    
                .es-m-p20 {
                    padding-left: 20px !important;
                    padding-right: 20px !important
                }
    
                .es-m-p0t {
                    padding-top: 0px !important
                }
    
                .es-m-p10t {
                    padding-top: 10px !important
                }
    
                .es-m-p0b {
                    padding-bottom: 0 !important
                }
    
                .es-m-p20b {
                    padding-bottom: 20px !important
                }
    
                .es-mobile-hidden,
                .es-hidden {
                    display: none !important
                }
    
                tr.es-desk-hidden,
                td.es-desk-hidden,
                table.es-desk-hidden {
                    width: auto !important;
                    overflow: visible !important;
                    float: none !important;
                    max-height: inherit !important;
                    line-height: inherit !important
                }
    
                tr.es-desk-hidden {
                    display: table-row !important
                }
    
                table.es-desk-hidden {
                    display: table !important
                }
    
                td.es-desk-menu-hidden {
                    display: table-cell !important
                }
    
                table.es-table-not-adapt,
                .esd-block-html table {
                    width: auto !important
                }
    
                table.es-social {
                    display: inline-block !important
                }
    
                table.es-social td {
                    display: inline-block !important
                }
    
                .es-desk-hidden {
                    display: table-row !important;
                    width: auto !important;
                    overflow: visible !important;
                    max-height: inherit !important
                }
    
                .h-auto {
                    height: auto !important
                }
            }
    
            @media only screen and (min-width:320px) {
                ul {
                    padding-left: 24px
                }
            }
        </style>
    </head>
    
    <body style='width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;padding:0;Margin:0'><span style='display:none !important;font-size:0px;line-height:0;color:#ffffff;visibility:hidden;opacity:0;height:0;width:0;mso-hide:all'>&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌</span>
        <div class='es-wrapper-color' style='background-color:#F7F7F7'><!--[if gte mso 9]><v:background xmlns:v='urn:schemas-microsoft-com:vml' fill='t'> <v:fill type='tile' color='#F7F7F7'></v:fill> </v:background><![endif]-->
            <table cellpadding='0' cellspacing='0' class='es-wrapper' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:left top;background-color:#F7F7F7'>
                <tr style='border-collapse:collapse'>
                    <td valign='top' style='padding:0;Margin:0'>
                        <table cellpadding='0' cellspacing='0' class='es-content' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%'>
                            <tr style='border-collapse:collapse'>
                                <td align='center' style='padding:0;Margin:0'>
                                    <table bgcolor='#ffffff' class='es-content-body' align='center' cellpadding='0' cellspacing='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:900px'>
                                        <tr style='border-collapse:collapse'>
                                            <td align='left' style='padding:0;Margin:0'>
                                                <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                                    <tr style='border-collapse:collapse'>
                                                        <td align='center' valign='top' style='padding:0;Margin:0;width:900px'>
                                                            <table cellpadding='0' cellspacing='0' width='100%' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                                                <tr style='border-collapse:collapse'>
                                                                    <td style='padding:0;Margin:0'><amp-img src='https://www.google-analytics.com/collect?v=1&amp;tid=UA-96386569-1&amp;t=event&amp;cid=%CONTACT_ID%&amp;cn=releases&amp;cs=email&amp;ec=email&amp;ea=openamp' width='1' height='1' alt></amp-img></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr style='border-collapse:collapse'>
                                            <td align='left' style='padding:0;Margin:0'>
                                                <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                                    <tr style='border-collapse:collapse'>
                                                        <td align='center' valign='top' style='padding:0;Margin:0;width:900px'>
                                                            <table cellpadding='0' cellspacing='0' width='100%' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                                                <tr style='border-collapse:collapse'>
                                                                    <td style='padding:0;Margin:0'><amp-img src='https://www.google-analytics.com/collect?v=1&amp;tid=UA-96386569-1&amp;t=event&amp;cid=%CONTACT_ID%&amp;cn=releases&amp;cs=email&amp;ec=email&amp;ea=openamp' width='1' height='1' alt></amp-img></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr style='border-collapse:collapse'>
                                            <td align='left' style='padding:0;Margin:0'>
                                                <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                                    <tr style='border-collapse:collapse'>
                                                        <td align='center' valign='top' style='padding:0;Margin:0;width:900px'>
                                                            <table cellpadding='0' cellspacing='0' width='100%' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                                                <tr style='border-collapse:collapse'>
                                                                    <td style='padding:0;Margin:0'><amp-img src='https://www.google-analytics.com/collect?v=1&amp;tid=UA-96386569-1&amp;t=event&amp;cid=%CONTACT_ID%&amp;cn=spring&amp;cs=email&amp;ec=email&amp;ea=openamp' width='1' height='1' alt></amp-img></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr style='border-collapse:collapse'>
                                            <td align='left' style='padding:0;Margin:0;padding-top:20px;padding-left:30px;padding-right:30px'>
                                                <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                                    <tr style='border-collapse:collapse'>
                                                        <td align='center' valign='top' style='padding:0;Margin:0;width:840px'>
                                                            <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                                                <tr style='border-collapse:collapse'>
                                                                    <td align='center' style='padding:0;Margin:0;display:none'></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr style='border-collapse:collapse'>
                                            <td align='left' style='padding:0;Margin:0;padding-left:30px;padding-right:30px'>
                                                <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                                    <tr style='border-collapse:collapse'>
                                                        <td align='center' valign='top' style='padding:0;Margin:0;width:840px'>
                                                            <table cellpadding='0' cellspacing='0' width='100%' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                                                <tr style='border-collapse:collapse'>
                                                                    <td align='center' style='padding:0;Margin:0;padding-bottom:20px;font-size:0px'><a target='_blank' href='https://stripo.email/' style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#31CB4B;font-size:15px'><img src='https://aymkeb.stripocdn.email/content/guids/CABINET_06c7ec87f847622aa14e3519a1d69219132ffe024bf1cd70bea0876ab8bb4287/images/inbracket_colour.png' alt='Stripo.email' style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic' width='125' title='Stripo.email' height='37'></a></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr style='border-collapse:collapse'>
                                            <td align='left' style='padding:0;Margin:0'>
                                                <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                                    <tr style='border-collapse:collapse'>
                                                        <td align='center' valign='top' style='padding:0;Margin:0;width:900px'>
                                                            <table cellpadding='0' cellspacing='0' width='100%' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                                                <tr style='border-collapse:collapse'>
                                                                    <td align='center' style='padding:0;Margin:0;font-size:0px'><img class='adapt-img' src='https://pics.esputnik.com/repository/home/17278/images/msg/68933580/1581343554682.png' alt style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic' width='900' height='30'></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr style='border-collapse:collapse'>
                                            <td align='left' bgcolor='#ffffff' style='Margin:0;padding-top:5px;padding-bottom:5px;padding-left:30px;padding-right:30px;background-color:#ffffff'>
                                                <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                                    <tr style='border-collapse:collapse'>
                                                        <td align='center' valign='top' style='padding:0;Margin:0;width:840px'>
                                                            <table cellpadding='0' cellspacing='0' width='100%' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                                                <tr style='border-collapse:collapse'>
                                                                    <td align='center' style='padding:0;Margin:0;padding-bottom:15px'>
                                                                        <h2 style='Margin:0;line-height:29px;mso-line-height-rule:exactly;font-family:tahoma, verdana, segoe, sans-serif;font-size:24px;font-style:normal;font-weight:bold;color:#0171cb'>Daily Out of Stock Report</h2>
                                                                    </td>
                                                                </tr>
                                                                <tr style='border-collapse:collapse'>
                                                                    <td align='left' class='es-m-txt-c' style='padding:0;Margin:0'>
                                                                        <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:23px;color:#808080;font-size:15px'>This report comprises of all the products maked as out of stock by the warehouse today. Investigate and correct inventory to prevent continues stock outs.</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr style='border-collapse:collapse'>
                                            <td align='left' bgcolor='#ffffff' style='padding:0;Margin:0;padding-left:30px;padding-right:30px;background-color:#ffffff'>
                                                <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                                    <tr style='border-collapse:collapse'>
                                                        <td align='center' valign='top' style='padding:0;Margin:0;width:840px'>
                                                            <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                                                <tr style='border-collapse:collapse'>
                                                                    <td align='center' style='padding:0;Margin:0;display:none'></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr style='border-collapse:collapse'>
                                            <td align='left' bgcolor='#ffffff' style='padding:0;Margin:0;padding-top:15px;padding-left:30px;padding-right:30px;background-color:#ffffff'><!--[if mso]><table style='width:840px' cellpadding='0' cellspacing='0'><tr><td style='width:120px' valign='top'><![endif]-->
                                                <table cellpadding='0' cellspacing='0' class='es-left' align='left' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left'>
                                                    <tr style='border-collapse:collapse'>
                                                        <td class='es-m-p20b' align='left' style='padding:0;Margin:0;width:120px'>
                                                            <table cellpadding='0' cellspacing='0' width='100%' bgcolor='#d8dddd' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-left:1px solid #d8dddd;border-right:1px solid #d8dddd;border-top:1px solid #d8dddd;border-bottom:1px solid #d8dddd;background-color:#d8dddd' role='presentation'>
                                                                <tr style='border-collapse:collapse'>
                                                                    <td align='left' style='padding:5px;Margin:0'>
                                                                        <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:23px;color:#646667;font-size:15px'>Product Code</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table><!--[if mso]></td>
    <td style='width:300px' valign='top'><![endif]-->
                                                <table cellpadding='0' cellspacing='0' class='es-left' align='left' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left'>
                                                    <tr style='border-collapse:collapse'>
                                                        <td align='left' class='es-m-p20b' style='padding:0;Margin:0;width:300px'>
                                                            <table cellpadding='0' cellspacing='0' width='100%' bgcolor='#d8dddd' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-left:1px solid #d8dddd;border-right:1px solid #d8dddd;border-top:1px solid #d8dddd;border-bottom:1px solid #d8dddd;background-color:#d8dddd' role='presentation'>
                                                                <tr style='border-collapse:collapse'>
                                                                    <td align='left' style='padding:5px;Margin:0'>
                                                                        <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:23px;color:#646667;font-size:15px'>Description</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table><!--[if mso]></td>
    <td style='width:108px' valign='top'><![endif]-->
                                                <table cellpadding='0' cellspacing='0' class='es-left' align='left' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left'>
                                                    <tr style='border-collapse:collapse'>
                                                        <td align='left' class='es-m-p20b' style='padding:0;Margin:0;width:108px'>
                                                            <table cellpadding='0' cellspacing='0' width='100%' bgcolor='#d8dddd' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-left:1px solid #d8dddd;border-right:1px solid #d8dddd;border-top:1px solid #d8dddd;border-bottom:1px solid #d8dddd;background-color:#d8dddd' role='presentation'>
                                                                <tr style='border-collapse:collapse'>
                                                                    <td align='center' style='padding:5px;Margin:0'>
                                                                        <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:23px;color:#646667;font-size:15px'>Order Qty</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table><!--[if mso]></td>
    <td style='width:108px' valign='top'><![endif]-->
                                                <table cellpadding='0' cellspacing='0' class='es-left' align='left' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left'>
                                                    <tr style='border-collapse:collapse'>
                                                        <td align='left' class='es-m-p20b' style='padding:0;Margin:0;width:108px'>
                                                            <table cellpadding='0' cellspacing='0' width='100%' bgcolor='#d8dddd' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-left:1px solid #d8dddd;border-right:1px solid #d8dddd;border-top:1px solid #d8dddd;border-bottom:1px solid #d8dddd;background-color:#d8dddd' role='presentation'>
                                                                <tr style='border-collapse:collapse'>
                                                                    <td align='center' style='padding:5px;Margin:0'>
                                                                        <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:23px;color:#646667;font-size:15px'>OOS Qty</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table><!--[if mso]></td><td style='width:0px'></td>
    <td style='width:204px' valign='top'><![endif]-->
                                                <table cellpadding='0' cellspacing='0' class='es-right' align='right' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right'>
                                                    <tr style='border-collapse:collapse'>
                                                        <td align='left' style='padding:0;Margin:0;width:204px'>
                                                            <table cellpadding='0' cellspacing='0' width='100%' bgcolor='#d8dddd' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-left:1px solid #d8dddd;border-right:1px solid #d8dddd;border-top:1px solid #d8dddd;border-bottom:1px solid #d8dddd;background-color:#d8dddd' role='presentation'>
                                                                <tr style='border-collapse:collapse'>
                                                                    <td align='left' style='padding:5px;Margin:0'>
                                                                        <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:23px;color:#646667;font-size:15px'>Order Number</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table><!--[if mso]></td></tr></table><![endif]-->
                                            </td>
                                        </tr>";
    while ($row = $result->fetch_assoc()) {
        //   echo '<a>' . $row["ProductCode"] . '</a>';
        $results .= "<tr style='border-collapse:collapse'>
        <td align='left' bgcolor='#ffffff' style='padding:0;Margin:0;padding-left:30px;padding-right:30px;background-color:#ffffff'><!--[if mso]><table style='width:840px' cellpadding='0' cellspacing='0'><tr><td style='width:120px' valign='top'><![endif]-->
            <table cellpadding='0' cellspacing='0' class='es-left' align='left' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left'>
                <tr style='border-collapse:collapse'>
                    <td class='es-m-p20b' align='left' style='padding:0;Margin:0;width:120px'>
                        <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-left:1px solid #d8dddd;border-right:1px solid #d8dddd;border-top:1px solid #d8dddd;border-bottom:1px solid #d8dddd' role='presentation'>
                            <tr style='border-collapse:collapse'>
                                <td align='left' style='padding:0;Margin:0'>
                                    <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:23px;color:#646667;font-size:15px'>" . $row["ProductCode"] . "</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table><!--[if mso]></td>
<td style='width:300px' valign='top'><![endif]-->
            <table cellpadding='0' cellspacing='0' class='es-left' align='left' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left'>
                <tr style='border-collapse:collapse'>
                    <td align='left' class='es-m-p20b' style='padding:0;Margin:0;width:300px'>
                        <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-left:1px solid #d8dddd;border-right:1px solid #d8dddd;border-top:1px solid #d8dddd;border-bottom:1px solid #d8dddd' role='presentation'>
                            <tr style='border-collapse:collapse'>
                                <td align='left' class='h-auto' height='24' style='padding:0;Margin:0'>
                                    <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:23px;color:#646667;font-size:15px'>" . $row["desc"] . "</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table><!--[if mso]></td>
<td style='width:108px' valign='top'><![endif]-->
            <table cellpadding='0' cellspacing='0' class='es-left' align='left' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left'>
                <tr style='border-collapse:collapse'>
                    <td align='left' class='es-m-p20b' style='padding:0;Margin:0;width:108px'>
                        <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-left:1px solid #d8dddd;border-right:1px solid #d8dddd;border-top:1px solid #d8dddd;border-bottom:1px solid #d8dddd' role='presentation'>
                            <tr style='border-collapse:collapse'>
                                <td align='center' class='h-auto' height='24' style='padding:0;Margin:0'>
                                    <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:23px;color:#646667;font-size:15px'>" . $row["OrderQuantity"] . "</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table><!--[if mso]></td>
<td style='width:108px' valign='top'><![endif]-->
            <table cellpadding='0' cellspacing='0' class='es-left' align='left' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left'>
                <tr style='border-collapse:collapse'>
                    <td align='left' class='es-m-p20b' style='padding:0;Margin:0;width:108px'>
                        <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-left:1px solid #d8dddd;border-right:1px solid #d8dddd;border-top:1px solid #d8dddd;border-bottom:1px solid #d8dddd' role='presentation'>
                            <tr style='border-collapse:collapse'>
                                <td align='center' style='padding:0;Margin:0'>
                                    <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:23px;color:#646667;font-size:15px'>" . $row["PickedQty"] . "</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table><!--[if mso]></td><td style='width:0px'></td>
<td style='width:204px' valign='top'><![endif]-->
            <table cellpadding='0' cellspacing='0' class='es-right' align='right' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right'>
                <tr style='border-collapse:collapse'>
                    <td align='left' style='padding:0;Margin:0;width:204px'>
                        <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-left:1px solid #d8dddd;border-right:1px solid #d8dddd;border-top:1px solid #d8dddd;border-bottom:1px solid #d8dddd' role='presentation'>
                            <tr style='border-collapse:collapse'>
                                <td align='left' style='padding:0;Margin:0'>
                                    <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:23px;color:#646667;font-size:15px'>" . $row["SalesOrderNumber"] . "</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table><!--[if mso]></td></tr></table><![endif]-->
        </td>
    </tr>";
    }
    $results .= "<tr style='border-collapse:collapse'>
    <td align='left' bgcolor='#ffffff' style='padding:0;Margin:0;padding-top:20px;padding-left:30px;padding-right:30px;background-color:#ffffff;border-radius:0px 0px 20px 20px'>
        <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
            <tr style='border-collapse:collapse'>
                <td align='center' valign='top' style='padding:0;Margin:0;width:840px'>
                    <table cellpadding='0' cellspacing='0' width='100%' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                        <tr style='border-collapse:collapse'>
                            <td align='left' style='padding:0;Margin:0'>
                                <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:23px;color:#4A4A4A;font-size:15px'><br></p>
                            </td>
                        </tr>
                        <tr style='border-collapse:collapse'>
                            <td align='center' style='padding:0;Margin:0;font-size:0px'><img class='adapt-img' src='https://pics.esputnik.com/repository/home/17278/images/msg/68933580/1581343554682.png' alt style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic' width='840' height='28'></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
</td>
</tr>
</table>
<table cellpadding='0' cellspacing='0' class='es-content' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%'>
<tr style='border-collapse:collapse'>
<td align='center' style='padding:0;Margin:0'>
<table class='es-content-body' cellspacing='0' cellpadding='0' align='center' bgcolor='#FFFFFF' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:900px'>
<tr style='border-collapse:collapse'>
    <td align='left' style='padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px'>
        <table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
            <tr style='border-collapse:collapse'>
                <td valign='top' align='center' style='padding:0;Margin:0;width:860px'>
                    <table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                        <tr style='border-collapse:collapse'>
                            <td align='center' style='padding:0;Margin:0;font-size:0px'><a href='https://viewstripo.email' target='_blank' style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#31CB4B;font-size:15px'><img src='https://aymkeb.stripocdn.email/content/guids/CABINET_06c7ec87f847622aa14e3519a1d69219132ffe024bf1cd70bea0876ab8bb4287/images/inbracket_gray.png' alt='Hummingbird logo' title='Hummingbird logo' width='89' style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic' height='26'></a></td>
                        </tr>
                        <tr style='border-collapse:collapse'>
                            <td align='center' style='padding:0;Margin:0;padding-top:10px;padding-left:10px;padding-right:10px'>
                                <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:21px;color:#999999;font-size:14px'>www.inbracket.com</p>
                            </td>
                        </tr>
                        <tr style='border-collapse:collapse'>
                            <td align='center' style='padding:10px;Margin:0'>
                                <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:21px;color:#999999;font-size:14px'>You are receiving this email because your administrator have subscribed you for this information. Should you wish to&nbsp;discontinue receipt of this report please contact your systems administrator.</p>
                            </td>
                        </tr>
                        <tr style='border-collapse:collapse'>
                            <td align='center' style='Margin:0;padding-top:5px;padding-bottom:5px;padding-left:20px;padding-right:20px;font-size:0'>
                                <table width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
                                    <tr style='border-collapse:collapse'>
                                        <td style='padding:0;Margin:0;border-bottom:1px solid #cccccc;background:none;height:1px;width:100%;margin:0px'></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr style='border-collapse:collapse'>
                            <td align='center' style='padding:10px;Margin:0'>
                                <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:23px;color:#999999;font-size:15px'>Help Desk : support@inbracket.com</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
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
    $mail->setFrom('support@inbracket.com', 'Inbracket Help Desk');
    // $mail->addAddress('tony@grwills.com.au', 'Tony Virgen');     //Add a recipient
    $mail->addAddress('mohan@grwills.com.au', 'Mohan Wijesena');               //Name is optional
    $mail->addAddress('mohan.a.wijesena@gmail.com', 'Mohan Wijesena');               //Name is optional
    $mail->addReplyTo('support@inbracket.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    $mailContent = $results;
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Welcome to Inbracket';
    $mail->Body    = $mailContent;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->ErrorInfo;
    $mail->send();

    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
