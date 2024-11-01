<?php 

$string = addslashes(preg_replace("/[\r\n]+/",' ',(preg_replace('/\s\s+/', ' ', get_include_contents("admin/wprtabs_inputs.php"))))); ?>
<script type="text/javascript" language="javascript">
var tabs_input = '<?php echo $string; ?>';
</script>
<div class="add_tabs">
<ul>
<li><input type="button" value="<?php _e('Add Tab', 'wp-rtabs'); ?>" class="button add_tab"></li>
<?php if(!empty($tab_titles)): $t=0; //pree($tab_titles); pree($tab_descriptions); ?>
<?php foreach($tab_titles as $key=>$titles): $t++; $descriptions = (isset($tab_descriptions[$key])?$tab_descriptions[$key]:''); ?>
<li>
<?php include('wprtabs_inputs.php'); ?>
</li>
<?php endforeach; ?>
<?php endif; ?>
</ul>

</div>

<div class="tabs_settings">
<ul><li></li></ul>
</div>
<?php /*if(!empty($tab_titles)): //pree($tab_titles); pree($tab_descriptions); ?>
<script type="text/javascript" language="javascript">
<?php foreach($tab_titles as $key=>$titles): ?>
populate_tabs('<?php echo $titles; ?>', '<?php echo isset($tab_descriptions[$key])?str_replace(array('&quot;', '&lt;', '&gt;'), array('', '<', '>'), htmlspecialchars(json_encode(stripslashes($tab_descriptions[$key])), ENT_QUOTES, 'UTF-8')):''; ?>');
<?php endforeach; ?>
</script>
<?php endif;*/ ?>