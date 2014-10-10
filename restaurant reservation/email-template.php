<?php


global	$name;
global	$email; 			
global	$phone; 			
global	$message; 		
global	$table;			
global	$persons;		
global	$lunch; 			
global	$date;			
global 	$time;		
global 	$recipient;
global 	$from;
global  $subject;
global  $messages;
global  $email_header_image;
global 	$email_icon_exist;
global  $email_facebook;
global  $email_twitter;
global  $email_google;
global  $email_linkedin;
global  $email_pinterest;
global  $email_youtube;
global  $email_template;



$email_template ='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title></title>


<!--[if gte mso 6]>
  <style>
      table.kmButtonBarContent {width:100% !important;}
      table.kmButtonCollectionContent {width:100% !important;}
  </style>
<![endif]-->
<style type="text/css">
  @media only screen and (max-width: 480px) {
    body, table, td, p, a, li, blockquote {
      -webkit-text-size-adjust: none !important;
    }
    body {
      width: 100% !important;
      min-width: 100% !important;
    }
    td[id=bodyCell] {
      padding: 10px !important;
    }
    table.kmMobileHide {
      display:none !important;
    }
    table[class=kmTextContentContainer] {
      width: 100% !important;
    }
    table[class=kmBoxedTextContentContainer] {
      width: 100% !important;
    }
    td[class=kmImageContent] {
      padding-left:0 !important;
      padding-right:0 !important;
    }
    img[class=kmImage] {
      width:100% !important;
    }
    table[class=kmSplitContentLeftContentContainer],
    table[class=kmSplitContentRightContentContainer],
    table[class=kmColumnContainer],
    td[class=kmVerticalButtonBarContentOuter] table[class=kmButtonBarContent],
    td[class=kmVerticalButtonCollectionContentOuter] table[class=kmButtonCollectionContent],
    table[class=kmVerticalButton],
    table[class=kmVerticalButtonContent] {
      width:100% !important;
    }
    td[class=kmButtonCollectionInner] {
      padding-left:9px !important;
      padding-right:9px !important;
      padding-top:9px !important;
      padding-bottom:0 !important;
      background-color:transparent !important;
    }
    td[class=kmVerticalButtonIconContent],
    td[class=kmVerticalButtonTextContent],
    td[class=kmVerticalButtonContentOuter] {
      padding-left:0 !important;
      padding-right:0 !important;
      padding-bottom:9px !important;
    }
    table[class=kmSplitContentLeftContentContainer] td[class=kmTextContent],
    table[class=kmSplitContentRightContentContainer] td[class=kmTextContent],
    table[class="kmColumnContainer"] td[class=kmTextContent],
    table[class=kmSplitContentLeftContentContainer] td[class=kmImageContent],
    table[class=kmSplitContentRightContentContainer] td[class=kmImageContent] {
      padding-top:9px !important;
    }
    td[class="rowContainer kmFloatLeft"],
    td[class="rowContainer kmFloatLeft firstColumn"],
    td[class="rowContainer kmFloatLeft lastColumn"] {
      float:left;
      clear: both;
      width: 100% !important;
    }
    table[id=templateContainer],
    table[class=templateRow] {
      max-width:600px !important;
      width:100% !important;
    }
    
      h1 {
        font-size:24px !important;
        line-height:130% !important;
      }
    
    
      h2 {
        font-size:20px !important;
        line-height:130% !important;
      }
    
    
      h3 {
        font-size:18px !important;
        line-height:130% !important;
      }
    
    
      h4 {
        font-size:16px !important;
        line-height:130% !important;
      }
    
    
      td[class=kmTextContent] {
        font-size:14px !important;
        line-height:130% !important;
      }
      td[class=kmTextBlockInner] td[class=kmTextContent] {
        padding-right:18px !important;
        padding-left:18px !important;
      }

      td[class="kmTableBlock kmTableMobile"] td[class=kmTableBlockInner] {
        padding-left:9px !important;
        padding-right:9px !important;
      }
      td[class="kmTableBlock kmTableMobile"] td[class=kmTableBlockInner] [class=kmTextContent] {
        font-size:14px !important;
        line-height:130% !important;
        padding-left:4px !important;
        padding-right:4px !important;
      }
    
  }
</style>

