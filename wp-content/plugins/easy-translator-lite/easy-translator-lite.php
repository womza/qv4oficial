<?php
/*
Plugin Name: Easy Translator
Plugin URI: http://www.thulasidas.com/easy-translator
Description: A plugin to translate other plugins (Yes, any other plugin) and blog pages. Access it by clicking <a href="tools.php?page=easy-translator-lite/easy-translator-lite.php">Tools &rarr; Easy Translator</a>.
Version: 4.40
Author: Manoj Thulasidas
Author URI: http://www.thulasidas.com
*/

/*
  Copyright (C) 2008 www.ads-ez.com

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if (class_exists("EasyTranslator")) {
  $plg = "Easy Translator Lite";
  $lite = plugin_basename(__FILE__);
  include_once('ezDenyLite.php');
  ezDenyLite($plg, $lite);
}

if (!class_exists("EasyTranslator")) {
  require_once('EzOptions.php');

  class EasyTranslator extends EzBasePlugin {

    var $eztPlgSlug, $eztPlgName, $eztMoName, $eztPlgDir, $eztAllDomains, $eztDomain,
            $eztAllMoFiles, $eztMoFile, $eztLocale, $eztPoName, $eztDelegate;
    var $sessionVars = array('eztPlgSlug', 'eztPlgName', 'eztMoName', 'eztPlgDir',
        'eztAllDomains', 'eztDomain', 'eztAllMoFiles', 'eztMoFile', 'eztLocale',
        'eztPoName', 'eztDelegate');

    function EasyTranslator() {
      parent::__construct("easy-translator", "Easy Translator", __FILE__);
    }

    function session_start() {
      if (!session_id())
        @session_start();
    }

    // Error messages
    function errMsg($s, $class = "error", $close = false) {
      $e = '';
      if ($class == "error") {
        $e = "<b>Error: </b>";
      }
      $s = '<div class="' . $class . '"><p>' . $e . $s . '</p></div>';
      if ($close) {
        $s .= "\n</div>\n";
      }
      return $s;
    }

    // Recursively finds all the MO files under a dir
    function findFiles($folder, $extensions = array('mo')) {

      function glob_recursive($folder, &$folders = array()) {
        $dirs = glob($folder, GLOB_ONLYDIR | GLOB_NOSORT);
        if (!empty($dirs)) {
          foreach ($dirs as $folder) {
            $folders[] = $folder;
            glob_recursive("{$folder}/*", $folders);
          }
        }
      }

      glob_recursive($folder, $folders);
      $files = array();
      foreach ($folders as $folder) {
        foreach ($extensions as $extension) {
          foreach (glob("{$folder}/*.{$extension}") as $file) {
            $files[$extension][] = $file;
          }
        }
      }
      return $files;
    }

    function putSessionVars($var = array()) {
      if (!is_array($var)) {
        $var = array($var);
      }
      foreach ($var as $v) {
        if (isset($this->$v)) {
          $_SESSION[$v] = $this->$v;
        }
      }
    }

    function getSessionVars($var = array()) {
      if (empty($var)) {
        $var = $this->sessionVars;
      }
      if (!is_array($var)) {
        $var = array($var);
      }
      foreach ($var as $v) {
        if (isset($_SESSION[$v])) {
          $this->$v = $_SESSION[$v];
        }
      }
    }

    function rmSessionVars($var = array()) {
      if (empty($var)) {
        $var = $this->sessionVars;
      }
      if (!is_array($var)) {
        $var = array($var);
      }
      // if (empty($var)), loop over $_SESSION vars, unset the ones that start with ezt
      foreach ($var as $v) {
        unset($_SESSION[$v]);
        $this->$v = '';
      }
    }

    function mkEzTran() {
      // Rebuild the EzTran object
      $this->getSessionVars();
      $this->ezTran->plgDir = $this->eztPlgDir;
      $this->ezTran->plgName = $this->eztPlgName;
      $this->ezTran->domain = $this->eztDomain;
      $this->ezTran->locale = $this->eztLocale;
      $this->ezTran->isEmbedded = false;
      load_textdomain($this->eztDomain, $this->eztMoFile);
    }

    function handleSubmits() {
      if (!$this->ezTran->handleSubmits()) {
        return;
      }
      if (isset($_POST['ezt-reset'])) {
        $this->rmSessionVars();
      }
      if (isset($_POST['ezt-load'])) {
        $this->rmSessionVars();
        $this->eztPlgSlug = $_POST['ezt-plugin'];
        $this->eztPlgDir = ABSPATH . PLUGINDIR . "/" . dirname($this->eztPlgSlug);
        $contents = $this->ezTran->getFileContents($this->eztPlgDir);
        EzTran::getStrings($contents, $keys, $domains);
        $this->eztAllDomains = array_count_values($domains);
        asort($this->eztAllDomains);
        $this->eztAllDomains = array_reverse($this->eztAllDomains, true);
        if (!empty($this->eztAllDomains)) {
          reset($this->eztAllDomains);
          $this->eztDomain = key($this->eztAllDomains);
        }
        $mofiles = $this->findFiles($this->eztPlgDir);
        if (!empty($mofiles['mo'])) {
          $mofiles = $mofiles['mo'];
        }
        $this->eztAllMoFiles = $mofiles;
        $this->eztPlgName = $_POST['ezt-name'];
        $this->putSessionVars(array('eztPlgSlug', 'eztPlgDir', 'eztPlgName', 'eztAllDomains', 'eztDomain', 'eztAllMoFiles'));
      }

      if (isset($_POST['ezt-loadmo']) || isset($_POST['ezt-createpo'])) {
        if (isset($_POST['ezt-createpo'])) {
          $this->eztPoName = $_POST['ezt-newpo'];
          $this->eztLocale = substr($this->eztPoName, 0, 5);
        }
        else {
          $this->eztMoFile = realpath($_POST['ezt-mofile']);
          $this->eztDomain = $_POST['ezt-domain'];
          if (!empty($_POST['ezt-locale'])) {
            $this->eztLocale = $_POST['ezt-locale'];
          }
          else {
            $this->eztLocale = $this->ezTran->locale;
          }
        }
        $this->putSessionVars(array('eztPoName', 'eztMoFile', 'eztLocale', 'eztDomain'));
        $_POST['eztran'] = 'eztran';
      }
      $this->getSessionVars();
      $this->mkEzTran();
    }

    function printAdminPage() {
      $this->mkEzTran();
      $this->handleSubmits();
      $this->getSessionVars();

      echo "<script src='{$this->plgURL}/wz_tooltip.js'></script>\n";

      if ($this->ezTran->printAdminPage()) {
        return;
      }
      echo "<div class='wrap' style='width:1000px'><h2>Easy Translator</h2><form method='post' action=''>";
      if (!empty($this->eztPlgSlug)) {
        $tip = "This plugin caches your inputs so that you restart from where you left off. If you would like to discard the cache and start from scratch, please click this button.";
        echo "<div style='background-color:#cff;padding:5px;margin:5px;border: solid 1px;margin-top:10px;'>If you would like to start from scratch, <input type='submit' style='width:10%' name='ezt-reset' value='Reset' title='$tip' onmouseover = 'Tip(\"$tip\",WIDTH, 300)' onmouseout='UnTip()'/></div>\n";
      }

      wp_nonce_field('ezTranSubmit', 'ezTranNonce');
      $plugins = get_plugins();
      $selPlugin = "<div style='' onmouseover = 'Tip(\"Hover over any of the labels below (like Select Plugin, for instance) for quick help.\",WIDTH, 300)' onmouseout='UnTip()'><h3>Input Selection</h3>[Hover over label for quick help.]<br /><br /></div><div style='width: 15%; float:left' onmouseover = 'Tip(\"Select one of your plugins to get started.\",WIDTH, 300)' onmouseout='UnTip()'>Select Plugin:</div><select style='width: 40%' name='ezt-plugin'>";
      $v = reset($plugins);
      $this->eztPlgName = $v['Name'];
      foreach ($plugins as $k => $v) {
        if ($k == $this->eztPlgSlug) {
          $selected = ' selected="selected" ';
          $this->eztPlgName = $v['Name'];
        }
        else {
          $selected = '';
        }
        $selPlugin .= "<option value='$k'  $selected >{$v['Name']}</option>\n";
      }
      $selPlugin .= '</select>';

      echo $selPlugin;

      echo "<input type='hidden' name='ezt-name' value='{$this->eztPlgName}' />";
      $loadPlugin = "&nbsp; <input type='submit' style='width:10%' name='ezt-load' value='Load it' title='Looks for all the MO files of the selected plugin' onmouseover = 'Tip(\"Looks for all language (MO) files of the selected plugin\",WIDTH, 300)' onmouseout='UnTip()'/> <br /><br />\n";
      echo $loadPlugin;

      if (empty($this->eztPlgSlug)) {
        echo $this->errMsg('Select and load a plugin!', 'updated');
        $this->printFooter();
        return;
      }

      $domain = '';
      if (!empty($this->eztDomain)) {
        $domain = $this->eztDomain;
      }
      if (empty($domain)) {
        $domain = $plugins[$this->eztPlgSlug]['TextDomain'];
      }
      if (empty($domain)) {
        $domain = dirname($this->eztPlgSlug);
      }
      if (empty($domain)) {
        echo $this->errMsg('No Text-domain!');
        $this->printFooter();
        return;
      }
      if (!empty($this->eztAllDomains)) {
        $info = 'The following are the text-domains detected in the plugin codebase:<br />';
        foreach ($this->eztAllDomains as $d => $count) {
          $info .= "<b><code>$d</code></b> [$count times]<br />";
        }
        $info .= 'Use one of them as your text-domain.<br /> The most likely one has been selected for you.<br />';
        $info = htmlentities($info);
      }
      else {
        $info = "No translatable strings are found in the plugin code base. Please take a look at {$this->eztPlgSlug} and other files to see if they are internationalized. Or contact the author of {$this->eztPlgSlug}.";
      }
      $textDomain = <<<EOF
<div style="width: 15%; float:left" onmouseover = "Tip('$info',WIDTH, 300)" onmouseout="UnTip()">Text Domain:</div>
<input type="text" style="width: 40%" name="ezt-domain" id="domain" value="$domain"  title="Enter the text-domain used by this plugin -- usually plugin-name" />&nbsp; <input type="button" style="width:10%" title="Click for more info" onclick="Tip('$info',WIDTH, 300)" onmouseover = "Tip('$info',WIDTH, 300)" onmouseout="UnTip()" value="Info" /><br />
EOF;
      echo $textDomain;

      if (!empty($this->eztAllMoFiles)) {
        $mosel = '<div style="width: 15%; float:left" onmouseover = "Tip(\'These are the language files found for this plugin. Select one of them to get started. Or create a new language (PO) file below.\',WIDTH, 300)" onmouseout="UnTip()">Language File:</div>' .
                '<select style="width: 40%" name="ezt-mofile">';
        foreach ($this->eztAllMoFiles as $k => $v) {
          $realv = realpath($v);
          if ($realv == $this->eztMoFile) {
            $selected = ' selected="selected" ';
          }
          else {
            $selected = '';
          }
          $mosel .= '<option value="' . $realv . '"' . $selected . '>' .
                  substr($realv, strlen($this->eztPlgDir)) . "</option>\n";
        }
        $mosel .= '</select><br />';
        echo $mosel;
      }

      $tip = "Enter the language code for your translation (used for machine translation seed by Google). It should be of the form <code>fr_FR</code>, for instance. The first two letters are for the language (and needed for Google translation), the last two are for the country, and not used by this plugin.";
      $lang = "<div style='width: 15%; float:left' onmouseover = 'Tip(\"$tip\",WIDTH, 300)' onmouseout='UnTip()' title='$tip'>Language Code:</div><input type='text' style='width: 40%' name='ezt-locale' title='$tip' onmouseover = 'Tip(\"$tip\",WIDTH, 300)' onmouseout='UnTip()' id='locale' value='$this->eztLocale'/>\n";
      echo $lang;

      $tip = "Loads the translations from the selected file and matches them with the translatable strings in the plugin. For the strings with no translations, Google translator will be invoked to give you a machine translation.";
      $loadmo = "&nbsp; <input type='submit' style='width:10%' name='ezt-loadmo' value='Load MO' title='$tip' onmouseover = 'Tip(\"$tip\",WIDTH, 300)' onmouseout='UnTip()' /><br /><br />\n";
      echo $loadmo;

      $tip = "Create a new language (PO) file for this plugin with the language code specified here. It should be of the form <code>fr_FR.po</code>, for instance. The first two letters are for the language (and needed for Google translation), the rest is for your reference, and is not used by this plugin.";
      $newpo = "<div style='width: 15%; float:left' title='$tip' onmouseover = 'Tip(\"$tip\",WIDTH, 300)' onmouseout='UnTip()'>Or Create New PO:</div><input type='text' name='ezt-newpo' style='width:40%' title='$tip' onmouseover = 'Tip(\"$tip\",WIDTH, 300)' onmouseout='UnTip()' value='{$this->eztPoName}'>&nbsp; <input type='submit' style='width:10%' name='ezt-createpo' value='Create PO' title='$tip' onmouseover = 'Tip(\"$tip\",WIDTH, 300)' onmouseout='UnTip()' /><br /><br />\n";

      echo $newpo;

      if (empty($this->eztMoFile) && empty($this->eztPoName)) {
        echo $this->errMsg('Please select and load a language file. Or create a new PO (language) file for this plugin.', 'updated');
        $this->printFooter();
        return;
      }
    }

    function printFooter() {
      echo "</form>";
      $ez = $this->mkEzAdmin();
      echo "<br /><hr />";
      $ez->renderWhyPro();
      ?>
      <div class='updated' id='rating'>
        <p>Thank you for using <i><b>Easy Translator</b></i>! You will find it feature-rich and robust. <br />
          If you are satisfied with how well it works, why not <a href='http://wordpress.org/extend/plugins/easy-translator-lite/' onclick="popupwindow('http://wordpress.org/extend/plugins/easy-translator-lite/', 'Rate it', 1024, 768); return false;">rate it</a>
          and <a href='http://wordpress.org/extend/plugins/easy-translator-lite/' onclick="popupwindow('http://wordpress.org/extend/plugins/easy-translator-lite/', 'Rate it', 1024, 768); return false;">recommend it</a> to others? :-)
        </p></div>
      <?php
      $ez->renderSupport();
      include ("{$this->plgDir}/tail-text.php");
      ?>
      <table class="form-table" >
        <tr><td><h3><?php _e('Credits', 'easy-adsenser'); ?></h3></td></tr>
      <tr><td>
          <ul style="padding-left:10px;list-style-type:circle; list-style-position:inside;" >
            <li>
              <?php printf(__('%s uses the excellent Javascript/DHTML tooltips by %s', 'easy-adsenser'), '<b>Easy Translator</b>', '<a href="http://www.walterzorn.com" target="_blank" title="Javascript, DTML Tooltips"> Walter Zorn</a>.');
              ?>
            </li>
          </ul>
        </td>
      </tr>
      </table>
      </div>
      <?php
    }

    function plugin_action($links, $file) {
      if ($file == plugin_basename($this->plgDir . '/easy-translator.php')) {
        $settings_link = "<a href='tools.php?page=easy-translator/easy-translator.php'>" .
                'Launch it' . "</a>";
        array_unshift($links, $settings_link);
      }
      return $links;
    }

  }

}

if (class_exists("EasyTranslator")) {
  $ezTran = new EasyTranslator();
  if (isset($ezTran)) {
    // Add it to the Tools Menu
    if (!function_exists("ezTran_ap")) {

      function ezTran_ap() {
        global $ezTran;
        if (function_exists('add_submenu_page')) {
          add_submenu_page('tools.php', 'Easy Translator', 'Easy Translator', "install_plugins", __FILE__, array($ezTran, 'printAdminPage'));
        }
        add_filter('plugin_action_links', array($ezTran, 'plugin_action'), -10, 2);
      }

    }
    add_action('admin_menu', 'ezTran_ap');
    add_action('init', array($ezTran, 'session_start'));
  }
}

if (!class_exists("EasyTranslatorWidget")) {

  class EasyTranslatorWidget extends WP_Widget {

    function EasyTranslatorWidget() {
      $widgetOps = array('description' =>
          'Translate Blog posts and pages using Easy Translator Lite.');
      parent::WP_Widget(false, $name = 'Easy Translator', $widgetOps);
    }

    function widget($args, $instance) {
      extract($args);
      $title = apply_filters('widget_title', $instance['title']);
      $translator = $instance['translator'];
      $plgName = 'easy-translator';
      switch ($translator) {
        case "ms":
          $translator = "<div id='MicrosoftTranslatorWidget' style='width: 200px; min-height: 83px;'><noscript><a href='http://www.microsofttranslator.com/bv.aspx?a=http%3a%2f%2fwww.thulasidas.com%2fplugins%2f$plgName'>Translate this page</a><br />Powered by <a href='http://www.bing.com/translator'>Microsoft® Translator</a></noscript></div> <script type='text/javascript'> /* <![CDATA[ */ setTimeout(function() { var s = document.createElement('script'); s.type = 'text/javascript'; s.charset = 'UTF-8'; s.src = ((location && location.href && location.href.indexOf('https') == 0) ? 'https://ssl.microsofttranslator.com' : 'http://www.microsofttranslator.com' ) + '/ajax/v2/widget.aspx?mode=manual&from=en&layout=ts'; var p = document.getElementsByTagName('head')[0] || document.documentElement; p.insertBefore(s, p.firstChild); }, 0); /* ]]> */ </script>";
          break;
        case "gg":
          $translator = "<span id='google_translate_element'></span><script type='text/javascript'>
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script><script type='text/javascript' src='//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit'></script>";
          break;
        default:
          $translator = "Please select a translator.";
      }
      echo $before_widget;
      if ($title) {
        echo $before_title . $title . $after_title;
      }
      echo $translator;
      echo $after_widget;
    }

    function update($new_instance, $old_instance) {
      $instance = array();
      $instance['title'] = strip_tags($new_instance['title']);
      $instance['translator'] = strip_tags($new_instance['translator']);
      return $instance;
    }

    function form($instance) {
      $titleId = $this->get_field_id('title');
      $titleName = $this->get_field_name('title');
      $translatorMs = $this->get_field_id('ms');
      $translatorGoogle = $this->get_field_id('gg');
      $translatorName = $this->get_field_name('translator');
      if (!empty($instance)) {
        $title = esc_attr($instance['title']);
        $translator = esc_attr($instance['translator']);
      }
      else {
        $translator = "ms";
        $title = "Easy Translator";
      }
      if ($translator == "ms") {
        $msChecked = "checked='checked'";
        $showMsColors = "block";
      }
      else {
        $msChecked = "";
        $showMsColors = "none";
      }
      if ($translator == "gg") {
        $ggChecked = "checked='checked'";
      }
      else {
        $ggChecked = "";
      }

      echo <<<EOF
<p>
<label for="">Title: </label>
<input id="$titleId" name="$titleName" type="text" value="{$title}" />
</p>
<p>
<label for="translatorName">Translator:<br />
<input id="$translatorMs" name="$translatorName" type="radio" value="ms" $msChecked/>&nbsp; Microsoft<sup>&reg;</sup><br />
<input id="$translatorGoogle" name="$translatorName" type="radio" value="gg" $ggChecked/>&nbsp; Google<sup>&reg;</sup><br />
</label>
</p>
EOF;
    }

  }

}

if (class_exists("EasyTranslatorWidget")) {
  add_action('widgets_init', create_function('', 'return register_widget("EasyTranslatorWidget");'));
}