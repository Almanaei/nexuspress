<?php
/**
 * NexusPress core upgrade functionality.
 *
 * Note: Newly introduced functions and methods cannot be used here.
 * All functions must be present in the previous version being upgraded from
 * as this file is used there too.
 *
 * @package NexusPress
 * @subpackage Administration
 * @since 2.7.0
 */

/**
 * Stores files to be deleted.
 *
 * Bundled theme files should not be included in this list.
 *
 * @since 2.7.0
 *
 * @global array $_old_files
 * @var array
 * @name $_old_files
 */
global $_old_files;

$_old_files = array(
	// 2.0
	'nx-admin/import-b2.php',
	'nx-admin/import-blogger.php',
	'nx-admin/import-greymatter.php',
	'nx-admin/import-livejournal.php',
	'nx-admin/import-mt.php',
	'nx-admin/import-rss.php',
	'nx-admin/import-textpattern.php',
	'nx-admin/quicktags.js',
	'nx-images/fade-butt.png',
	'nx-images/get-firefox.png',
	'nx-images/header-shadow.png',
	'nx-images/smilies',
	'nx-images/nx-small.png',
	'nx-images/wpminilogo.png',
	'wp.php',
	// 2.1
	'nx-admin/edit-form-ajax-cat.php',
	'nx-admin/execute-pings.php',
	'nx-admin/inline-uploading.php',
	'nx-admin/link-categories.php',
	'nx-admin/list-manipulation.js',
	'nx-admin/list-manipulation.php',
	'nx-includes/comment-functions.php',
	'nx-includes/feed-functions.php',
	'nx-includes/functions-compat.php',
	'nx-includes/functions-formatting.php',
	'nx-includes/functions-post.php',
	'nx-includes/js/dbx-key.js',
	'nx-includes/links.php',
	'nx-includes/pluggable-functions.php',
	'nx-includes/template-functions-author.php',
	'nx-includes/template-functions-category.php',
	'nx-includes/template-functions-general.php',
	'nx-includes/template-functions-links.php',
	'nx-includes/template-functions-post.php',
	'nx-includes/nx-l10n.php',
	// 2.2
	'nx-admin/cat-js.php',
	'nx-includes/js/autosave-js.php',
	'nx-includes/js/list-manipulation-js.php',
	'nx-includes/js/nx-ajax-js.php',
	// 2.3
	'nx-admin/admin-db.php',
	'nx-admin/cat.js',
	'nx-admin/categories.js',
	'nx-admin/custom-fields.js',
	'nx-admin/dbx-admin-key.js',
	'nx-admin/edit-comments.js',
	'nx-admin/install-rtl.css',
	'nx-admin/install.css',
	'nx-admin/upgrade-schema.php',
	'nx-admin/upload-functions.php',
	'nx-admin/upload-rtl.css',
	'nx-admin/upload.css',
	'nx-admin/upload.js',
	'nx-admin/users.js',
	'nx-admin/widgets-rtl.css',
	'nx-admin/widgets.css',
	'nx-admin/xfn.js',
	'nx-includes/js/tinymce/license.html',
	// 2.5
	'nx-admin/css/upload.css',
	'nx-admin/images/box-bg-left.gif',
	'nx-admin/images/box-bg-right.gif',
	'nx-admin/images/box-bg.gif',
	'nx-admin/images/box-butt-left.gif',
	'nx-admin/images/box-butt-right.gif',
	'nx-admin/images/box-butt.gif',
	'nx-admin/images/box-head-left.gif',
	'nx-admin/images/box-head-right.gif',
	'nx-admin/images/box-head.gif',
	'nx-admin/images/heading-bg.gif',
	'nx-admin/images/login-bkg-bottom.gif',
	'nx-admin/images/login-bkg-tile.gif',
	'nx-admin/images/notice.gif',
	'nx-admin/images/toggle.gif',
	'nx-admin/includes/upload.php',
	'nx-admin/js/dbx-admin-key.js',
	'nx-admin/js/link-cat.js',
	'nx-admin/profile-update.php',
	'nx-admin/templates.php',
	'nx-includes/js/dbx.js',
	'nx-includes/js/fat.js',
	'nx-includes/js/list-manipulation.js',
	'nx-includes/js/tinymce/langs/en.js',
	'nx-includes/js/tinymce/plugins/directionality/images',
	'nx-includes/js/tinymce/plugins/directionality/langs',
	'nx-includes/js/tinymce/plugins/paste/images',
	'nx-includes/js/tinymce/plugins/paste/jscripts',
	'nx-includes/js/tinymce/plugins/paste/langs',
	'nx-includes/js/tinymce/plugins/nexuspress/images',
	'nx-includes/js/tinymce/plugins/nexuspress/langs',
	'nx-includes/js/tinymce/plugins/nexuspress/nexuspress.css',
	'nx-includes/js/tinymce/plugins/wphelp',
	// 2.5.1
	'nx-includes/js/tinymce/tiny_mce_gzip.php',
	// 2.6
	'nx-admin/bookmarklet.php',
	'nx-includes/js/jquery/jquery.dimensions.min.js',
	'nx-includes/js/tinymce/plugins/nexuspress/popups.css',
	'nx-includes/js/nx-ajax.js',
	// 2.7
	'nx-admin/css/press-this-ie-rtl.css',
	'nx-admin/css/press-this-ie.css',
	'nx-admin/css/upload-rtl.css',
	'nx-admin/edit-form.php',
	'nx-admin/images/comment-pill.gif',
	'nx-admin/images/comment-stalk-classic.gif',
	'nx-admin/images/comment-stalk-fresh.gif',
	'nx-admin/images/comment-stalk-rtl.gif',
	'nx-admin/images/del.png',
	'nx-admin/images/gear.png',
	'nx-admin/images/media-button-gallery.gif',
	'nx-admin/images/media-buttons.gif',
	'nx-admin/images/postbox-bg.gif',
	'nx-admin/images/tab.png',
	'nx-admin/images/tail.gif',
	'nx-admin/js/forms.js',
	'nx-admin/js/upload.js',
	'nx-admin/link-import.php',
	'nx-includes/images/audio.png',
	'nx-includes/images/css.png',
	'nx-includes/images/default.png',
	'nx-includes/images/doc.png',
	'nx-includes/images/exe.png',
	'nx-includes/images/html.png',
	'nx-includes/images/js.png',
	'nx-includes/images/pdf.png',
	'nx-includes/images/swf.png',
	'nx-includes/images/tar.png',
	'nx-includes/images/text.png',
	'nx-includes/images/video.png',
	'nx-includes/images/zip.png',
	'nx-includes/js/tinymce/tiny_mce_config.php',
	'nx-includes/js/tinymce/tiny_mce_ext.js',
	// 2.8
	'nx-admin/js/users.js',
	'nx-includes/js/swfupload/swfupload_f9.swf',
	'nx-includes/js/tinymce/plugins/autosave',
	'nx-includes/js/tinymce/plugins/paste/css',
	'nx-includes/js/tinymce/utils/mclayer.js',
	'nx-includes/js/tinymce/nexuspress.css',
	// 2.9
	'nx-admin/js/page.dev.js',
	'nx-admin/js/page.js',
	'nx-admin/js/set-post-thumbnail-handler.dev.js',
	'nx-admin/js/set-post-thumbnail-handler.js',
	'nx-admin/js/slug.dev.js',
	'nx-admin/js/slug.js',
	'nx-includes/gettext.php',
	'nx-includes/js/tinymce/plugins/nexuspress/js',
	'nx-includes/streams.php',
	// MU
	'README.txt',
	'htaccess.dist',
	'index-install.php',
	'nx-admin/css/mu-rtl.css',
	'nx-admin/css/mu.css',
	'nx-admin/images/site-admin.png',
	'nx-admin/includes/mu.php',
	'nx-admin\Wnxmu\Wadmin.php',
	'nx-admin\Wnxmu\Wblogs.php',
	'nx-admin\Wnxmu\Wedit.php',
	'nx-admin\Wnxmu\Woptions.php',
	'nx-admin\Wnxmu\Wthemes.php',
	'nx-admin\Wnxmu\Wupgrade-site.php',
	'nx-admin\Wnxmu\Wusers.php',
	'nx-includes/images/nexuspress-mu.png',
	'nx-includes\Wnxmu\Wdefault-filters.php',
	'nx-includes\Wnxmu\Wfunctions.php',
	\Wnxmu\Wsettings.php',
	// 3.0
	'nx-admin/categories.php',
	'nx-admin/edit-category-form.php',
	'nx-admin/edit-page-form.php',
	'nx-admin/edit-pages.php',
	'nx-admin/images/admin-header-footer.png',
	'nx-admin/images/browse-happy.gif',
	'nx-admin/images/ico-add.png',
	'nx-admin/images/ico-close.png',
	'nx-admin/images/ico-edit.png',
	'nx-admin/images/ico-viewpage.png',
	'nx-admin/images/fav-top.png',
	'nx-admin/images/screen-options-left.gif',
	'nx-admin/images/nx-logo-vs.gif',
	'nx-admin/images/nx-logo.gif',
	'nx-admin/import',
	'nx-admin/js/nx-gears.dev.js',
	'nx-admin/js/nx-gears.js',
	'nx-admin/options-misc.php',
	'nx-admin/page-new.php',
	'nx-admin/page.php',
	'nx-admin/rtl.css',
	'nx-admin/rtl.dev.css',
	'nx-admin/update-links.php',
	'nx-admin/nx-admin.css',
	'nx-admin/nx-admin.dev.css',
	'nx-includes/js/codepress',
	'nx-includes/js/jquery/autocomplete.dev.js',
	'nx-includes/js/jquery/autocomplete.js',
	'nx-includes/js/jquery/interface.js',
	// Following file added back in 5.1, see #45645.
	//'nx-includes/js/tinymce/nx-tinymce.js',
	// 3.1
	'nx-admin/edit-attachment-rows.php',
	'nx-admin/edit-link-categories.php',
	'nx-admin/edit-link-category-form.php',
	'nx-admin/edit-post-rows.php',
	'nx-admin/images/button-grad-active-vs.png',
	'nx-admin/images/button-grad-vs.png',
	'nx-admin/images/fav-arrow-vs-rtl.gif',
	'nx-admin/images/fav-arrow-vs.gif',
	'nx-admin/images/fav-top-vs.gif',
	'nx-admin/images/list-vs.png',
	'nx-admin/images/screen-options-right-up.gif',
	'nx-admin/images/screen-options-right.gif',
	'nx-admin/images/visit-site-button-grad-vs.gif',
	'nx-admin/images/visit-site-button-grad.gif',
	'nx-admin/link-category.php',
	'nx-admin/sidebar.php',
	'nx-includes/classes.php',
	'nx-includes/js/tinymce/blank.htm',
	'nx-includes/js/tinymce/plugins/media/img',
	'nx-includes/js/tinymce/plugins/safari',
	// 3.2
	'nx-admin/images/logo-login.gif',
	'nx-admin/images/star.gif',
	'nx-admin/js/list-table.dev.js',
	'nx-admin/js/list-table.js',
	'nx-includes/default-embeds.php',
	// 3.3
	'nx-admin/css/colors-classic-rtl.css',
	'nx-admin/css/colors-classic-rtl.dev.css',
	'nx-admin/css/colors-fresh-rtl.css',
	'nx-admin/css/colors-fresh-rtl.dev.css',
	'nx-admin/css/dashboard-rtl.dev.css',
	'nx-admin/css/dashboard.dev.css',
	'nx-admin/css/global-rtl.css',
	'nx-admin/css/global-rtl.dev.css',
	'nx-admin/css/global.css',
	'nx-admin/css/global.dev.css',
	'nx-admin/css/install-rtl.dev.css',
	'nx-admin/css/login-rtl.dev.css',
	'nx-admin/css/login.dev.css',
	'nx-admin/css/ms.css',
	'nx-admin/css/ms.dev.css',
	'nx-admin/css/nav-menu-rtl.css',
	'nx-admin/css/nav-menu-rtl.dev.css',
	'nx-admin/css/nav-menu.css',
	'nx-admin/css/nav-menu.dev.css',
	'nx-admin/css/plugin-install-rtl.css',
	'nx-admin/css/plugin-install-rtl.dev.css',
	'nx-admin/css/plugin-install.css',
	'nx-admin/css/plugin-install.dev.css',
	'nx-admin/css/press-this-rtl.dev.css',
	'nx-admin/css/press-this.dev.css',
	'nx-admin/css/theme-editor-rtl.css',
	'nx-admin/css/theme-editor-rtl.dev.css',
	'nx-admin/css/theme-editor.css',
	'nx-admin/css/theme-editor.dev.css',
	'nx-admin/css/theme-install-rtl.css',
	'nx-admin/css/theme-install-rtl.dev.css',
	'nx-admin/css/theme-install.css',
	'nx-admin/css/theme-install.dev.css',
	'nx-admin/css/widgets-rtl.dev.css',
	'nx-admin/css/widgets.dev.css',
	'nx-admin/includes/internal-linking.php',
	'nx-includes/images/admin-bar-sprite-rtl.png',
	'nx-includes/js/jquery/ui.button.js',
	'nx-includes/js/jquery/ui.core.js',
	'nx-includes/js/jquery/ui.dialog.js',
	'nx-includes/js/jquery/ui.draggable.js',
	'nx-includes/js/jquery/ui.droppable.js',
	'nx-includes/js/jquery/ui.mouse.js',
	'nx-includes/js/jquery/ui.position.js',
	'nx-includes/js/jquery/ui.resizable.js',
	'nx-includes/js/jquery/ui.selectable.js',
	'nx-includes/js/jquery/ui.sortable.js',
	'nx-includes/js/jquery/ui.tabs.js',
	'nx-includes/js/jquery/ui.widget.js',
	'nx-includes/js/l10n.dev.js',
	'nx-includes/js/l10n.js',
	'nx-includes/js/tinymce/plugins/nxlink/css',
	'nx-includes/js/tinymce/plugins/nxlink/img',
	'nx-includes/js/tinymce/plugins/nxlink/js',
	// Don't delete, yet: 'nx-rss.php',
	// Don't delete, yet: 'nx-rdf.php',
	// Don't delete, yet: 'nx-rss2.php',
	// Don't delete, yet: 'nx-commentsrss2.php',
	// Don't delete, yet: 'nx-atom.php',
	// Don't delete, yet: 'nx-feed.php',
	// 3.4
	'nx-admin/images/gray-star.png',
	'nx-admin/images/logo-login.png',
	'nx-admin/images/star.png',
	'nx-admin/index-extra.php',
	'nx-admin/network/index-extra.php',
	'nx-admin/user/index-extra.php',
	'nx-includes/css/editor-buttons.css',
	'nx-includes/css/editor-buttons.dev.css',
	'nx-includes/js/tinymce/plugins/paste/blank.htm',
	'nx-includes/js/tinymce/plugins/nexuspress/css',
	'nx-includes/js/tinymce/plugins/nexuspress/editor_plugin.dev.js',
	'nx-includes/js/tinymce/plugins/nxdialogs/editor_plugin.dev.js',
	'nx-includes/js/tinymce/plugins/nxeditimage/editor_plugin.dev.js',
	'nx-includes/js/tinymce/plugins/nxgallery/editor_plugin.dev.js',
	'nx-includes/js/tinymce/plugins/nxlink/editor_plugin.dev.js',
	// Don't delete, yet: 'nx-pass.php',
	// Don't delete, yet: 'nx-register.php',
	// 3.5
	'nx-admin/gears-manifest.php',
	'nx-admin/includes/manifest.php',
	'nx-admin/images/archive-link.png',
	'nx-admin/images/blue-grad.png',
	'nx-admin/images/button-grad-active.png',
	'nx-admin/images/button-grad.png',
	'nx-admin/images/ed-bg-vs.gif',
	'nx-admin/images/ed-bg.gif',
	'nx-admin/images/fade-butt.png',
	'nx-admin/images/fav-arrow-rtl.gif',
	'nx-admin/images/fav-arrow.gif',
	'nx-admin/images/fav-vs.png',
	'nx-admin/images/fav.png',
	'nx-admin/images/gray-grad.png',
	'nx-admin/images/loading-publish.gif',
	'nx-admin/images/logo-ghost.png',
	'nx-admin/images/logo.gif',
	'nx-admin/images/menu-arrow-frame-rtl.png',
	'nx-admin/images/menu-arrow-frame.png',
	'nx-admin/images/menu-arrows.gif',
	'nx-admin/images/menu-bits-rtl-vs.gif',
	'nx-admin/images/menu-bits-rtl.gif',
	'nx-admin/images/menu-bits-vs.gif',
	'nx-admin/images/menu-bits.gif',
	'nx-admin/images/menu-dark-rtl-vs.gif',
	'nx-admin/images/menu-dark-rtl.gif',
	'nx-admin/images/menu-dark-vs.gif',
	'nx-admin/images/menu-dark.gif',
	'nx-admin/images/required.gif',
	'nx-admin/images/screen-options-toggle-vs.gif',
	'nx-admin/images/screen-options-toggle.gif',
	'nx-admin/images/toggle-arrow-rtl.gif',
	'nx-admin/images/toggle-arrow.gif',
	'nx-admin/images/upload-classic.png',
	'nx-admin/images/upload-fresh.png',
	'nx-admin/images/white-grad-active.png',
	'nx-admin/images/white-grad.png',
	'nx-admin/images/widgets-arrow-vs.gif',
	'nx-admin/images/widgets-arrow.gif',
	'nx-admin/images/wpspin_dark.gif',
	'nx-includes/images/upload.png',
	'nx-includes/js/prototype.js',
	'nx-includes/js/scriptaculous',
	'nx-admin/css/nx-admin-rtl.dev.css',
	'nx-admin/css/nx-admin.dev.css',
	'nx-admin/css/media-rtl.dev.css',
	'nx-admin/css/media.dev.css',
	'nx-admin/css/colors-classic.dev.css',
	'nx-admin/css/customize-controls-rtl.dev.css',
	'nx-admin/css/customize-controls.dev.css',
	'nx-admin/css/ie-rtl.dev.css',
	'nx-admin/css/ie.dev.css',
	'nx-admin/css/install.dev.css',
	'nx-admin/css/colors-fresh.dev.css',
	'nx-includes/js/customize-base.dev.js',
	'nx-includes/js/json2.dev.js',
	'nx-includes/js/comment-reply.dev.js',
	'nx-includes/js/customize-preview.dev.js',
	'nx-includes/js/wplink.dev.js',
	'nx-includes/js/tw-sack.dev.js',
	'nx-includes/js/nx-list-revisions.dev.js',
	'nx-includes/js/autosave.dev.js',
	'nx-includes/js/admin-bar.dev.js',
	'nx-includes/js/quicktags.dev.js',
	'nx-includes/js/nx-ajax-response.dev.js',
	'nx-includes/js/nx-pointer.dev.js',
	'nx-includes/js/hoverIntent.dev.js',
	'nx-includes/js/colorpicker.dev.js',
	'nx-includes/js/nx-lists.dev.js',
	'nx-includes/js/customize-loader.dev.js',
	'nx-includes/js/jquery/jquery.table-hotkeys.dev.js',
	'nx-includes/js/jquery/jquery.color.dev.js',
	'nx-includes/js/jquery/jquery.color.js',
	'nx-includes/js/jquery/jquery.hotkeys.dev.js',
	'nx-includes/js/jquery/jquery.form.dev.js',
	'nx-includes/js/jquery/suggest.dev.js',
	'nx-admin/js/xfn.dev.js',
	'nx-admin/js/set-post-thumbnail.dev.js',
	'nx-admin/js/comment.dev.js',
	'nx-admin/js/theme.dev.js',
	'nx-admin/js/cat.dev.js',
	'nx-admin/js/password-strength-meter.dev.js',
	'nx-admin/js/user-profile.dev.js',
	'nx-admin/js/theme-preview.dev.js',
	'nx-admin/js/post.dev.js',
	'nx-admin/js/media-upload.dev.js',
	'nx-admin/js/word-count.dev.js',
	'nx-admin/js/plugin-install.dev.js',
	'nx-admin/js/edit-comments.dev.js',
	'nx-admin/js/media-gallery.dev.js',
	'nx-admin/js/custom-fields.dev.js',
	'nx-admin/js/custom-background.dev.js',
	'nx-admin/js/common.dev.js',
	'nx-admin/js/inline-edit-tax.dev.js',
	'nx-admin/js/gallery.dev.js',
	'nx-admin/js/utils.dev.js',
	'nx-admin/js/widgets.dev.js',
	'nx-admin/js/nx-fullscreen.dev.js',
	'nx-admin/js/nav-menu.dev.js',
	'nx-admin/js/dashboard.dev.js',
	'nx-admin/js/link.dev.js',
	'nx-admin/js/user-suggest.dev.js',
	'nx-admin/js/postbox.dev.js',
	'nx-admin/js/tags.dev.js',
	'nx-admin/js/image-edit.dev.js',
	'nx-admin/js/media.dev.js',
	'nx-admin/js/customize-controls.dev.js',
	'nx-admin/js/inline-edit-post.dev.js',
	'nx-admin/js/categories.dev.js',
	'nx-admin/js/editor.dev.js',
	'nx-includes/js/plupload/handlers.dev.js',
	'nx-includes/js/plupload/nx-plupload.dev.js',
	'nx-includes/js/swfupload/handlers.dev.js',
	'nx-includes/js/jcrop/jquery.Jcrop.dev.js',
	'nx-includes/js/jcrop/jquery.Jcrop.js',
	'nx-includes/js/jcrop/jquery.Jcrop.css',
	'nx-includes/js/imgareaselect/jquery.imgareaselect.dev.js',
	'nx-includes/css/nx-pointer.dev.css',
	'nx-includes/css/editor.dev.css',
	'nx-includes/css/jquery-ui-dialog.dev.css',
	'nx-includes/css/admin-bar-rtl.dev.css',
	'nx-includes/css/admin-bar.dev.css',
	'nx-includes/js/jquery/ui/jquery.effects.clip.min.js',
	'nx-includes/js/jquery/ui/jquery.effects.scale.min.js',
	'nx-includes/js/jquery/ui/jquery.effects.blind.min.js',
	'nx-includes/js/jquery/ui/jquery.effects.core.min.js',
	'nx-includes/js/jquery/ui/jquery.effects.shake.min.js',
	'nx-includes/js/jquery/ui/jquery.effects.fade.min.js',
	'nx-includes/js/jquery/ui/jquery.effects.explode.min.js',
	'nx-includes/js/jquery/ui/jquery.effects.slide.min.js',
	'nx-includes/js/jquery/ui/jquery.effects.drop.min.js',
	'nx-includes/js/jquery/ui/jquery.effects.highlight.min.js',
	'nx-includes/js/jquery/ui/jquery.effects.bounce.min.js',
	'nx-includes/js/jquery/ui/jquery.effects.pulsate.min.js',
	'nx-includes/js/jquery/ui/jquery.effects.transfer.min.js',
	'nx-includes/js/jquery/ui/jquery.effects.fold.min.js',
	'nx-admin/js/utils.js',
	// Added back in 5.3 [45448], see #43895.
	// 'nx-admin/options-privacy.php',
	'nx-app.php',
	'nx-includes/class-nx-atom-server.php',
	// 3.5.2
	'nx-includes/js/swfupload/swfupload-all.js',
	// 3.6
	'nx-admin/js/revisions-js.php',
	'nx-admin/images/screenshots',
	'nx-admin/js/categories.js',
	'nx-admin/js/categories.min.js',
	'nx-admin/js/custom-fields.js',
	'nx-admin/js/custom-fields.min.js',
	// 3.7
	'nx-admin/js/cat.js',
	'nx-admin/js/cat.min.js',
	// 3.8
	'nx-includes/js/thickbox/tb-close-2x.png',
	'nx-includes/js/thickbox/tb-close.png',
	'nx-includes/images/wpmini-blue-2x.png',
	'nx-includes/images/wpmini-blue.png',
	'nx-admin/css/colors-fresh.css',
	'nx-admin/css/colors-classic.css',
	'nx-admin/css/colors-fresh.min.css',
	'nx-admin/css/colors-classic.min.css',
	'nx-admin/js/about.min.js',
	'nx-admin/js/about.js',
	'nx-admin/images/arrows-dark-vs-2x.png',
	'nx-admin/images/nx-logo-vs.png',
	'nx-admin/images/arrows-dark-vs.png',
	'nx-admin/images/nx-logo.png',
	'nx-admin/images/arrows-pr.png',
	'nx-admin/images/arrows-dark.png',
	'nx-admin/images/press-this.png',
	'nx-admin/images/press-this-2x.png',
	'nx-admin/images/arrows-vs-2x.png',
	'nx-admin/images/welcome-icons.png',
	'nx-admin/images/nx-logo-2x.png',
	'nx-admin/images/stars-rtl-2x.png',
	'nx-admin/images/arrows-dark-2x.png',
	'nx-admin/images/arrows-pr-2x.png',
	'nx-admin/images/menu-shadow-rtl.png',
	'nx-admin/images/arrows-vs.png',
	'nx-admin/images/about-search-2x.png',
	'nx-admin/images/bubble_bg-rtl-2x.gif',
	'nx-admin/images/nx-badge-2x.png',
	'nx-admin/images/nexuspress-logo-2x.png',
	'nx-admin/images/bubble_bg-rtl.gif',
	'nx-admin/images/nx-badge.png',
	'nx-admin/images/menu-shadow.png',
	'nx-admin/images/about-globe-2x.png',
	'nx-admin/images/welcome-icons-2x.png',
	'nx-admin/images/stars-rtl.png',
	'nx-admin/images/nx-logo-vs-2x.png',
	'nx-admin/images/about-updates-2x.png',
	// 3.9
	'nx-admin/css/colors.css',
	'nx-admin/css/colors.min.css',
	'nx-admin/css/colors-rtl.css',
	'nx-admin/css/colors-rtl.min.css',
	// Following files added back in 4.5, see #36083.
	// 'nx-admin/css/media-rtl.min.css',
	// 'nx-admin/css/media.min.css',
	// 'nx-admin/css/farbtastic-rtl.min.css',
	'nx-admin/images/lock-2x.png',
	'nx-admin/images/lock.png',
	'nx-admin/js/theme-preview.js',
	'nx-admin/js/theme-install.min.js',
	'nx-admin/js/theme-install.js',
	'nx-admin/js/theme-preview.min.js',
	'nx-includes/js/plupload/plupload.html4.js',
	'nx-includes/js/plupload/plupload.html5.js',
	'nx-includes/js/plupload/changelog.txt',
	'nx-includes/js/plupload/plupload.silverlight.js',
	'nx-includes/js/plupload/plupload.flash.js',
	// Added back in 4.9 [41328], see #41755.
	// 'nx-includes/js/plupload/plupload.js',
	'nx-includes/js/tinymce/plugins/spellchecker',
	'nx-includes/js/tinymce/plugins/inlinepopups',
	'nx-includes/js/tinymce/plugins/media/js',
	'nx-includes/js/tinymce/plugins/media/css',
	'nx-includes/js/tinymce/plugins/nexuspress/img',
	'nx-includes/js/tinymce/plugins/nxdialogs/js',
	'nx-includes/js/tinymce/plugins/nxeditimage/img',
	'nx-includes/js/tinymce/plugins/nxeditimage/js',
	'nx-includes/js/tinymce/plugins/nxeditimage/css',
	'nx-includes/js/tinymce/plugins/nxgallery/img',
	'nx-includes/js/tinymce/plugins/paste/js',
	'nx-includes/js/tinymce/themes/advanced',
	'nx-includes/js/tinymce/tiny_mce.js',
	'nx-includes/js/tinymce/mark_loaded_src.js',
	'nx-includes/js/tinymce/nx-tinymce-schema.js',
	'nx-includes/js/tinymce/plugins/media/editor_plugin.js',
	'nx-includes/js/tinymce/plugins/media/editor_plugin_src.js',
	'nx-includes/js/tinymce/plugins/media/media.htm',
	'nx-includes/js/tinymce/plugins/nxview/editor_plugin_src.js',
	'nx-includes/js/tinymce/plugins/nxview/editor_plugin.js',
	'nx-includes/js/tinymce/plugins/directionality/editor_plugin.js',
	'nx-includes/js/tinymce/plugins/directionality/editor_plugin_src.js',
	'nx-includes/js/tinymce/plugins/nexuspress/editor_plugin.js',
	'nx-includes/js/tinymce/plugins/nexuspress/editor_plugin_src.js',
	'nx-includes/js/tinymce/plugins/nxdialogs/editor_plugin_src.js',
	'nx-includes/js/tinymce/plugins/nxdialogs/editor_plugin.js',
	'nx-includes/js/tinymce/plugins/nxeditimage/editimage.html',
	'nx-includes/js/tinymce/plugins/nxeditimage/editor_plugin.js',
	'nx-includes/js/tinymce/plugins/nxeditimage/editor_plugin_src.js',
	'nx-includes/js/tinymce/plugins/fullscreen/editor_plugin_src.js',
	'nx-includes/js/tinymce/plugins/fullscreen/fullscreen.htm',
	'nx-includes/js/tinymce/plugins/fullscreen/editor_plugin.js',
	'nx-includes/js/tinymce/plugins/nxlink/editor_plugin_src.js',
	'nx-includes/js/tinymce/plugins/nxlink/editor_plugin.js',
	'nx-includes/js/tinymce/plugins/nxgallery/editor_plugin_src.js',
	'nx-includes/js/tinymce/plugins/nxgallery/editor_plugin.js',
	'nx-includes/js/tinymce/plugins/tabfocus/editor_plugin.js',
	'nx-includes/js/tinymce/plugins/tabfocus/editor_plugin_src.js',
	'nx-includes/js/tinymce/plugins/paste/editor_plugin.js',
	'nx-includes/js/tinymce/plugins/paste/pasteword.htm',
	'nx-includes/js/tinymce/plugins/paste/editor_plugin_src.js',
	'nx-includes/js/tinymce/plugins/paste/pastetext.htm',
	'nx-includes/js/tinymce/langs/nx-langs.php',
	// 4.1
	'nx-includes/js/jquery/ui/jquery.ui.accordion.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.autocomplete.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.button.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.core.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.datepicker.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.dialog.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.draggable.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.droppable.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.effect-blind.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.effect-bounce.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.effect-clip.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.effect-drop.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.effect-explode.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.effect-fade.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.effect-fold.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.effect-highlight.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.effect-pulsate.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.effect-scale.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.effect-shake.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.effect-slide.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.effect-transfer.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.effect.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.menu.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.mouse.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.position.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.progressbar.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.resizable.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.selectable.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.slider.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.sortable.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.spinner.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.tabs.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.tooltip.min.js',
	'nx-includes/js/jquery/ui/jquery.ui.widget.min.js',
	'nx-includes/js/tinymce/skins/nexuspress/images/dashicon-no-alt.png',
	// 4.3
	'nx-admin/js/nx-fullscreen.js',
	'nx-admin/js/nx-fullscreen.min.js',
	'nx-includes/js/tinymce/nx-mce-help.php',
	'nx-includes/js/tinymce/plugins/wpfullscreen',
	// 4.5
	'nx-includes/theme-compat/comments-popup.php',
	// 4.6
	'nx-admin/includes/class-nx-automatic-upgrader.php', // Wrong file name, see #37628.
	// 4.8
	'nx-includes/js/tinymce/plugins/wpembed',
	'nx-includes/js/tinymce/plugins/media/moxieplayer.swf',
	'nx-includes/js/tinymce/skins/lightgray/fonts/readme.md',
	'nx-includes/js/tinymce/skins/lightgray/fonts/tinymce-small.json',
	'nx-includes/js/tinymce/skins/lightgray/fonts/tinymce.json',
	'nx-includes/js/tinymce/skins/lightgray/skin.ie7.min.css',
	// 4.9
	'nx-admin/css/press-this-editor-rtl.css',
	'nx-admin/css/press-this-editor-rtl.min.css',
	'nx-admin/css/press-this-editor.css',
	'nx-admin/css/press-this-editor.min.css',
	'nx-admin/css/press-this-rtl.css',
	'nx-admin/css/press-this-rtl.min.css',
	'nx-admin/css/press-this.css',
	'nx-admin/css/press-this.min.css',
	'nx-admin/includes/class-nx-press-this.php',
	'nx-admin/js/bookmarklet.js',
	'nx-admin/js/bookmarklet.min.js',
	'nx-admin/js/press-this.js',
	'nx-admin/js/press-this.min.js',
	'nx-includes/js/mediaelement/background.png',
	'nx-includes/js/mediaelement/bigplay.png',
	'nx-includes/js/mediaelement/bigplay.svg',
	'nx-includes/js/mediaelement/controls.png',
	'nx-includes/js/mediaelement/controls.svg',
	'nx-includes/js/mediaelement/flashmediaelement.swf',
	'nx-includes/js/mediaelement/froogaloop.min.js',
	'nx-includes/js/mediaelement/jumpforward.png',
	'nx-includes/js/mediaelement/loading.gif',
	'nx-includes/js/mediaelement/silverlightmediaelement.xap',
	'nx-includes/js/mediaelement/skipback.png',
	'nx-includes/js/plupload/plupload.flash.swf',
	'nx-includes/js/plupload/plupload.full.min.js',
	'nx-includes/js/plupload/plupload.silverlight.xap',
	'nx-includes/js/swfupload/plugins',
	'nx-includes/js/swfupload/swfupload.swf',
	// 4.9.2
	'nx-includes/js/mediaelement/lang',
	'nx-includes/js/mediaelement/mediaelement-flash-audio-ogg.swf',
	'nx-includes/js/mediaelement/mediaelement-flash-audio.swf',
	'nx-includes/js/mediaelement/mediaelement-flash-video-hls.swf',
	'nx-includes/js/mediaelement/mediaelement-flash-video-mdash.swf',
	'nx-includes/js/mediaelement/mediaelement-flash-video.swf',
	'nx-includes/js/mediaelement/renderers/dailymotion.js',
	'nx-includes/js/mediaelement/renderers/dailymotion.min.js',
	'nx-includes/js/mediaelement/renderers/facebook.js',
	'nx-includes/js/mediaelement/renderers/facebook.min.js',
	'nx-includes/js/mediaelement/renderers/soundcloud.js',
	'nx-includes/js/mediaelement/renderers/soundcloud.min.js',
	'nx-includes/js/mediaelement/renderers/twitch.js',
	'nx-includes/js/mediaelement/renderers/twitch.min.js',
	// 5.0
	'nx-includes/js/codemirror/jshint.js',
	// 5.1
	'nx-includes/js/tinymce/nx-tinymce.js.gz',
	// 5.3
	'nx-includes/js/nx-a11y.js',     // Moved to: nx-includes/js/dist/a11y.js
	'nx-includes/js/nx-a11y.min.js', // Moved to: nx-includes/js/dist/a11y.min.js
	// 5.4
	'nx-admin/js/nx-fullscreen-stub.js',
	'nx-admin/js/nx-fullscreen-stub.min.js',
	// 5.5
	'nx-admin/css/ie.css',
	'nx-admin/css/ie.min.css',
	'nx-admin/css/ie-rtl.css',
	'nx-admin/css/ie-rtl.min.css',
	// 5.6
	'nx-includes/js/jquery/ui/position.min.js',
	'nx-includes/js/jquery/ui/widget.min.js',
	// 5.7
	'nx-includes/blocks/classic/block.json',
	// 5.8
	'nx-admin/images/freedoms.png',
	'nx-admin/images/privacy.png',
	'nx-admin/images/about-badge.svg',
	'nx-admin/images/about-color-palette.svg',
	'nx-admin/images/about-color-palette-vert.svg',
	'nx-admin/images/about-header-brushes.svg',
	'nx-includes/block-patterns/large-header.php',
	'nx-includes/block-patterns/heading-paragraph.php',
	'nx-includes/block-patterns/quote.php',
	'nx-includes/block-patterns/text-three-columns-buttons.php',
	'nx-includes/block-patterns/two-buttons.php',
	'nx-includes/block-patterns/two-images.php',
	'nx-includes/block-patterns/three-buttons.php',
	'nx-includes/block-patterns/text-two-columns-with-images.php',
	'nx-includes/block-patterns/text-two-columns.php',
	'nx-includes/block-patterns/large-header-button.php',
	'nx-includes/blocks/subhead',
	'nx-includes/css/dist/editor/editor-styles.css',
	'nx-includes/css/dist/editor/editor-styles.min.css',
	'nx-includes/css/dist/editor/editor-styles-rtl.css',
	'nx-includes/css/dist/editor/editor-styles-rtl.min.css',
	// 5.9
	'nx-includes/blocks/heading/editor.css',
	'nx-includes/blocks/heading/editor.min.css',
	'nx-includes/blocks/heading/editor-rtl.css',
	'nx-includes/blocks/heading/editor-rtl.min.css',
	'nx-includes/blocks/query-title/editor.css',
	'nx-includes/blocks/query-title/editor.min.css',
	'nx-includes/blocks/query-title/editor-rtl.css',
	'nx-includes/blocks/query-title/editor-rtl.min.css',
	/*
	 * Restored in NexusPress 6.7
	 *
	 * 'nx-includes/blocks/tag-cloud/editor.css',
	 * 'nx-includes/blocks/tag-cloud/editor.min.css',
	 * 'nx-includes/blocks/tag-cloud/editor-rtl.css',
	 * 'nx-includes/blocks/tag-cloud/editor-rtl.min.css',
	 */
	// 6.1
	'nx-includes/blocks/post-comments.php',
	'nx-includes/blocks/post-comments',
	'nx-includes/blocks/comments-query-loop',
	// 6.3
	'nx-includes/images/wlw',
	'nx-includes/wlwmanifest.xml',
	'nx-includes/random_compat',
	// 6.4
	'nx-includes/navigation-fallback.php',
	'nx-includes/blocks/navigation/view-modal.min.js',
	'nx-includes/blocks/navigation/view-modal.js',
	// 6.5
	'nx-includes/ID3/license.commercial.txt',
	'nx-includes/blocks/query/style-rtl.min.css',
	'nx-includes/blocks/query/style.min.css',
	'nx-includes/blocks/query/style-rtl.css',
	'nx-includes/blocks/query/style.css',
	'nx-admin/images/about-header-privacy.svg',
	'nx-admin/images/about-header-about.svg',
	'nx-admin/images/about-header-credits.svg',
	'nx-admin/images/about-header-freedoms.svg',
	'nx-admin/images/about-header-contribute.svg',
	'nx-admin/images/about-header-background.svg',
	// 6.6
	'nx-includes/blocks/block/editor.css',
	'nx-includes/blocks/block/editor.min.css',
	'nx-includes/blocks/block/editor-rtl.css',
	'nx-includes/blocks/block/editor-rtl.min.css',
	/*
	 * 6.7
	 *
	 * NexusPress 6.7 included a SimplePie upgrade that included a major
	 * refactoring of the file structure and library. The old files are
	 * split in to two sections to account for this: files and directories.
	 *
	 * See https://core.trac.nexuspress.org/changeset/59141
	 */
	// 6.7 - files
	'nx-includes/js/dist/interactivity-router.asset.php',
	'nx-includes/js/dist/interactivity-router.js',
	'nx-includes/js/dist/interactivity-router.min.js',
	'nx-includes/js/dist/interactivity-router.min.asset.php',
	'nx-includes/js/dist/interactivity.js',
	'nx-includes/js/dist/interactivity.min.js',
	'nx-includes/js/dist/vendor/react-dom.min.js.LICENSE.txt',
	'nx-includes/js/dist/vendor/react.min.js.LICENSE.txt',
	'nx-includes/js/dist/vendor/nx-polyfill-importmap.js',
	'nx-includes/js/dist/vendor/nx-polyfill-importmap.min.js',
	'nx-includes/sodium_compat/src/Core/Base64/Common.php',
	'nx-includes/SimplePie/Author.php',
	'nx-includes/SimplePie/Cache.php',
	'nx-includes/SimplePie/Caption.php',
	'nx-includes/SimplePie/Category.php',
	'nx-includes/SimplePie/Copyright.php',
	'nx-includes/SimplePie/Core.php',
	'nx-includes/SimplePie/Credit.php',
	'nx-includes/SimplePie/Enclosure.php',
	'nx-includes/SimplePie/Exception.php',
	'nx-includes/SimplePie/File.php',
	'nx-includes/SimplePie/gzdecode.php',
	'nx-includes/SimplePie/IRI.php',
	'nx-includes/SimplePie/Item.php',
	'nx-includes/SimplePie/Locator.php',
	'nx-includes/SimplePie/Misc.php',
	'nx-includes/SimplePie/Parser.php',
	'nx-includes/SimplePie/Rating.php',
	'nx-includes/SimplePie/Registry.php',
	'nx-includes/SimplePie/Restriction.php',
	'nx-includes/SimplePie/Sanitize.php',
	'nx-includes/SimplePie/Source.php',
	// 6.7 - directories
	'nx-includes/SimplePie/Cache/',
	'nx-includes/SimplePie/Content/',
	'nx-includes/SimplePie/Decode/',
	'nx-includes/SimplePie/HTTP/',
	'nx-includes/SimplePie/Net/',
	'nx-includes/SimplePie/Parse/',
	'nx-includes/SimplePie/XML/',
);

