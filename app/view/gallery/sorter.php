<a class="upload_btn" href="<?php url_base('gallery', 'form')?>"><?php t('Upload photo')?></a>
<br/>
<hr/>
<?php t('Sort by:')?>
<div id="sort">
    <a class="sorter" href="<?php url_base('gallery', 'list', 'date', 'ASC', 'current_page')?>"> <?php t('Date')?> ↗</a>
    <a class="sorter" href="<?php url_base('gallery', 'list', 'date', 'DESC', 'current_page')?>"> <?php t('Date')?> ↘</a>
    <a class="sorter" href="<?php url_base('gallery', 'list', 'size', 'ASC', 'current_page')?>"> <?php t('Size')?> ↗</a>
    <a class="sorter" href="<?php url_base('gallery', 'list', 'size', 'DESC', 'current_page')?>"> <?php t('Size')?> ↘</a>
</div>