</head>
<body style="margin: 0; padding: 0; background-color: #C7C7C7">
<center>
<table align="center" border="0" cellpadding="0" cellspacing="0" id="bodyTable" width="100%" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; background-color: #C7C7C7; height: 100%; margin: 0; width: 100%">
<tbody>
<tr>
<td align="center" id="bodyCell" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; padding-top: 50px; padding-left: 20px; padding-bottom: 20px; padding-right: 20px; border-top: 0; height: 100%; margin: 0; width: 100%">
<table border="0" cellpadding="0" cellspacing="0" id="templateContainer" width="600" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; border: 1px solid #AAA; background-color: #F4F4F4">
<tbody>
<tr>
<td id="templateContainerInner" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0">
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<tr>
<td align="center" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<table border="0" cellpadding="0" cellspacing="0" class="templateRow" width="100%" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<tbody>
<tr>
<td class="rowContainer kmFloatLeft" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<table border="0" cellpadding="0" cellspacing="0" class="kmTextBlock" width="100%" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<tbody class="kmTextBlockOuter">
<tr>
<td class="kmTextBlockInner" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; background-color:#4542F9;">
<table align="left" border="0" cellpadding="0" cellspacing="0" class="kmTextContentContainer" width="100%" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<tbody>
<tr>
<td class="kmTextContent" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; color: #FFF; font-family: Helvetica, Arial; font-size: 14px; line-height: 150%; text-align: left; font-size:12px;color:#727272;padding-bottom:20px;text-align:center;padding-right:18px;padding-left:18px;padding-top:20px;">
<p style="margin: 0; padding-bottom: 0"><span style="color:#E6E6FA;"><span style="font-size: 36px;line-height:46px;"><strong>'.$from.'</strong></span></span></p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="kmImageBlock" width="100%" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<tbody class="kmImageBlockOuter">
<tr>
<td class="kmImageBlockInner" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; padding:9px;" valign="top">
<table align="left" border="0" cellpadding="0" cellspacing="0" class="kmImageContentContainer" width="100%" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<tbody>
<tr>
<td class="kmImageContent" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; padding-top:0px;padding-bottom:0;padding-left:9px;padding-right:9px;text-align: center;">
<img align="center" alt="store image" class="kmImage" src="'.$email_header_image.'" width="274" style="border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; padding-bottom: 0; display: inline; vertical-align: bottom; max-width:274px;" />
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td align="center" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<table border="0" cellpadding="0" cellspacing="0" class="templateRow" width="100%" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<tbody>
<tr>
<td class="rowContainer kmFloatLeft" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<table border="0" cellpadding="0" cellspacing="0" class="kmTextBlock" width="100%" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<tbody class="kmTextBlockOuter">
<tr>
<td class="kmTextBlockInner" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; background-color:#04DBF0;">
<table align="left" border="0" cellpadding="0" cellspacing="0" class="kmTextContentContainer" width="100%" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<tbody>
<tr>
<td class="kmTextContent" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; color: #FFF; font-family: Helvetica, Arial; font-size: 14px; line-height: 150%; text-align: left; padding-top:20px;padding-bottom:20px;padding-left:18px;padding-right:18px;">
<h1 style="color: #F20000; display: block; font-family: Helvetica, Arial; font-size: 26px; font-style: normal; font-weight: bold; line-height: 110%; letter-spacing: normal; margin: 0; margin-bottom: 9px; text-align: left"><span style="color:#FFFFFF;">'.$subject.'</span></h1>

<p style="margin: 0; padding-bottom: 1em"><span style="color:#FFFFFF;"><strong>Name 			: </strong>'.$name.'</span></p>
<p style="margin: 0; padding-bottom: 1em"><span style="color:#FFFFFF;"><strong>Email			: </strong>'.$email.'</span></p>
<p style="margin: 0; padding-bottom: 1em"><span style="color:#FFFFFF;"><strong>Phone			: </strong>'.$phone.'</span></p>
<p style="margin: 0; padding-bottom: 1em"><span style="color:#FFFFFF;"><strong>Type of table	: </strong>'.$type_of_table.'</span></p>
<p style="margin: 0; padding-bottom: 1em"><span style="color:#FFFFFF;"><strong>Persons			: </strong>'.$persons.'</span></p>
<p style="margin: 0; padding-bottom: 1em"><span style="color:#FFFFFF;"><strong>Booking Date		: </strong>'.$date.'</span></p>
<p style="margin: 0; padding-bottom: 1em"><span style="color:#FFFFFF;"><strong>Booking Time		: </strong>'.$time.'</span></p>
<p style="margin: 0; padding-bottom: 1em"><span style="color:#FFFFFF;"><strong>Message			: </strong>'.$message.'</span></p>

</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>

';




if( $email_icon_exist ):
$email_template .= '

<table border="0" cellpadding="0" cellspacing="0" class="kmButtonBarBlock" width="100%" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<tbody class="kmButtonBarOuter">
<tr>
<td class="kmButtonBarInner" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; padding-top:9px;padding-bottom:9px;padding-left:9px;padding-right:9px;">
<table align="left" border="0" cellpadding="0" cellspacing="0" class="kmButtonBarContentContainer" width="100%" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<tbody>
<tr>
<td align="left" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; padding-left:9px;padding-right:9px;">
<table border="0" cellpadding="0" cellspacing="0" class="kmButtonBarContent" align="left" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; font-family: Helvetica, Arial">
<tbody>
<tr>
<td align="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
';



