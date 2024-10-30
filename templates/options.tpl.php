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

// phpcs:disable PSR1.Files.SideEffects

if (!defined('ABSPATH')) {
    exit;// Exit if accessed directly
}

use Com\ExtremeIdea\Bidorbuy\StoreIntegrator\Core as bobsi;

$storeIntegrator = $this->core;
$wordings = $storeIntegrator->getSettings()->getDefaultWordings();
$warnings = array_merge($storeIntegrator->getWarnings(), bobsi\StaticHolder::getWarnings()->getBusinessWarnings());
// Currency. Supported by WooCommerce Currency Converter
$currencies = $this->currencyConverter->getCurrencies();
$bobsiCurrency = '<select name="' . bobsi\Settings::NAME_CURRENCY . '">';
$bobsiCurrency .= '<option value="0"></option>';
foreach ($currencies as $currency) {
    $selected = ($currency == $storeIntegrator->getSettings()->getCurrency()) ? 'selected="selected"' : '';
    $bobsiCurrency .= '<option value="' . $currency . '" ' . $selected . '>' . $currency . '</option>';
}
$bobsiCurrency .= '</select>';


function createCategoriesMultipleSelectBox($categories, $excludeCategories, $incId, $incName, $excId, $excName)
{
    $includedCategories = "<select id='$incId' class='bobsi-categories-select'
            name='{$incName}[]' multiple='multiple' size='9'>";
    $excludedCategories = "<select id='$excId' class='bobsi-categories-select' 
            name='{$excName}[]' multiple='multiple' size='9'>";

    foreach ($categories as $category) {
        $t = '<option  value="' . $category->term_id . '">' . $category->name . '</option>';
        if (in_array($category->term_id, $excludeCategories)) {
            $excludedCategories .= $t;
            continue;
        }
        $includedCategories .= $t;
    }
    $includedCategories .= '</select>';
    $excludedCategories .= '</select>';
    return ['included' => $includedCategories, 'excluded' => $excludedCategories];
}

$categories = $this->getCategories(array('hide_empty' => 0));
$uncatTerm = isset($categories[0]) && $categories[0]->slug == 'uncategorized';
if (!$uncatTerm) {
    $uncat = new stdClass();
    $uncat->term_id = 0;
    $uncat->name = 'Uncategorized';
    array_unshift($categories, $uncat);    //adding Uncategorized
}
$excludedProductCategories = $storeIntegrator->getSettings()->getExcludeCategories();
$includedAllowOffersCategories = $storeIntegrator->getSettings()->getIncludeAllowOffersCategories();
$excludedAllowOffersCategories = [];
foreach ($categories as $category) {
    $categoryId = $category->term_id;
    if (!in_array($categoryId, $includedAllowOffersCategories)) {
        $excludedAllowOffersCategories[] = $categoryId;
    }
}

$productsCategories = createCategoriesMultipleSelectBox(
    $categories,
    $excludedProductCategories,
    'bobsi-inc-categories',
    'bobsi_inc_categories',
    'bobsi-exc-categories',
    'excludeCategories'
);

$allowOffersCategories = createCategoriesMultipleSelectBox(
    $categories,
    $excludedAllowOffersCategories,
    'bobsi-inc-allow-offers-categories',
    'includeAllowOffersCategories',
    'bobsi-exc-allow-offers-categories',
    'excludeAllowOffersCategories'
);

// statuses to include
$exportStatuses = $storeIntegrator->getSettings()->getExportStatuses();
$statuses = array(
    'publish' => 'Published',
    'pending' => 'Pending review',
    'draft' => 'Draft'
);
$includedStatuses =
    '<select id="bobsi-inc-statuses" class="bobsi-select" name="exportStatuses[]" multiple="multiple" size="9">';
$excludedStatuses =
    '<select id="bobsi-exc-statuses" class="bobsi-select" name="excludeStatuses[]" multiple="multiple" size="9">';

foreach ($statuses as $key => $status) {
    $t = '<option  value="' . $key . '">' . $status . '</option>';
    if (in_array($key, $exportStatuses)) {
        $includedStatuses .= $t;
        continue;
    }
    $excludedStatuses .= $t;
}
$includedStatuses .= '</select>';
$excludedStatuses .= '</select>';

