<?php
/**
 * Created by PhpStorm.
 * User: myslyvyi
 * Date: 26.02.2015
 * Time: 16:16
 */

function gallery_list($sorter = null, $direction = null, $currentPage = 1, $pageSize = 3)
{
  /*  if (!isset($sorter)) {
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
    m()->view('gallery/index')->title('gallery')->items($items)->pager($pager)->current_page($currentPage);*/


    $gallery = gallery_async_list($sorter, $direction, $currentPage, $pageSize);

    /* Set window title and view to render, pass items variable to view, pass the Pager and current page to view*/
    m()->view('gallery/index')->title('My gallery')->gallery_list($gallery['list'])->gallery_sorter($gallery['sorter'])->pager_html($gallery['pager']);

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

function gallery_async_form($id = null)
{
    $result = array('status' => 1);

    /**@var \samson\activerecord\gallery $dbItem */
    $dbItem = null;
    /*
     * Try to recieve one first record from DB by identifier,
     * if $id == null the request will fail anyway, and in case
     * of success store record into $dbItem variable
     */
    if (dbQuery('photo')->id($id)->first($dbItem)) {
        $form = m()->view('gallery/NewFile')->img($dbItem)->output();
        // Render the form to redact item
        $result['form'] = m()->view('gallery/form/index')->title('Redact form')->image($dbItem)->form($form)->output();
    } elseif (isset($id)) {
        // File with passed ID wasn't find in DB
        $result['form'] = m()->view('gallery/form/notfoundID')->title('Not Found')->output();
    } else {
        // No ID was passed
        $result['form'] = m()->view('gallery/form/newfile')->title('New Photo')->output();
    }
    return $result;
}

function gallery_async_save()
{
    $result = array('status' => 0);
    // If we have really received form data
    if (isset($_POST)) {

        /** @var \samson\activerecord\gallery $dbItem */
        $dbItem = null;

        // Clear received variable
        $id = isset($_POST['id']) ? filter_var($_POST['id']) : null;

        /*
         * Try to receive one first record from DB by identifier,
         * in case of success store record into $dbItem variable,
         * otherwise create new gallery item
         */
        if (!dbQuery('photo')->id($id)->first($dbItem)) {
            // Create new instance but without creating a db record
            $dbItem = new \samson\activerecord\photo(false);
        }


        // Save image name
        if (isset($_POST['description'])) {
            $dbItem->description = filter_var($_POST['description']);
            $dbItem->save();
            $result = array('status' => 1);
        }

        // At this point we can guarantee that $dbItem is not empty
        if (isset($_FILES['img']['tmp_name']) && $_FILES['img']['tmp_name'] != null) {
            $tmp_name = $_FILES["img"]["tmp_name"];
            $name = $_FILES["img"]["name"];

            // Create upload dir with correct rights
            if (!file_exists('img/upload')) {
                mkdir('img/upload', 0775);
            }

            $new_name = 'upload/photo'.md5(time()).$name;

            // If file has been created
            if (move_uploaded_file($tmp_name, $new_name)) {
                // Store file in upload dir
                $dbItem->url = $new_name;
                $dbItem->size = $_FILES["file"]["size"];
                $dbItem->date = date("y-m-d h:m:s");
                // Save image
                $dbItem->save();
                $result = array('status' => 1);
            }

        }

    }

    return $result;
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
  /* $dbItem = null;

    if (dbQuery('photo')->id($id)->first($dbItem)) {
        unlink('img/'.$dbItem->url);
        $dbItem->delete();
    }*/

}

function gallery_async_delete($id)
{
    // Set the result status to 0 by default
    $result = array('status' => 0);

    /** @var \samson\activerecord\gallery $dbItem */
    $dbItem = null;
    if (dbQuery('photo')->id($id)->first($dbItem)) {
        // Delete uploaded file
        unlink($dbItem->url);
        // Delete DB record about this file
        $dbItem->delete();
        // If deleted change the result status to 1
        $result['status'] = 1;
    }

    return $result;
}

function gallery_async_list($sorter = null, $direction = "ASC", $currentPage = 1, $pageSize = 3)
{
    // Set the $result['status'] to 1 to provide asynchronous functionality
    $result = array('status' => 1);

    // If no sorter is passed
    if (!isset($sorter)) {
        // Load sorter from session if it is there
        $sorter = isset($_SESSION['sorter']) ? $_SESSION['sorter'] : 'date';
    }

    if (!isset($direction)) {
        $direction = isset($_SESSION['direction']) ? $_SESSION['direction'] : 'desc';
    }

    if (!isset($currentPage)) {
        // Load current page from session if it is there
        $currentPage = isset($_SESSION['SamsonPager_current_page']) ? $_SESSION['SamsonPager_current_page'] : 1;
    }

    // Prepare db query object
    $query = dbQuery('photo');

    // Set the prefix for pager
    $urlPrefix = "gallery/list/".$sorter."/".$direction."/";
    // Count the number of images in query
    $rowsCount = $query->count();

    // Create a new instance of Pager
    $pager = new \samson\pager\Pager($currentPage, $pageSize, $urlPrefix, $rowsCount);

    // Set the limit condition to db request
    $query->limit($pager->start, $pager->end);

    if (isset($sorter) && in_array($sorter, array('size', 'date'))) {
        // Add sorting condition to db request
        $query->order_by($sorter, $direction);

        // Store sorting in a session
        $_SESSION['sorter'] = $sorter;
        $_SESSION['direction'] = $direction;
    }

    // Iterate all records from "gallery" table
    $items = '';

    foreach ($query->exec() as $dbItem) {
        /**@var \samson\activerecord\gallery $dbItem``` */

        /*
         * Render view(output method) and pass object received fron DB and
         * prefix all its fields with "image_", return and gather this outputs
         * in $items
         */
        $items .= m()->view('gallery/items')->img($dbItem)->sorter($sorter)->direction($direction)->current_page($currentPage)->output();
    }

    // Include the data about images in the result array
    $result['list'] = m()->view('gallery/list')->items($items)->output();
    // Include the data about Pager state in the result array
    $result['pager'] = $pager->toHTML();
    // Include the data about sorter links state in the result array
    $result['sorter'] = m()->view('gallery/sorter')->current_page($currentPage)->output();

    return $result;
}

