<?php
$settings = '';
$php_settings = $this->settings->get('settings', array());
$settingIndex = $this->settings->get('settingIndex', 0);
if (isset($php_settings[$settingIndex]['php'])) {
    foreach ($php_settings[$settingIndex]['php'] as $key => $value) {
        $settings .= $value . PHP_EOL;
    }
}
?>
<div class="wrap">
    <?php do_action('custom_php_settings_admin_notices'); ?>
    <?php settings_errors(); ?>
    <?php require_once('cps-tabs.php'); ?>
    <form action="<?php echo admin_url('admin-post.php'); ?>" method="POST">
    <?php wp_nonce_field('custom-php-settings-action', 'custom-php-settings-nonce'); ?>
        <input type="hidden" name="action" value="custom_php_settings_save_settings" />
        <table class="form-table">
            <tr>
                <td>
                    <fieldset>
                        <textarea id="code_editor_custom_php_settings"
                                  rows="5"
                                  name="settings"
                                  class="widefat textarea"><?php echo $settings; ?></textarea>
                    </fieldset>
                    <p class="description"><?php echo __('Custom PHP Settings. Each setting should be in the form key=value.', 'custom-php-settings'); ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" name="update_config"<?php checked($this->settings->get('update_config')); ?> />
                    <span class="description"><?php echo __('Update configuration file.', 'custom-php-settings'); ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" name="restore_config"<?php checked($this->settings->get('restore_config')); ?> />
                    <span class="description"><?php echo __('The configuration file will be restored when the plugin is deactivated or uninstalled.', 'custom-php-settings'); ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" name="trim_comments"<?php checked($this->settings->get('trim_comments')); ?> />
                    <span class="description"><?php echo __('Do not store any comments in the configuration file.', 'custom-php-settings'); ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" name="trim_whitespaces"<?php checked($this->settings->get('trim_whitespaces')); ?> />
                    <span class="description"><?php echo __('Do not store any blank lines in the configuration file.', 'custom-php-settings'); ?></span>
                </td>
            </tr>
        </table>
        <?php echo get_submit_button(__('Save settings', 'custom-php-settings'), 'primary', 'custom-php-settings'); ?>
    </form>
</div>
