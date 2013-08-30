<?php
$conf = array (
  'tables' => 
  array (
    'countries' => 
    array (
      'fields' => 
      array (
        'id' => 
        array (
          'type' => 'int',
          'length' => 10,
          'auto_increment' => 1,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'integer',
          ),
        ),
        'title' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Название',
          ),
        ),
        'url' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'URL',
          ),
        ),
        'price' => 
        array (
          'type' => 'tinytext',
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'string',
            'req' => 0,
            'title' => 'Цена для главной',
          ),
        ),
        'price_final' => 
        array (
          'type' => 'tinytext',
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'string',
            'req' => 0,
            'title' => 'Цена для заявки',
          ),
        ),
        'text' => 
        array (
          'type' => 'text',
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'ckhtml',
            'htmltype' => 'ckhtml',
            'req' => 0,
            'title' => 'Текст',
          ),
        ),
        'flag' => 
        array (
          'type' => 'tinytext',
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'image',
            'title' => 'Флаг',
          ),
        ),
        'pos' => 
        array (
          'type' => 'int',
          'length' => 10,
          'unsigned' => 1,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'integer',
            'htmltype' => 'hidden',
          ),
        ),
        'code' => 
        array (
          'type' => 'varchar',
          'length' => '255',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'integer',
            'req' => 1,
            'title' => 'Код',
            'trimNE' => 'Поле "Код" не должно быть пустым',
          ),
        ),
        'in_list' => 
        array (
          'type' => 'enum(\'yes\',\'no\')',
          'default' => 'no',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'title' => 'Отображать в списке стран',
            'htmltype' => 'checkbox',
            'default' => 'no',
            'checked' => 'yes',
            'unchecked' => 'no',
            'values' => 
            array (
              'no' => 'нет',
              'yes' => 'да',
            ),
          ),
        ),
        'source' => 
        array (
          'type' => 'enum(\'yes\',\'no\')',
          'default' => 'no',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'title' => 'Отображать в списке стран источников',
            'htmltype' => 'checkbox',
            'default' => 'no',
            'checked' => 'yes',
            'unchecked' => 'no',
            'values' => 
            array (
              'no' => 'нет',
              'yes' => 'да',
            ),
          ),
        ),
        'receiver' => 
        array (
          'type' => 'enum(\'yes\',\'no\')',
          'default' => 'no',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'title' => 'Отображать в списке стран приемников',
            'htmltype' => 'checkbox',
            'default' => 'no',
            'checked' => 'yes',
            'unchecked' => 'no',
            'values' => 
            array (
              'no' => 'нет',
              'yes' => 'да',
            ),
          ),
        ),
        'active' => 
        array (
          'type' => 'enum(\'yes\',\'no\')',
          'default' => 'yes',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'title' => 'Отображать на сайте',
            'htmltype' => 'checkbox',
            'default' => 'yes',
            'checked' => 'yes',
            'unchecked' => 'no',
            'values' => 
            array (
              'no' => 'нет',
              'yes' => 'да',
            ),
          ),
        ),
        'quotation' => 
        array (
          'type' => 'enum(\'red\',\'green\')',
          'default' => 'red',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'title' => 'Котировка',
            'htmltype' => 'checkbox',
            'default' => 'red',
            'checked' => 'red',
            'unchecked' => 'green',
            'values' => 
            array (
              'red' => 'красная',
              'green' => 'зеленая',
            ),
          ),
        ),
      ),
      'table' => 
      array (
        'PRIMARY KEY' => 'id',
        'KEYS' => 
        array (
          'pos' => 
          array (
            0 => 'pos',
          ),
          'active' => 
          array (
            0 => 'active',
          ),
        ),
      ),
      'actions' => 
      array (
        'list' => 
        array (
          0 => 'id',
          1 => 'pos',
          2 => 'title',
          3 => 'url',
          4 => 'price',
          5 => 'text',
          6 => 'flag',
          7 => 'in_list',
          8 => 'code',
          9 => 'source',
          10 => 'receiver',
          11 => 'active',
          12 => 'quotation',
        ),
        'show' => 
        array (
          0 => 'title',
          1 => 'url',
          2 => 'price',
          3 => 'price_final',
          4 => 'text',
          5 => 'flag',
          6 => 'in_list',
          7 => 'source',
          8 => 'receiver',
          9 => 'code',
          10 => 'active',
        ),
        'modify' => 
        array (
          0 => 'title',
          1 => 'url',
          2 => 'price',
          3 => 'price_final',
          4 => 'text',
          5 => 'flag',
          6 => 'in_list',
          7 => 'source',
          8 => 'receiver',
          9 => 'code',
          10 => 'active',
        ),
        'add' => 
        array (
          0 => 'pos',
          1 => 'title',
          2 => 'url',
          3 => 'price',
          4 => 'price_final',
          5 => 'text',
          6 => 'flag',
          7 => 'in_list',
          8 => 'source',
          9 => 'receiver',
          10 => 'code',
          11 => 'active',
        ),
        'site_list' => 
        array (
          0 => 'id',
          1 => 'pos',
          2 => 'title',
          3 => 'url',
          4 => 'price',
          5 => 'price_final',
          6 => 'text',
          7 => 'flag',
          8 => 'quotation',
          9 => 'code',
        ),
        'site_show' => 
        array (
          0 => 'id',
          1 => 'title',
          2 => 'price',
          3 => 'price_final',
          4 => 'text',
          5 => 'flag',
          6 => 'quotation',
          7 => 'code',
        ),
      ),
      'images' => 
      array (
        'flag' => 
        array (
          'small' => 
          array (
            'w' => 28,
            'h' => 20,
            'ratio' => 'x',
            'cut' => 0,
          ),
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
  ),
);
?>