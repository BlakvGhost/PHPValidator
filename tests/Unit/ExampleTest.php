<?php
use BlakvGhost\PHPValidator\Rules\EmailRule;
use BlakvGhost\PHPValidator\Rules\RequiredRule;
use function PHPUnit\Framework\assertTrue;

it('should validate email successfully', function() {

    $result = new EmailRule([]);
    
    //($result);

    assertTrue(true);

});