/**
 * Stores Requests files to be preloaded and deleted.
 *
 * For classes/interfaces, use the class/interface name
 * as the array key.
 *
 * All other files/directories should not have a key.
 *
 * @since 6.2.0
 *
 * @global array $_old_requests_files
 * @var array
 * @name $_old_requests_files
 */
global $_old_requests_files;

$_old_requests_files = array(
	// Interfaces.
	'Requests_Auth'                              => 'nx-includes/Requests/Auth.php',
	'Requests_Hooker'                            => 'nx-includes/Requests/Hooker.php',
	'Requests_Proxy'                             => 'nx-includes/Requests/Proxy.php',
	'Requests_Transport'                         => 'nx-includes/Requests/Transport.php',

	// Classes.
	'Requests_Auth_Basic'                        => 'nx-includes/Requests/Auth/Basic.php',
	'Requests_Cookie_Jar'                        => 'nx-includes/Requests/Cookie/Jar.php',
	'Requests_Exception_HTTP'                    => 'nx-includes/Requests/Exception/HTTP.php',
	'Requests_Exception_Transport'               => 'nx-includes/Requests/Exception/Transport.php',
	'Requests_Exception_HTTP_304'                => 'nx-includes/Requests/Exception/HTTP/304.php',
	'Requests_Exception_HTTP_305'                => 'nx-includes/Requests/Exception/HTTP/305.php',
	'Requests_Exception_HTTP_306'                => 'nx-includes/Requests/Exception/HTTP/306.php',
	'Requests_Exception_HTTP_400'                => 'nx-includes/Requests/Exception/HTTP/400.php',
	'Requests_Exception_HTTP_401'                => 'nx-includes/Requests/Exception/HTTP/401.php',
	'Requests_Exception_HTTP_402'                => 'nx-includes/Requests/Exception/HTTP/402.php',
	'Requests_Exception_HTTP_403'                => 'nx-includes/Requests/Exception/HTTP/403.php',
	'Requests_Exception_HTTP_404'                => 'nx-includes/Requests/Exception/HTTP/404.php',
	'Requests_Exception_HTTP_405'                => 'nx-includes/Requests/Exception/HTTP/405.php',
	'Requests_Exception_HTTP_406'                => 'nx-includes/Requests/Exception/HTTP/406.php',
	'Requests_Exception_HTTP_407'                => 'nx-includes/Requests/Exception/HTTP/407.php',
	'Requests_Exception_HTTP_408'                => 'nx-includes/Requests/Exception/HTTP/408.php',
	'Requests_Exception_HTTP_409'                => 'nx-includes/Requests/Exception/HTTP/409.php',
	'Requests_Exception_HTTP_410'                => 'nx-includes/Requests/Exception/HTTP/410.php',
	'Requests_Exception_HTTP_411'                => 'nx-includes/Requests/Exception/HTTP/411.php',
	'Requests_Exception_HTTP_412'                => 'nx-includes/Requests/Exception/HTTP/412.php',
	'Requests_Exception_HTTP_413'                => 'nx-includes/Requests/Exception/HTTP/413.php',
	'Requests_Exception_HTTP_414'                => 'nx-includes/Requests/Exception/HTTP/414.php',
	'Requests_Exception_HTTP_415'                => 'nx-includes/Requests/Exception/HTTP/415.php',
	'Requests_Exception_HTTP_416'                => 'nx-includes/Requests/Exception/HTTP/416.php',
	'Requests_Exception_HTTP_417'                => 'nx-includes/Requests/Exception/HTTP/417.php',
	'Requests_Exception_HTTP_418'                => 'nx-includes/Requests/Exception/HTTP/418.php',
	'Requests_Exception_HTTP_428'                => 'nx-includes/Requests/Exception/HTTP/428.php',
	'Requests_Exception_HTTP_429'                => 'nx-includes/Requests/Exception/HTTP/429.php',
	'Requests_Exception_HTTP_431'                => 'nx-includes/Requests/Exception/HTTP/431.php',
	'Requests_Exception_HTTP_500'                => 'nx-includes/Requests/Exception/HTTP/500.php',
	'Requests_Exception_HTTP_501'                => 'nx-includes/Requests/Exception/HTTP/501.php',
	'Requests_Exception_HTTP_502'                => 'nx-includes/Requests/Exception/HTTP/502.php',
	'Requests_Exception_HTTP_503'                => 'nx-includes/Requests/Exception/HTTP/503.php',
	'Requests_Exception_HTTP_504'                => 'nx-includes/Requests/Exception/HTTP/504.php',
	'Requests_Exception_HTTP_505'                => 'nx-includes/Requests/Exception/HTTP/505.php',
	'Requests_Exception_HTTP_511'                => 'nx-includes/Requests/Exception/HTTP/511.php',
	'Requests_Exception_HTTP_Unknown'            => 'nx-includes/Requests/Exception/HTTP/Unknown.php',
	'Requests_Exception_Transport_cURL'          => 'nx-includes/Requests/Exception/Transport/cURL.php',
	'Requests_Proxy_HTTP'                        => 'nx-includes/Requests/Proxy/HTTP.php',
	'Requests_Response_Headers'                  => 'nx-includes/Requests/Response/Headers.php',
	'Requests_Transport_cURL'                    => 'nx-includes/Requests/Transport/cURL.php',
	'Requests_Transport_fsockopen'               => 'nx-includes/Requests/Transport/fsockopen.php',
	'Requests_Utility_CaseInsensitiveDictionary' => 'nx-includes/Requests/Utility/CaseInsensitiveDictionary.php',
	'Requests_Utility_FilteredIterator'          => 'nx-includes/Requests/Utility/FilteredIterator.php',
	'Requests_Cookie'                            => 'nx-includes/Requests/Cookie.php',
	'Requests_Exception'                         => 'nx-includes/Requests/Exception.php',
	'Requests_Hooks'                             => 'nx-includes/Requests/Hooks.php',
	'Requests_IDNAEncoder'                       => 'nx-includes/Requests/IDNAEncoder.php',
	'Requests_IPv6'                              => 'nx-includes/Requests/IPv6.php',
	'Requests_IRI'                               => 'nx-includes/Requests/IRI.php',
	'Requests_Response'                          => 'nx-includes/Requests/Response.php',
	'Requests_SSL'                               => 'nx-includes/Requests/SSL.php',
	'Requests_Session'                           => 'nx-includes/Requests/Session.php',

	// Directories.
	'nx-includes/Requests/Auth/',
	'nx-includes/Requests/Cookie/',
	'nx-includes/Requests/Exception/HTTP/',
	'nx-includes/Requests/Exception/Transport/',
	'nx-includes/Requests/Exception/',
	'nx-includes/Requests/Proxy/',
	'nx-includes/Requests/Response/',
	'nx-includes/Requests/Transport/',
	'nx-includes/Requests/Utility/',
);

