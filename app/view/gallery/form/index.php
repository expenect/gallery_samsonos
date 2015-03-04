<div class="redact">
    <div id="item">
        <img src="<?php iv('img_url')?>"  title="<?php iv('img_description')?>" style="max-width:600px">
        <p>Name: <?php iv('img_description')?></p>
        <p>Size: <?php iv('img_size')?></p>
        <p>Loaded: <?php iv('img_date')?></p>
    </div>
    <div class="upload_form">
        <form action="<?php url_base('gallery', 'save', 'list', 'sorter', 'direction', 'current_page')?>/" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php iv('img_id')?>">
            <?php t('New name')?>: <input name="description" value="<?php iv('img_description')?>">
            <input type="file" name="img"  <?php if(!isv('img_description')):?>  <?php endif?> value="<?php iv('img_url')?>">
            <input type="submit" value="<?php t('Save')?>">
        </form>
    </div>
</div>
