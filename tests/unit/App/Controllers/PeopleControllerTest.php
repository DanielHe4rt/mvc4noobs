<?php

use \PHPUnit\Framework\TestCase;
use App\Controllers\PeopleController;

class PeopleControllerTest extends TestCase
{
    public function testIfNada()
    {
        $controller = new PeopleController();
        $this->assertEquals(['name' => 'danielhe4rt'], $controller->index());
    }
}