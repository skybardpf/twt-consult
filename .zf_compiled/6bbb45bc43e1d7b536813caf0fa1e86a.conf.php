<?php
$conf = array (
  'types' => 
  array (
    'integer' => 
    array (
      'htmltype' => 'text',
      'validate' => 
      array (
        'is_numeric' => 'not_a_number',
      ),
    ),
    'float' => 
    array (
      'htmltype' => 'text',
      'validate' => 
      array (
        'is_numeric' => 'not_a_number',
      ),
    ),
    'string' => 
    array (
      'htmltype' => 'text',
      'spchars' => true,
      'validate' => 
      array (
        'is_string' => 'not_a_string',
      ),
      'allowed_tags' => false,
    ),
    'color' => 
    array (
      'htmltype' => 'color',
      'validate' => 
      array (
        'is_string' => 'not_a_string',
      ),
    ),
    'expr' => 
    array (
      'basetype' => 'string',
      'validate' => 
      array (
        'is_expr' => 'not_a_expr',
      ),
    ),
    'login' => 
    array (
      'spchars' => true,
      'basetype' => 'expr',
      'htmltype' => 'text',
      'validate' => 
      array (
        'is_unique' => 'not_a_unique',
      ),
    ),
    'mail' => 
    array (
      'spchars' => true,
      'htmltype' => 'mail',
      'validate' => 
      array (
        'is_mail' => 'mail_incorrect',
      ),
    ),
    'pass' => 
    array (
      'htmltype' => 'pass',
    ),
    'multimail' => 
    array (
      'spchars' => true,
      'htmltype' => 'multimail',
    ),
    'multiphone' => 
    array (
      'spchars' => true,
      'htmltype' => 'multimail',
    ),
    'doublemultitext' => 
    array (
      'spchars' => true,
      'htmltype' => 'doublemultitext',
    ),
    'raw_text' => 
    array (
      'htmltype' => 'textarea',
      'validate' => 
      array (
        'text' => 'not_a_text',
      ),
    ),
    'text' => 
    array (
      'spchars' => true,
      'htmltype' => 'textarea',
      'convert_rn' => true,
    ),
    'youtube_video' => 
    array (
      'htmltype' => 'text',
      'strip_tags' => true,
      'allowed_tags' => '<video><object><embed><param><iframe>',
    ),
    'time' => 
    array (
      'htmltype' => 'time',
      'validate' => 
      array (
        'time' => 'time_incorrect',
      ),
      'attrs' => 
      array (
        'class' => 'zf_time',
      ),
    ),
    'date' => 
    array (
      'htmltype' => 'date',
      'validate' => 
      array (
        'is_date' => 'date_incorrect',
      ),
      'attrs' => 
      array (
        'class' => 'zf_date',
      ),
    ),
    'arraystr' => 
    array (
      'htmltype' => 'arraystr',
      'validate' => 
      array (
        'is_string' => 'not_a_string',
      ),
    ),
    'datetime' => 
    array (
      'htmltype' => 'datetime',
      'validate' => 
      array (
        'is_datetime' => 'datetime_incorrect',
      ),
      'attrs' => 
      array (
        'class' => 'zf_datetime',
      ),
    ),
    'date_boxes' => 
    array (
      'basetype' => 'datetime',
      'htmltype' => 'date_boxes',
      'validate' => 
      array (
        'is_date_box' => 'date_incorrect',
      ),
    ),
    'ip' => 
    array (
      'basetype' => 'string',
      'htmltype' => 'text',
    ),
    'year' => 
    array (
      'htmltype' => 'year',
    ),
    'shtml' => 
    array (
      'htmltype' => 'shtml',
      'strip_tags' => true,
      'allowed_tags' => '<b><i><u><br><p><strong><em><span>',
      'features' => 
      array (
        0 => 'FullScreen',
        1 => '|',
        2 => 'Undo\',\'Redo\',\'Bold\',\'Italic\',\'Underline\',\'|\',\'Paste\',\'PasteText\',\'PasteWord\',\'|\',\'XHTMLSource',
      ),
      'validate' => 
      array (
        'allowed_tags' => '*shtml_allowed_tags',
      ),
      'prepare_for_db' => 
      array (
        'striptags' => '*shtml_allowed_tags',
      ),
    ),
    'html' => 
    array (
      'htmltype' => 'html',
      'allowed_tags' => '<b><i><u>',
      'features' => 
      array (
        0 => 'FullScreen',
        1 => '|',
        2 => 'Undo',
        3 => 'Redo',
        4 => '|',
        5 => 'Paragraph',
        6 => '|',
        7 => 'Bold',
        8 => 'Italic',
        9 => 'Underline',
        10 => '|',
        11 => 'Hyperlink',
        12 => 'Bookmark',
        13 => '|',
        14 => 'Image',
        15 => '|',
        16 => 'Paste',
        17 => 'PasteText',
        18 => 'PasteWord',
        19 => '|',
        20 => 'Numbering',
        21 => 'Bullets',
        22 => 'Indent',
        23 => 'Outdent',
        24 => '|',
        25 => 'Table',
        26 => 'Guidelines',
        27 => '|',
        28 => 'XHTMLSource',
      ),
      'addons' => 
      array (
        'AssetManager' => 'modalDialogShow(\'/public/zf/wysiwyg/assetmanager/assetmanager.php?appname={app_name}&apppath={app_path}\',640,445);',
      ),
      'validate' => 
      array (
        'allowed_tags' => '*html_allowed_tags',
      ),
      'prepare_for_db' => 
      array (
        'striptags' => '*html_allowed_tags',
      ),
    ),
    'ckhtml' => 
    array (
      'htmltype' => 'ckhtml',
      'toolbar' => 
      array (
        0 => 
        array (
          0 => 'Source',
          1 => '-',
          2 => 'Save',
          3 => 'NewPage',
          4 => 'Preview',
          5 => '-',
          6 => 'Templates',
        ),
        1 => 
        array (
          0 => 'Maximize',
          1 => 'ShowBlocks',
        ),
        2 => 
        array (
          0 => 'Cut',
          1 => 'Copy',
          2 => 'Paste',
          3 => 'PasteText',
          4 => 'PasteFromWord',
          5 => '-',
          6 => 'Print',
        ),
        3 => 
        array (
          0 => 'Undo',
          1 => 'Redo',
          2 => '-',
          3 => 'Find',
          4 => 'Replace',
          5 => '-',
          6 => 'SelectAll',
          7 => 'RemoveFormat',
        ),
        4 => '/',
        5 => 
        array (
          0 => 'Bold',
          1 => 'Italic',
          2 => 'Underline',
          3 => 'Strike',
          4 => '-',
          5 => 'Subscript',
          6 => 'Superscript',
        ),
        6 => 
        array (
          0 => 'NumberedList',
          1 => 'BulletedList',
          2 => '-',
          3 => 'Outdent',
          4 => 'Indent',
          5 => 'Blockquote',
          6 => 'CreateDiv',
        ),
        7 => 
        array (
          0 => 'JustifyLeft',
          1 => 'JustifyCenter',
          2 => 'JustifyRight',
          3 => 'JustifyBlock',
        ),
        8 => 
        array (
          0 => 'Link',
          1 => 'Unlink',
          2 => 'Anchor',
        ),
        9 => '/',
        10 => 
        array (
          0 => 'Image',
          1 => 'Flash',
          2 => 'Table',
          3 => 'HorizontalRule',
          4 => 'SpecialChar',
        ),
        11 => 
        array (
          0 => 'TextColor',
          1 => 'BGColor',
        ),
        12 => '/',
        13 => 
        array (
          0 => 'Styles',
          1 => 'Format',
          2 => 'Font',
          3 => 'FontSize',
        ),
      ),
    ),
    'radio' => 
    array (
      'htmltype' => 'radio',
      'attrs' => 
      array (
        'class' => 'zf_radio',
      ),
    ),
    'checkbox' => 
    array (
      'htmltype' => 'checkbox',
      'attrs' => 
      array (
        'class' => 'zf_radio',
      ),
    ),
    'checkboxes' => 
    array (
      'htmltype' => 'checkboxes',
      'attrs' => 
      array (
        'class' => 'zf_radio',
      ),
    ),
    'checkboxesarr' => 
    array (
      'htmltype' => 'checkboxesarr',
      'attrs' => 
      array (
        'class' => 'zf_radio',
      ),
    ),
    'select' => 
    array (
      'htmltype' => 'select',
    ),
    'tselect' => 
    array (
      'htmltype' => 'tselect',
    ),
    'geo' => 
    array (
      'htmltype' => 'geo',
    ),
    'mselect' => 
    array (
      'htmltype' => 'mselect',
      'attrs' => 
      array (
        'multiple' => 'true',
        'size' => 3,
      ),
    ),
    'metroselect' => 
    array (
      'htmltype' => 'metroselect',
    ),
    'captcha' => 
    array (
      'htmltype' => 'captcha',
    ),
    'placeholder' => 
    array (
      'htmltype' => 'placeholder',
    ),
    'file' => 
    array (
      'htmltype' => 'file',
      'allowed_ext' => 
      array (
        0 => 'pdf',
        1 => 'txt',
        2 => 'rtf',
        3 => 'jpg',
        4 => 'jpeg',
        5 => 'gif',
        6 => 'png',
        7 => 'eps',
        8 => 'ai',
        9 => 'cdr',
        10 => 'psd',
        11 => 'bmp',
        12 => 'tiff',
        13 => 'tif',
        14 => 'doc',
        15 => 'docx',
        16 => 'zip',
        17 => 'rar',
        18 => 'xls',
        19 => 'xlsx',
        20 => 'xlsm',
        21 => 'ppt',
        22 => 'pptx',
      ),
    ),
    'ckfile' => 
    array (
      'htmltype' => 'ckfile',
    ),
    'files' => 
    array (
      'htmltype' => 'files',
      'allowed_ext' => 
      array (
        0 => 'pdf',
        1 => 'txt',
        2 => 'rtf',
        3 => 'jpg',
        4 => 'jpeg',
        5 => 'gif',
        6 => 'png',
        7 => 'eps',
        8 => 'ai',
        9 => 'cdr',
        10 => 'psd',
        11 => 'bmp',
        12 => 'tiff',
        13 => 'tif',
        14 => 'doc',
        15 => 'docx',
        16 => 'zip',
        17 => 'rar',
        18 => 'xls',
        19 => 'xlsx',
        20 => 'xlsm',
        21 => 'ppt',
        22 => 'pptx',
      ),
    ),
    'mfiles' => 
    array (
      'htmltype' => 'mfiles',
      'allowed_ext' => 
      array (
        '[pdf, txt, rtf, jpg, jpeg, gif, png, eps, ai, cdr, psd, bmp, tiff, tif, doc, docx, zip, rar, xls, xlsx, xlsm, ppt, pptx]}#attrs' => '{maxlength: 2',
      ),
      'accept' => 'gif|jpg|exe',
    ),
    'flash' => 
    array (
      'htmltype' => 'file',
      'allowed_ext' => 
      array (
        0 => 'swf',
      ),
    ),
    'spfile' => 
    array (
      'htmltype' => 'file',
      'allowed_ext' => 
      array (
      ),
    ),
    'image' => 
    array (
      'htmltype' => 'image',
      'allowed_ext' => 
      array (
        0 => 'png',
        1 => 'gif',
        2 => 'jpg',
        3 => 'jpeg',
      ),
      'crop' => 0,
      'cropdir' => 'original',
      'icon' => 
      array (
        'w' => 80,
        'h' => 80,
        'ratio' => 'y',
        'cut' => 1,
      ),
    ),
    'images' => 
    array (
      'htmltype' => 'images',
      'allowed_ext' => 
      array (
        0 => 'png',
        1 => 'gif',
        2 => 'jpg',
        3 => 'jpeg',
      ),
      'icon' => 
      array (
        'w' => 100,
        'h' => 100,
        'ratio' => true,
        'cut' => 0,
      ),
    ),
    'audio' => 
    array (
      'htmltype' => 'audio',
      'allowed_ext' => 
      array (
        0 => 'mp3',
        1 => 'wav',
      ),
      'optimized_defaults' => 
      array (
        'mp3' => 
        array (
          'ar' => 48000,
          'ab' => '128k',
          'ext' => 'mp3',
        ),
      ),
    ),
    'video' => 
    array (
      'htmltype' => 'video',
      'allowed_ext' => 
      array (
        0 => 'avi',
        1 => 'wmv',
        2 => 'flv',
        3 => 'mp4',
        4 => 'mov',
        5 => 'moov',
        6 => 'mpe',
        7 => 'mpeg',
        8 => 'mpeg4',
        9 => 'mpg',
        10 => '3gp',
        11 => 'divx',
        12 => 'dvx',
        13 => 'rv',
        14 => 'qt',
      ),
      'optimized_defaults' => 
      array (
        'preview' => 
        array (
          'ss' => '00:00:05',
          'vframes' => 1,
          'ext' => 'jpg',
        ),
        'low' => 
        array (
          'ab' => '32k',
          'ar' => 22050,
          'ext' => 'flv',
        ),
        'high' => 
        array (
          'vcodec' => 'libx264',
          'threads' => 0,
          'vpre' => 'normal',
          'b' => '2000k',
          'ar' => 48000,
          'ab' => '192k',
          'ext' => 'mp4',
        ),
      ),
    ),
    'pos' => 
    array (
      'htmltype' => 'hidden',
    ),
    'mobile_phone' => 
    array (
      'htmltype' => 'mobilephone',
      'codes' => 
      array (
        0 => 1,
        1 => 7,
        2 => 20,
        3 => 27,
        4 => 30,
        5 => 31,
        6 => 32,
        7 => 33,
        8 => 34,
        9 => 36,
        10 => 39,
        11 => 40,
        12 => 41,
        13 => 43,
        14 => 44,
        15 => 45,
        16 => 46,
        17 => 47,
        18 => 48,
        19 => 49,
        20 => 51,
        21 => 52,
        22 => 53,
        23 => 54,
        24 => 55,
        25 => 56,
        26 => 57,
        27 => 58,
        28 => 60,
        29 => 61,
        30 => 62,
        31 => 63,
        32 => 64,
        33 => 65,
        34 => 66,
        35 => 81,
        36 => 82,
        37 => 84,
        38 => 86,
        39 => 90,
        40 => 91,
        41 => 92,
        42 => 93,
        43 => 94,
        44 => 95,
        45 => 98,
        46 => 211,
        47 => 212,
        48 => 213,
        49 => 216,
        50 => 218,
        51 => 220,
        52 => 221,
        53 => 222,
        54 => 223,
        55 => 224,
        56 => 225,
        57 => 226,
        58 => 227,
        59 => 228,
        60 => 229,
        61 => 230,
        62 => 231,
        63 => 232,
        64 => 233,
        65 => 234,
        66 => 235,
        67 => 236,
        68 => 237,
        69 => 238,
        70 => 239,
        71 => 240,
        72 => 241,
        73 => 242,
        74 => 243,
        75 => 244,
        76 => 245,
        77 => 246,
        78 => 248,
        79 => 249,
        80 => 250,
        81 => 251,
        82 => 252,
        83 => 253,
        84 => 254,
        85 => 255,
        86 => 256,
        87 => 257,
        88 => 258,
        89 => 260,
        90 => 261,
        91 => 262,
        92 => 263,
        93 => 264,
        94 => 265,
        95 => 266,
        96 => 267,
        97 => 268,
        98 => 269,
        99 => 290,
        100 => 291,
        101 => 297,
        102 => 298,
        103 => 299,
        104 => 350,
        105 => 351,
        106 => 352,
        107 => 353,
        108 => 354,
        109 => 355,
        110 => 356,
        111 => 357,
        112 => 358,
        113 => 359,
        114 => 370,
        115 => 371,
        116 => 372,
        117 => 373,
        118 => 374,
        119 => 375,
        120 => 376,
        121 => 377,
        122 => 378,
        123 => 380,
        124 => 381,
        125 => 382,
        126 => 385,
        127 => 386,
        128 => 387,
        129 => 389,
        130 => 420,
        131 => 421,
        132 => 423,
        133 => 500,
        134 => 501,
        135 => 502,
        136 => 503,
        137 => 504,
        138 => 505,
        139 => 506,
        140 => 507,
        141 => 508,
        142 => 509,
        143 => 590,
        144 => 591,
        145 => 592,
        146 => 593,
        147 => 594,
        148 => 595,
        149 => 596,
        150 => 597,
        151 => 598,
        152 => 599,
        153 => 670,
        154 => 672,
        155 => 673,
        156 => 674,
        157 => 675,
        158 => 676,
        159 => 677,
        160 => 678,
        161 => 679,
        162 => 680,
        163 => 681,
        164 => 682,
        165 => 683,
        166 => 685,
        167 => 686,
        168 => 687,
        169 => 688,
        170 => 689,
        171 => 690,
        172 => 691,
        173 => 692,
        174 => 850,
        175 => 852,
        176 => 853,
        177 => 855,
        178 => 856,
        179 => 880,
        180 => 886,
        181 => 960,
        182 => 961,
        183 => 962,
        184 => 963,
        185 => 964,
        186 => 965,
        187 => 966,
        188 => 967,
        189 => 968,
        190 => 970,
        191 => 971,
        192 => 972,
        193 => 973,
        194 => 974,
        195 => 975,
        196 => 976,
        197 => 977,
        198 => 992,
        199 => 993,
        200 => 994,
        201 => 995,
        202 => 996,
        203 => 998,
      ),
    ),
    'separator' => 
    array (
      'htmltype' => 'separator',
    ),
    'link2smth' => 
    array (
      'htmltype' => 'link2smth',
    ),
    'fieldset' => 
    array (
      'htmltype' => 'fieldset',
    ),
    'label' => 
    array (
      'htmltype' => 'label',
    ),
  ),
);
?>