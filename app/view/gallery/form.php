<div id="download" class="wrapper">
    <br/>
    <h3>Додати нову картинку</h3>
    <hr/>
    <form enctype="multipart/form-data" method="POST" action="<?php url_base('gallery','save')?>">
        <input type="hidden" name="id" value="<?php iv('img_id')?>"/>
        <table>
            <tr><td colspan="2" style="color:red;"></td></tr>
            <tr>
                <td colspan="2">Опис:</td>
            </tr>
            <tr>
                <td colspan="2">
 <textarea name="description" maxlength="200" style="max-width: 890px;"><?php iv('img_description')?></textarea>
                </td>
            </tr>

            <tr style="float: left;">
                <td>Виберіть фото:</td>
                <td><input type="file" name="img" value="<?php iv('img_url')?>"/></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Сохранить"/>
                </td>
            </tr>
        </table>
    </form>
    <hr/>
</div>