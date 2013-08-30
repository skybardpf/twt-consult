<?php
$conf = array (
  'tables' => 
  array (
    'content' => 
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
        'pid' => 
        array (
          'type' => 'int',
          'length' => 10,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'integer',
            'title' => 'Родительский раздел',
            'htmltype' => 'select',
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
        'path' => 
        array (
          'type' => 'tinytext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Адрес страницы',
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
            'title' => 'Заголовок',
          ),
        ),
        'description' => 
        array (
          'type' => 'tinytext',
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'string',
            'req' => 0,
            'title' => 'Описание',
          ),
        ),
        'content' => 
        array (
          'type' => 'longtext',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'ckhtml',
            'htmltype' => 'ckhtml',
            'req' => 1,
            'title' => 'Текст',
          ),
        ),
        'hidden' => 
        array (
          'type' => 'enum(\'yes\',\'no\')',
          'default' => 'no',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'title' => 'Скрытый',
            'otitle' => 'Скрыть',
            'htmltype' => 'checkbox',
            'default' => 'no',
            'checked' => 'yes',
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
      ),
      'foreign' => 
      array (
        'pid_ttl' => 
        array (
          'table' => 'content',
          'field' => 'title',
          'use_ref' => 'content2content',
          'am' => 'pid',
        ),
      ),
      'actions' => 
      array (
        'list' => 
        array (
          0 => 'id',
          1 => 'pos',
          2 => 'path',
          3 => 'title',
          4 => 'hidden',
        ),
        'show' => 
        array (
          0 => 'pid',
          1 => 'path',
          2 => 'title',
          3 => 'hidden',
          4 => 'description',
          5 => 'content',
        ),
        'modify' => 
        array (
          0 => 'title',
          1 => 'pid',
          2 => 'path',
          3 => 'description',
          4 => 'content',
          5 => 'hidden',
        ),
        'modify_main' => 
        array (
          0 => 'title',
          1 => 'description',
          2 => 'content',
        ),
        'add' => 
        array (
          0 => 'pid',
          1 => 'title',
          2 => 'path',
          3 => 'pos',
          4 => 'description',
          5 => 'content',
          6 => 'hidden',
        ),
        'menu' => 
        array (
          0 => 'id',
          1 => 'pid',
          2 => 'path',
          3 => 'title',
          4 => 'description',
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
  ),
  'refs' => 
  array (
    'content2content' => 
    array (
      'type' => 'M-1',
      'self' => 
      array (
        0 => 'pid',
        1 => 'id',
      ),
      'join' => 'LEFT',
      'alias' => 'content_title',
    ),
  ),
);
?>