<?php
/**
 * Copyright (c) 2014, 2015, 2016 Bidorbuy http://www.bidorbuy.co.za
 * This software is the proprietary information of Bidorbuy.
 *
 * All Rights Reserved.
 * Modification, redistribution and use in source and binary forms, with or without
 * modification are not permitted without prior written approval by the copyright
 * holder.
 *
 * Vendor: EXTREME IDEA LLC http://www.extreme-idea.com
 */

namespace Com\ExtremeIdea\Bidorbuy\StoreIntegrator\WooCommerce;

// phpcs:disable PSR1.Files.SideEffects
if (!defined('ABSPATH')) {
    exit;// Exit if accessed directly
}
// phpcs:enable PSR1.Files.SideEffects

use Com\ExtremeIdea\Bidorbuy\StoreIntegrator\Core as bobsi;

/**
 * Class BidorbuyStoreIntegratorExport
 *
 * @package com\extremeidea\bidorbuy\storeintegrator\woocommerce.
 */
class BidorbuyStoreIntegratorExport
{
    protected $plugin;

    /**
     * BidorbuyStoreIntegratorExport constructor.
     *
     * @return self
     */
    public function __construct(BidorbuyStoreIntegrator $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Support WooCommerce 2.x
     * Helper Function
     *
     * @param \WC_Product $product product
     * @param bool        $parent  return product parent id
     *
     * @return mixed
     */
    protected function getProductId(\WC_Product $product, $parent = null)
    {
        if ($parent && $product instanceof \WC_Product_Variation) {
            if (method_exists($product, 'get_parent_id')) {
                return $product->get_parent_id();
            }
            return $product->parent->id;
        }
        if (method_exists($product, 'get_id')) {
            return $product->get_id();
        }
        if ($product instanceof \WC_Product_Variation) {
            return $product->variation_id;
        }
        $productId = 'id';
        return $product->$productId;
    }

    /**
     * Support WooCommerce 2.x
     * Helper Function
     *
     * @param \WC_Product $product product
     * @param bool        $parent  return product parent id
     *
     * @return mixed
     */
    protected function getProductRegularPrice(\WC_Product $product)
    {
        if (method_exists($product, 'get_regular_price')) {
            return $product->get_regular_price();
        }
        return $product->regular_price;
    }

    /**
     * Support WooCommerce 2.x
     * Helper Function
     *
     * @param \WC_Product $product product
     *
     * @return mixed
     */
    protected function getPriceIncludingTax(\WC_Product $product)
    {
        if (function_exists('wc_get_price_including_tax')) {
            return wc_get_price_including_tax($product);
        }
        return $product->get_price_including_tax();
    }

    /**
     * Support WooCommerce 2.x
     * Helper Function
     *
     * @param \WC_Product $product product
     *
     * @return mixed
     */
    protected function getGalleryImageIds(\WC_Product $product)
    {
        if (method_exists($product, 'get_gallery_image_ids')) {
            return $product->get_gallery_image_ids();
        }
        return $product->get_gallery_attachment_ids();
    }

    /**
     * Get breadcrumb
     *
     * @param integer $categoryId category id
     *
     * @return string
     */
    public function getBreadcrumb($categoryId)
    {
        $names = array();

        while ($term = get_term_by('id', $categoryId, 'product_cat')) {
            $names[] = $term->name;
            $categoryId = $term->parent;

            $term = null;
        }

        $breadcrumb = implode(' > ', array_reverse($names));
        $names = null;

        return $breadcrumb;
    }

    /**
     * Get product width
     *
     * @param \WC_Product $product product
     *
     * @return mixed
     */
    protected function getProductWidth(\WC_Product $product)
    {
        if (method_exists($product, 'get_width')) {
            return $product->get_width();
        }
        return $product->width;
    }

    /**
     * Get product length
     *
     * @param \WC_Product $product product
     *
     * @return mixed
     */
    protected function productLength(\WC_Product $product)
    {
        if (method_exists($product, 'get_length')) {
            return $product->get_length();
        }
        return $product->length;
    }

    /**
     * Get product height
     *
     * @param \WC_Product $product product
     *
     * @return mixed
     */
    protected function getProductHeight(\WC_Product $product)
    {
        if (method_exists($product, 'get_height')) {
            return $product->get_height();
        }
        return $product->height;
    }

    /**
     * Calc product quantity
     *
     * @param \WC_Product $product product
     * @param int         $default default
     *
     * @return int
     */
    protected function calcProductQuantity(\WC_Product $product, $default = 0)
    {
        $qty = intval($product->get_stock_quantity());
        return ($product->managing_stock()) ? $qty : ($product->is_in_stock() ? $default : 0);
    }

    /**
     * Get product description
     *
     * @param \WC_Product $product product
     *
     * @return int
     */
    protected function getProductDescription(\WC_Product $product)
    {
        if (method_exists($product, 'get_description')) {
            return apply_filters('the_content', $product->get_description());
        }

        $postData = get_post($this->getProductId($product));

        return apply_filters('the_content', $postData->post_content);
    }

    /**
     * Get product description
     *
     * @param \WC_Product $product product
     *
     * @return int
     */
    protected function getProductSummary(\WC_Product $product)
    {
        if (method_exists($product, 'get_short_description')) {
            return apply_filters('the_content', $product->get_short_description());
        }

        $postData = get_post($this->getProductId($product));

        return apply_filters('the_content', $postData->post_excerpt);
    }

    /**
     * Build export product
     *
     * @param \WC_Product $product    product
     * @param array       $variations variations
     * @param array       $categories categories
     *
     * @return array
     */
    protected function buildExportProduct(
        $product,
        $variations = array(),
        $categories = array(),
        $allowOffersCategories = array()
    ) {
        $exportedProduct = array();

        $productCodeId = $this->getProductId($product);
        $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_ID] = $this->getProductId($product);
        $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_NAME] = $product->get_title();

