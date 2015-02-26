<div id="content" class="wrapper">

    <div id="sort">
        <a  href="<?php url_base('gallery', 'form')?>">Upload photo</a>
        <br/>
        Sort by:
        <a class="sorter" href="<?php url_base('gallery', 'list', 'date', 'ASC')?>">DATE ASC</a>
        <a class="sorter" href="<?php url_base('gallery', 'list', 'date', 'DESC')?>">DATE DESC</a>
        <a class="sorter" href="<?php url_base('gallery', 'list', 'size', 'ASC')?>">SIZE ASC</a>
        <a class="sorter" href="<?php url_base('gallery', 'list', 'size', 'DESC')?>">SIZE DESC</a>
    </div>
<table id="cont_tab">
    <?php iv('items');?>
</table>
</div>

