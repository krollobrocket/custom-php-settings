<?php
$extensions = get_loaded_extensions();
natcasesort($extensions);
foreach ($extensions as $key => $extension) {
    $version = phpversion($extension);
    $extensions[$key] = array(
            'version' => $version,
            'name' => $extension,
    );
}
?>
<div class="wrap">
    <?php require_once('cps-tabs.php'); ?>
    <table class="custom-php-settings-table widefat">
        <thead>
            <th><?php echo __('Extension', 'custom-php-settings'); ?></th>
            <th><?php echo __('Version', 'custom-php-settings'); ?></th>
        </thead>
        <?php $i = 0; ?>
        <?php foreach ($extensions as $key => $extension) : ?>
        <?php $attribute = (++$i & 1) ? ' class="striped"' : ''; ?>
        <tr<?php echo $attribute; ?>>
            <td><?php echo $extension['name']; ?></td>
            <td><?php echo $extension['version']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