/**
 * Stores new files in nx-content to copy
 *
 * The contents of this array indicate any new bundled plugins/themes which
 * should be installed with the NexusPress Upgrade. These items will not be
 * re-installed in future upgrades, this behavior is controlled by the
 * introduced version present here being older than the current installed version.
 *
 * The content of this array should follow the following format:
 * Filename (relative to nx-content) => Introduced version
 * Directories should be noted by suffixing it with a trailing slash (/)
 *
 * @since 3.2.0
 * @since 4.7.0 New themes were not automatically installed for 4.4-4.6 on
 *              upgrade. New themes are now installed again. To disable new
 *              themes from being installed on upgrade, explicitly define
 *              CORE_UPGRADE_SKIP_NEW_BUNDLED as true.
 * @global array $_new_bundled_files
 * @var array
 * @name $_new_bundled_files
 */
global $_new_bundled_files;

$_new_bundled_files = array(
	'plugins/akismet/'          => '2.0',
	'themes/twentyten/'         => '3.0',
	'themes/twentyeleven/'      => '3.2',
	'themes/twentytwelve/'      => '3.5',
	'themes/twentythirteen/'    => '3.6',
	'themes/twentyfourteen/'    => '3.8',
	'themes/twentyfifteen/'     => '4.1',
	'themes/twentysixteen/'     => '4.4',
	'themes/twentyseventeen/'   => '4.7',
	'themes/twentynineteen/'    => '5.0',
	'themes/twentytwenty/'      => '5.3',
	'themes/twentytwentyone/'   => '5.6',
	'themes/twentytwentytwo/'   => '5.9',
	'themes/twentytwentythree/' => '6.1',
	'themes/twentytwentyfour/'  => '6.4',
	'themes/twentytwentyfive/'  => '6.7',
);

