<?php
namespace gallery;

class Img extends \samson\activerecord\photo
{
    public static function byId($id)
    {
        return dbQuery('gallery\Img')->id($id)->first();
    }

    public function delete($full = true)
    {
        /**@var \samsonphp\fs\FileService $fs Pointer to file service */
        $fsys = & m('fs');

        // Get the real path to the image
        $imgSrc = realpath(getcwd().$this->url);

        // If file exist delete this file from sever
        if ($fsys->exists($imgSrc)) {

            $fsys->delete($imgSrc);

            if ($full) {
                // Delete DB record about this file
                parent::delete();
            }
        }
    }

    public function updateRecord($name, $img)
    {
        $this->description = $name;
        $type = substr($img['name'], strpos($img['name'], "."));
        $new_name = 'upload/'.md5(time()).$type;

        if (!is_dir('upload')) {
            mkdir('upload', 0777);
        }

        if (move_uploaded_file($img['tmp_name'], $new_name)) {
            unlink(substr($this->url, 1, strlen($this->url)-1));
            $this ->url = '/'.$new_name;
            $this->size = $img['size'];
        }

        $this->date_edit = date("y-m-d H:i:s");

        // Execute the query
        parent::save();
    }

    public function save(\samsonphp\upload\Upload $upload = null)
    {
        $result = false;
        // If upload is successful return true
        if (isset($upload) && $upload->upload($filePath, $fileName, $realName)) {
            // Store the path to the uploaded file in the DB
            $this->url = $filePath;

            // Save file size to the DB
            $this->size = $upload->size();

            // Save the original name of the picture in the DB for new image or leave old name
            $len_type = substr($realName, strpos($realName, "."));

            $realName = substr($realName, 0, strlen($realName)-strlen($len_type));

            $this->description = empty($this->description) ? $realName : $this->description;

            $this->date_edit = date("y-m-d H:i:s");
            $this->date = date("y-m-d H:i:s");
            $result = true;
        }

        // Execute the query
        parent::save();

        return $result;
    }
}