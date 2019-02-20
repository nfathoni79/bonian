<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Images Controller
 *
 *
 * @property \AdminPanel\Model\Table\ProductImageSizesTable $ProductImageSizes
 */
class ImagesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.ProductImageSizes');
    }

    /**
     * @param $dimension
     * @param $name
     * @param $ext
     * @return \Cake\Http\Response|null
     */
    public function index($dimension, $name, $ext)
    {
        $this->disableAutoRender();
        $find = $this->ProductImageSizes->ProductImages->find('all')
            ->select()
            ->where([
                'ProductImages.name' => $name . '.' . $ext
            ])
            ->contain('ProductImageSizes', function (\Cake\ORM\Query $q) use ($dimension) {
                return $q
                    ->where(['ProductImageSizes.dimension' => $dimension]);
            });

        if (!$find->isEmpty()) {
            /**
             * @var \AdminPanel\Model\Entity\ProductImage $data
             */
            $data = $find->first();
            if (count($data->get('product_image_sizes')) == 0) {
                //processing and resize on the fly
                list($width, $height) = explode('x', $dimension);
                $this->ProductImageSizes->resize($data, $width, $height);
                return $this->redirect($this->request->here());
            }
        }
    }

}
