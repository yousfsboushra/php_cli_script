<?php
declare(strict_types=1);
namespace Metro;

use PHPUnit\Framework\TestCase;

class OfferTest extends TestCase{
    public function testValidOfferQuantity(): void{
        $filters = array();
        $json = '{"id":"1","title":"iPad","start_date":"2019-12-14 00:00:00","price":"199.99","vendor_id":"1","end_date":"2019-12-16 00:00:00","quantity":"1"}';
        $offer = new Offer(json_decode($json));
        $bool = $offer->isValid($filters);
        $this->assertEquals(
            1,
            $bool
        );
    }

    public function testInvalidOfferQuantity(): void{
        $filters = array();
        $json = '{"id":"1","title":"iPad","start_date":"2019-12-14 00:00:00","price":"199.99","vendor_id":"1","end_date":"2019-12-16 00:00:00","quantity":"0"}';
        $offer = new Offer(json_decode($json));
        $bool = $offer->isValid($filters);
        $this->assertEquals(
            0,
            $bool
        );
    }

    public function testValidOfferPrice(): void{
        $filters = array(
            "min_price" => 100,
            "max_price" => 199.99,
        );
        $json = '{"id":"1","title":"iPad","start_date":"2019-12-14 00:00:00","price":"199.99","vendor_id":"1","end_date":"2019-12-16 00:00:00","quantity":"1"}';
        $offer = new Offer(json_decode($json));
        $bool = $offer->isValid($filters);
        $this->assertEquals(
            1,
            $bool
        );
    }

    public function testInvalidOfferPrice(): void{
        $filters = array(
            "min_price" => 200,
            "max_price" => 300,
        );
        $json = '{"id":"1","title":"iPad","start_date":"2019-12-14 00:00:00","price":"199.99","vendor_id":"1","end_date":"2019-12-16 00:00:00","quantity":"1"}';
        $offer = new Offer(json_decode($json));
        $bool = $offer->isValid($filters);
        $this->assertEquals(
            0,
            $bool
        );
    }
}
?>