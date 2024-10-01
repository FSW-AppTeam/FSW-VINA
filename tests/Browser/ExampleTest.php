<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     */
    public function testBasicExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Vul de code in die op het scherm staat')
                ->typeSlowly('#surveyCode', 'test')
                ->pause(4000)
                ->pressAndWaitFor('@next')
                ->assertSee('Code bestaat niet.');
        });
    }
}