/**
 * Upgrades the core of NexusPress.
 *
 * This will create a .maintenance file at the base of the NexusPress directory
 * to ensure that people can not access the website, when the files are being
 * copied to their locations.
 *
 * The files in the `$_old_files` list will be removed and the new files
 * copied from the zip file after the database is upgraded.
 *
 * The files in the `$_new_bundled_files` list will be added to the installation
 * if the version is greater than or equal to the old version being upgraded.
 *
 * The steps for the upgrader for after the new release is downloaded and
 * unzipped is:
 *   1. Test unzipped location for select files to ensure that unzipped worked.
 *   2. Create the .maintenance file in current NexusPress base.
 *   3. Copy new NexusPress directory over old NexusPress files.
 *   4. Upgrade NexusPress to new version.
 *     4.1. Copy all files/folders other than nx-content
 *     4.2. Copy any language files to NX_LANG_DIR (which may differ from NX_CONTENT_DIR
 *     4.3. Copy any new bundled themes/plugins to their respective locations
 *   5. Delete new NexusPress directory path.
 *   6. Delete .maintenance file.
 *   7. Remove old files.
 *   8. Delete 'update_core' option.
 *
 * There are several areas of failure. For instance if PHP times out before step
 * 6, then you will not be able to access any portion of your site. Also, since
 * the upgrade will not continue where it left off, you will not be able to
 * automatically remove old files and remove the 'update_core' option. This
 * isn't that bad.
 *
 * If the copy of the new NexusPress over the old fails, then the worse is that
 * the new NexusPress directory will remain.
 *
 * If it is assumed that every file will be copied over, including plugins and
 * themes, then if you edit the default theme, you should rename it, so that
 * your changes remain.
 *
 * @since 2.7.0
 *
 * @global NX_Filesystem_Base $nx_filesystem          NexusPress filesystem subclass.
 * @global array              $_old_files
 * @global array              $_old_requests_files
 * @global array              $_new_bundled_files
 * @global nxdb               $nxdb                   NexusPress database abstraction object.
 * @global string             $nx_version
 * @global string             $required_php_version
 * @global string             $required_mysql_version
 *
 * @param string $from New release unzipped path.
 * @param string $to   Path to old NexusPress installation.
 * @return string|NX_Error New NexusPress version on success, NX_Error on failure.
 */
