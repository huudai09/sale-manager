<?php

$f = new Form();
$f
        ->addField(array(
            'label' => 'Ly ddieen',
            'content' => Tag::input('name')
        ))
        ->addField(array(
            'label' => 'Bắt đầu từ ngày',
            'content' => Tag::input('desc')
        ))
        ->addField(array(
            'label' => 'Loại sự kiện',
            'content' => '<select><option>1</option></select>'
        ))
        ->addField(array(
            array(
                'label' => 'Từ lúc',
                'content' => Tag::input('date_from')
            ),
            array(
                'label' => 'Tới lúc',
                'content' => Tag::input('date_to')
            )
                ), true)
        ->addField(array(
            'label' => '{@lang: Bắt đầu từ ngày}',
            'content' => Tag::input('desc')
        ))
        ->addButtons()
        ->bang();
