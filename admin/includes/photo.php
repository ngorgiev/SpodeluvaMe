<?php
class Photo extends Db_object
{
    protected static $db_table = "photos";
    protected static $db_table_fields = array('id', 'title', 'caption', 'description', 'filename', 'alternate_text', 'type', 'size');

    public $id;
    public $title;
    public $caption;
    public $description;
    public $filename;
    public $alternate_text;
    public $type;
    public $size;

    public $tmp_path;
    public $upload_directory = "images";
    public $errors = array();
    public $upload_errors_array = array(
        UPLOAD_ERR_OK           => "There is no error",
        UPLOAD_ERR_INI_SIZE		=> "The uploaded file exceeds the upload_max_filesize directive in php.ini",
        UPLOAD_ERR_FORM_SIZE    => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        UPLOAD_ERR_PARTIAL      => "The uploaded file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE      => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR   => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE   => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION    => "A PHP extension stopped the file upload."
    );

    public function picture_path()
    {
        return $this->upload_directory.DS.$this->filename;
    }

    public function save()
    {
        //if the file exists
        if($this->id)
        {
            $this->update();
        }
        else
        {
            //if there are error while uploading
            if(!empty($this->errors))
            {
                return false;
            }

            //if we provided empty file
            if(empty($this->filename) || empty($this->tmp_path))
            {
                $this->errors[] = "фајлот не е достапен";
                return false;
            }

            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;

            //if file exists
            if(file_exists($target_path))
            {
                $this->errors[] = "Фајлот {$this->filename} веќе постои!";
                return false;
            }

            if(move_uploaded_file($this->tmp_path, $target_path))
            {
                if($this->create())
                {
                    unset($this->tmp_path);
                    return true;
                }
            }
            else
            {
                $this->errors[] = "Проблем со пермисси при зачувување на фајлот!";
                return false;
            }
        }
    }

    public function delete_photo()
    {
        if($this->delete())
        {
            $target_path = SITE_ROOT.DS. 'admin' . DS . $this->picture_path();
            return unlink($target_path) ? true : false;
        }
        else
        {
            return false;
        }
    }
}
?>