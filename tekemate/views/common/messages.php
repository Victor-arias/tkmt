<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php if(isset($messages) && $messages): 
        foreach($messages as $item): ?>
<div class="messages <?php echo $item['tipo'];?>">
<?php 	echo $item['msg']; ?>
</div>
<?php 	endforeach; 
 endif;
 if(validation_errors()) echo validation_errors();
 ?>
 <?php 
/* End of file messages.php */
/* Location: ./interllantas/views/common/messages.php */