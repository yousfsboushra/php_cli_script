<?php
namespace Metro;

class Main{
    private $jsonEndpoint;
    private $filters;

    function __construct($jsonEndpoint, $filters){
        $this->jsonEndpoint = $jsonEndpoint;
        $this->mapFilters($filters);
    }

    public function mapFilters($filters){
        $this->filters = [];
        if(isset($filters[1])){
            switch($filters[1]){
                case 'date_filter':
                    if(isset($filters[2])){
                        $this->filters['start_date'] = date("Y-m-d H:i:s", strtotime($filters[2]));
                    }
                    if(isset($filters[3])){
                        $this->filters['end_date'] = date("Y-m-d H:i:s", strtotime($filters[3]));
                    }
                break;
                case 'price_filter':
                    if(isset($filters[2])){
                        $this->filters['min_price'] = $filters[2];
                    }
                    if(isset($filters[3])){
                        $this->filters['max_price'] = $filters[3];
                    }
                break;
            }
        }
    }

    public function getFilteredOffers(){
        $offerCollection = new OfferCollection($this->filters);
        $http = new HttpReader($offerCollection);
        $returnedOfferCollection = $http->read($this->jsonEndpoint);
        return $returnedOfferCollection->getAll();
    }
}
?>