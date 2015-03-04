<div class="item_gallery">

    <a href="<?php url_base('gallery', 'delete', 'img_id', 'list', 'sorter',  'direction', 'current_page')?>" class="btn delete">
        <img src="img/delete.png" class="img_delete btn"/>
    </a>

    <a class="edit" href="<?php url_base('gallery', 'form', 'img_id');?>">
        <div class="img_resize">
            <img src="<?php iv('img_url') ?>" alt=""/>
        </div>
        <?php iv('img_description')?>
    </a>

    <p><?php iv('img_date')?></p>
    <p><?php iv('img_date_edit')?></p>

    <a href="<?php url_base('gallery', 'form', 'img_id');?>" class="btn edit">
        <?php t('Edit');?>
    </a>
    <input class="delete_message" type="hidden" value="<?php t('Delete img')?>:<?php iv('img_description')?>">
</div>