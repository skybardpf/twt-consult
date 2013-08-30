<?php
$conf = array (
  'tables' => 
  array (
    'siteusers' => 
    array (
      'fields' => 
      array (
        'id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'auto_increment' => 1,
          'am' => 
          array (
            'type' => 'integer',
            'title' => 'ID',
          ),
        ),
        'name' => 
        array (
          'type' => 'varchar',
          'length' => 255,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'ФИ',
            'validate' => 
            array (
              'trimNE' => 'Поле \'ФИ\' не должно быть пустым',
            ),
          ),
        ),
        'email' => 
        array (
          'type' => 'varchar',
          'length' => 80,
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'E-mail(логин)',
            'validate' => 
            array (
              'trimNE' => 'Поле \'E-mail(логин)\' не должно быть пустым',
            ),
          ),
        ),
        'password' => 
        array (
          'type' => 'varchar',
          'length' => 32,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'pass',
            'req' => 1,
            'title' => 'Пароль',
            'validate' => 
            array (
              'trimNE' => 'Поле \'Пароль\' не должно быть пустым',
            ),
          ),
        ),
        'password2' => 
        array (
          'am' => 
          array (
            'not_exists_in_db' => 1,
            'type' => 'pass',
            'req' => 1,
            'title' => 'Повторите пароль',
            'validate' => 
            array (
              'trimNE' => 'Поле \'Повторите пароль\' не должно быть пустым',
            ),
          ),
        ),
        'phone' => 
        array (
          'type' => 'varchar',
          'length' => 80,
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Телефон',
          ),
        ),
        'uniq_key' => 
        array (
          'type' => 'tinytext',
          'am' => 
          array (
            'type' => 'string',
            'title' => 'Уникальный ключ для смены пароля',
          ),
        ),
        'key_date' => 
        array (
          'type' => 'datetime',
          'am' => 
          array (
            'type' => 'datetime',
            'title' => 'Дата выдачи уникального ключа',
          ),
        ),
      ),
      'table' => 
      array (
        'PRIMARY KEY' => 'id',
      ),
      'actions' => 
      array (
        'list' => 
        array (
          0 => 'id',
          1 => 'name',
          2 => 'email',
          3 => 'phone',
        ),
        'add' => 
        array (
          0 => 'name',
          1 => 'email',
          2 => 'phone',
          3 => 'password',
        ),
        'modify' => 
        array (
          0 => 'name',
          1 => 'email',
          2 => 'phone',
        ),
        'show' => 
        array (
          0 => 'id',
          1 => 'name',
          2 => 'email',
          3 => 'password',
          4 => 'phone',
          5 => 'name',
          6 => 'name',
        ),
        'site_authorize' => 
        array (
          0 => 'email',
          1 => 'password',
        ),
        'site_reg' => 
        array (
          0 => 'name',
          1 => 'email',
        ),
        'user' => 
        array (
          0 => 'id',
          1 => 'name',
          2 => 'email',
          3 => 'phone',
        ),
        'login' => 
        array (
          0 => 'id',
          1 => 'name',
          2 => 'email',
          3 => 'phone',
        ),
        'cabinet' => 
        array (
          0 => 'name',
          1 => 'email',
          2 => 'phone',
        ),
        'change_pass' => 
        array (
          0 => 'password',
          1 => 'password2',
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
    'companies' => 
    array (
      'fields' => 
      array (
        'id' => 
        array (
          'type' => 'int',
          'notnull' => 1,
          'auto_increment' => 1,
          'am' => 
          array (
            'type' => 'integer',
            'title' => 'ID',
          ),
        ),
        'created' => 
        array (
          'type' => 'datetime',
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'date',
            'req' => 1,
            'title' => 'Дата создания',
          ),
        ),
        'name' => 
        array (
          'type' => 'varchar',
          'length' => 255,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Наименование организации',
            'validate' => 
            array (
              'trimNE' => 'Поле \'Наименование организации\' не должно быть пустым',
            ),
          ),
        ),
        'jur_address' => 
        array (
          'type' => 'varchar',
          'length' => 255,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Юр. адрес',
            'validate' => 
            array (
              'trimNE' => 'Поле \'Юр. адрес\' не должно быть пустым',
            ),
          ),
        ),
        'address' => 
        array (
          'type' => 'varchar',
          'length' => 255,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Фактический адрес',
            'validate' => 
            array (
              'trimNE' => 'Поле \'Фактический адрес\' не должно быть пустым',
            ),
          ),
        ),
        'inn' => 
        array (
          'type' => 'varchar',
          'length' => 12,
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'integer',
            'req' => 1,
            'title' => 'ИНН',
            'attrs' => 
            array (
              'maxlength' => 12,
            ),
            'validate' => 
            array (
              'trimNE' => 'Поле \'ИНН\' не должно быть пустым',
              'innInt' => 'Поле \'ИНН\' должно содержать 10 или 12 цифр',
            ),
          ),
        ),
        'kpp' => 
        array (
          'type' => 'varchar',
          'length' => 9,
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'integer',
            'req' => 1,
            'title' => 'КПП',
            'attrs' => 
            array (
              'maxlength' => 9,
            ),
            'validate' => 
            array (
              'trimNE' => 'Поле \'КПП\' не должно быть пустым',
              'kppInt' => 'Поле \'КПП\' должно содержать 9 цифр',
            ),
          ),
        ),
        'account' => 
        array (
          'type' => 'varchar',
          'length' => 20,
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Расчётный счет',
            'validate' => 
            array (
              'trimNE' => 'Поле \'Расчётный счет\' не должно быть пустым',
            ),
          ),
        ),
        'bank' => 
        array (
          'type' => 'varchar',
          'length' => 100,
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Банк',
            'validate' => 
            array (
              'trimNE' => 'Поле \'Банк\' не должно быть пустым',
            ),
          ),
        ),
        'bik' => 
        array (
          'type' => 'varchar',
          'length' => 9,
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'БИК',
            'validate' => 
            array (
              'trimNE' => 'Поле \'БИК\' не должно быть пустым',
            ),
          ),
        ),
        'korschot' => 
        array (
          'type' => 'varchar',
          'length' => 20,
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'КорСчет',
            'validate' => 
            array (
              'trimNE' => 'Поле \'КорСчет\' не должно быть пустым',
            ),
          ),
        ),
        'signer' => 
        array (
          'type' => 'varchar',
          'length' => 50,
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'Должность подписанта',
            'validate' => 
            array (
              'trimNE' => 'Поле \'Должность подписанта\' не должно быть пустым',
            ),
          ),
        ),
        'fio' => 
        array (
          'type' => 'varchar',
          'length' => 255,
          'notnull' => 0,
          'am' => 
          array (
            'type' => 'string',
            'req' => 1,
            'title' => 'ФИО подписанта',
            'validate' => 
            array (
              'trimNE' => 'Поле \'ФИО подписанта\' не должно быть пустым',
            ),
          ),
        ),
        'user_id' => 
        array (
          'type' => 'int',
          'length' => 10,
          'notnull' => 1,
          'am' => 
          array (
            'type' => 'integer',
            'title' => 'Пользователь',
            'htmltype' => 'select',
            'null' => 'Не выбранно',
          ),
        ),
      ),
      'table' => 
      array (
        'PRIMARY KEY' => 'id',
        'KEYS' => 
        array (
          'user_id' => 
          array (
            0 => 'user_id',
          ),
        ),
      ),
      'actions' => 
      array (
        'list' => 
        array (
          0 => 'id',
          1 => 'name',
          2 => 'jur_address',
          3 => 'address',
          4 => 'inn',
          5 => 'kpp',
          6 => 'fio',
          7 => 'user_id',
          8 => 'created',
        ),
        'add' => 
        array (
          0 => 'name',
          1 => 'jur_address',
          2 => 'address',
          3 => 'inn',
          4 => 'kpp',
          5 => 'account',
          6 => 'bik',
          7 => 'signer',
          8 => 'fio',
        ),
        'modify' => 
        array (
          0 => 'name',
          1 => 'jur_address',
          2 => 'address',
          3 => 'inn',
          4 => 'kpp',
          5 => 'account',
          6 => 'bik',
          7 => 'signer',
          8 => 'fio',
        ),
        'show' => 'all',
        'cabinet' => 
        array (
          0 => 'id',
          1 => 'name',
          2 => 'jur_address',
          3 => 'address',
          4 => 'inn',
          5 => 'kpp',
          6 => 'account',
          7 => 'bik',
          8 => 'signer',
          9 => 'fio',
          10 => 'created',
        ),
        'view' => 
        array (
          0 => 'name',
          1 => 'jur_address',
          2 => 'address',
          3 => 'inn',
          4 => 'kpp',
          5 => 'account',
          6 => 'bik',
          7 => 'signer',
          8 => 'fio',
        ),
      ),
      'use_list' => 
      array (
      ),
    ),
  ),
  'mail' => 
  array (
    'register' => 
    array (
      'from' => 'no_reply@twtconsult.com',
      'subject' => 'Вы зарегистрировались на сайте [site_name]',
      'type' => 'text/html',
      'message' => '<p>Уважаемый [name]!</p>
Вы зарегистрировались на сайте [site_name]. <br/>
Ваш логин для авторизации: [email]<br/>
Ваш пароль для авторизации: [pass]<br/>
<p>С уважением, [site_name]</p>',
    ),
    'register_admin' => 
    array (
      'from' => 'no_reply@twtconsult.com',
      'subject' => 'Новый пользователь на сайте',
      'type' => 'text/html',
      'message' => '<p>Уважаемый администратор!</p>
На сайте зарегистрировался новый пользователь [name] ([email]).<br/>',
    ),
    'remind_pass' => 
    array (
      'from' => 'no_reply@twtconsult.com',
      'subject' => '[site_name]: Восстановление пароля',
      'type' => 'text/html',
      'message' => '<p>Вы запросили восстановление пароля</p>
<hr>Перейдите по <a href="[link]">ссылке</a> и введите новый пароль.
<hr>
[DATE]<br>',
    ),
    'change_pass' => 
    array (
      'from' => 'no_reply@twtconsult.com',
      'subject' => '[site_name]: Смена пароля',
      'type' => 'text/html',
      'message' => '<p>Вы изменили пароль</p>
<hr>Ваш пароль: [pass].
<hr>
[DATE]<br>',
    ),
    'repl' => 
    array (
      'site_name' => 'TWT',
    ),
    'date_format' => 'H:i:s d.m.Y',
  ),
);
?>