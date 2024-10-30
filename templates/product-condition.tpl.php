<?php

use \Com\ExtremeIdea\Bidorbuy\StoreIntegrator\Core\Settings;

$secondhandCategories = $storeIntegrator->getSettings()->getSecondhandProductConditionCategories();
$refurbishedCategories = $storeIntegrator->getSettings()->getRefurbishedProductConditionCategories();

$secondhandCategoriesName = Settings::NAME_PRODUCT_CONDITION_SECONDHAND_CATEGORIES;
$refurbishedCategoriesName = Settings::NAME_PRODUCT_CONDITION_REFURBISHED_CATEGORIES;

$secondhandCategoriesHtml = "<select id='$secondhandCategoriesName' 
                                 class='bobsi-categories-select' 
                                 name='{$secondhandCategoriesName}[]' 
                                 multiple='multiple' 
                                 size='9'>";

$newCategoriesHtml = "<select id='productConditionNewCategories' 
                                 class='bobsi-categories-select' 
                                 name='productConditionNewCategories[]' 
                                 multiple='multiple' 
                                 size='9'>";

$refurbishedCategoriesHtml = "<select id='$refurbishedCategoriesName' 
                                 class='bobsi-categories-select' 
                                 name='{$refurbishedCategoriesName}[]' 
                                 multiple='multiple' 
                                 size='9'>";


foreach ($categories as $category) {
    $option = '<option  value="' . $category->term_id . '">' . $category->name . '</option>';
    $termId = $category->term_id;
    if (in_array($termId, $secondhandCategories)) {
        $secondhandCategoriesHtml .= $option;
        continue;
    } elseif (in_array($termId, $refurbishedCategories)) {
        $refurbishedCategoriesHtml .= $option;
        continue;
    }
    $newCategoriesHtml .= $option;
}
$secondhandCategoriesHtml .= '</select>';
$newCategoriesHtml .= '</select>';
$refurbishedCategoriesHtml .= '</select>';

?>


<table width="45%" style="padding-left: 10px">
    <tr>
        <td colspan="5"><h3>Product Condition</h3></td>
    </tr>
    <tr>
        <td id="cats-left">
            <span class="title-item">Secondhand</span><br>
            <img class="bobsi_help_tip"
                 data-tip="All included categories to `Secondhand` column will be exported with `Secondhand` condition"
                 src="<?php echo $tooltipImgUrl; ?>"
                 height="16" width="16"/>
            <?= $secondhandCategoriesHtml; ?>
        </td>
        <td id="cats-middle">
            <?php
            echo get_submit_button('< Include', 'secondary', 'includeProductConditionSecondhandCategories')
                . get_submit_button('> Exclude', 'secondary', 'excludeProductConditionSecondhandCategories');
            ?>
        </td>
        <td id="cats-right" class="last-item">
            <span class="title-item">New</span>
            <img class="bobsi_help_tip"
                 data-tip="All included categories to `New` column will be exported with `New` condition"
                 src="<?php echo $tooltipImgUrl; ?>"
                 height="16" width="16"/>
            <?= $newCategoriesHtml; ?>
        </td>
        <td id="cats-middle">
            <?php
            echo get_submit_button('> Include', 'secondary', 'includeProductConditionRefurbishedCategories')
                . get_submit_button('< Exclude', 'secondary', 'excludeProductConditionRefurbishedCategories');
            ?>
        </td>
        <td id="cats-right" class="last-item">
            <span class="title-item">Refurbished</span>
            <img class="bobsi_help_tip"
                 data-tip="All included categories to `Refurbished` column will be exported with
                 `Refurbished` condition"
                 src="<?php echo $tooltipImgUrl; ?>"
                 height="16" width="16"/>
            <?= $refurbishedCategoriesHtml; ?>
        </td>
    </tr>
</table>
