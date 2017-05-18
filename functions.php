<?php
/**
 * +++++ Note for Tokopedia Developer +++++
 * - Use this $sage_includes array block to include files
 * - Please note that missing files will produce a fatal error. Info @link https://github.com/roots/sage/pull/1042
 * - Place your custom code in Folder ThemeName > Lib > Custom
 */
$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php', // Theme customizer
  'lib/custom/cpt.libs.php', // Your Custom Post Type Code Goes Here
  'lib/custom/metabox.libs.php', // Your Custom Metabox Code Goes Here
  'lib/custom/custom.libs.php' // Your Custom Code Goes Here or You can add new line of included codes here...
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);