$zipLoaded = array_key_exists('zip', $storeIntegrator->getSettings()->getCompressLibraryOptions());
$exportLink = $this->generateActionUrl('export', $storeIntegrator->getSettings()->getTokenExport());
$downloadLink = $this->generateActionUrl('download', $storeIntegrator->getSettings()->getTokenDownload());
$resetauditLink = $this->generateActionUrl('resetaudit', $storeIntegrator->getSettings()->getTokenDownload());
$phpInfoLink = $this->generateActionUrl('version', $storeIntegrator->getSettings()->getTokenDownload() . '&phpinfo=y');
$logfilesTable = $storeIntegrator->getLogsHtml();
$tooltipImgUrl = plugins_url('../assets/images/tooltip.png', __FILE__);
$bobLogoUrl = plugins_url('../assets/images/bidorbuy.png', __FILE__);
$submitButton = get_submit_button(null, 'button-primary bobsi-save-settings');
$bobsiFilename = $storeIntegrator->getSettings()->getFilename();
$bobsiUsername = $storeIntegrator->getSettings()->getUsername();
$bobsiPassword = $storeIntegrator->getSettings()->getPassword();
$compressLibs = '';
$compressOptions = $storeIntegrator->getSettings()->getCompressLibraryOptions();
$compressOptions = array_keys($compressOptions);
foreach ($compressOptions as $lib) {
    $selected = ($storeIntegrator->getSettings()->getCompressLibrary() == $lib) ? 'selected="selected"' : '';
    $compressLibs .= '<option value="' . $lib . '" ' . $selected . '>' . $lib . '</option>';
}
$bobsiDefaultQuantity = $storeIntegrator->getSettings()->getDefaultStockQuantity();

$loggingApp = '';
foreach ($storeIntegrator->getSettings()->getLoggingApplicationOptions() as $level => $name) {
    $selected = ($storeIntegrator->getSettings()->getLoggingApplication() == $level) ? 'selected="selected"' : '';
    $loggingApp .= '<option value="' . $level . '" ' . $selected . '>' . $name . '</option>';
}

$loggingLevels = '';
foreach ($storeIntegrator->getSettings()->getLoggingLevelOptions() as $level) {
    $selected = ($storeIntegrator->getSettings()->getLoggingLevel() == $level) ? 'selected="selected"' : '';
    $loggingLevels .= '<option value="' . $level . '" ' . $selected . '>' . ucfirst($level) . '</option>';
}

$bobsiMinQuantity = $storeIntegrator->getSettings()->getExportQuantityMoreThan();
$onlyActiveProducts = 1; //$storeIntegrator->getSettings()->getExportActiveProducts();

foreach ($warnings as $warning) {
    echo "<div class='error'><p>$warning </p></div>";
}
// phpcs:enable
?>

<div id="bobsi-admin-header">
    <div id="bobsi-icon-trade-feed"
         style="background-image: url('<?php echo $bobLogoUrl ?>');">
    </div>
    <h2><?php echo bobsi\Version::$name ?></h2>
    <div id="bobsi-adv">
        <!-- BEGIN ADVERTPRO CODE BLOCK -->
        <script type="text/javascript">
            document.write('<scr'
                + 'ipt src="https://nope.bidorbuy.co.za/servlet/view/banner/javascript/zone?zid=153&pid=0&random='
                + Math.floor(89999999 * Math.random() + 10000000)
                + '&millis=' + new Date().getTime()
                + '&referrer=' + encodeURIComponent(document.location) + '" type="text/javascript"></scr' + 'ipt>');
        </script>
        <!-- END ADVERTPRO CODE BLOCK -->
    </div>
</div>

