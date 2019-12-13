<?php
namespace Metro;

/**
* Interface for The Collection class that contains Offers
*/
interface OfferCollectionInterface {
    /**
    * Add offer to the collection
    *
    * @param OfferInterface $offer
    * @return void
    */
    public function add(OfferInterface $offer): void;
    
    /**
    * Get offer at specific index
    *
    * @param int $index
    * @return OfferInterface
    */
    public function get(int $index): OfferInterface;
    
    /**
    * @return Iterator
    */
    public function getIterator(): Iterator;
}

class OfferCollection implements OfferCollectionInterface{
    private $offers;
    private $filters;

    function __construct(array $filters){
        $this->filters = $filters;
    }

    public function add(OfferInterface $offer): void{
        if($offer->isValid($this->filters)){
            $this->offers[] = $offer;
        }
    }

    public function get(int $index): OfferInterface{
        if(isset($this->offers[$index])){
            return $this->offers[$index];
        }
        return null;
    }

    public function getAll(){
        return $this->offers;
    }

    public function getIterator(): Iterator{
        
    }
}
?>