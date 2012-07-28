<div class="colmask fullpage">
	<div class="col1"><?php
			$this->load->view('common/messages');
			if(isset($content))
				if(is_array($content))
					foreach($content as $item)
						echo $item;
				else
						echo $content;
		?>
	</div>
</div>