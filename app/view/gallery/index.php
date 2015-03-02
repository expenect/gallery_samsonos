<div id="content" class="wrapper">
    <div id="sort">
        <div id="download" class="wrapper">
            <br/>
            <a href="<?php url_base('gallery', 'form');?>">
                <?php t('New file');?>
            </a>
            <br/>
            <i style="color:red;">
                <?php
                if (isset($_SESSION['message'])) {
                    t($_SESSION['message']);
                    unset ($_SESSION['message']);
                }
                ?></i>
            <hr/>
        </div>
        <br/>
        <div id="sort">
             <?php t('Sort by:');?>
            <a class="sorter" href="<?php url_base('gallery', 'list', 'date', 'asc', 'current_page')?>"><?php t('Date');?> ASC</a>
            <a class="sorter" href="<?php url_base('gallery', 'list', 'date', 'desc', 'current_page')?>"><?php t('Date');?> DESC</a>
            <a class="sorter" href="<?php url_base('gallery', 'list', 'size', 'asc', 'current_page')?>"><?php t('Size');?> ASC</a>
            <a class="sorter" href="<?php url_base('gallery', 'list', 'size', 'desc', 'current_page')?>"><?php t('Size');?> DESC</a>
        </div>
    </div>
<table id="cont_tab">
    <?php iv('items');?>
</table>
</div>
<div class="wrapper">
    <ul id="pager">
        <?php iv('pager_html')?>
    </ul>
</div>

