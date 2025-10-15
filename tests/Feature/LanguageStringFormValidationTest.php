<?php

use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

it('passes validation with required fields', function () {
    $data = [
        'key' => 'nav.contact',
        'type' => 'contact',
        'default' => 'Contact us',
    ];

    $rules = [
        'key' => ['required', 'string', 'max:255'],
        'type' => ['required', 'string', 'max:255'],
        'default' => ['required', 'string'],
    ];

    $validator = Validator::make($data, $rules);

    expect($validator->passes())->toBeTrue();
});

it('fails validation when default is missing', function () {
    $data = [
        'key' => 'nav.contact',
        'type' => 'contact',
        // 'default' omitted
    ];

    $rules = [
        'key' => ['required', 'string', 'max:255'],
        'type' => ['required', 'string', 'max:255'],
        'default' => ['required', 'string'],
    ];

    $validator = Validator::make($data, $rules);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('default'))->toBeTrue();
});
