<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Routing\Router;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
/**
 * Uploads Controller
 *
 *
 * @method \AdminPanel\Model\Entity\Upload[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UploadsController extends AppController
{

    /**
     * Initialization hook method.
     * Loads RequestHandler component.
     *
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }
    /**
     * Upload method
     * @param  string $type file type
     * @return void
     */
    public function upload($type = null)
    {
        $this->autoRender = false;
        if ($this->request->getData('file')){
            $response =  $this->_uploadFile($this->request->getData('file'), 'uploads', $type);
            $this->_show($response);
        }
    }
    public function delete()
    {
        if ($this->request->is('post')) {
            //$file = new File(WWW_ROOT . $this->request->getData('src') );
            $file = new File($this->request->getData('path'));
            if(getimagesize($file->path) && $file->delete()) {
                $this->response->withStringBody('true');
            } else {
                $this->response->withStringBody('false');
            }
            return $this->response;
        }
    }
    /**
     * Lists images method
     * @return void
     */
    public function images()
    {
        $response = $this->_listImages();
        $this->_show($response);
    }
    /**
     * Takes an array and renders it in a json response
     * @param  array $response data for a response to Froala
     * @return void
     */
    protected function _show($response)
    {
        $this->viewBuilder()->setLayout('ajax');
        //$this->RequestHandler->renderAs($this, 'json');
        $this->RequestHandler->respondAs('json');
        $this->set('_serialize', 'response');
        $this->set('response', $response);
        $this->render('froala');
    }
    /**
     * Find all images in the uploads directory
     * @param  string $uploadsFolder path to uploads
     * @param  string $thumbsFolder  path to thumbnails
     * @return array                 list of files
     */
    protected function _listImages($uploadsFolder = 'uploads', $thumbsFolder = 'uploads/thumbs')
    {
        $dir = new Folder(WWW_ROOT.$uploadsFolder);
        $files = $dir->find('.*');
        $items = array();
        foreach ($files as $file) {
            $image = new File($dir->pwd() . DS . $file);
            if(@getimagesize(WWW_ROOT.$uploadsFolder.DS.$image->name)) { // only show images
                $items[] = array(
                    'url' => Router::url('/') . $uploadsFolder . '/' . $image->name,
                    'path' => WWW_ROOT.$uploadsFolder.DS.$image->name
                );
            }
        }
        return $items;
    }
    /**
     * Move a file to the uploads directory
     * @param  string $uploadedFile  file name
     * @param  string $uploadsFolder name of uploads directory in webroot
     * @param  string $filetype      type of file
     * @return array                 details of uploaded file
     */
    protected function _uploadFile($uploadedFile, $uploadsFolder, $filetype)
    {
        $dir = WWW_ROOT . $uploadsFolder;
        // Get filename.
        $temp = explode(".", $uploadedFile["name"]);
        $extension  = array_pop($temp);
        $name = implode('.', $temp);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $uploadedFile["tmp_name"]);
        if($filetype == 'image') {
            $allowedExts = array("gif", "jpeg", "jpg", "png");
            if ((($mime == "image/gif")
                    || ($mime == "image/jpeg")
                    || ($mime == "image/pjpeg")
                    || ($mime == "image/x-png")
                    || ($mime == "image/png"))
                && in_array($extension, $allowedExts)) {
            } else {
                return false;
            }
        }
        if($filetype == 'file') {
            $allowedExts = array("txt", "pdf");

            if ((($mime == "text/plain")
                    || ($mime == "application/x-pdf")
                    || ($mime == "application/pdf")
                    || ($mime == "application/zip") // MS Office 2007
                    || ($mime == "application/doc")
                    || ($mime == "application/docx")
                    || ($mime == "application/xls")
                    || ($mime == "application/xlsx"))
                && in_array($extension, $allowedExts)) {
            } else {
                return false;
            }
        }
        $cleanName = $this->_cleanString($name);
        $increment = '';
        while(file_exists($dir . DS . $cleanName . $increment . '.' . $extension)) {
            $increment++;
        }
        $file = $cleanName . $increment . '.' . $extension;
        move_uploaded_file($uploadedFile['tmp_name'], $dir .DS. $file);
        $data = array(
            'link' => Router::url('/')  . $uploadsFolder. '/' . $file
        );
        return $data;
    }
    /**
     * Make a string lowercase with only alphanumeric characters and dashes.
     * from http://stackoverflow.com/a/11330527/354196
     * @param  string $string file name
     * @return string
     */
    protected function _cleanString($string)
    {
        $string = strtolower($string);
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }
}