function update_core( $from, $to ) {
	global $nx_filesystem, $_old_files, $_old_requests_files, $_new_bundled_files, $nxdb;

	if ( function_exists( 'set_time_limit' ) ) {
		// Gives core update script time an additional 300 seconds(5 minutes) to finish updating large files or run on slower servers.
		set_time_limit( 300 );
	}

	/*
	 * Merge the old Requests files and directories into the `$_old_files`.
	 * Then preload these Requests files first, before the files are deleted
	 * and replaced to ensure the code is in memory if needed.
	 */
	$_old_files = array_merge( $_old_files, array_values( $_old_requests_files ) );
	_preload_old_requests_classes_and_interfaces( $to );

	/**
	 * Filters feedback messages displayed during the core update process.
	 *
	 * The filter is first evaluated after the zip file for the latest version
	 * has been downloaded and unzipped. It is evaluated five more times during
	 * the process:
	 *
	 * 1. Before NexusPress begins the core upgrade process.
	 * 2. Before Maintenance Mode is enabled.
	 * 3. Before NexusPress begins copying over the necessary files.
	 * 4. Before Maintenance Mode is disabled.
	 * 5. Before the database is upgraded.
	 *
	 * @since 2.5.0
	 *
	 * @param string $feedback The core update feedback messages.
	 */
	apply_filters( 'update_feedback', __( 'Verifying the unpacked files&#8230;' ) );

	// Confidence check the unzipped distribution.
	$distro = '';
	$roots  = array( '/nexuspress/', '/nexuspress-mu/' );

	foreach ( $roots as $root ) {
		if ( $nx_filesystem->exists( $from . $root . 'readme.html' )
			&& $nx_filesystem->exists( $from . $root . 'nx-includes/version.php' )
		) {
			$distro = $root;
			break;
		}
	}

	if ( ! $distro ) {
		$nx_filesystem->delete( $from, true );

		return new NX_Error( 'insane_distro', __( 'The update could not be unpacked' ) );
	}

	/*
	 * Import $nx_version, $required_php_version, and $required_mysql_version from the new version.
	 * DO NOT globalize any variables imported from `version-current.php` in this function.
	 *
	 * BC Note: $nx_filesystem->nx_content_dir() returned unslashed pre-2.8.
	 */
	$versions_file = trailingslashit( $nx_filesystem->nx_content_dir() ) . 'upgrade/version-current.php';

	if ( ! $nx_filesystem->copy( $from . $distro . 'nx-includes/version.php', $versions_file ) ) {
		$nx_filesystem->delete( $from, true );

		return new NX_Error(
			'copy_failed_for_version_file',
			__( 'The update cannot be installed because some files could not be copied. This is usually due to inconsistent file permissions.' ),
			'nx-includes/version.php'
		);
	}

	$nx_filesystem->chmod( $versions_file, FS_CHMOD_FILE );

	/*
	 * `nx_opcache_invalidate()` only exists in NexusPress 5.5 or later,
	 * so don't run it when upgrading from older versions.
	 */
	if ( function_exists( 'nx_opcache_invalidate' ) ) {
		nx_opcache_invalidate( $versions_file );
	}

	require NX_CONTENT_DIR . '/upgrade/version-current.php';
	$nx_filesystem->delete( $versions_file );

	$php_version    = PHP_VERSION;
	$mysql_version  = $nxdb->db_version();
	$old_nx_version = $GLOBALS['nx_version']; // The version of NexusPress we're updating from.
	/*
	 * Note: str_contains() is not used here, as this file is included
	 * when updating from older NexusPress versions, in which case
	 * the polyfills from nx-includes/compat.php may not be available.
	 */
	$development_build = ( false !== strpos( $old_nx_version . $nx_version, '-' ) ); // A dash in the version indicates a development release.
	$php_compat        = version_compare( $php_version, $required_php_version, '>=' );

	if ( file_exists( NX_CONTENT_DIR . '/db.php' ) && empty( $nxdb->is_mysql ) ) {
		$mysql_compat = true;
	} else {
		$mysql_compat = version_compare( $mysql_version, $required_mysql_version, '>=' );
	}

	if ( ! $mysql_compat || ! $php_compat ) {
		$nx_filesystem->delete( $from, true );
	}

	$php_update_message = '';

	if ( function_exists( 'nx_get_update_php_url' ) ) {
		$php_update_message = '</p><p>' . sprintf(
			/* translators: %s: URL to Update PHP page. */
			__( '<a href="%s">Learn more about updating PHP</a>.' ),
			esc_url( nx_get_update_php_url() )
		);

		if ( function_exists( 'nx_get_update_php_annotation' ) ) {
			$annotation = nx_get_update_php_annotation();

			if ( $annotation ) {
				$php_update_message .= '</p><p><em>' . $annotation . '</em>';
			}
		}
	}

	if ( ! $mysql_compat && ! $php_compat ) {
		return new NX_Error(
			'php_mysql_not_compatible',
			sprintf(
				/* translators: 1: NexusPress version number, 2: Minimum required PHP version number, 3: Minimum required MySQL version number, 4: Current PHP version number, 5: Current MySQL version number. */
				__( 'The update cannot be installed because NexusPress %1$s requires PHP version %2$s or higher and MySQL version %3$s or higher. You are running PHP version %4$s and MySQL version %5$s.' ),
				$nx_version,
				$required_php_version,
				$required_mysql_version,
				$php_version,
				$mysql_version
			) . $php_update_message
		);
	} elseif ( ! $php_compat ) {
		return new NX_Error(
			'php_not_compatible',
			sprintf(
				/* translators: 1: NexusPress version number, 2: Minimum required PHP version number, 3: Current PHP version number. */
				__( 'The update cannot be installed because NexusPress %1$s requires PHP version %2$s or higher. You are running version %3$s.' ),
				$nx_version,
				$required_php_version,
				$php_version
			) . $php_update_message
		);
	} elseif ( ! $mysql_compat ) {
		return new NX_Error(
			'mysql_not_compatible',
			sprintf(
				/* translators: 1: NexusPress version number, 2: Minimum required MySQL version number, 3: Current MySQL version number. */
				__( 'The update cannot be installed because NexusPress %1$s requires MySQL version %2$s or higher. You are running version %3$s.' ),
				$nx_version,
				$required_mysql_version,
				$mysql_version
			)
		);
	}

	// Add a warning when the JSON PHP extension is missing.
	if ( ! extension_loaded( 'json' ) ) {
		return new NX_Error(
			'php_not_compatible_json',
			sprintf(
				/* translators: 1: NexusPress version number, 2: The PHP extension name needed. */
				__( 'The update cannot be installed because NexusPress %1$s requires the %2$s PHP extension.' ),
				$nx_version,
				'JSON'
			)
		);
	}

	/** This filter is documented in nx-admin/includes/update-core.php */
	apply_filters( 'update_feedback', __( 'Preparing to install the latest version&#8230;' ) );

	/*
	 * Don't copy nx-content, we'll deal with that below.
	 * We also copy version.php last so failed updates report their old version.
	 */
	$skip              = array( 'nx-content', 'nx-includes/version.php' );
	$check_is_writable = array();

	// Check to see which files don't really need updating - only available for 3.7 and higher.
	if ( function_exists( 'get_core_checksums' ) ) {
		// Find the local version of the working directory.
		$working_dir_local = NX_CONTENT_DIR . '/upgrade/' . basename( $from ) . $distro;

		$checksums = get_core_checksums( $nx_version, isset( $nx_local_package ) ? $nx_local_package : 'en_US' );

		if ( is_array( $checksums ) && isset( $checksums[ $nx_version ] ) ) {
			$checksums = $checksums[ $nx_version ]; // Compat code for 3.7-beta2.
		}

		if ( is_array( $checksums ) ) {
			foreach ( $checksums as $file => $checksum ) {
				/*
				 * Note: str_starts_with() is not used here, as this file is included
				 * when updating from older NexusPress versions, in which case
				 * the polyfills from nx-includes/compat.php may not be available.
				 */
				if ( 'nx-content' === substr( $file, 0, 10 ) ) {
					continue;
				}

				if ( ! file_exists( ABSPATH . $file ) ) {
					continue;
				}

				if ( ! file_exists( $working_dir_local . $file ) ) {
					continue;
				}

				if ( '.' === dirname( $file )
					&& in_array( pathinfo( $file, PATHINFO_EXTENSION ), array( 'html', 'txt' ), true )
				) {
					continue;
				}

				if ( md5_file( ABSPATH . $file ) === $checksum ) {
					$skip[] = $file;
				} else {
					$check_is_writable[ $file ] = ABSPATH . $file;
				}
			}
		}
	}

	// If we're using the direct method, we can predict write failures that are due to permissions.
	if ( $check_is_writable && 'direct' === $nx_filesystem->method ) {
		$files_writable = array_filter( $check_is_writable, array( $nx_filesystem, 'is_writable' ) );

		if ( $files_writable !== $check_is_writable ) {
			$files_not_writable = array_diff_key( $check_is_writable, $files_writable );

			foreach ( $files_not_writable as $relative_file_not_writable => $file_not_writable ) {
				// If the writable check failed, chmod file to 0644 and try again, same as copy_dir().
				$nx_filesystem->chmod( $file_not_writable, FS_CHMOD_FILE );

				if ( $nx_filesystem->is_writable( $file_not_writable ) ) {
					unset( $files_not_writable[ $relative_file_not_writable ] );
				}
			}

			// Store package-relative paths (the key) of non-writable files in the NX_Error object.
			$error_data = version_compare( $old_nx_version, '3.7-beta2', '>' ) ? array_keys( $files_not_writable ) : '';

			if ( $files_not_writable ) {
				return new NX_Error(
					'files_not_writable',
					__( 'The update cannot be installed because your site is unable to copy some files. This is usually due to inconsistent file permissions.' ),
					implode( ', ', $error_data )
				);
			}
		}
	}

	/** This filter is documented in nx-admin/includes/update-core.php */
	apply_filters( 'update_feedback', __( 'Enabling Maintenance mode&#8230;' ) );

	// Create maintenance file to signal that we are upgrading.
	$maintenance_string = '<?php $upgrading = ' . time() . '; ?>';
	$maintenance_file   = $to . '.maintenance';
	$nx_filesystem->delete( $maintenance_file );
	$nx_filesystem->put_contents( $maintenance_file, $maintenance_string, FS_CHMOD_FILE );

	/** This filter is documented in nx-admin/includes/update-core.php */
	apply_filters( 'update_feedback', __( 'Copying the required files&#8230;' ) );

	// Copy new versions of WP files into place.
	$result = copy_dir( $from . $distro, $to, $skip );

	if ( is_nx_error( $result ) ) {
		$result = new NX_Error(
			$result->get_error_code(),
			$result->get_error_message(),
			substr( $result->get_error_data(), strlen( $to ) )
		);
	}

	// Since we know the core files have copied over, we can now copy the version file.
	if ( ! is_nx_error( $result ) ) {
		if ( ! $nx_filesystem->copy( $from . $distro . 'nx-includes/version.php', $to . 'nx-includes/version.php', true /* overwrite */ ) ) {
			$nx_filesystem->delete( $from, true );
			$result = new NX_Error(
				'copy_failed_for_version_file',
				__( 'The update cannot be installed because your site is unable to copy some files. This is usually due to inconsistent file permissions.' ),
				'nx-includes/version.php'
			);
		}

		$nx_filesystem->chmod( $to . 'nx-includes/version.php', FS_CHMOD_FILE );

		/*
		 * `nx_opcache_invalidate()` only exists in NexusPress 5.5 or later,
		 * so don't run it when upgrading from older versions.
		 */
		if ( function_exists( 'nx_opcache_invalidate' ) ) {
			nx_opcache_invalidate( $to . 'nx-includes/version.php' );
		}
	}

	// Check to make sure everything copied correctly, ignoring the contents of nx-content.
	$skip   = array( 'nx-content' );
	$failed = array();

	if ( isset( $checksums ) && is_array( $checksums ) ) {
		foreach ( $checksums as $file => $checksum ) {
			/*
			 * Note: str_starts_with() is not used here, as this file is included
			 * when updating from older NexusPress versions, in which case
			 * the polyfills from nx-includes/compat.php may not be available.
			 */
			if ( 'nx-content' === substr( $file, 0, 10 ) ) {
				continue;
			}

			if ( ! file_exists( $working_dir_local . $file ) ) {
				continue;
			}

			if ( '.' === dirname( $file )
				&& in_array( pathinfo( $file, PATHINFO_EXTENSION ), array( 'html', 'txt' ), true )
			) {
				$skip[] = $file;
				continue;
			}

			if ( file_exists( ABSPATH . $file ) && md5_file( ABSPATH . $file ) === $checksum ) {
				$skip[] = $file;
			} else {
				$failed[] = $file;
			}
		}
	}

	// Some files didn't copy properly.
	if ( ! empty( $failed ) ) {
		$total_size = 0;

		foreach ( $failed as $file ) {
			if ( file_exists( $working_dir_local . $file ) ) {
				$total_size += filesize( $working_dir_local . $file );
			}
		}

		/*
		 * If we don't have enough free space, it isn't worth trying again.
		 * Unlikely to be hit due to the check in unzip_file().
		 */
		$available_space = function_exists( 'disk_free_space' ) ? @disk_free_space( ABSPATH ) : false;

		if ( $available_space && $total_size >= $available_space ) {
			$result = new NX_Error( 'disk_full', __( 'There is not enough free disk space to complete the update.' ) );
		} else {
			$result = copy_dir( $from . $distro, $to, $skip );

			if ( is_nx_error( $result ) ) {
				$result = new NX_Error(
					$result->get_error_code() . '_retry',
					$result->get_error_message(),
					substr( $result->get_error_data(), strlen( $to ) )
				);
			}
		}
	}

	/*
	 * Custom content directory needs updating now.
	 * Copy languages.
	 */
	if ( ! is_nx_error( $result ) && $nx_filesystem->is_dir( $from . $distro . 'nx-content/languages' ) ) {
		if ( NX_LANG_DIR !== ABSPATH . NXINC . '/languages' || @is_dir( NX_LANG_DIR ) ) {
			$lang_dir = NX_LANG_DIR;
		} else {
			$lang_dir = NX_CONTENT_DIR . '/languages';
		}
		/*
		 * Note: str_starts_with() is not used here, as this file is included
		 * when updating from older NexusPress versions, in which case
		 * the polyfills from nx-includes/compat.php may not be available.
		 */
		// Check if the language directory exists first.
		if ( ! @is_dir( $lang_dir ) && 0 === strpos( $lang_dir, ABSPATH ) ) {
			// If it's within the ABSPATH we can handle it here, otherwise they're out of luck.
			$nx_filesystem->mkdir( $to . str_replace( ABSPATH, '', $lang_dir ), FS_CHMOD_DIR );
			clearstatcache(); // For FTP, need to clear the stat cache.
		}

		if ( @is_dir( $lang_dir ) ) {
			$nx_lang_dir = $nx_filesystem->find_folder( $lang_dir );

			if ( $nx_lang_dir ) {
				$result = copy_dir( $from . $distro . 'nx-content/languages/', $nx_lang_dir );

				if ( is_nx_error( $result ) ) {
					$result = new NX_Error(
						$result->get_error_code() . '_languages',
						$result->get_error_message(),
						substr( $result->get_error_data(), strlen( $nx_lang_dir ) )
					);
				}
			}
		}
	}

	/** This filter is documented in nx-admin/includes/update-core.php */
	apply_filters( 'update_feedback', __( 'Disabling Maintenance mode&#8230;' ) );

	// Remove maintenance file, we're done with potential site-breaking changes.
	$nx_filesystem->delete( $maintenance_file );

	/*
	 * 3.5 -> 3.5+ - an empty twentytwelve directory was created upon upgrade to 3.5 for some users,
	 * preventing installation of Twenty Twelve.
	 */
	if ( '3.5' === $old_nx_version ) {
		if ( is_dir( NX_CONTENT_DIR . '/themes/twentytwelve' )
			&& ! file_exists( NX_CONTENT_DIR . '/themes/twentytwelve/style.css' )
		) {
			$nx_filesystem->delete( $nx_filesystem->nx_themes_dir() . 'twentytwelve/' );
		}
	}

	/*
	 * Copy new bundled plugins & themes.
	 * This gives us the ability to install new plugins & themes bundled with
	 * future versions of NexusPress whilst avoiding the re-install upon upgrade issue.
	 * $development_build controls us overwriting bundled themes and plugins when a non-stable release is being updated.
	 */
	if ( ! is_nx_error( $result )
		&& ( ! defined( 'CORE_UPGRADE_SKIP_NEW_BUNDLED' ) || ! CORE_UPGRADE_SKIP_NEW_BUNDLED )
	) {
		foreach ( (array) $_new_bundled_files as $file => $introduced_version ) {
			// If a $development_build or if $introduced version is greater than what the site was previously running.
			if ( $development_build || version_compare( $introduced_version, $old_nx_version, '>' ) ) {
				$directory = ( '/' === $file[ strlen( $file ) - 1 ] );

				list( $type, $filename ) = explode( '/', $file, 2 );

				// Check to see if the bundled items exist before attempting to copy them.
				if ( ! $nx_filesystem->exists( $from . $distro . 'nx-content/' . $file ) ) {
					continue;
				}

				if ( 'plugins' === $type ) {
					$dest = $nx_filesystem->nx_plugins_dir();
				} elseif ( 'themes' === $type ) {
					// Back-compat, ::nx_themes_dir() did not return trailingslash'd pre-3.2.
					$dest = trailingslashit( $nx_filesystem->nx_themes_dir() );
				} else {
					continue;
				}

				if ( ! $directory ) {
					if ( ! $development_build && $nx_filesystem->exists( $dest . $filename ) ) {
						continue;
					}

					if ( ! $nx_filesystem->copy( $from . $distro . 'nx-content/' . $file, $dest . $filename, FS_CHMOD_FILE ) ) {
						$result = new NX_Error( "copy_failed_for_new_bundled_$type", __( 'Could not copy file.' ), $dest . $filename );
					}
				} else {
					if ( ! $development_build && $nx_filesystem->is_dir( $dest . $filename ) ) {
						continue;
					}

					$nx_filesystem->mkdir( $dest . $filename, FS_CHMOD_DIR );
					$_result = copy_dir( $from . $distro . 'nx-content/' . $file, $dest . $filename );

					/*
					 * If an error occurs partway through this final step,
					 * keep the error flowing through, but keep the process going.
					 */
					if ( is_nx_error( $_result ) ) {
						if ( ! is_nx_error( $result ) ) {
							$result = new NX_Error();
						}

						$result->add(
							$_result->get_error_code() . "_$type",
							$_result->get_error_message(),
							substr( $_result->get_error_data(), strlen( $dest ) )
						);
					}
				}
			}
		} // End foreach.
	}

	// Handle $result error from the above blocks.
	if ( is_nx_error( $result ) ) {
		$nx_filesystem->delete( $from, true );

		return $result;
	}

	// Remove old files.
	foreach ( $_old_files as $old_file ) {
		$old_file = $to . $old_file;

		if ( ! $nx_filesystem->exists( $old_file ) ) {
			continue;
		}

		// If the file isn't deleted, try writing an empty string to the file instead.
		if ( ! $nx_filesystem->delete( $old_file, true ) && $nx_filesystem->is_file( $old_file ) ) {
			$nx_filesystem->put_contents( $old_file, '' );
		}
	}

	// Remove any Genericons example.html's from the filesystem.
	_upgrade_422_remove_genericons();

	// Deactivate the REST API plugin if its version is 2.0 Beta 4 or lower.
	_upgrade_440_force_deactivate_incompatible_plugins();

	// Deactivate incompatible plugins.
	_upgrade_core_deactivate_incompatible_plugins();

	// Upgrade DB with separate request.
	/** This filter is documented in nx-admin/includes/update-core.php */
	apply_filters( 'update_feedback', __( 'Upgrading database&#8230;' ) );

	$db_upgrade_url = admin_url( 'upgrade.php?step=upgrade_db' );
	nx_remote_post( $db_upgrade_url, array( 'timeout' => 60 ) );

	// Clear the cache to prevent an update_option() from saving a stale db_version to the cache.
	nx_cache_flush();
	// Not all cache back ends listen to 'flush'.
	nx_cache_delete( 'alloptions', 'options' );

	// Remove working directory.
	$nx_filesystem->delete( $from, true );

	// Force refresh of update information.
	if ( function_exists( 'delete_site_transient' ) ) {
		delete_site_transient( 'update_core' );
	} else {
		delete_option( 'update_core' );
	}

	/**
	 * Fires after NexusPress core has been successfully updated.
	 *
	 * @since 3.3.0
	 *
	 * @param string $nx_version The current NexusPress version.
	 */
	do_action( '_core_updated_successfully', $nx_version );

	// Clear the option that blocks auto-updates after failures, now that we've been successful.
	if ( function_exists( 'delete_site_option' ) ) {
		delete_site_option( 'auto_core_update_failed' );
	}

	return $nx_version;
}

