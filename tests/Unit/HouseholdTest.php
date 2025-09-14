<?php

use App\Models\Household;
use App\Models\User;

it('belongs to a user', function () {
    // arrange, act, assert

    $user = User::factory()->create();
    $user->households()->create(['name' => 'Test Household']);
    // $household = Household::factory()->create([
    //     'user_id' => $user->id,
    // ]);

    expect($user->households)->toHaveCount(1);
});
