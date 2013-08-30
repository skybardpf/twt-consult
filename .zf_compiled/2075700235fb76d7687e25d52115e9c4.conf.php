<?php
$conf = array (
  'tables' => 
  array (
    'meta_tags' => 
    array (
      'fields' => 
      array (
        'id' => 
        array (
          'type' => 'int',
          'unsigned' => 1,
          'notnull' => 1,
          'auto_increment' => 1,
        ),
        'url' => 
        array (
          'type' => 'varchar',
          'length' => 255,
          'notnull' => 1,
          'am' => 
          array (
            'title' => 'url',
            'type' => 'string',
            'default' => '/',
            'req' => 1,
          ),
        ),
        'meta_title' => 
        array (
          'type' => 'text',
          'notnull' => 1,
          'am' => 
          array (
            'title' => 'Meta title',
            'type' => 'string',
            'req' => 0,
          ),
        ),
        'meta_keywords' => 
        array (
          'type' => 'text',
          'notnull' => 1,
          'am' => 
          array (
            'title' => 'Meta keywords',
            'type' => 'string',
            'req' => 0,
          ),
        ),
        'meta_description' => 
        array (
          'type' => 'text',
          'notnull' => 1,
          'am' => 
          array (
            'title' => 'Meta description',
            'type' => 'string',
            'req' => 0,
          ),
        ),
        'meta_additional' => 
        array (
          'type' => 'text',
          'notnull' => 1,
          'am' => 
          array (
            'title' => 'Дополнительные meta',
            'type' => 'raw_text',
          ),
        ),
        'isActive' => 
        array (
          'type' => 'enum(\'yes\',\'no\')',
          'default' => 'yes',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'title' => 'Включено',
            'htmltype' => 'checkbox',
            'default' => 'yes',
            'checked' => 'yes',
            'otitle' => '',
            'values' => 
            array (
              'yes' => 'да',
              'no' => 'нет',
            ),
            'attrs' => 
            array (
              'class' => 'auto_width',
            ),
          ),
        ),
      ),
      'table' => 
      array (
        'PRIMARY KEY' => 'id',
        'KEYS' => 
        array (
          'url' => 
          array (
            0 => 'url',
          ),
        ),
      ),
      'actions' => 
      array (
        'list' => 
        array (
          0 => 'id',
          1 => 'url',
          2 => 'meta_title',
          3 => 'meta_keywords',
          4 => 'meta_description',
          5 => 'isActive',
        ),
        'add' => 
        array (
          0 => 'url',
          1 => 'meta_title',
          2 => 'meta_keywords',
          3 => 'meta_description',
          4 => 'meta_additional',
          5 => 'isActive',
        ),
        'modify' => 
        array (
          0 => 'id',
          1 => 'url',
          2 => 'meta_title',
          3 => 'meta_keywords',
          4 => 'meta_description',
          5 => 'meta_additional',
          6 => 'isActive',
        ),
        'additional_fields' => 
        array (
          0 => 'meta_additional',
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
  ),
);
?>