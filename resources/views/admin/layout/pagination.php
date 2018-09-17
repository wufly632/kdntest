<div class="sc-pagination pagination pagination-right">
    <span>共<?php echo $all_rows;?>条</span>
    <span><?php echo $pg_now.'/'.ceil($all_rows/$pg_num);?>页</span>
    <span>每页<?php echo $pg_num;?>条</span>
    <?php echo $pg_link;?>
</div>