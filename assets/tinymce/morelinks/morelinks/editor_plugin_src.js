/**
 * Morelinks extension for TinyMCE in Contao
 *
 * @copyright  computino.de Webservice 2009 / Magmell GbR 2014
 * @author     Markus Milkereit <markus.milkereit@magmell.de>
 * @package    Morelinks
 * @license    LGPL
 */

(function() {
	tinymce.create('tinymce.plugins.MorelinksPlugin', {
		init : function(ed, url) {

			// Register morelinks command
			ed.addCommand('mceMorelinks', function() {
				ed.windowManager.open({
					file : url + '/morelinks.php',
					width : 360 + parseInt(ed.getLang('morelinks.delta_width', 0)),
					height : 302 + parseInt(ed.getLang('morelinks.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register button
			ed.addButton('morelinks', {
				title : 'morelinks.link_desc',
				cmd   : 'mceMorelinks',
				image : url + '/img/morelinks.gif'
			});

			// Add shortcut
			// ed.addShortcut('ctrl+k', 'morelinks.desc', 'mceMorelinks');

			// Add a node change handler
			ed.onNodeChange.add(function(ed, cm, n, co) {
				cm.setDisabled('morelinks', co && n.nodeName != 'A');
				cm.setActive('morelinks', n.nodeName == 'A');
			});
		},

		getInfo : function() {
			return {
				longname : 'Morelinks - a Contao plugin for TinyMCE',
				author : 'Markus Milkereit',
				authorurl : 'http://www.magmell.de',
				infourl : 'http://www.contao.org',
				version : '3.0.1'
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('morelinks', tinymce.plugins.MorelinksPlugin);
})();