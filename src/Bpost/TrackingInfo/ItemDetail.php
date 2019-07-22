<?php
namespace Bpost\BpostApiClient\Bpost\TrackingInfo;

use SimpleXMLElement;

/**
 * bPost ItemDetail class
 */
class ItemDetail
{
    const TAG_NAME = 'itemDetail';

    /**
     * @var int
     */
    private $weightInGrams;

    /**
     * @var string
     */
    private $type;
	
	/**
	 * @return int
	 */
	public function getWeightInGrams() {
		return $this->weightInGrams;
	}
	
	/**
	 * @param int $weightInGrams
	 */
	public function setWeightInGrams($weightInGrams) {
		$this->weightInGrams = $weightInGrams;
	}
	
	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * @param string $type
	 */
	public function setType($type) {
		$this->type = $type;
	}
	
    /**
     * @param  SimpleXMLElement $xml
     *
     * @return ItemDetail
     */
    public static function createFromXMLHelper(SimpleXMLElement $xml)
    {
    	$instance = new ItemDetail();
    	
        if (isset($xml->weightInGrams) && $xml->weightInGrams != '') {
            $instance->setWeightInGrams((int) $xml->weightInGrams);
        }
        if (isset($xml->type) && $xml->type != '') {
            $instance->setType((string) $xml->type);
        }

        return $instance;
    }
}
