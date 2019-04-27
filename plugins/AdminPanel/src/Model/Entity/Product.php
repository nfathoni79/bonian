<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $model
 * @property string|null $code
 * @property string|null $sku
 * @property string|null $barcode
 * @property string|null $supplier_code
 * @property int $qty
 * @property int|null $product_stock_status_id
 * @property int $shipping
 * @property float $price
 * @property float $price_sale
 * @property float|null $weight
 * @property int|null $product_weight_class_id
 * @property int|null $product_warranty_id
 * @property int|null $brand_id
 * @property int $product_status_id
 * @property string|null $highlight
 * @property string|null $condition
 * @property string|null $profile
 * @property int $view
 * @property int $point
 * @property float $rating
 * @property int $rating_count
 * @property string|null $video_url
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \AdminPanel\Model\Entity\ProductStockStatus $product_stock_status
 * @property \AdminPanel\Model\Entity\ProductWeightClass $product_weight_class
 * @property \AdminPanel\Model\Entity\ProductStatus $product_status
 * @property \AdminPanel\Model\Entity\OrderProduct[] $order_products
 * @property \AdminPanel\Model\Entity\ProductAttribute[] $product_attributes
 * @property \AdminPanel\Model\Entity\ProductDeal[] $product_deals
 * @property \AdminPanel\Model\Entity\ProductDiscount[] $product_discounts
 * @property \AdminPanel\Model\Entity\ProductImage[] $product_images
 * @property \AdminPanel\Model\Entity\ProductMetaTag[] $product_meta_tags
 * @property \AdminPanel\Model\Entity\ProductOptionPrice[] $product_option_prices
 * @property \AdminPanel\Model\Entity\ProductOptionStock[] $product_option_stocks
 * @property \AdminPanel\Model\Entity\ProductStockMutation[] $product_stock_mutations
 * @property \AdminPanel\Model\Entity\ProductToCategory[] $product_to_categories
 */
class Product extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'title' => true,
        'slug' => true,
        'model' => true,
        'code' => true,
        'sku' => true,
        'barcode' => true,
        'supplier_code' => true,
        'qty' => true,
        'product_stock_status_id' => true,
        'shipping' => true,
        'price' => true,
        'price_sale' => true,
        'weight' => true,
        'product_weight_class_id' => true,
        'product_warranty_id' => true,
        'brand_id' => true,
        'product_status_id' => true,
        'highlight' => true,
        'highlight_text' => true,
        'condition' => true,
        'profile' => true,
        'view' => true,
        'point' => true,
        'rating' => true,
        'type' => true,
        'rating_count' => true,
        'video_url' => true,
        'created' => true,
        'modified' => true,
        'product_stock_status' => true,
        'product_weight_class' => true,
        'product_status' => true,
        'order_products' => true,
        'product_attributes' => true,
        'product_deals' => true,
        'product_discounts' => true,
        'product_images' => true,
        'product_meta_tags' => true,
        'product_option_prices' => true,
        'product_option_stocks' => true,
        'product_stock_mutations' => true,
        'product_to_categories' => true
    ];
}
