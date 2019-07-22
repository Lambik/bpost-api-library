<?php

namespace Bpost\BpostApiClient\Bpost;

use Bpost\BpostApiClient\Bpost\TrackingInfo\ItemDetail;

/**
 * bPost TrackingInfo class
 */
class TrackingInfo
{
	/** @var ItemDetail */
	private $itemDetail;
	
	/**
	 * @return ItemDetail
	 */
	public function getItemDetail() {
		return $this->itemDetail;
	}
	
	/**
	 * @param ItemDetail $itemDetail
	 */
	public function setItemDetail($itemDetail) {
		$this->itemDetail = $itemDetail;
	}

    /**
     * @param  \SimpleXMLElement $xml
     *
     * @return TrackingInfo
     */
    public static function createFromXML(\SimpleXMLElement $xml)
    {
        $trackingInfo = new TrackingInfo();

        if (isset($xml->itemDetail)) {
            $trackingInfo->setItemDetail(ItemDetail::createFromXMLHelper($xml->itemDetail));
        }

        return $trackingInfo;
    }
}
