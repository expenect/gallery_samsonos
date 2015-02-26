<?php
/**
 * Created by PhpStorm.
 * User: myslyvyi
 * Date: 26.02.2015
 * Time: 16:16
 */

function gallery_list($sorter = null, $direction = 'ASC')
{
    $query = dbQuery('photo');

    if (isset($sorter) && in_array($sorter, array('date', 'size'))) {
        $query->order_by($sorter, $direction);
    }

    $items = "<tr>";
    $j = 0;
    foreach ($query->exec() as $dbItem) {
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

function gallery_form($id = null)
{
    $dbItem = null;

    if (dbQuery('gallery')->id($id)->first($dbItem)) {

    }
    m()->view('gallery/form')->title('Gallery_form')->img($dbItem);
}

function gallery_save()
{
    if (isset($_POST)) {
        $dbItem = null;

        $id = isset($_POST['id']) ? filter_var($_POST['id']) : null;

        if (!dbQuery("photo")->id($id)->first($dbItem)) {
            $dbItem = new\samson\activerecord\photo(false);
        }

        $dbItem->description = $_POST['description'];
        $dbItem->save();

        if (isset($_FILES['img']['tmp_name']) && $_FILES['img']['tmp_name']!=null) {
            $tmp_name = $_FILES['img']['tmp_name'];
            $name = $_FILES['img']['name'];

            if (!file_exists('img/upload')) {
                mkdir('img/upload', 0775);
            }

            $new_name = 'upload/photo'.md5(time()).$name;

            if (move_uploaded_file($tmp_name, 'img/'.$new_name)) {
                $dbItem->size = $_FILES['img']['size'];
                $dbItem->url = $new_name;
                $dbItem->date = date("y-m-d");
                $dbItem->save();
            }
        }
    }

    url()->redirect();
}