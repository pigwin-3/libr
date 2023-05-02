<?php

use PHPUnit\Framework\TestCase;

class PermsTest extends TestCase {
    public function testPerms() {
        $perms = new Perms();
        $result = $perms->check(2);
        $this->assertEquals(1, $result);
    }
}

class Perms {
    public function check($a) {
        if ($a <= 1) {
            return 0;
        } else {
            return 1;
        }
    }
}
?>
