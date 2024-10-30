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
 * Class BidorbuyStoreIntegratorTriggers.
 *
 * @package com\extremeidea\bidorbuy\storeintegrator\woocommerce
 */
class BidorbuyStoreIntegratorTriggers
{
    protected $plugin;

    protected $productsTouched;

    /**
     * BidorbuyStoreIntegratorTriggers constructor.
     *
     * @return self
     */
    public function __construct(BidorbuyStoreIntegrator $plugin)
    {
        $this->plugin = $plugin;
    }

    public function registerTriggersActions()
    {
        add_action('save_post_product', array($this,'productUpdated'), 10, 2);
        add_action('woocommerce_update_product_variation', array($this, 'productVariationUpdate'));
        add_action('woocommerce_create_product_variation', array($this, 'productVariationUpdate'));
        add_action('woocommerce_product_bulk_edit_save', array($this, 'productBulkOrQuickUpdate'));
        add_action('woocommerce_product_quick_edit_save', array($this, 'productBulkOrQuickUpdate'));
        add_action('woocommerce_attribute_updated', array($this, 'attributeUpdated'), 10, 2);
        add_action('woocommerce_attribute_deleted', array($this, 'attributeUpdated'), 10, 2);
        add_action('woocommerce_tax_rate_added', array($this->plugin, 'refreshAllProducts'));
        add_action('woocommerce_tax_rate_updated', array($this->plugin, 'refreshAllProducts'));
        add_action('woocommerce_tax_rate_deleted', array($this->plugin, 'refreshAllProducts'));
        //For categories
        add_action('create_term', array($this, 'termCreate'), 10, 3);//attributes and categories
        add_action('edited_terms', array($this, 'termUpdate'), 10, 2);//attributes and categories
        add_action('delete_term', array($this, 'termDelete'), 10, 4);//attributes and categories
    }

    /**
     * Product variation update
     *
     * @param integer $vid id
     *
     * @return void
     */
    public function productVariationUpdate($vid)
    {
        $product = new \WC_Product_Variation($vid);
        $pid = $product->parent->id;
        if (!isset($this->productsTouched[$pid])) {
            $this->productsTouched[$pid] = $pid;
            $this->plugin->wpdb->query(
                $this->plugin->core->getQueries()->getAddJobQueries($pid, bobsi\Queries::STATUS_UPDATE)
            );
        }
    }

    /**
     * Product updated
     * we can't easily catch difference between new/update events :(
     *
     * @param integer $postId id
     * @param mixed   $post   post
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function productUpdated($postId, $post)
    {
        $this->processProduct($post);
    }

    /**
     * Product bulk or quick update
     *
     * @param object $product product
     *
     * @return void
     */
    public function productBulkOrQuickUpdate($product)
    {
        $this->processProduct($product);
    }

    /**
     * Attribute updated
     *
     * @param integer $attrId attr id
     * @param array   $attr   attribute
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function attributeUpdated($attrId, $attr)
    {
        $attr = isset($attr['attribute_name']) ? $attr['attribute_name'] : $attr;
        $pids = $this->getProductsIdsByAttrValues(
            $attr,
            get_terms('pa_' . $attr, array('fields' => 'names', 'hide_empty' => 0))
        );

        foreach ($pids as $pid) {
            $this->plugin->wpdb->query(
                $this->plugin->core->getQueries()->getAddJobQueries($pid, bobsi\Queries::STATUS_UPDATE)
            );
        }
    }

    /**
     * Term create
     *
     * @param integer $termId   id
     * @param integer $ttId     id
     * @param string  $taxonomy taxonomy
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function termCreate($termId, $ttId, $taxonomy)
    {
        //product attribute
        if (strpos($taxonomy, 'pa_') === 0) {
            $this->attributeUpdated(0, array('attribute_name' => substr($taxonomy, 3)));
        }
    }

    /**
     * Term update
     *
     * @param integer $term_id  id
     * @param string  $taxonomy taxonomy
     *
     * @return void
     */
    public function termUpdate($term_id, $taxonomy)
    {
        if ($taxonomy == 'product_cat') {
            $this->categoryUpdate($term_id, bobsi\Queries::STATUS_UPDATE);
        }

        //product attribute
        if (strpos($taxonomy, 'pa_') === 0) {
            $this->attributeUpdated(0, array('attribute_name' => substr($taxonomy, 3)));
        }
    }

