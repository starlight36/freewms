<?php if($taglist): ?>
<?php foreach($taglist as $row): ?>
<label><input type="checkbox" name="tag_item" value="<?php echo $row['tag_name']; ?>" /><?php echo $row['tag_name']; ?>(<?php echo $row['tag_usenum']; ?>)</label>
<?php endforeach; ?>
<?php else:?>
<?php echo Lang::_('admin_tag_item_tip');?>
<?php endif;?>
