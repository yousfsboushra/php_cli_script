<?php
declare(strict_types=1);
namespace Metro;
use \InvalidArgumentException;

use PHPUnit\Framework\TestCase;

class HttpReaderTest extends TestCase{
    public function testReadFromValidEndpoint(): void{
        $offerCollection = new OfferCollection([]);
        $reader = new HttpReader($offerCollection);
        $offersCollection = $reader->read("http://localhost/metro.php");

        $this->assertInstanceOf(
            OfferCollection::class,
            $offersCollection
        );
    }

    public function testReadFromInvalidEndpoint(): void{
        $offerCollection = new OfferCollection([]);
        $reader = new HttpReader($offerCollection);
        
        $this->expectException(InvalidArgumentException::class);
        $offersCollection = $reader->read("http://localhost/bad.php");
    }
}
?>