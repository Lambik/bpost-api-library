<?php
namespace Bpost;

use Bpost\BpostApiClient\Bpost\Order\Address;
use Bpost\BpostApiClient\Bpost\Order\Sender;
use Bpost\BpostApiClient\Exception\BpostLogicException\BpostInvalidLengthException;

class SenderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Create a generic DOM Document
     *
     * @return \DOMDocument
     */
    private static function createDomDocument()
    {
        $document = new \DOMDocument('1.0', 'utf-8');
        $document->preserveWhiteSpace = false;
        $document->formatOutput = true;

        return $document;
    }

    /**
     * Tests Sender->toXML
     */
    public function testToXML()
    {
        $data = array(
            'name' => 'Tijs Verkoyen',
            'company' => 'Sumo Coders',
            'address' => array(
                'streetName' => 'Afrikalaan',
                'number' => '289',
                'box' => '3',
                'postalCode' => '9000',
                'locality' => 'Gent',
                'countryCode' => 'BE',
            ),
            'emailAddress' => 'bpost@verkoyen.eu',
            'phoneNumber' => '+32 9 395 02 51',
        );

        $expectedDocument = self::createDomDocument();
        $sender = $expectedDocument->createElement('sender');
        foreach ($data as $key => $value) {
            $key = 'common:' . $key;
            if ($key == 'common:address') {
                $address = $expectedDocument->createElement($key);
                foreach ($value as $key2 => $value2) {
                    $key2 = 'common:' . $key2;
                    $address->appendChild(
                        $expectedDocument->createElement($key2, $value2)
                    );
                }
                $sender->appendChild($address);
            } else {
                $sender->appendChild(
                    $expectedDocument->createElement($key, $value)
                );
            }
        }
        $expectedDocument->appendChild($sender);

        $actualDocument = self::createDomDocument();
        $address = new Address(
            $data['address']['streetName'],
            $data['address']['number'],
            $data['address']['box'],
            $data['address']['postalCode'],
            $data['address']['locality'],
            $data['address']['countryCode']
        );
        $sender = new Sender();
        $sender->setName($data['name']);
        $sender->setCompany($data['company']);
        $sender->setAddress($address);
        $sender->setEmailAddress($data['emailAddress']);
        $sender->setPhoneNumber($data['phoneNumber']);
        $actualDocument->appendChild(
            $sender->toXML($actualDocument, null)
        );

        $this->assertSame($expectedDocument->saveXML(), $actualDocument->saveXML());
    }

    /**
     * Test validation in the setters
     */
    public function testFaultyProperties()
    {
        $sender = new Sender();

        try {
            $sender->setEmailAddress(str_repeat('a', 51));
            $this->fail('BpostInvalidLengthException not launched');
        } catch (BpostInvalidLengthException $e) {
            // Nothing, the exception is good
        } catch (\Exception $e) {
            $this->fail('BpostInvalidLengthException not caught');
        }

        try {
            $sender->setPhoneNumber(str_repeat('a', 21));
            $this->fail('BpostInvalidLengthException not launched');
        } catch (BpostInvalidLengthException $e) {
            // Nothing, the exception is good
        } catch (\Exception $e) {
            $this->fail('BpostInvalidLengthException not caught');
        }

        // Exceptions were caught,
        $this->assertTrue(true);
    }
}
