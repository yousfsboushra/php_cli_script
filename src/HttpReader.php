<?php
namespace Metro;
use \InvalidArgumentException;

/**
* The Interface provides the contract for different readers
* It can be XML, JSON Remote EntryPoint, or CSV, JSON, XML local files
*/
interface ReaderInterface {
    /**
    * Read in incoming data and parse to objects
    *
    * @param string $input
    * @return OfferCollectionInterface
    */
    public function read(string $input): OfferCollectionInterface;
}


class HttpReader implements ReaderInterface {
    private $offersCollection;

    function __construct(OfferCollectionInterface $offersCollection){
        $this->offersCollection = $offersCollection;
    }

    public function read(string $input): OfferCollectionInterface{
        $json = "";
        $file_headers = @get_headers($input);
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            error_log("Error: $input doesn't exist", 3, "error.log");
            throw new InvalidArgumentException("Bad input");
        }else{
            $json = file_get_contents($input);
            $data = json_decode($json);
            if(!empty($data)){
                foreach($data as $item){
                    $this->offersCollection->add(new Offer($item));
                }
            }
        }
        return $this->offersCollection;
    }
}