if( $email_facebook != ''){
    $email_template .= '
        <table align="left" border="0" cellpadding="0" cellspacing="0" class="" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
        <tbody>
        <tr>
        <td align="center" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; padding-right:10px;">
        <a href="'.$email_facebook.'" target="_blank" style="word-wrap: break-word; color: #0000CD; font-weight: normal; text-decoration: underline"><img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/default/facebook_48.png" alt="Facebook" class="kmButtonBlockIcon" width="48" style="border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; width:48px; max-width:48px; display:block;" /></a>
        </td>
        </tr>
        
        </tbody>
        </table>
    ';
} // if( $email_facebook != ''){

if( $email_google != ''){
	$email_template .= '
        <table align="left" border="0" cellpadding="0" cellspacing="0" class="" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
        <tbody>
        <tr>
        <td align="center" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; padding-right:10px;">
        <a href="'.$email_google.'" target="_blank" style="word-wrap: break-word; color: #0000CD; font-weight: normal; text-decoration: underline"><img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/default/google_plus_48.png" alt="Google" class="kmButtonBlockIcon" width="48" style="border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; width:48px; max-width:48px; display:block;" /></a>
        </td>
        </tr>
        </tbody>
        </table>
    ';
} // if( $email_google != ''){

if( $email_linkedin != ''){
	$email_template .= '
        <table align="left" border="0" cellpadding="0" cellspacing="0" class="" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
        <tbody>
        <tr>
        <td align="center" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; padding-right:10px;">
        <a href="'.$email_linkedin.'" target="_blank" style="word-wrap: break-word; color: #0000CD; font-weight: normal; text-decoration: underline"><img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/default/linkedin_48.png" alt="LinkedIn" class="kmButtonBlockIcon" width="48" style="border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; width:48px; max-width:48px; display:block;" /></a>
        </td>
        </tr>
        </tbody>
        </table>
    ';
} // if( $email_linkedin != ''){


if( $email_pinterest != ''){
	$email_template .= '
        <table align="left" border="0" cellpadding="0" cellspacing="0" class="" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
        <tbody>
        <tr>
        <td align="center" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; padding-right:10px;">
        <a href="'.$email_pinterest.'" target="_blank" style="word-wrap: break-word; color: #0000CD; font-weight: normal; text-decoration: underline"><img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/default/pinterest_48.png" alt="Pinterest" class="kmButtonBlockIcon" width="48" style="border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; width:48px; max-width:48px; display:block;" /></a>
        </td>
        </tr>
        </tbody>
        </table>
    ';
} // if( $email_pinterest != ''){


if( $email_twitter != ''){
    $email_template .= '
        <table align="left" border="0" cellpadding="0" cellspacing="0" class="" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
        <tbody>
        <tr>
        <td align="center" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; padding-right:10px;">
        <a href="'.$email_twitter.'" target="_blank" style="word-wrap: break-word; color: #0000CD; font-weight: normal; text-decoration: underline"><img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/default/twitter_48.png" alt="Twitter" class="kmButtonBlockIcon" width="48" style="border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; width:48px; max-width:48px; display:block;" /></a>
        </td>
        </tr>
        </tbody>
        </table>
    ';
} // if( $email_twitter != ''){

if( $email_youtube != ''){
    $email_template .= '
        <table align="left" border="0" cellpadding="0" cellspacing="0" class="" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
        <tbody>
        <tr>
        <td align="center" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; ">
        <a href="'.$email_youtube.'" target="_blank" style="word-wrap: break-word; color: #0000CD; font-weight: normal; text-decoration: underline"><img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/default/youtube_48.png" alt="Youtube" class="kmButtonBlockIcon" width="48" style="border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; width:48px; max-width:48px; display:block;" /></a>
        </td>
        </tr>
        </tbody>
        </table>
    ';
} // if( $email_youtube != ''){


$email_template .= '
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
';
endif;	// if( $email_icon_exist ):


$email_template .= '
</td>
</tr>
</tbody>
</table>

<table border="0" cellpadding="0" cellspacing="0" class="kmImageBlock" width="100%" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<tbody class="kmImageBlockOuter">
<tr>
<td class="kmImageBlockInner" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; padding:0px;background-color:#FFFFFF;" valign="top">
<table align="left" border="0" cellpadding="0" cellspacing="0" class="kmImageContentContainer" width="100%" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">
<tbody>
<tr>
<td class="kmImageContent" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; padding:0;">
<img align="center" alt="Shadow" class="kmImage" src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/bottom_shadow_444.png" width="600" style="border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; padding-bottom: 0; display: inline; vertical-align: bottom" />
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</center>
</body>
</html>
';
?>