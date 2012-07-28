<div class="colmask leftmenu">
	<div class="colright">
        <div class="col1wrap">
            <div class="col1">
                <?php
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
		<?php if(isset($sidebar)): ?>
        <div class="col2">
        <?php
            if(is_array($sidebar))
                foreach($sidebar as $item)
                    echo $item;
            else
                    echo $sidebar;
        ?>
        </div>
        <?php endif;?>
	</div>
</div>