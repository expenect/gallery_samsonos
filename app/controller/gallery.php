<?php
/**
 * Created by PhpStorm.
 * User: myslyvyi
 * Date: 26.02.2015
 * Time: 16:16
 */

function gallery_list()
{
    $items = "<tr>";
    $j = 0;
    foreach (dbQuery('photo')->exec() as $dbItem) {
        if ($j==3) {
            $j=0;
            $items.="<tr>";
        }
        $j++;
        $items.=m()->view('gallery/items')->img($dbItem)->output();
        if ($j==3) {
            $items.="</tr>";
        }
    }
    $items.= "</tr>";

    m()->title('gallery')->view('gallery/index')->items($items);

}

function gallery__HANDLER()
{
    gallery_list();
}