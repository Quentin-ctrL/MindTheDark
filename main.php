<?php
/**
 * DokuWiki Default Template 2012
 *
 * @link     http://dokuwiki.org/template
 * @author   Anika Henke <anika@selfthinker.org>
 * @author   Clarence Lee <clarencedglee@gmail.com>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
header('X-UA-Compatible: IE=edge,chrome=1');

$hasSidebar = page_findnearest($conf['sidebar']);
$showSidebar = $hasSidebar && ($ACT=='show');

/**
 * MindTheDark theme settings ******************************************************
 */
$configUserChoice = tpl_getConf('userChoice');
$configAutoDark = tpl_getConf('autoDark');
$theme = tpl_getConf('theme');

if ($configUserChoice) {

    if (isset($_COOKIE["theme"])) {
        $theme = $_COOKIE["theme"];
    } 
    else {
        // If the cookie has never been set and both options are enabled, 
        // then the auto mode will be used until the user makes a choice
        if ($configAutoDark) {
            $theme = "auto";
        }
        else {
            $theme = "light";
        } 
    }
}

if ($configAutoDark and !$configUserChoice) {
    $theme = "auto";
}

// MindTheDark additional plugins
$pluginNote = "0";
if (tpl_getConf('pluginNote')) {
    $pluginNote = "1";
}
$pluginWrap = "0";
if (tpl_getConf('pluginWrap')) {
    $pluginWrap = "1";
}
$pluginHidden = "0";
if (tpl_getConf('pluginHidden')) {
    $pluginHidden = "1";
}


/**
 * *********************************************************************************
 */

?><!DOCTYPE html>
<html lang="<?php echo $conf['lang'] ?>" 
    dir="<?php echo $lang['direction'] ?>" 
    class="no-js" 
    theme="<?php echo $theme ?>" 
    pluginnote="<?php echo $pluginNote ?>"
    pluginwrap="<?php echo $pluginWrap ?>"
    pluginhidden="<?php echo $pluginHidden ?>"
>

<head>
    <meta charset="utf-8" />
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <?php tpl_metaheaders() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_includeFile('meta.html') ?>
    <meta name="configUserChoice" id="configUserChoice" content="<?php echo $configUserChoice ?>" />
</head>

<body>
    <div id="dokuwiki__site"><div id="dokuwiki__top" class="site <?php echo tpl_classes(); ?> <?php
        echo ($showSidebar) ? 'showSidebar' : ''; ?> <?php echo ($hasSidebar) ? 'hasSidebar' : ''; ?>">

        <?php include('tpl_header.php') ?>

        <div class="wrapper group">

            <?php if($showSidebar): ?>
                <!-- ********** ASIDE ********** -->
                <div id="dokuwiki__aside"><div class="pad aside include group">
                    <h3 class="toggle"><?php echo $lang['sidebar'] ?></h3>
                    <div class="content"><div class="group">
                        <?php tpl_flush() ?>
                        <?php tpl_includeFile('sidebarheader.html') ?>
                        <?php tpl_include_page($conf['sidebar'], true, true) ?>
                        <?php tpl_includeFile('sidebarfooter.html') ?>
                    </div></div>
                </div></div><!-- /aside -->
            <?php endif; ?>

            <!-- ********** CONTENT ********** -->
            <div id="dokuwiki__content"><div class="pad group">
                <?php html_msgarea() ?>

                <div class="pageId"><span><?php echo hsc($ID) ?></span></div>

                <div class="page group">
                    <?php tpl_flush() ?>
                    <?php tpl_includeFile('pageheader.html') ?>
                    <!-- wikipage start -->
                    <?php tpl_content() ?>
                    <!-- wikipage stop -->
                    <?php tpl_includeFile('pagefooter.html') ?>
                </div>

                <div class="docInfo"><?php tpl_pageinfo() ?></div>

                <?php tpl_flush() ?>
            </div></div><!-- /content -->

            <hr class="a11y" />

            <!-- PAGE ACTIONS -->
            <div id="dokuwiki__pagetools">
                <h3 class="a11y"><?php echo $lang['page_tools']; ?></h3>
                <div class="tools">
                    <ul>
                        <?php echo (new \dokuwiki\Menu\PageMenu())->getListItems(); ?>
                    </ul>
                </div>
            </div>
        </div><!-- /wrapper -->

        <?php include('tpl_footer.php') ?>
        
    </div></div><!-- /site -->

    <div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
    <div id="screen__mode" class="no"></div><?php /* helper to detect CSS media query in script.js */ ?>
</body>
</html>
