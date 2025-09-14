<?php

it('returns a successful response', function () {
    $page = visit('/');

    $page->assertSee('Did you do that yet?');
});
