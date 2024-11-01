<?php $t = isset($t)?$t:''; $titles = isset($titles)?$titles:''; $descriptions = isset($descriptions)?$descriptions:''; ?>
<div>
	<a><?php _e('Delete', 'wp-rtabs'); ?></a>
	<div>
		<div><label for="title_<?php echo $t; ?>"><?php _e('Title', 'wp-rtabs'); ?>:</label></div>
        <div><input id="title_<?php echo $t; ?>" type="text" name="tab_title[]" value="<?php echo $titles; ?>" /></div>
    </div>
    <div>
		<div><label for="description_<?php echo $t; ?>"><?php _e('Description', 'wp-rtabs'); ?>:</label></div>
        <div title="<?php _e('Note', 'wp-rtabs'); ?>: <?php _e('If you are using shortcodes inside, then it is recommended that you use shortcode only.', 'wp-rtabs'); ?>">
        <textarea id="description_<?php echo $t; ?>" name="tab_description[]"><?php echo $descriptions; ?></textarea></div>
    </div>
</div>