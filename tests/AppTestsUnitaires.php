<?php

namespace App\tests;


use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testTestUser()
    {
        $user = new User();
        $nomComplet = $user->setFirstName("Alpha"). '' .$user->setName("SYLLA");
        $this->assertEquals('Alpha SYLLA', $nomComplet);
    }
}
