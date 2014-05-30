<?php

class ValidatorTest extends PHPUnit_Framework_TestCase {

    protected function setUp() {}

    public function data() {
        $data = [[-1],[2],[6]];
        return $data;
    }

    /**
     * @dataProvider data
     * @author Carlos Ro
     */
    public function testAddNumbers($actual_1) {
        $this->assertTrue(Validador::createBuilder($actual_1)->esInt()->max(20)->build()->isValid(), "Logrado");
    }
    
    

}

?>