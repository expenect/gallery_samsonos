<td>
    <a href="<?php url_base('gallery', 'delete', $img_id);?>">
        <img src="img/delete.png" id="img_delete"/></a>
    <a href="<?php url_base('gallery', 'form', $img_id);?>">
        <div class="img_resize">
            <img src="img/<?php iv('img_url') ?>" alt=""/>
        </div>
        <?php iv('img_description')?>
    </a>
    <p><?php iv('img_date')?></p>
    <a href="<?php url_base('gallery', 'form', $img_id);?>">
        <?php t('Edit');?>
    </a>
</td>