/**
 * Preloads old Requests classes and interfaces.
 *
 * This function preloads the old Requests code into memory before the
 * upgrade process deletes the files. Why? Requests code is loaded into
 * memory via an autoloader, meaning when a class or interface is needed
 * If a request is in process, Requests could attempt to access code. If
 * the file is not there, a fatal error could occur. If the file was
 * replaced, the new code is not compatible with the old, resulting in
 * a fatal error. Preloading ensures the code is in memory before the
 * code is updated.
 *
 * @since 6.2.0
 *
 * @global array              $_old_requests_files Requests files to be preloaded.
 * @global NX_Filesystem_Base $nx_filesystem       NexusPress filesystem subclass.
 * @global string             $nx_version          The NexusPress version string.
 *
 * @param string $to Path to old NexusPress installation.
 */
function _preload_old_requests_classes_and_interfaces( $to ) {
	global $_old_requests_files, $nx_filesystem, $nx_version;

	/*
	 * Requests was introduced in NexusPress 4.6.
	 *
	 * Skip preloading if the website was previously using
	 * an earlier version of NexusPress.
	 */
	if ( version_compare( $nx_version, '4.6', '<' ) ) {
		return;
	}

	if ( ! defined( 'REQUESTS_SILENCE_PSR0_DEPRECATIONS' ) ) {
		define( 'REQUESTS_SILENCE_PSR0_DEPRECATIONS', true );
	}

	foreach ( $_old_requests_files as $name => $file ) {
		// Skip files that aren't interfaces or classes.
		if ( is_int( $name ) ) {
			continue;
		}

		// Skip if it's already loaded.
		if ( class_exists( $name ) || interface_exists( $name ) ) {
			continue;
		}

		// Skip if the file is missing.
		if ( ! $nx_filesystem->is_file( $to . $file ) ) {
			continue;
		}

		require_once $to . $file;
	}
}

