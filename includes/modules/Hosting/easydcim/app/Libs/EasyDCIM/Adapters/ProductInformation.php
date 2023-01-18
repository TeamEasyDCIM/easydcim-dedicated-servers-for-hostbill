<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters;

use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\ProductConfiguration;
use ModulesGarden\Servers\EasyDCIMv2\App\Models\Whmcs\Product;

/**
 * Description of ProductConfiguration
 *
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class ProductInformation
{

    private $productID;

    /**
     * Set a params
     * 
     * @param integer $productID
     */
    public function __construct($productID)
    {
        $this->productID = $productID;
    }

    /**
     * Get Configuration
     * 
     * @return array 
     */
    public function getConfiguration()
    {
        $customConfig = $this->getCustomConfiguration();
        if (empty($customConfig))
        {
            return $this->standardConfiguration();
        }
        return $customConfig;
    }

    /**
     * Get MG Custom Configuration
     * 
     * @return array 
     */
    private function getCustomConfiguration()
    {
        return ProductConfiguration::get($this->productID);
    }

    /**
     * Get WHMCS Standard Cconfiguration
     * 
     * @return array $params
     */
    private function standardConfiguration()
    {
        $product = $this->getProduct();
        return [
            'location'                => $product->configoption1,
            'model'                   => $product->configoption2,
            'autoAcceptOrder'         => [$product->configoption3],
            'serviceAccessLevel'      => $product->configoption4,
            'suspendActions'           => [$product->configoption5],
            'templateSuspend'         => $product->configoption6,
            'unsuspendActions'         => [$product->configoption7],
            'templateUnsuspend'       => $product->configoption8,
            'terminateActions'         => [$product->configoption9],
            'templateTerminate'       => $product->configoption10,
            'notificationAdminId'     => $this->unserializeParams($product->configoption11),
            'trafficStatisticVisible' => [$product->configoption12],
            'powerUsageVisible'       => [$product->configoption13],
            'powerOutletsVisible'     => [$product->configoption14],
        ];
    }

    private function getProduct()
    {
        return Product::where('id', $this->productID)->first();
    }

    /**
     * Unserialize when $value is not empty
     * @param string $value
     * $return array
     */
    private function unserializeParams($value)
    {
        return ($value) ? unserialize($value) : [];
    }

}
