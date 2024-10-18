<?php declare(strict_types=1);

$messages = [
    'wordpress_customize' => [
        'message' => [
            'integer' => '※正負の整数のみ入力できます。',
            'unsigned_integer' => '※正の整数のみ入力できます。',
            'float' => '※正負の整数、小数のみ入力できます。',
            'unsigned_float' => '※正の整数、小数のみ入力できます。',
        ],
    ],
    'validation' => [
        'RequiredRule' => '{field}は、必須です。',
        'MinLengthRule' => '{field}は、{minimum}文字以上で入力してください。',
        'MaxLengthRule' => '{field}は、{max}文字以内で入力してください。',
        'LengthRule' => '{field}は、{minimum}文字以上、{max}文字以内で入力してください。',
        'RegExpRule' => '{field}が、正しい形式ではありません。',
    ],
];