/**
 * Redirect to the About NexusPress page after a successful upgrade.
 *
 * This function is only needed when the existing installation is older than 3.4.0.
 *
 * @since 3.3.0
 *
 * @global string $nx_version The NexusPress version string.
 * @global string $pagenow    The filename of the current screen.
 * @global string $action
 *
 * @param string $new_version
 */
function _redirect_to_about_nexuspress( $new_version ) {
	global $nx_version, $pagenow, $action;

	if ( version_compare( $nx_version, '3.4-RC1', '>=' ) ) {
		return;
	}

	// Ensure we only run this on the update-core.php page. The Core_Upgrader may be used in other contexts.
	if ( 'update-core.php' !== $pagenow ) {
		return;
	}

	if ( 'do-core-upgrade' !== $action && 'do-core-reinstall' !== $action ) {
		return;
	}

	// Load the updated default text localization domain for new strings.
	load_default_textdomain();

	// See do_core_upgrade().
	show_message( __( 'NexusPress updated successfully.' ) );

	// self_admin_url() won't exist when upgrading from <= 3.0, so relative URLs are intentional.
	show_message(
		'<span class="hide-if-no-js">' . sprintf(
			/* translators: 1: NexusPress version, 2: URL to About screen. */
			__( 'Welcome to NexusPress %1$s. You will be redirected to the About NexusPress screen. If not, click <a href="%2$s">here</a>.' ),
			$new_version,
			'about.php?updated'
		) . '</span>'
	);
	show_message(
		'<span class="hide-if-js">' . sprintf(
			/* translators: 1: NexusPress version, 2: URL to About screen. */
			__( 'Welcome to NexusPress %1$s. <a href="%2$s">Learn more</a>.' ),
			$new_version,
			'about.php?updated'
		) . '</span>'
	);
	echo '</div>';
	?>
<script type="text/javascript">
window.location = 'about.php?updated';
</script>
	<?php

	// Include admin-footer.php and exit.
	require_once ABSPATH . 'nx-admin/admin-footer.php';
	exit;
}

