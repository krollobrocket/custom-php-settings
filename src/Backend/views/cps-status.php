<?php
// Get plugin information.
$settings = $this->settings->toOptionsArray();
$pluginSettings = array(
    __('Version', 'custom-php-settings') => $settings['version'],
    __('Update configuration file', 'custom-php-settings') => __($settings['update_config'] ? 'yes' : 'no', 'custom-php-settings'),
    __('Restore configuration file', 'custom-php-settings') => __($settings['restore_config'] ? 'yes' : 'no', 'custom-php-settings'),
    __('Remove comments', 'custom-php-settings') => __($settings['trim_comments'] ? 'yes' : 'no', 'custom-php-settings'),
    __('Remove whitespaces', 'custom-php-settings') => __($settings['trim_whitespaces'] ? 'yes' : 'no', 'custom-php-settings') . PHP_EOL,
    __('=== Custom PHP Settings ===', 'custom-php-settings') => '',
);
foreach ($settings['settings'] as $php_setting) {
    $pluginSettings['<b>' . $php_setting['name'] . '</b>'] = '';
    foreach ($php_setting['php'] as $value) {
        if (!empty($value)) {
            $setting = explode('=', $value);
            $pluginSettings['&#9;' . $setting[0]] = isset($setting[1]) ? $setting[1] : '';
        }
    }
}

// Get PHP information.
$phpInfo = array(
    __('System name', 'custom-php-settings') => php_uname(),
    __('Architecture', 'custom-php-settings') => PHP_INT_SIZE === 8 ? 'x64' : 'x86',
    __('PHP Version', 'custom-php-settings') => phpversion(),
    __('Debug build', 'custom-php-settings') => __(defined('ZEND_DEBUG_BUILD') && ZEND_DEBUG_BUILD ? 'yes' : 'no', 'custom-php-settings'),
    __('Zend Engine version', 'custom-php-settings') => zend_version(),
    __('Server Api', 'custom-php-settings') => php_sapi_name(),
    __('Configuration File (php.ini) Path', 'custom-php-settings') => defined('PHP_CONFIG_FILE_PATH') ? PHP_CONFIG_FILE_PATH : '',
    __('Extension directory', 'custom-php-settings') => defined('PHP_EXTENSION_DIR') ? PHP_EXTENSION_DIR : '',
    __('Loaded configuration file', 'custom-php-settings') => php_ini_loaded_file(),
    __('Additional configuration files', 'custom-php-settings') => php_ini_scanned_files(),
    __('Include path', 'custom-php-settings') => get_include_path(),
    __('User INI file', 'custom-php-settings') => ini_get('user_ini.filename'),
    __('User INI file cache TTL', 'custom-php-settings') => ini_get('user_ini.cache_ttl'),
    __('Thread Safety', 'custom-php-settings') => __(defined('ZEND_THREAD_SAFE') && ZEND_THREAD_SAFE ? 'enabled' : 'disabled', 'custom-php-settings'),
    __('IPv6 Support', 'custom-php-settings') => __(extension_loaded('sockets') && defined('AF_INET6') ? 'enabled' : 'disabled', 'custom-php-settings'),
    __('PHP Streams', 'custom-php-settings') => implode(', ', stream_get_wrappers()),
    __('Stream Socket Transports', 'custom-php-settings') => implode(', ', stream_get_transports()),
    __('Stream Filters', 'custom-php-settings') => implode(', ', stream_get_filters()),
    __('GC enabled', 'custom-php-settings') => __(gc_enabled() ? 'enabled' : 'disabled', 'custom-php-settings') . PHP_EOL,
    __('=== PHP Variables ===', 'custom-php-settings') => '',
    __('max_execution_time', 'custom-php-settings') => ini_get('max_execution_time'),
    __('max_input_time', 'custom-php-settings') => ini_get('max_input_time'),
    __('memory_limit', 'custom-php-settings') => ini_get('memory_limit'),
    __('upload_max_filesize', 'custom-php-settings') => ini_get('upload_max_filesize'),
    __('post_max_size', 'custom-php-settings') => ini_get('post_max_size'),
    __('variables_order', 'custom-php-settings') => ini_get('variables_order'),
    __('safe_mode', 'custom-php-settings') => ini_get('safe_mode'),
    __('enable_dl', 'custom-php-settings') => ini_get('enable_dl'),
    __('register_globals', 'custom-php-settings') => ini_get('register_globals'),
);

