<?php

/**
 *
 * PHP version 5
 * @copyright  computino.de Webservice 2009 / Magmell GbR
 * @author     Markus Milkereit <markus.milkereit@magmell.de>
 * @package    Morelinks
 * @license    LGPL
 */


/**
 * Initialize system
 */
define('TL_MODE', 'BE');
require '../../../../system/initialize.php';


/**
 * Include library class
 */
require('morelib.php');


/**
 * Generate page
 */
header('Content-Type: text/html; charset='.$GLOBALS['TL_CONFIG']['characterSet']);
$objLib = new morelib();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{#morelinks_dlg.link_title}</title>
	<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<script type="text/javascript" src="../../utils/mctabs.js"></script>
	<script type="text/javascript" src="../../utils/editable_selects.js"></script>
	<script type="text/javascript" src="../../utils/form_utils.js"></script>
	<script type="text/javascript" src="../../utils/validate.js"></script>
	<script type="text/javascript" src="js/morelinks.js"></script>
	<style>a.browse span{display:inline-block}input[name="href"]{margin-right:4px}#srcbrowser{background-position:-380px -1px}</style>
</head>
<body id="link" style="display: none">
<form onsubmit="LinkDialog.update();return false;" action="#">
	<div class="tabs">
		<ul>
			<li id="general_tab" class="current"><span><a href="javascript:mcTabs.displayTab('general_tab','general_panel');" onmousedown="return false;">{#morelinks_dlg.link_title}</a></span></li>
		</ul>
	</div>
	
	<div class="panel_wrapper" style="height:227px;">
		<div id="general_panel" class="panel current">
		<table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td nowrap="nowrap"><label for="tlnews">{#morelinks_dlg.news}</label></td>
            <td><select id="tlpage" name="tlnews" style="width: 200px" onchange="document.forms[0].tlarticle.value='';document.forms[0].tlevents.value='';document.forms[0].tlfaq.value='';document.forms[0].href.value='{{news_url::'+this.value+'}}';document.forms[0].linktitle.value='{{news_title::'+this.value+'}}';"><option value="">-</option><?php echo $objLib->createNewsList();; ?></select></td>
          </tr>          
          <tr>
            <td nowrap="nowrap"><label for="tlevents">{#morelinks_dlg.events}</label></td>
            <td><select id="tlfile" name="tlevents" style="width: 200px" onchange="document.forms[0].tlarticle.value='';document.forms[0].tlnews.value='';document.forms[0].tlfaq.value='';document.forms[0].href.value='{{event_url::'+this.value+'}}';document.forms[0].linktitle.value='{{event_title::'+this.value+'}}';"><option value="">-</option><?php echo $objLib->createEventsList(); ?></select></td>
          </tr>
          <tr>
            <td nowrap="nowrap"><label for="tlfaq">{#morelinks_dlg.faqs}</label></td>
            <td><select id="tlfile" name="tlfaq" style="width: 200px" onchange="document.forms[0].tlarticle.value='';document.forms[0].tlevents.value='';document.forms[0].tlnews.value='';document.forms[0].href.value='{{faq_url::'+this.value+'}}';document.forms[0].linktitle.value='{{faq_title::'+this.value+'}}';"><option value="">-</option><?php echo $objLib->createFaqList(); ?></select></td>
          </tr>
          <tr>
            <td nowrap="nowrap"><label for="tlarticle">{#morelinks_dlg.articles}</label></td>
            <td><select id="tlfile" name="tlarticle" style="width: 200px" onchange="document.forms[0].tlnews.value='';document.forms[0].tlevents.value='';document.forms[0].tlfaq.value='';document.forms[0].href.value='{{article_url::'+this.value+'}}';document.forms[0].linktitle.value='{{article_title::'+this.value+'}}';"><option value="">-</option><?php echo $objLib->createArticleList(); ?></select></td>
          </tr>
          <tr>
            <td class="nowrap"><label for="href">{#morelinks_dlg.link_url}</label></td>
            <td><table border="0" cellspacing="0" cellpadding="0"> 
	    	<tr> 
			<td><input id="href" name="href" type="text" class="mceFocus" value="" style="width: 200px" onchange="LinkDialog.checkPrefix(this);" /></td> 
			<td id="hrefbrowsercontainer"> </td>
	    	</tr> 
	  	</table>
	    </td>
          </tr>
          <tr>
            <td class="nowrap"><label for="linktitle">{#morelinks_dlg.link_titlefield}</label></td>
            <td><input id="linktitle" name="linktitle" type="text" value="" style="width: 200px" /></td>
          </tr>
          <tr>
            <td><label id="rellistlabel" for="rel_list">{#morelinks_dlg.image_rel}</label></td>
            <td><select id="rel_list" name="rel_list" class="mceEditableSelect" style="width: 200px"></select></td>
          </tr>
          <tr>
            <td><label id="targetlistlabel" for="target_list">{#morelinks_dlg.link_target}</label></td>
            <td><select id="target_list" name="target_list" style="width: 200px"></select></td>
          </tr>
          <tr>
            <td><label for="class_list">{#class_name}</label></td>
            <td><select id="class_list" name="class_list" class="mceEditableSelect" style="width: 200px"></select></td>
          </tr>
        </table>
		</div>
	</div>

	<div class="mceActionPanel">
		<input type="submit" id="insert" name="insert" value="{#insert}" />
		<input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
	</div>
</form>
</body>
</html>