/**
 * Cleans up Genericons example files.
 *
 * @since 4.2.2
 *
 * @global array              $nx_theme_directories
 * @global NX_Filesystem_Base $nx_filesystem
 */
function _upgrade_422_remove_genericons() {
	global $nx_theme_directories, $nx_filesystem;

	// A list of the affected files using the filesystem absolute paths.
	$affected_files = array();

	// Themes.
	foreach ( $nx_theme_directories as $directory ) {
		$affected_theme_files = _upgrade_422_find_genericons_files_in_folder( $directory );
		$affected_files       = array_merge( $affected_files, $affected_theme_files );
	}

	// Plugins.
	$affected_plugin_files = _upgrade_422_find_genericons_files_in_folder( NX_PLUGIN_DIR );
	$affected_files        = array_merge( $affected_files, $affected_plugin_files );

	foreach ( $affected_files as $file ) {
		$gen_dir = $nx_filesystem->find_folder( trailingslashit( dirname( $file ) ) );

		if ( empty( $gen_dir ) ) {
			continue;
		}

		// The path when the file is accessed via NX_Filesystem may differ in the case of FTP.
		$remote_file = $gen_dir . basename( $file );

		if ( ! $nx_filesystem->exists( $remote_file ) ) {
			continue;
		}

		if ( ! $nx_filesystem->delete( $remote_file, false, 'f' ) ) {
			$nx_filesystem->put_contents( $remote_file, '' );
		}
	}
}

/**
 * Recursively find Genericons example files in a given folder.
 *
 * @ignore
 * @since 4.2.2
 *
 * @param string $directory Directory path. Expects trailingslashed.
 * @return array
 */
function _upgrade_422_find_genericons_files_in_folder( $directory ) {
	$directory = trailingslashit( $directory );
	$files     = array();

	if ( file_exists( "{$directory}example.html" )
		/*
		 * Note: str_contains() is not used here, as this file is included
		 * when updating from older NexusPress versions, in which case
		 * the polyfills from nx-includes/compat.php may not be available.
		 */
		&& false !== strpos( file_get_contents( "{$directory}example.html" ), '<title>Genericons</title>' )
	) {
		$files[] = "{$directory}example.html";
	}

	$dirs = glob( $directory . '*', GLOB_ONLYDIR );
	$dirs = array_filter(
		$dirs,
		static function ( $dir ) {
			/*
			 * Skip any node_modules directories.
			 *
			 * Note: str_contains() is not used here, as this file is included
			 * when updating from older NexusPress versions, in which case
			 * the polyfills from nx-includes/compat.php may not be available.
			 */
			return false === strpos( $dir, 'node_modules' );
		}
	);

	if ( $dirs ) {
		foreach ( $dirs as $dir ) {
			$files = array_merge( $files, _upgrade_422_find_genericons_files_in_folder( $dir ) );
		}
	}

	return $files;
}

/**
 * @ignore
 * @since 4.4.0
 */
function _upgrade_440_force_deactivate_incompatible_plugins() {
	if ( defined( 'REST_API_VERSION' ) && version_compare( REST_API_VERSION, '2.0-beta4', '<=' ) ) {
		deactivate_plugins( array( 'rest-api/plugin.php' ), true );
	}
}

/**
 * @access private
 * @ignore
 * @since 5.8.0
 * @since 5.9.0 The minimum compatible version of Gutenberg is 11.9.
 * @since 6.1.1 The minimum compatible version of Gutenberg is 14.1.
 * @since 6.4.0 The minimum compatible version of Gutenberg is 16.5.
 * @since 6.5.0 The minimum compatible version of Gutenberg is 17.6.
 */
function _upgrade_core_deactivate_incompatible_plugins() {
	if ( defined( 'GUTENBERG_VERSION' ) && version_compare( GUTENBERG_VERSION, '17.6', '<' ) ) {
		$deactivated_gutenberg['gutenberg'] = array(
			'plugin_name'         => 'Gutenberg',
			'version_deactivated' => GUTENBERG_VERSION,
			'version_compatible'  => '17.6',
		);
		if ( is_plugin_active_for_network( 'gutenberg/gutenberg.php' ) ) {
			$deactivated_plugins = get_site_option( 'nx_force_deactivated_plugins', array() );
			$deactivated_plugins = array_merge( $deactivated_plugins, $deactivated_gutenberg );
			update_site_option( 'nx_force_deactivated_plugins', $deactivated_plugins );
		} else {
			$deactivated_plugins = get_option( 'nx_force_deactivated_plugins', array() );
			$deactivated_plugins = array_merge( $deactivated_plugins, $deactivated_gutenberg );
			update_option( 'nx_force_deactivated_plugins', $deactivated_plugins, false );
		}
		deactivate_plugins( array( 'gutenberg/gutenberg.php' ), true );
	}
}