// Get Wordpress information.
$wpInfo = array(
    __('Version', 'custom-php-settings') => get_bloginfo('version'),
    __('Multisite', 'custom-php-settings') => __(is_multisite() ? 'yes' : 'no', 'custom-php-settings'),
    __('Site address', 'custom-php-settings') => get_bloginfo('url'),
    __('Debug mode', 'custom-php-settings') => __(WP_DEBUG ? 'yes' : 'no', 'custom-php-settings'),
    __('Memory limit', 'custom-php-settings') => WP_MEMORY_LIMIT,
    __('Cron', 'custom-php-settings') => __(defined('DISABLE_WP_CRON') && DISABLE_WP_CRON ? 'no' : 'yes', 'custom-php-settings'),
    __('Language', 'custom-php-settings') => get_locale(),
);

// Get plugin information.
$plugins = get_plugins();
uasort($plugins, function ($a, $b) {
    return strcmp(strtolower($a['Name']), strtolower($b['Name']));
});
$activePlugins = array_values(get_option('active_plugins'));
foreach ($plugins as $key => $plugin) {
    $plugins[$key]['Active'] = in_array($key, $activePlugins);
}

// Get theme information.
$theme = wp_get_theme();
?>
<div class="wrap">
    <?php require_once('cps-tabs.php'); ?>
    <form id="status-form" action="<?php echo admin_url('admin-post.php'); ?>" method="POST">
        <table class="form-table">
            <tr>
                <td>
                    <div id="status"><?php
                    echo '=== Plugin Settings ===' . PHP_EOL;
                    foreach ($pluginSettings as $key => $value) :
                        if ($value === '') {
                            echo $key . PHP_EOL;
                        } else {
                            echo $key . ($key[0] === '=' ? '' : ' = ' . $value) . PHP_EOL;
                        }
                    endforeach;
                    echo PHP_EOL;
                    echo '=== PHP ===' . PHP_EOL;
                    foreach ($phpInfo as $key => $value) :
                        echo $key . ($key[0] === '=' ? '' : ' = ' . $value) . PHP_EOL;
                    endforeach;
                    echo PHP_EOL;
                    echo '=== Wordpress ===' . PHP_EOL;
                    foreach ($wpInfo as $key => $value) :
                        echo $key . ' = ' . $value . PHP_EOL;
                    endforeach;
                    echo PHP_EOL;
                    echo '=== Configuration File ===' . PHP_EOL;
                    $configFilePath = self::getConfigFilePath();
                    if (file_exists($configFilePath)) {
                        echo __('Path', 'custom-php-settings') . ' = ' . $configFilePath . PHP_EOL;
                        echo __('Readable', 'custom-php-settings') . ' = ' . __(is_readable($configFilePath) ? 'yes' : 'no', 'custom-php-settings') . PHP_EOL;
                        echo __('Writeable', 'custom-php-settings') . ' = ' . __(is_writeable($configFilePath) ? 'yes' : 'no', 'custom-php-settings') . PHP_EOL;
                    }
                    echo PHP_EOL;
                    echo '=== Enabled Plugins ===' . PHP_EOL;
                    foreach ($plugins as $key => $plugin) {
                        if ($plugin['Active']) {
                            echo $plugin['Name'] . ' ' . $plugin['Version'] . PHP_EOL;
                        }
                    }
                    echo PHP_EOL;
                    echo '=== Disabled Plugins ===' . PHP_EOL;
                    foreach ($plugins as $key => $plugin) {
                        if (!$plugin['Active']) {
                            echo $plugin['Name'] . ' ' . $plugin['Version'] . PHP_EOL;
                        }
                    }
                    echo PHP_EOL;
                    echo '=== Theme ===' . PHP_EOL;
                    echo $theme['Name'] . ' ' . $theme['Version'] . PHP_EOL;
                    ?></div>
                    <p class="description"><?php _e('If you need help, copy and paste the above information for faster support.', 'custom-php-settings'); ?></p>
                </td>
            </tr>
        </table>
        <button type="button" class="button" onclick="jQuery().copyToClipboard(jQuery('#status').text())"><?php _e('Copy for support', 'custom-php-settings'); ?></button>
    </form>
</div>
