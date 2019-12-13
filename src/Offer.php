<?php
namespace Metro;

/**
* Interface the Data Transfer Object, that is representation of external JSON Data
*/
interface OfferInterface {
}

class Offer implements OfferInterface {
    private $id;
    private $title;
    private $vendor;
    private $start_date;
    private $end_date;
    private $price;
    private $quantity;

    public function __construct($offer){
        $this->id = (isset($offer->id))? $offer->id : 0;
        $this->title = (isset($offer->title))? $offer->title : '';
        $this->vendor = (isset($offer->vendor))? $offer->vendor : 0;
        $this->start_date = (isset($offer->start_date))? $offer->start_date : '1970:01:01 00:00:00';
        $this->end_date = (isset($offer->end_date))? $offer->end_date : '1970:01:01 00:00:00';
        $this->price = (isset($offer->price))? $offer->price : -1;
        $this->quantity = (isset($offer->quantity))? $offer->quantity : -1;
    }

    public function isValid(array $filters): bool{
        if($this->quantity == 0){ //if not in stock
            return 0;
        }

        $priceFilter = 1;
        if(isset($filters['min_price']) && $this->price < $filters['min_price']){ //if the offer price is less than the minimum price
            $priceFilter = 0;
        }
        if(isset($filters['max_price']) && $this->price > $filters['max_price']){ //if the offer price is more than the maximum price
            $priceFilter = 0;
        }
        if(!$priceFilter){
            return 0;
        }

        $dateFilter = 1;
        // if the offer will start after the filter end date or will end before the filter start date
        if(isset($filters['start_date']) && isset($filters['end_date'])){
            // if the offer will start after the filter end date or will end before the filter start date
            if($this->start_date > $filters['end_date'] || $this->end_date < $filters['start_date']){
                $dateFilter = 0;
            }
        }else if(isset($filters['start_date']) && ($this->start_date > $filters['start_date'] || $this->end_date < $filters['start_date'])){ //if the offer ends before the filter date or starts after it
            $dateFilter = 0; // the filter is not valid in this specific date
        }
        if(!$dateFilter){
            return 0;
        }

        $vendorFilter = 1;
        if(isset($filters['vendor_key']) && isset($filters['vendor_value'])){
            if(!isset($this->vendor->{$filters['vendor_key']})){
                return 0;
            }else if($this->vendor->{$filters['vendor_key']} != $filters['vendor_value']){
                return 0;
            }
        }

        return 1;
    }

    public function display(): void{
        echo "$this->title costs $$this->price from $this->start_date untill $this->end_date" . PHP_EOL;
    }
}
?>