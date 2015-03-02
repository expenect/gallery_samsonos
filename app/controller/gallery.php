<?php
/**
 * Created by PhpStorm.
 * User: myslyvyi
 * Date: 26.02.2015
 * Time: 16:16
 */

function gallery_list($sorter = null, $direction = null, $currentPage = 1, $pageSize = 3)
{
    if (!isset($sorter)) {
        $sorter = isset($_SESSION['sorter'])?$_SESSION['sorter']:'date';
    } else {
        $_SESSION['sorter'] = $sorter;
    }

    if (!isset($direction)) {
        $direction = isset($_SESSION['direction']) ? $_SESSION['direction'] : 'asc';
    } else {
        $_SESSION['direction'] = $direction;
    }

    if (!isset($currentPage)) {
        $currentPage = isset($_SESSION['SamsonPager_current_page']) ? $_SESSION['SamsonPager_current_page'] : 1;
    } else {
        $_SESSION['SamsonPager_current_page'] = $currentPage;
    }

    $query = dbQuery('photo');

    if (isset($sorter) && in_array($sorter, array('date', 'size'))) {
        $query->order_by($sorter, $direction);
    }

    $urlPrefix = "gallery/list/".$sorter."/".$direction."/";

    $rowsCount = $query->count();

    $pager = new \samson\pager\Pager($currentPage, $pageSize, $urlPrefix, $rowsCount);

    $query->limit($pager->start, $pager->end);

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

  // m()->title('gallery')->view('gallery/index')->items($items);
    m()->view('gallery/index')->title('gallery')->items($items)->pager($pager)->current_page($currentPage);
}

function gallery__HANDLER()
{
    unset($_SESSION['SamsonPager_current_page']);
    unset($_SESSION['sorter']);
    unset($_SESSION['direction']);
    gallery_list();
}

function gallery_form($id = null)
{
    $dbItem = null;

    if (dbQuery('photo')->id($id)->first($dbItem)) {
            m()->view('gallery/form')->title('Redact form')->img($dbItem)->title_operation("Edit");
    } elseif (isset($id)) {
            m()->view('gallery/NotFound')->title('Page not found');
    } else {
        m()->view('gallery/form')->title('Gallery form')->img($dbItem)->title_operation("New file");
    }
}

function gallery_save()
{
    if (isset($_POST)) {
        $dbItem = null;

        $id = isset($_POST['id']) ? filter_var($_POST['id']) : null;

        if ($_POST['description']=="") {
            $_SESSION['message'] = "Fields discription empty";
            gallery_list();
            return false;
        }

        if ($id==null) {
            if (!check_img()) {
                gallery_list();
                return false;
            }
        } elseif ($_FILES['img']['name']!="") {
            if (!check_img()) {
                gallery_list();
                return false;
            }
        }

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
                $dbItem->date = date("y-m-d h:m:s");
                $dbItem->save();
            }
        }
    }

    gallery_list();
}

function check_img()
{
    if ($_FILES['img']['tmp_name']=="") {
        $_SESSION["message"] = "Select your img";
        return false;
    } else {
        $type = strtolower(substr($_FILES['img']['name'], 1 + strrpos($_FILES['img']['name'], ".")));
        if ($type != "jpg" && $type != "jpeg" && $type != "png") {
            $_SESSION["message"] = "Invalid file type may only upload jpeg, jpg, png";
            return false;
        }

        if ($_FILES['img']["size"]>1000000) {
            $_SESSION["message"] = "Size foto exceeded ! Maximum 1MB.";
            return false;
        }
    }
    return true;
}

function gallery_delete($id)
{
    $dbItem = null;

    if (dbQuery('photo')->id($id)->first($dbItem)) {
        unlink('img/'.$dbItem->url);
        $dbItem->delete();
    }

    gallery_list();
}