<?php

namespace Tests\Doubles\Stubs\Paths\Operations;

class TestController
{
    public function actionWithTypeHintedParams(int $id, $unHinted, \stdClass $unknown): void
    {
    }
}
