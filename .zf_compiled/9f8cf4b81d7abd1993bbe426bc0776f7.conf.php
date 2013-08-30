<?php
$conf = array (
  'tables' => 
  array (
    'settings' => 
    array (
      'fields' => 
      array (
        'id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
          'auto_increment' => 1,
        ),
        'name' => 
        array (
          'type' => 'varchar',
          'length' => 20,
          'notnull' => 1,
        ),
        'value' => 
        array (
          'type' => 'text',
          'notnull' => 0,
        ),
      ),
      'table' => 
      array (
        'PRIMARY KEY' => 'id',
      ),
      'use_list' => 
      array (
      ),
    ),
    'images' => 
    array (
      'dont_install' => 1,
      'fields' => 
      array (
        'id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'auto_increment' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'integer',
          ),
        ),
        'model' => 
        array (
          'type' => 'varchar',
          'length' => 16,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Модель',
          ),
        ),
        'pid' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'integer',
            'htmltype' => 'hidden',
          ),
        ),
        'pos' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'unsigned' => 1,
          'am' => 
          array (
            'type' => 'integer',
            'htmltype' => 'hidden',
          ),
        ),
        'title' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'title' => 'Заголовок',
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
        'hidden' => 
        array (
          'type' => 'enum(\'yes\',\'no\')',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'title' => 'Скрытая',
            'htmltype' => 'radio',
            'default' => 'no',
            'values' => 
            array (
              'yes' => 'да',
              'no' => 'нет',
            ),
          ),
        ),
      ),
      'table' => 
      array (
        'PRIMARY KEY' => 'id',
      ),
      'use_list' => 
      array (
      ),
    ),
  ),
);
?>