<div id="poststuff">
    <form id="bobsi-settings-form" name="bobsi-settings-form" method="POST"
          action="">
        <input type="hidden" name="submit_options" value="1"/>
        <div class="postbox postbox-left">
            <h3><span>Export Configuration</span></h3>
            <table class="form-table">

                <?php if ($currencies) : ?>
                    <tr>
                        <th scope="row">Currency</th>
                        <td>
                            <?php echo $bobsiCurrency; ?>
                            <p class="description">Supported by WooCommerce Currency
                                Converter</p>
                        </td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th scope="row">Export filename</th>
                    <td>
                        <input class="bobsi-input" type="text" size="50"
                               name="<?php echo bobsi\Settings::NAME_FILENAME; ?>"
                               value="<?php echo $bobsiFilename; ?>"/>

                        <p class="description">16 characters max. Must start with a
                            letter.<br>Can contain letters,
                            digits, "-" and "_"</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Compress Tradefeed XML</th>
                    <td>
                        <select class="bobsi-input" name="<?php echo bobsi\Settings::NAME_COMPRESS_LIBRARY; ?>">
                            <?php echo $compressLibs; ?>
                        </select>
                        <img class="bobsi_help_tip"
                             data-tip="Choose a Compress Library to compress destination Tradefeed XML"
                             src="<?php echo $tooltipImgUrl; ?>" height="16"
                             width="16"/>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Min quantity in stock</th>
                    <td>
                        <input class="bobsi-input" type="text"
                               name="<?php echo bobsi\Settings::NAME_DEFAULT_STOCK_QUANTITY; ?>"
                               value="<?php echo $bobsiDefaultQuantity; ?>"/>
                        <img class="bobsi_help_tip"
                             data-tip="If you do not manage stock quantities for your products, you can set the default
                                stock quantity to be used for the XML feed.
                                This quantity will apply to all your products"
                             src="<?php echo $tooltipImgUrl; ?>" height="16"
                             width="16"/>

                        <p class="description">Set minimum quantity if quantity
                            management is turned OFF</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="postbox postbox-right">
            <h3><span>Export Criteria</span></h3>
            <table class="form-table">
                <tr>
                    <th scope="row">Export products with available quantity more than</th>
                    <td class="data-item">
                        <input class="bobsi-input" type="text"
                               name="<?php echo bobsi\Settings::NAME_EXPORT_QUANTITY_MORE_THAN; ?>"
                               value="<?php echo $bobsiMinQuantity; ?>"/>
                        <img class="bobsi_help_tip"
                             data-tip="Products with stock quantities lower than this value
                             will be excluded from the XML feed"
                             src="<?php echo $tooltipImgUrl; ?>" height="16"
                             width="16"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <fieldset>
                            <table width="100%">
                                <tr>
                                    <td id="cats-left">
                                        <span
                                                class="title-item">Included Categories</span>
                                        <br>
                                        <?php echo $productsCategories['included']; ?>
                                    </td>
                                    <td id="cats-middle">
                                        <?php
                                        echo get_submit_button('< Include', 'secondary', 'include')
                                            . get_submit_button('> Exclude', 'secondary', 'exclude');
                                        ?>
                                    </td>
                                    <td id="cats-right" class="last-item">
                                        <span
                                                class="title-item">Excluded Categories</span>
                                        <img class="bobsi_help_tip"
                                             data-tip="Move categories to the \'Excluded Categories\' column if would
                                             like to exclude any of your categories."
                                             src="<?php echo $tooltipImgUrl; ?>"
                                             height="16" width="16"/>
                                        <?php echo $productsCategories['excluded']; ?>
                                    </td>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <fieldset>
                            <table width="100%">
                                <tr>
                                    <td id="cats-left">
                                        <span
                                                class="title-item">Included Statuses</span>
                                        <br>
                                        <?php echo $includedStatuses; ?>
                                    </td>
                                    <td id="cats-middle">
                                        <?php
                                        echo get_submit_button('< Include', 'secondary', 'include-stat')
                                            . get_submit_button('> Exclude', 'secondary', 'exclude-stat');
                                        ?>
                                    </td>
                                    <td id="cats-right" class="last-item">
                                        <span
                                                class="title-item">Excluded Statuses</span>
                                        <img class="bobsi_help_tip"
                                             data-tip="Move statuses to the \'Excluded Statuses\' column if would like
                                             to exclude any of your statuses."
                                             src="<?php echo $tooltipImgUrl; ?>"
                                             height="16" width="16"/>
                                        <?php echo $excludedStatuses; ?>
                                    </td>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row" colspan="2">

                    </th>
                </tr>
            </table>
        </div>

        <div class="postbox product-settings">
            <h3><span>Product Settings</span></h3>

            <table width="45%" style="padding-left: 10px">
                <tr>
                    <td colspan="3"><h3>Allow Offers</h3></td>
                </tr>
                <tr>
                    <td id="cats-left">
                        <span class="title-item">Included Categories</span><br>
                        <?php echo $allowOffersCategories['included']; ?>
                    </td>
                    <td id="cats-middle">
                        <?php
                        echo get_submit_button('< Include', 'secondary', 'include-allow-offers')
                            . get_submit_button('> Exclude', 'secondary', 'exclude-allow-offers');
                        ?>
                    </td>
                    <td id="cats-right" class="last-item">
                        <span class="title-item">Excluded Categories</span>
                        <img class="bobsi_help_tip"
                             data-tip="Move Allow Offers categories to the 'Excluded Categories' column if would like
                              to disable Allow Offers for products in specific categories."
                             src="<?php echo $tooltipImgUrl; ?>"
                             height="16" width="16"/>
                        <?php echo $allowOffersCategories['excluded']; ?>
                    </td>
                </tr>
            </table>

            <?php include __DIR__ . "/product-condition.tpl.php";?>
        </div>

        <input type="hidden" name="<?php echo bobsi\Settings::NAME_TOKEN_DOWNLOAD; ?>"
               value="<?php echo $storeIntegrator->getSettings()->getTokenDownload(); ?>">
        <input type="hidden" name="<?php echo bobsi\Settings::NAME_TOKEN_EXPORT; ?>"
               value="<?php echo $storeIntegrator->getSettings()->getTokenExport(); ?>">
        <select style="display: none;"
                name="<?php echo bobsi\Settings::NAME_EXPORT_VISIBILITIES . '[]'; ?>">
            <?php foreach ($storeIntegrator->getSettings()->getExportVisibilities() as $visibility) : ?>
                <option value="<?php echo $visibility; ?>"/>
            <?php endforeach; ?>
        </select>

        <p class="button-item">
            <?php echo $submitButton; ?>
        </p>


        <div class="postbox debug postbox-inner">
            <h3><span>Debug</span></h3>
            <table class="form-table">

                <!-- Feature 3910 -->
                <?php
                $baa = isset($_REQUEST['baa']) ? (int)$_REQUEST['baa'] : false;
                if ($baa == 1) :
                    ?>
                    <tr>
                        <td colspan="2">
                            <b>Basic Access Authentication</b>
                            <br>(if necessary)<br>
                            <span style="color: red">
                                Do not enter username or password of ecommerce platform, please read carefully
                                about this kind of authentication!
                </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Username</th>
                        <td>
                            <input class="bobsi-input" type="text" size="50"
                                   name="<?php echo bobsi\Settings::NAME_USERNAME; ?>"
                                   value="<?php echo $bobsiUsername; ?>"/>

                            <p class="description">
                                <?php echo $wordings
                                [bobsi\Settings::NAME_USERNAME]
                                [bobsi\Settings::NAME_WORDINGS_DESCRIPTION]; ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Password</th>
                        <td>
                            <input class="bobsi-input" type="password" size="50"
                                   name="<?php echo bobsi\Settings::NAME_PASSWORD; ?>"
                                   value="<?php echo $bobsiPassword; ?>"/>

                            <p class="description">
                                <?php echo $wordings
                                [bobsi\Settings::NAME_PASSWORD]
                                [bobsi\Settings::NAME_WORDINGS_DESCRIPTION]; ?>
                            </p>
                        </td>
                    </tr>
                <?php else : ?>
                    <input type="hidden" name="<?php echo bobsi\Settings::NAME_USERNAME; ?>"
                           value="<?php echo $bobsiUsername; ?>"/>
                    <input type="hidden" name="<?php echo bobsi\Settings::NAME_PASSWORD; ?>"
                           value="<?php echo $bobsiPassword; ?>"/>

                <?php endif; ?>

                <tr>
                    <td><?= $wordings[bobsi\Settings::NAME_LOGGING_APPLICATION]
                        [bobsi\Settings::NAME_WORDINGS_TITLE] ?></td>
                    <td>
                        <select class="bobsi-input" name="<?php echo bobsi\Settings::NAME_LOGGING_APPLICATION; ?>">
                            <?php echo $loggingApp; ?>
                        </select>
                        <img class="bobsi_help_tip"
                             data-tip="<?= $wordings[bobsi\Settings::NAME_LOGGING_APPLICATION]
                                [bobsi\Settings::NAME_WORDINGS_DESCRIPTION] ?>"
                             src="<?php echo $tooltipImgUrl; ?>" height="16"
                             width="16"/>
                    </td>
                </tr>
                <tr>
                    <td>Logging Level</td>
                    <td>
                        <select class="bobsi-input" name="<?php echo bobsi\Settings::NAME_LOGGING_LEVEL; ?>">
                            <?php echo $loggingLevels; ?>
                        </select>
                        <img class="bobsi_help_tip"
                             data-tip="A level describes the severity of a logging message.
                                There are six levels, show here in descending order of severity"
                             src="<?php echo $tooltipImgUrl; ?>" height="16"
                             width="16"/>
                    </td>
                </tr>
            </table>
        </div>
        <input type="button" onclick="jQuery('#submit').click()"
               class="button-primary bobsi-save-settings" value="<?php _e('Save Changes') ?>">
    </form>

    <div class="postbox logfiles postbox-inner">
        <h3><span>Logs</span></h3>
        <?php echo $logfilesTable; ?>
    </div>

    <div id="linksblock">
        <div id="ctrl-c-message">Press Ctrl+C</div>

        <form name="bobsi-export-form" method="POST" action="">
            <div class="postbox links postbox-inner">
                <input class="bobsi-input" type="hidden"
                       id="<?php echo bobsi\Settings::NAME_ACTION_RESET; ?>"
                       name="<?php echo bobsi\Settings::NAME_ACTION_RESET; ?>"
                       value="1"/>

                <h3><span>Links</span></h3>
                <table class="form-table export-links">
                    <tr>
                        <td><label for="tokenExportUrl">Export</label></td>
                        <td>
                            <input type="text" id="tokenExportUrl" class="bobsi-url"
                                   title="Click to select"
                                   value="<?php echo $exportLink; ?>" readonly/>
                        </td>
                        <td>
                            <button type="button" class="button button-primary"
                                    onclick="window.open('<?php echo $exportLink; ?>&r='
                                            + new Date().getTime(),'_blank');"><?php echo __('Launch'); ?></button>
                            <button type="button"
                                    class="button copy-button"><?php echo __('Copy'); ?></button>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="tokenDownloadUrl">Download</label></td>
                        <td>
                            <input type="text" id="tokenDownloadUrl" class="bobsi-url"
                                   title="Click to select"
                                   value="<?php echo $downloadLink; ?>" readonly/>
                        </td>
                        <td class="button-section">
                            <button type="button" class="button button-primary"
                                    onclick="window.open('<?php echo $downloadLink; ?>&r='
                                            + new Date().getTime(),'_blank');"><?php echo __('Launch'); ?></button>
                            <button type="button"
                                    class="button copy-button"><?php echo __('Copy'); ?></button>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="resetaudit">Reset export data</label></td>
                        <td>
                            <input type="text" id="resetaudit" class="bobsi-url"
                                   title="Click to select"
                                   value="<?php echo $resetauditLink; ?>" readonly/>
                            <p class="description">Clicking on this link will reset all
                                exported data in your tradefeed. This is done by clearing
                                all exported product data, before re-adding all products
                                to the export and completing the query. Please note, you
                                will still need to run the export link once this process
                                completes in order to update the download file.</p>
                        </td>
                        <td class="bobsi-top">
                            <button type="button" class="button button-primary"
                                    onclick="window.open('<?php echo $resetauditLink; ?>&r='
                                            + new Date().getTime(),'_blank');"><?php echo __('Launch'); ?></button>
                            <button type="button"
                                    class="button copy-button"><?php echo __('Copy'); ?></button>
                        </td>
                    </tr>
                </table>
            </div>
            <p class="button-item">
                <button
                        class="button button-primary"><?php echo __('Reset Tokens'); ?></button>
            </p>
        </form>
    </div>


    <div class="postbox version postbox-inner">
        <h3>Version</h3>
        <h3>
        <span>
            <a href="<?php echo $phpInfoLink ?>" target="_blank">@See PHP
                information</a><br>
            <?php echo bobsi\Version::getLivePluginVersion(); ?>
        </span>
        </h3>
    </div>
    <script>
        jQuery(document).ready(function () {
            jQuery('.bobsi_help_tip').tipTip({
                'attribute': 'data-tip',
                'fadeIn': 50,
                'fadeOut': 50,
                'delay': 200
            });
        });
    </script>
</div>