        if ($product instanceof \WC_Product_Variation) {
            $exportedProduct[bobsi\Settings::PARAM_VARIATION_ID] = $this->getProductId($product);
            $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_ID] = $this->getProductId($product, true);
            $productCodeId = $this->getProductId($product, true) . '-' . $this->getProductId($product);
        }

        $sku = ($product->get_sku() != '') ? $product->get_sku() : $productCodeId;
        $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_CODE] = $sku;

        $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_PRICE] =
            $this->plugin->currencyConverter->convertPrice($this->getPriceIncludingTax($product));
        $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_MARKET_PRICE] = '';

        $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_ALLOW_OFFERS] = (bool)array_intersect(
            $allowOffersCategories,
            $categories
        );

        if ($product->is_on_sale() && ($product->get_price() !== $this->getProductRegularPrice($product))) {
            $price = $product->get_price();
            $product->set_price($this->getProductRegularPrice($product));
            $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_MARKET_PRICE] =
                $this->plugin->currencyConverter->convertPrice($this->getPriceIncludingTax($product));
            $product->set_price($price);
        }

        $productCondition = $this->plugin->core->getSettings()->getProductCondition($categories);
        $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_CONDITION] = $productCondition;
        $this->plugin->core->logInfo("Product Condition: $productCondition");
        //$product->id = $id; // It is 0 by default, besides $product->get_shipping_class()
        // returns "slug" instead of "name"
        //$exportedProduct[bobsi\Tradefeed::nameProductShippingClass] = $product->get_shipping_class();

        $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_SHIPPING_CLASS] = ($product instanceof \WC_Product_Variation)
            ? $this->getShippingClass($this->getProductId($product), $this->getProductId($product, true))
            : $this->getShippingClass($this->getProductId($product));

        if (isset($variations['attributes'])) {
            foreach ($variations['attributes'] as $key => $value) {
                $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_ATTRIBUTES][$key] = $value;
            }
        }
        $exclAttr = get_post_meta(
            $this->getProductId($product, true),
            '_' . BidorbuyStoreIntegrator::WOOCOMMERCE_ATTRIBUTE_FIELD
        );
        $excludedAttributes = array_shift($exclAttr) ?: array();
        $excludedAttributes = array_map(array(
            $this,
            'attributeLabel'
        ), $excludedAttributes);

        $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_EXCLUDED_ATTRIBUTES] = $excludedAttributes;

        if ($this->getProductWidth($product)) {
            $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_ATTRIBUTES][bobsi\Tradefeed::NAME_PRODUCT_ATTR_WIDTH] =
                number_format($this->getProductWidth($product), 2, '.', '');
        }

        if ($this->getProductHeight($product)) {
            $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_ATTRIBUTES][bobsi\Tradefeed::NAME_PRODUCT_ATTR_HEIGHT] =
                number_format($this->getProductHeight($product), 2, '.', '');
        }

        if ($this->productLength($product)) {
            $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_ATTRIBUTES][bobsi\Tradefeed::NAME_PRODUCT_ATTR_LENGTH] =
                number_format($this->productLength($product), 2, '.', '');
        }

        if ($product->has_weight()) {
            $productWeight = number_format((double)$product->get_weight(), 2, '.', '');
            $productWeightUnit = (string)get_option('woocommerce_weight_unit', '');
            $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_ATTRIBUTES]
            [bobsi\Tradefeed::NAME_PRODUCT_ATTR_SHIPPING_WEIGHT] = $productWeight . $productWeightUnit;
        }

        $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_AVAILABLE_QTY] =
            $this->calcProductQuantity($product, $this->plugin->core->getSettings()->getDefaultStockQuantity());

        //Image of the variation has Priority 1. If there is no image in the variation - get the image of the product.
        $image = false;
        $productId = $this->getProductId($product);
        if ($product instanceof \WC_Product_Variation) {
            $productId = $this->getProductId($product);
            $image = wp_get_attachment_url(get_post_thumbnail_id($productId));
            $productId = $this->getProductId($product, true);
        }
        $image = $image ? $image : wp_get_attachment_url(get_post_thumbnail_id($productId));
        if ($image) {
            $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_IMAGE_URL] = $image;
        }
        $images = $image ? array($image) : array();

        $attachment_ids = $this->getGalleryImageIds($product);
        foreach ($attachment_ids as $attachment_id) {
            //Get URL of Gallery Images - default wordpress image sizes
            $images[] = wp_get_attachment_url($attachment_id);
        }

        if (!empty($images)) {
            $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_IMAGES] = $images;
        }
        //Add categories to the product
        $categorie_names = array();
        $categorie_ids = array();

        foreach ($categories as $category_id) {
            $categorie_names[] = $this->getBreadcrumb($category_id);
            $categorie_ids[] = $category_id;
        }
        $exportedProduct[bobsi\Settings::PARAM_CATEGORY_ID] =
            bobsi\Tradefeed::CATEGORY_ID_DELIMITER . join(bobsi\Tradefeed::CATEGORY_ID_DELIMITER, $categorie_ids)
            . bobsi\Tradefeed::CATEGORY_ID_DELIMITER;
        $exportedProduct[bobsi\Tradefeed::NAME_PRODUCT_CATEGORY] =
            join(bobsi\Tradefeed::CATEGORY_NAME_DELIMITER, $categorie_names);

        return $exportedProduct;
    }

    /**
     * Export products
     *
     * @param integer $productId            id
     * @param array   $available_variations available variations
     *
     * @return array
     */
    public function exportProducts($productId, $available_variations = array())
    {
        $exportedProducts = array();
        $exportQuantityMoreThan = $this->plugin->core->getSettings()->getExportQuantityMoreThan();
        $defaultStockQuantity = $this->plugin->core->getSettings()->getDefaultStockQuantity();
        $exportVisibilities = $this->plugin->core->getSettings()->getExportVisibilities();

        $product = wc_get_product($productId);
        $this->plugin->core->logInfo('Processing product id: ' . $productId);

        if (count($this->plugin->core->getSettings()->getExportStatuses()) == 0
            or !in_array(
                get_post($this->getProductId($product))->post_status,
                $this->plugin->core->getSettings()->getExportStatuses()
            )
        ) {
            return $exportedProducts;
        }

        $allowedCategories = $this->plugin->getExportCategoriesIds(
            $this->plugin->core->getSettings()->getExcludeCategories()
        );

        $allowOffersCategories = $this->plugin->core->getSettings()->getIncludeAllowOffersCategories();

        $productCategories =
            wp_get_object_terms(($product instanceof \WC_Product_Variation) ? $this->getProductId($product, true)
                : $productId, 'product_cat', array('fields' => 'ids'));
        if (empty($productCategories)) {
            $productCategories[] = 0;
        }

        $categoriesMatching = array_intersect($allowedCategories, $productCategories);
        if (empty($categoriesMatching)) {
            return $exportedProducts;
        }

        $productVisibility = get_post($this->getProductId($product))->post_password ? 'protected' : 'visible';
        if (!empty($exportVisibilities) && !in_array($productVisibility, $exportVisibilities)) {
            return $exportedProducts;
        }

        if (!($product instanceof \WC_Product_Variation)) {
            $summary = $this->getProductSummary($product);
            $description = $this->getProductDescription($product);

            $exportedProducts[bobsi\Tradefeed::NAME_PRODUCT_SUMMARY] = $summary;
            $exportedProducts[bobsi\Tradefeed::NAME_PRODUCT_DESCRIPTION] = $description;
        }

        if ($product instanceof \WC_Product_Variable) {
            $available_variations = $this->woocommerceGetAllVariations($productId);

            $ids = $product->get_children();
            foreach ($ids as $vid) {
                $ps = $this->exportProducts($vid, $available_variations);
                foreach ($ps as &$item) {
                    $exportedProducts[] = $item;
                }
            }
        } elseif (($product instanceof \WC_Product_Simple || $product instanceof \WC_Product_Variation)) {
            $attributes = $product instanceof \WC_Product_Variation ?
                wc_get_product($this->getProductId($product, true))->get_attributes() : $product->get_attributes();

            $attributes_variations =
                $product instanceof \WC_Product_Variation ? $product->get_variation_attributes() : array();

            $qty = $this->calcProductQuantity($product, $defaultStockQuantity);
            if ($qty <= $exportQuantityMoreThan) {
                $this->plugin->core->logInfo("QTY is not enough to export product id: $productId, qty: $qty");
                return $exportedProducts;
            }

            if (!empty($attributes_variations) && in_array('', array_values($attributes_variations))) {
                $mhash = $this->plugin->core->shash($attributes_variations);

                $available_variations_copy = $available_variations;

                foreach ($available_variations_copy as &$variation) {
                    $hash = $this->plugin->core->shash($variation);
                    if (preg_match('/^' . $mhash . '$/', $hash)) {
                        $variations = $this->getSortedAttributes($variation, $attributes, $product);
                        $this->buildExportProductHelper(
                            $product,
                            $variations,
                            $categoriesMatching,
                            $allowOffersCategories,
                            $exportedProducts
                        );
                    }
                }
                return $exportedProducts;
            }

            $variations = $this->getSortedAttributes($attributes_variations, $attributes, $product);
            $this->buildExportProductHelper(
                $product,
                $variations,
                $categoriesMatching,
                $allowOffersCategories,
                $exportedProducts
            );
        }

        return $exportedProducts;
    }

    /**
     * Build export product helper
     *
     * @param \WC_Product $product            product
     * @param array       $variations         variations
     * @param array       $categoriesMatching categories
     * @param array       $exportedProducts   exported product
     *
     * @return void
     */
    protected function buildExportProductHelper(
        $product,
        $variations,
        $categoriesMatching,
        $allowOffersCategories,
        &$exportedProducts
    ) {
        $exportProduct = $this->buildExportProduct($product, $variations, $categoriesMatching, $allowOffersCategories);

        if ((int)$exportProduct[bobsi\Tradefeed::NAME_PRODUCT_PRICE] <= 0) {
            $this->plugin->core->logInfo('Product price <= 0, skipping, product id: ' . $this->getProductId($product));
            return;
        }
        $exportedProducts[] = $exportProduct;
    }

    /**
     * Puts in order all variations and attributes
     *
     * @param array  $attributesVariations - variable attributes
     * @param array  $attributes           - simple attributes of the product
     * @param object $product              product
     *
     * @return array
     */
    protected function getSortedAttributes($attributesVariations, $attributes, $product)
    {
        $variations = array();
        //Order of attrs: variations should come first in tradefeed.
        $attributesVariationsKeys = array_keys($attributesVariations);
        foreach ($attributesVariationsKeys as $attrVarKey) {
            $name = strstr($attrVarKey, 'attribute_') ? str_replace('attribute_', '', $attrVarKey) : $attrVarKey;
            $variations['attributes'][$this->attributeLabel($name)] = '';
        }

        foreach ($attributes as $key => &$attribute) {
            $variations['attributes'][$this->attributeLabel($attribute['name'])] =
                isset($attributesVariations['attribute_' . $key]) ? $attributesVariations['attribute_' . $key]
                    : $product->get_attribute($attribute['name']);
        }
        return $variations;
    }

    /**
     * Attribute label
     *
     * @param string $name name
     *
     * @return mixed
     */
    protected function attributeLabel($name)
    {
        if (strstr($name, 'pa_')) {
            $name = str_replace('pa_', '', $name);
        }
        return $name;
    }

    /**
     * Get shipping class
     *
     * @param integer $post_id                     post id
     * @param int     $getParentShipmentMethodById id
     *
     * @return string
     */
    protected function getShippingClass($post_id, $getParentShipmentMethodById = 0)
    {
        $classes = get_the_terms($post_id, 'product_shipping_class');
        $shipping_class_name = ($classes && !is_wp_error($classes)) ? current($classes)->name : '';

        if (empty($shipping_class_name) && $getParentShipmentMethodById) {
            $classes = get_the_terms($getParentShipmentMethodById, 'product_shipping_class');
            $shipping_class_name = ($classes && !is_wp_error($classes)) ? current($classes)->name : '';
        }

        return $shipping_class_name;
    }


    /**
     * Get all variations.
     *
     * @param integer $postId post id
     *
     * @return array
     */
    protected function woocommerceGetAllVariations($postId)
    {
        $postId = intval($postId);
        if (!$postId) {
            return array();
        }

        $variations = array();
        $product = wc_get_product($postId);

        // Put variation attributes into an array
        foreach ($product->get_attributes() as $attribute) {
            if (!$attribute['is_variation']) {
                continue;
            }

            $attributeFieldName = 'attribute_' . sanitize_title($attribute['name']);

            $options = array();
            if ($attribute['is_taxonomy']) {
                $postTerms = wp_get_post_terms($postId, $attribute['name']);

                foreach ($postTerms as $term) {
                    $options[] = $term->slug;
                }
            }

            $options = $options ?: explode('|', $attribute['value']);
            $options = array_map('sanitize_title', array_map('trim', $options));
            $variations[$attributeFieldName] = $options;
        }
        // Quit out if none were found
        if (count($variations) == 0) {
            $product = null;

            //only variables should be returned by reference
            $tempvar = array();
            return $tempvar;
        }
        // Now find all combinations and create posts

        $variationIds = $this->woocommerceGetPossibleVariations($product, $variations);
        wc_delete_product_transients($postId);
        $product = null;

        return $variationIds;
    }

    /**
     * Get possible variations
     *
     * @param object $product    product
     * @param array  $variations variations
     *
     * @return array
     */
    protected function woocommerceGetPossibleVariations($product, $variations)
    {

        // Get existing variations so we don't create duplicates
        $availableVariations = array();

        foreach ($product->get_children() as $childId) {
            $child = wc_get_product($childId);
            $id = $this->getProductId($child);
            if (!empty($id)) {
                $availableVariations[] = $child->get_variation_attributes();
            }
        }

        $variationIds = array();
        $possibleVariations = $this->arrayCartesian($variations);

        foreach ($possibleVariations as $variation) {
            // Check if variation already exists
            if (in_array($variation, $availableVariations)) {
                continue;
            }

            $attrs = array();
            foreach ($variation as $key => $value) {
                $attrs[$key] = $value;
            }
            $variationIds[] = $attrs;
        }

        return $variationIds;
    }

    /**
     * Array Cartesian Func
     *
     * @param array $input input
     *
     * @return array
     */
    protected function arrayCartesian($input)
    {
        $result = array();

        while (list($key, $values) = each($input)) {
            // If a sub-array is empty, it doesn't affect the cartesian product
            if (empty($values)) {
                continue;
            }

            // Special case: seeding the product array with the values from the first sub-array
            if (empty($result)) {
                foreach ($values as $value) {
                    $result[] = array($key => $value);
                }
                continue;
            }
            // Second and subsequent input sub-arrays work like this:
            //   1. In each existing array inside $product, add an item with
            //      key == $key and value == first item in input sub-array
            //   2. Then, for each remaining item in current input sub-array,
            //      add a copy of each existing array inside $product with
            //      key == $key and value == first item in current input sub-array

            // Store all items to be added to $product here; adding them on the spot
            // inside the foreach will result in an infinite loop
            $append = array();
            foreach ($result as &$product) {
                // Do step 1 above. array_shift is not the most efficient, but it
                // allows us to iterate over the rest of the items with a simple
                // foreach, making the code short and familiar.
                $product[$key] = array_shift($values);

                // $product is by reference (that's why the key we added above
                // will appear in the end result), so make a copy of it here
                $copy = $product;

                // Do step 2 above.
                foreach ($values as $item) {
                    $copy[$key] = $item;
                    $append[] = $copy;
                }

                // Undo the side effecst of array_shift
                array_unshift($values, $product[$key]);
            }

            // Out of the foreach, we can add to $results now
            $result = array_merge($result, $append);
        }
        return $result;
    }
}
