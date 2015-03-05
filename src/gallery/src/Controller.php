<?php
namespace gallery;

use samson\pager\Pager;

class Gallery extends \samson\core\CompressableExternalModule
{
    protected $id = 'gallery';

    public function __list($sorter = null, $direction = null, $currentPage = 1, $pageSize = 3)
    {
        $gallery = $this->__async_list($sorter, $direction, $currentPage, $pageSize);

        $this->view('index')
            ->title('My Gallery')
            ->gallery_list($gallery['list'])
            ->gallery_sorter($gallery['sorter'])
            ->pagger_html($gallery['pager']);
    }

    public function __HANDLER()
    {
        $this->__list();
    }

    public function __async_list($sorter = null, $direction = 'DESC', $currentPage = 1, $pageSize = 3)
    {
        $result = array('status' => 1);

        if (!isset($sorter)) {
            $sorter = (isset($_SESSION['sorter'])) ? $_SESSION['sorter']: 'date';
        }

        if (!isset($direction)) {
            $direction = (isset($_SESSION['direction'])) ? $_SESSION['direction']: 'desc';
        }

        if (!isset($currentPage)) {
            $currentPage = (isset($_SESSION['SamsonPager_current_page'])) ? $_SESSION['SamsonPager_current_page']: 1;
        }


        if (isset($sorter) && in_array($sorter, array("size, date"))) {
            $_SESSION['sorter'] = $sorter;
            $_SESSION['direction'] = $direction;
        }

        $urlPrefix = "gallery/list/" . $sorter . "/" . $direction . "/";

        // Create a new instance of Pager
        $pager = new Pager($currentPage, $pageSize, $urlPrefix);

        // Create a new instance of Collection
        $collection = new Collection($this, $sorter, $direction, $pager, $currentPage);

        $dbItem =null;

        $result['list'] = $collection->render();
        // Include the data about Pager state in the result array
        $result['pager'] = $collection->pager->toHTML();
        // Include the data about sorter links state in the result array
        $result['sorter'] = $this->view('sorter')->currentPage($currentPage)->output();

        return $result;
    }


    public function __async_form ($id = null)
    {
        $result = array ("status" => 1);

        $dbItem = null;

        if (!isset($sorter)) {
            $sorter = (isset($_SESSION['sorter'])) ? $_SESSION['sorter']: 'date';
        }

        if (!isset($direction)) {
            $direction = (isset($_SESSION['direction'])) ? $_SESSION['direction']: 'desc';
        }

        if (!isset($currentPage)) {
            $currentPage = (isset($_SESSION['SamsonPager_current_page'])) ? $_SESSION['SamsonPager_current_page']: 1;
        }


        if (isset($sorter) && in_array($sorter, array("size, date"))) {
            $_SESSION['sorter'] = $sorter;
            $_SESSION['direction'] = $direction;
        }

        if (false != ($dbItem = Img::byId($id))) {
            $form = $this->view('/form/newfile')->img($dbItem)->output();
            $result['form'] = $this->view('/form/index')->form($form)->title('Redact form')->sorter($sorter)->currentPage($currentPage)->direction($direction)->img($dbItem)->output();
        } elseif (isset($id)) {
            $result['form'] = $this->view('/form/not_found')->title('Not found image')->output();
        } else {
            $result['form'] = $this->view('/form/newfile')->title('New file')->sorter($sorter)->currentPage($currentPage)->direction($direction)->output();
        }

        return $result;
    }

    public function __async_save()
    {
        $result = array('status' => 0);
        // If we have really received form data
        if (isset($_POST)) {
            // Clear received variable
            $id = isset($_POST['id']) ? filter_var($_POST['id']) : null;
            /*
             * Try to receive one first record from DB by identifier,
             * in case of success store record into $dbItem variable.
             */
            if (false != ($dbItem = Img::byID($id))) {
                // Update image name in DB
                $dbItem->updateName(filter_var($_POST['description']));
                // Change the request status for successful asynchronous action
                $result = array('status' => 1);
            }
        }
        return $result;
    }

    public function __async_delete($id)
    {
        $result = array('status' => 0);
        /** @var \gallery\Image $dbItem */
        if (false != ($dbItem = Img::byID($id))) {
            // Delete image from server and remove DB record about this image
            $dbItem->delete();
            // Change the request status for successful asynchronous action
            $result['status'] = 1;
        }
        return $result;
    }

    public function __async_upload()
    {
        // Create AJAX response array
        $result = array('status' =>  0);

        /*
         * Try to receive one first record from DB by identifier,
         * in case of success store record into $dbItem variable,
         * delete old picture from server without deleting DB record.
         * Otherwise create new instance of \gallery\Image
         */
    //    if (false != ($dbItem = Img::byID($id))) {
      //      $dbItem->delete(false);
       // } else {
            /** @var \gallery\Img $dbItem */
            $dbItem = new Img(false);
        //}
        /*
         * Upload file to the server, in case of success
         * set the request status to 1 for successful asynchronous action
         */
        if ($dbItem->save(new \samsonphp\upload\Upload(array('png', 'jpg', 'jpeg', 'gif')))) {

            $result['status'] = 1;
        }
        return $result;
    }
}