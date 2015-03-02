<div id="download" class="wrapper">
    <br/>
    <h3><?php t($title_operation);?></h3>
    <hr/>
    <form enctype="multipart/form-data" method="POST" action="<?php url_base('gallery','save')?>">
        <input type="hidden" name="id" value="<?php iv('img_id')?>"/>
        <table>
            <tr><td colspan="2" style="color:red;"></td></tr>
            <tr>
                <td colspan="2"><?php t('Description');?>:</td>
            </tr>
            <tr>
                <td colspan="2">
 <textarea name="description" maxlength="200" style="max-width: 890px;"><?php iv('img_description')?></textarea>
                </td>
            </tr>

            <tr style="float: left;">
                <td><?php t('Change foto');?>:</td>
                <td><input type="file" name="img" value="<?php iv('img_url')?>"/></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="<?php t("Save");?>" style="padding:3px;"/>
                </td>
            </tr>
        </table>
    </form>
    <hr/>
</div>