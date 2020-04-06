<?php

namespace Gewaer\Cli\Tasks;

use Phalcon\Cli\Task as PhTask;
use Canvas\Models\EmailTemplates;

/**
 * Class AclTask.
 *
 * @package Canvas\Cli\Tasks;
 *
 * @property \Canvas\Acl\Manager $acl
 */
class EmailtemplatesTask extends PhTask
{
    /**
     * Create the default roles of the system.
     *
     * @return void
     */
    public function mainAction()
    {
        $this->insertUserNotificationTemplate();
    }

    /**
     * Insert default email template.
     * @return void
     */
    public function insertUserNotificationTemplate()
    {
        $usersNotificationHTML = <<<EOD
        <!DOCTYPEhtmlPUBLIC"-//W3C//DTDXHTML1.0Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><htmlxmlns="http://www.w3.org/1999/xhtml"><head><metahttp-equiv="content-type"content="text/html;charset=utf-8"><metaname="viewport"content="width=device-width"><metaname="description"content="Kanvasecosystem"><linkhref="https://fonts.googleapis.com/css?family=Lato:300,400,500,600,700&display=swap"rel="stylesheet"type="text/css"><title>{{app-name}}</title><!--GeneralStylesheet--><styletype="text/css">html{background-color:{{base_color}};}body{font-family:'Lato',Verdana,sans-serif;}@mediaonlyscreen{html{min-height:100%;background-color:{{base_color}};}}@mediaonlyscreenand(max-width:596px){.small-float-center{margin:0auto!important;float:none!important;text-align:center!important;}.small-text-center{text-align:center!important;}.small-text-left{text-align:left!important;}.small-text-right{text-align:right!important;}.main-title{font-size:23px!important;}.quote-text{font-size:16px!important;}.logo{padding:0!important;}.hide-for-large{display:block!important;width:auto!important;overflow:visible!important;max-height:none!important;font-size:inherit!important;line-height:inherit!important;}table.bodytable.container.hide-for-large,table.bodytable.container.row.hide-for-large{display:table!important;width:100%!important;}table.bodytable.container.callout-inner.hide-for-large{display:table-cell!important;width:100%!important;}table.bodytable.container.show-for-large{display:none!important;width:0;mso-hide:all;overflow:hidden;}table.bodyimg{width:auto;height:auto;}table.body.container{max-width:480px!important;width:auto!important;}table.body.column,table.body.columns{height:auto!important;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;padding-left:18px!important;padding-right:18px!important;}table.body.column.column,table.body.column.columns,table.body.columns.column,table.body.columns.columns{padding-left:0!important;padding-right:0!important;}table.body.collapse.column,table.body.collapse.columns{padding-left:0!important;padding-right:0!important;}td.small-1,th.small-1{display:inline-block!important;width:8.33333%!important;}td.small-2,th.small-2{display:inline-block!important;width:16.66667%!important;}td.small-3,th.small-3{display:inline-block!important;width:25%!important;}td.small-4,th.small-4{display:inline-block!important;width:33.33333%!important;}td.small-5,th.small-5{display:inline-block!important;width:41.66667%!important;}td.small-6,th.small-6{display:inline-block!important;width:50%!important;}td.small-7,th.small-7{display:inline-block!important;width:58.33333%!important;}td.small-8,th.small-8{display:inline-block!important;width:66.66667%!important;}td.small-9,th.small-9{display:inline-block!important;width:75%!important;}td.small-10,th.small-10{display:inline-block!important;width:83.33333%!important;}td.small-11,th.small-11{display:inline-block!important;width:91.66667%!important;}td.small-12,th.small-12{display:inline-block!important;width:100%!important;}.columntd.small-12,.columnth.small-12,.columnstd.small-12,.columnsth.small-12{display:block!important;width:100%!important;}table.bodytd.small-offset-1,table.bodyth.small-offset-1{margin-left:8.33333%!important;}table.bodytd.small-offset-2,table.bodyth.small-offset-2{margin-left:16.66667%!important;}table.bodytd.small-offset-3,table.bodyth.small-offset-3{margin-left:25%!important;}table.bodytd.small-offset-4,table.bodyth.small-offset-4{margin-left:33.33333%!important;}table.bodytd.small-offset-5,table.bodyth.small-offset-5{margin-left:41.66667%!important;}table.bodytd.small-offset-6,table.bodyth.small-offset-6{margin-left:50%!important;}table.bodytd.small-offset-7,table.bodyth.small-offset-7{margin-left:58.33333%!important;}table.bodytd.small-offset-8,table.bodyth.small-offset-8{margin-left:66.66667%!important;}table.bodytd.small-offset-9,table.bodyth.small-offset-9{margin-left:75%!important;}table.bodytd.small-offset-10,table.bodyth.small-offset-10{margin-left:83.33333%!important;}table.bodytd.small-offset-11,table.bodyth.small-offset-11{margin-left:91.66667%!important;}table.bodytable.columnstd.expander,table.bodytable.columnsth.expander{display:none!important;}table.body.right-text-pad,table.body.text-pad-right{padding-left:10px!important;}table.body.left-text-pad,table.body.text-pad-left{padding-right:10px!important;}table.menu{width:100%!important;}table.menutd,table.menuth{width:auto!important;display:inline-block!important;}table.menu.small-verticaltd,table.menu.small-verticalth,table.menu.verticaltd,table.menu.verticalth{display:block!important;}table.menu[align=center]{width:auto!important;}table.button.small-expand,table.button.small-expanded{width:100%!important;}table.button.small-expandtable,table.button.small-expandedtable{width:100%;}table.button.small-expandtablea,table.button.small-expandedtablea{text-align:center!important;width:100%!important;padding-left:0!important;padding-right:0!important;}table.button.small-expandcenter,table.button.small-expandedcenter{min-width:0;}}</style></head><bodystyle="-moz-box-sizing:border-box;-ms-text-size-adjust:100%;-webkit-box-sizing:border-box;-webkit-text-size-adjust:100%;Margin:0;background:{{base_color}}!important;box-sizing:border-box;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;min-width:100%;padding:0;text-align:left;width:100%!important"><!----><spanclass="preheader"style="color:#f3f3f3;display:none!important;font-size:1px;line-height:1px;max-height:0;max-width:0;mso-hide:all!important;opacity:0;overflow:hidden;visibility:hidden"></span><!--CONTAINER--><tableclass="body"style="margin:0;background:{{base_color}}!important;border-collapse:collapse;border-spacing:0;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;height:100%;line-height:1.3;padding:0;text-align:left;vertical-align:top;width:100%;"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><tdclass="center"valign="top"style="-webkit-hyphens:auto;margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word;"><divstyle="min-width:580px;width:100%;"><!--LOGO--><tableclass="wrapperheaderfloat-center"style="margin:0auto;background:#8a8a8a;background-color:{{base_color}};border-collapse:collapse;border-spacing:0;float:none;padding:0;text-align:center;vertical-align:top;width:100%;"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><tdclass="wrapper-inner"style="-webkit-hyphens:auto;margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:20px;text-align:left;vertical-align:top;word-wrap:break-word;"><tableclass="container"style="margin:0auto;background:00;border-collapse:collapse;border-spacing:0;padding:0;text-align:inherit;vertical-align:top;width:580px;"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><tdstyle="-webkit-hyphens:auto;margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word;"><tableclass="rowcollapse"style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%;"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><tdstyle="-webkit-hyphens:auto;margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word;"><!--Logo--><imgclass="logo"src="https://kanvas.dev/img/kanvas-white-logo.svg"style="-ms-interpolation-mode:bicubic;clear:both;display:block;margin:0auto;margin-top:20px;margin-bottom:20px;outline:0;padding:20px;text-decoration:none;max-height:100px"></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><!--CONTENT--><tablestyle="margin:0auto;background:#fefefe;border-collapse:collapse;border-radius:10px;border-spacing:0;float:none;padding:0;text-align:center;vertical-align:top;width:580px;"align="center"class="containerfloat-center"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><tdstyle="-webkit-hyphens:auto;margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word;"><!--SPACER--><tableclass="spacer"style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%;"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><tdheight="16"style="-webkit-hyphens:auto;margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:16px;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word;"></td></tr></tbody></table><tableclass="row"style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%;"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><thclass="small-12large-12columnsfirstlast"style="margin:0auto;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:16px;padding-left:35px;padding-right:35px;text-align:left;width:564px;"><tablestyle="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%;"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><thstyle="margin:0;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left;"><!--MAINTITLE--><tablestyle="border-collapse:collapse;border-spacing:0;margin-top:50px;padding:0;text-align:center;vertical-align:top;width:100%;"><tbody><trstyle="padding:150px;text-align:center;vertical-align:top;"><thstyle="margin:0;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:center;"><imgstyle="width:90%;"src="https://kanvas.dev/img/kanvas-laptop.png"></th></tr></tbody></table><!--SPACER--><tableclass="spacerfloat-center"style="margin:0auto;border-collapse:collapse;border-spacing:0;float:none;padding:0;text-align:center;vertical-align:top;width:100%;"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><tdheight="20"style="-webkit-hyphens:auto;margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:16px;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word;"></td></tr></tbody></table><!--WELCOMEPHRASE--><tablestyle="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%;"><tbody><trstyle="padding:0;text-align:center;vertical-align:top;"><tdstyle="-webkit-hyphens:auto;margin:0;border-collapse:collapse;"><h3style="color:{{base_color}};margin-bottom:0px;font-family:'Lato',sans-serif;font-size:25px;text-transform:capitalize;">{{notification-title}}</h3></td></tr></tbody></table><!--SPACER--><tableclass="spacerfloat-center"style="margin:0auto;border-collapse:collapse;border-spacing:0;float:none;padding:0;text-align:center;vertical-align:top;width:100%;"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><tdheight="10"style="-webkit-hyphens:auto;margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:16px;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word;"></td></tr></tbody></table><!--TEXTBODY--><tablestyle="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%;"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><tdstyle="-webkit-hyphens:auto;margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word;"><pstyle="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:26px;padding:0;text-align:left;">{{notification-body}}<br></p></td></tr></tbody></table><!--SPACER--><tableclass="spacerfloat-center"style="margin:0auto;border-collapse:collapse;border-spacing:0;float:none;padding:0;text-align:center;vertical-align:top;width:100%;"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><tdheight="10"style="-webkit-hyphens:auto;margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:16px;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word;"></td></tr></tbody></table><!--GREENBOX--><tablestyle="background:{{secondary_color}};border-radius:3px;border-collapse:collapse;border-spacing:0;padding:0;text-align:center;vertical-align:top;width:100%;"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><thclass="quote"style="margin:0;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left;"><ahref="{{external-link}}"class="quote-text"style="display:block;text-decoration:none;margin:0;padding:15px;border-radius:5px;color:#ffffff;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:700;letter-spacing:0px;line-height:1.2;text-align:center;text-transform:uppercase;">{{external-link-label}}</a></th></tr></tbody></table><!--SPACER--><tableclass="spacerfloat-center"style="margin:0auto;border-collapse:collapse;border-spacing:0;float:none;padding:0;text-align:center;vertical-align:top;width:100%;"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><tdheight="20"style="-webkit-hyphens:auto;margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:16px;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word;"></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></td></tr></tbody></table><!--GREENSPACER--><tablestyle="margin:0auto;background:#fefefe;background-color:{{base_color}};border-collapse:collapse;border-spacing:0;float:none;padding:0;text-align:center;vertical-align:top;width:580px;"align="left"class="containerfloat-center"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><tdstyle="-webkit-hyphens:auto;margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word;"><tablestyle="border-collapse:collapse;border-spacing:0;padding:0;text-align:center;vertical-align:top;margin:0%auto;"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><thstyle="margin:0auto;color:#0a0a0a;float:none;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:center;"class="menu-itemfloat-center"><astyle="display:block;margin:15px0px;color:#fafafa;font-family:'Lato',Verdana,sans-serif;font-weight:400;line-height:1.3;padding:0;text-align:left;text-decoration:none;"href="#"></a></th></tr></tbody></table></td></tr></tbody></table><!--VEREMAILENELNAVEGADOR--><!--<tableclass="row"style="border-collapse:collapse;border-spacing:0;padding:20px0;position:relative;text-align:left;vertical-align:top;width:100%;"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><thstyle="color:#ffffff;font-family:'OpenSans',Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;"><pclass="text-center"style="color:#ffffff;font-family:'OpenSans',Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;line-height:1.3;margin:30px010px;padding:0;text-align:center;">Can'tseethisemail?<ahref="#test"style="color:#ffffff;font-family:'OpenSans',Helvetica,Arial,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:underline;">Openitinyourbrowser</a></p></th></tr></tbody></table>--><!--SPACER--><tableclass="spacerfloat-center"style="margin:0auto;border-collapse:collapse;border-spacing:0;float:none;padding:0;text-align:center;vertical-align:top;width:100%;"><tbody><trstyle="padding:0;text-align:left;vertical-align:top;"><tdheight="20"style="-webkit-hyphens:auto;margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:16px;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word;"></td></tr></tbody></table><!--COPIRYGHT--><tableclass="menufloat-center"style="margin:0auto;border-collapse:collapse;border-spacing:0;float:none;padding:0;text-align:center;vertical-align:top;width:auto!important;"><tbody><trstyle="padding:0;text-align:center;vertical-align:top;"><tdstyle="-webkit-hyphens:auto;margin:0;border-collapse:collapse!important;color:#ffffff;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:center;vertical-align:top;word-wrap:break-word;"><tablestyle="border-collapse:collapse;border-spacing:0;padding:0;text-align:center;vertical-align:top;width:564px;margin:0auto;"><tbody><trstyle="padding:0;text-align:center;vertical-align:top;"><thstyle="margin:0auto;color:#ffffff;float:none;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-right:10px;text-align:center;"class="menu-itemfloat-center"><pstyle="margin:0;margin-bottom:10px;color:#fff;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:700;line-height:1.3;padding:0;text-align:center;">KANVAS&copy;2020</p></th></tr></tbody></table><!--SPACER--><tableclass="spacerfloat-center"style="margin:0auto;border-collapse:collapse;border-spacing:0;float:none;padding:0;text-align:center;vertical-align:top;width:100%;"><tbody><trstyle="padding:0;text-align:center;vertical-align:top;"><tdheight="10"style="-webkit-hyphens:auto;margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:20px;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word;"></td></tr></tbody></table><tablestyle="border-collapse:collapse;border-spacing:0;padding:0;text-align:center;vertical-align:top;width:564px;margin:0auto;"><tbody><trstyle="padding:0;text-align:center;vertical-align:top;"><thstyle="margin:0auto;color:#ffffff;float:none;font-family:'Lato',Verdana,sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-right:10px;text-align:center;"class="menu-itemfloat-center"><pstyle="margin:0;margin-bottom:50px;color:#fff;font-family:'Lato',Verdana,sans-serif;font-size:12px;font-weight:400;line-height:1.3;padding:0;text-align:center;">ThisemailwassentbytheKANVASapplication.<br/>IfyouarenolongerinterestedinreceivingemailsfromtheKANVASapplication.<br/>Unsubscribe<ahref="{{unsubscribe-link}}"style="color:#ffffff;font-family:'OpenSans',Helvetica,Arial,sans-serif;font-weight:700;line-height:1.3;margin:0;padding:0;text-align:center;text-decoration:none;">Here</a></p></th></tr></tbody></table></td></tr></tbody></table></div></td></tr></tbody></table><divstyle="display:none;white-space:nowrap;font:15pxcourier;line-height:0;"></div></body></html>
EOD;
        $emailTemplate = new EmailTemplates();
        $emailTemplate->users_id = 1;
        $emailTemplate->companies_id = 0;
        $emailTemplate->apps_id = 0;
        $emailTemplate->name = 'users-notification';
        $emailTemplate->template = $usersNotificationHTML;
        $emailTemplate->created_at = date('Y-m-d H:i:s');
        $emailTemplate->save();
    }
}