    /**
     * Term delete
     *
     * @param string  $term        term
     * @param integer $ttId        id
     * @param string  $taxonomy    taxonomy
     * @param string  $deletedTerm deleted_term
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function termDelete($term, $ttId, $taxonomy, $deletedTerm)
    {
        if ($taxonomy == 'product_cat') {
            $this->categoryUpdate($ttId, bobsi\Queries::STATUS_DELETE);
        }

        //product attribute
        if (strpos($taxonomy, 'pa_') === 0) {
            $this->attributeUpdated(0, array('attribute_name' => substr($taxonomy, 3)));
        }
    }

    /**
     * Category update
     *
     * @param integer $term_id id
     * @param string  $action  action
     *
     * @return void
     */
    protected function categoryUpdate($term_id, $action)
    {
        $exportConfiguration =
            array(bobsi\Settings::PARAM_ITEMS_PER_ITERATION => PHP_INT_MAX, bobsi\Settings::PARAM_ITERATION => 0,
                bobsi\Settings::PARAM_CATEGORY_ID => $term_id);

        $pids = $this->getProducts($exportConfiguration);

        foreach ($pids as $pid) {
            $this->plugin->wpdb->query($this->plugin->core->getQueries()->getAddJobQueries($pid, $action));
        }
    }

    /**
     * Process product
     *
     * @param mixed $post post
     *
     * @return void
     */
    protected function processProduct($post)
    {
        $productId = isset($post->ID) ? $post->ID : $post->id;
        $postStatus = isset($post->post->post_status) ? $post->post->post_status : $post->post_status;
        $data = $this->plugin->request->request->get('data');

        // do not response on autosave
        if (!isset($data['wp_autosave']) and !isset($this->productsTouched[$productId])) {
            $this->productsTouched[$productId] = $productId;

            if (in_array(
                $postStatus,
                $this->plugin->core->getSettings()->getExportStatuses()
            )) {
                $this->plugin->wpdb->query(
                    $this->plugin->core->getQueries()
                        ->getSetJobsRowStatusQuery($productId, bobsi\Queries::STATUS_DELETE, time())
                );
                $this->plugin->wpdb->query(
                    $this->plugin->core->getQueries()->getAddJobQueries($productId, bobsi\Queries::STATUS_UPDATE)
                );
                return;
            }
            $this->plugin->wpdb->query(
                $this->plugin->core->getQueries()->getAddJobQueries($productId, bobsi\Queries::STATUS_DELETE)
            );
        }
    }

    /**
     * Get products ids by attr values.
     *
     * @param string $key    key
     * @param string $values value
     *
     * @return mixed
     */
    protected function getProductsIdsByAttrValues($key, $values)
    {
        $args = array('fields' => 'ids', 'post_type' => 'product', 'posts_per_page' => 10,
            'tax_query' => array(array('taxonomy' => 'pa_' . $key, 'terms' => $values, 'field' => 'slug',
                'operator' => 'IN')));
        $result = new \WP_Query($args);

        return $result->posts;
    }

    /**
     * Get products
     *
     * @param array $exportConfiguration config
     *
     * @return array
     */
    protected function getProducts($exportConfiguration)
    {
        $itemsPerIteration = (int)$exportConfiguration[bobsi\Settings::PARAM_ITEMS_PER_ITERATION];
        $iteration = (int)$exportConfiguration[bobsi\Settings::PARAM_ITERATION];
        $categoryId = $exportConfiguration[bobsi\Settings::PARAM_CATEGORY_ID];

        $terms = $categoryId ?: $this->plugin->getExportCategoriesIds();
        $operator = $categoryId ? '' : 'NOT IN';

        $wpq = array('post_type' => 'product', 'fields' => 'ids',
            'tax_query' => array(array('taxonomy' => 'product_cat', 'field' => 'id', 'terms' => $terms,
                'include_children' => false, 'operator' => $operator)));

        if (count($this->plugin->core->getSettings()->getExportStatuses()) == 0) {
            return array();
        }
        $wpq['post_status'] = $this->plugin->core->getSettings()->getExportStatuses();
        $wpq['posts_per_page'] = $itemsPerIteration;
        $wpq['offset'] = $iteration * $itemsPerIteration;

        $query = new \WP_Query();
        $posts = $query->query($wpq);

        $query = null;

        return $posts;
    }
}
