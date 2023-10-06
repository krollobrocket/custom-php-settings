<div class="wrap">
    <?php require_once('cps-tabs.php'); ?>
    <table class="custom-php-settings-table widefat">
        <thead>
            <th><?php echo __('Name', 'custom-php-settings'); ?></th>
            <th><?php echo __('Value', 'custom-php-settings'); ?></th>
        </thead>
        <?php $i = 0; ?>
        <?php foreach ($_ENV as $name => $value) : ?>
        <?php $attribute = (++$i & 1) ? ' class="striped"' : ''; ?>
        <tr<?php echo $attribute; ?>>
            <td><?php echo esc_html($name); ?></td>
            <td><?php echo esc_html($value); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
