<?php
$conf = array (
  'tables' => 
  array (
    'announcies' => 
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
        'created' => 
        array (
          'type' => 'date',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'date',
            'req' => 1,
            'title' => 'Дата загрузки',
          ),
        ),
        'title' => 
        array (
          'type' => 'varchar',
          'length' => 200,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Название баннера',
          ),
        ),
        'image' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'image',
            'req' => 1,
            'title' => 'Изображение',
          ),
        ),
        'url' => 
        array (
          'type' => 'tinytext',
          'am' => 
          array (
            'type' => 'string',
            'title' => 'URL',
          ),
        ),
        'type' => 
        array (
          'type' => 'enum(\'promo\',\'banner\')',
          'default' => 'banner',
          'am' => 
          array (
            'type' => 'radio',
            'title' => 'Тип баннера',
            'default' => 'banner',
            'values' => 
            array (
              'promo' => 'промо-баннер',
              'banner' => 'баннер',
            ),
          ),
        ),
        'static' => 
        array (
          'type' => 'enum(\'yes\',\'no\')',
          'default' => 'no',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'checkbox',
            'title' => 'Статический',
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
        'position' => 
        array (
          'type' => 'enum(\'top\',\'middle\',\'bottom\')',
          'default' => 'top',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'select',
            'title' => 'Позиция',
            'default' => 'top',
            'values' => 
            array (
              'top' => 'верхний',
              'middle' => 'средний',
              'bottom' => 'нижний',
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
            'type' => 'checkbox',
            'title' => 'Отображать на сайте',
            'otitle' => 'Отображать на сайте',
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
      ),
      'table' => 
      array (
        'PRIMARY KEY' => 'id',
        'KEYS' => 
        array (
          'title' => 
          array (
            0 => 'title',
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
          2 => 'created',
          3 => 'title',
          4 => 'image',
          5 => 'url',
          6 => 'type',
          7 => 'static',
          8 => 'position',
          9 => 'active',
        ),
        'add' => 
        array (
          0 => 'pos',
          1 => 'title',
          2 => 'image',
          3 => 'url',
          4 => 'type',
          5 => 'static',
          6 => 'position',
          7 => 'active',
        ),
        'modify' => 
        array (
          0 => 'pos',
          1 => 'title',
          2 => 'image',
          3 => 'url',
          4 => 'type',
          5 => 'static',
          6 => 'position',
          7 => 'active',
        ),
        'show' => 
        array (
          0 => 'pos',
          1 => 'created',
          2 => 'title',
          3 => 'image',
          4 => 'url',
          5 => 'type',
          6 => 'static',
          7 => 'position',
          8 => 'active',
        ),
        'site_list' => 
        array (
          0 => 'pos',
          1 => 'title',
          2 => 'image',
          3 => 'url',
          4 => 'static',
          5 => 'position',
        ),
      ),
      'images' => 
      array (
        'image' => 
        array (
          'resized' => 
          array (
            'w' => 338,
            'h' => 132,
            'ratio' => 'equal',
            'cut' => 5,
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