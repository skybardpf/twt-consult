<?php
/**
 * This file contains form class
 *
 * @version 1.0, SVN: $Id: form.class.php 42 2009-09-08 15:06:04Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com)
 * @category Framework
 * @package zFramework
 * @subpackage form

 */

/**
 * Class for dealing with forms
 *
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */
class form
{
	/**
	 * Array from values of fields should to be taken
	 *
	 * @var array
	 */
	private $arr;

	/**
	 * Array of form elements
	 *
	 * @var array
	 */
	public $elArr;

	/**
	 * Stores count of elements array
	 *
	 * @var integer
	 */
	public $elArrCount = 0;

	/**
	 * Stores keys of elements array
	 *
	 * @var array
	 */
	public $elArrKeys = 0;

	/**
	 * Current input name beeing processed
	 *
	 * @var string
	 */
	public $inpName;

	/**
	 * Stores action of the form
	 *
	 * @var string
	 */
    public $action;

    /**
     * Stores id of the form
     *
     * @var string
     */
	public $id;

	/**
	 * Stores method of the form
	 *
	 * @var string
	 */
	public $post;

	/**
	 * Determine whether form should assign id to its elements automatically
	 *
	 * @var boolean
	 */
	private $use_ids;

	/**
	 * Name of the form
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Stores whether validation failed
	 *
	 * @var boolen
	 */
	public $fail;

	/**
	 * Stores errors
	 *
	 * @var array
	 */
	protected $errors = array();

	/**
	 * Stores configuration of the form
	 *
	 * @var array
	 */
	private $conf = array();

	private $caller = null;
	private $model  = '';
	/**
	 * @var Controller
	 */
	public $ctrl    = null;

	public $last_error = '';

	protected $dont_use_id = array('checkbox', 'radio');

	/**
	 * Stores elements groups
	 *
	 * @var array
	 */
	protected $groups = array();

	protected $skeep = array();

	/**
	 * Current group
	 *
	 * @var string
	 */
	protected $currGroup = '';

	protected $num = null;

	protected $method = '';

	/**
	 * Constructor
	 *
	 * @param mixed $arr Array from values of fields should to be taken
	 * @param array $elements Form elements to load
	 * @param string $action
	 * @param string $formName
	 * @param string $method
	 * @param array $conf
	 * @param boolean $use_ids Determine whether form should assign id to its elements automatically
	 * @return form
	 */
	public function __construct($arr, $elements = array(), $action = '', $formName = '', $method = 'post', $conf = array(), $use_ids = true, $target = null, $id = null)
	{
		$this->arr     = $arr;
		$this->fail    = 0;
        $this->action  = $action;
		$this->id      = empty($id) ? $formName.'_form' : $id;
		$this->method  = $method;
		$this->target  = $target;
		$this->name    = $formName;
		$this->conf    = $conf;
		$this->use_ids = $use_ids;
		if ($elements) $this->loadElements($elements);
		zf::addJS('zf.form', '/public/zf/js/form.js');
	}

	/**
	 * Returns html code of the form
	 *
	 * @return string
	 */
	public function getHeader()
	{
		$app = zf::gi()->app;
		$encoding = !empty($app->conf['charset']) ? " accept-charset=\"{$app->conf['charset']}\"" : '';
		return "<form$encoding enctype=\"multipart/form-data\" name=\"{$this->name}\" action=\"{$this->action}\" id=\"{$this->id}\" method=\"{$this->method}\" target=\"{$this->target}\">";
	}

	/**
	 * Loads elements into the form object
	 *
	 * @param array $elements
	 * @return void
	 */
	public function loadElements($elements) {
		foreach ($elements as $key => $val) {
			if (strpos($key, 'form_groups') === 0) {
				foreach ($val as $groupName => $group) {
					$this->groups[$groupName] = array(
						'title'    => $group['title'],
						'complete' => 1,
						'elements' => $group['elements']
					);

					foreach ($group['elements'] as $elementName) {
						if (!empty($this->elArr[$elementName])) {
							$this->elArr[$elementName]['group'] = $groupName;
						} else {
							$this->groups[$groupName]['complete'] = 0;
						}
					}
				}
				continue;
			}
			if ($key === 'skeep') {
				$this->skeep = $val;
				continue;
			}
			if (!is_array($val) || !array_key_exists('name', $val)) $val['name'] = $key;
			if (!is_array($val) || !array_key_exists('default', $val)) $val['default'] = '';

			if (!array_key_exists('input', $val) && !empty($val['type'])) {
				$val['input'] = !empty($val['htmltype']) ? $val['htmltype'] : zf::$types['types'][$val['type']]['htmltype'];
			} else {
				$val['input'] = !empty($val['htmltype']) ? $val['htmltype'] : 'hidden';
			}
			if (empty($val['type'])) $val['type'] = '';

			if (!isset($val['value'])) {
				switch ($val['type']) {
					case 'image':
					case 'images':
					case 'file':
					case 'flash':
					case 'files':
                    case 'mfiles':
					case 'video':
					case 'audio':
                        if ($_FILES && $_FILES[$key]['error'] != 4) {
							$val['value'] = $_FILES ? $_FILES[$val['name']]['tmp_name'] : '/public/img/no_image.gif';
							$val['file']  = $_FILES[$val['name']];
							break;
						} else {
							$val['file'] = array(
                                'name'     => '',
                                'tmp_name' => '',
                                'type'     => ''
                                );
						}

					default:
                        $val['value'] = misc::htmlspecialchars_deep(misc::htmlspecialchars_decode_deep($this->convert($val,
                        isset($this->arr[$val['name']])
						?
						$this->arr[$val['name']]
						:
						(isset($val['default']) ? $val['default'] : '')
						)));
				}
			}


			if (!empty($val['req'])) {
				if (!empty($val['validate'])) {
					$val['validate'] = array_merge(array('not_empty' => 'mustbe_filled'), $val['validate']);
				} else {
					$val['validate']['not_empty'] = 'mustbe_filled';
				}
			}

			if ($val['type'] == 'captcha') {
				$val['validate']['captcha'] = 'captcha_error';
			}

			if (($val['type'] == 'arraystr') && !$val['value']) {
				$val['value'] = '';
			}

            if (($val['type'] == 'checkboxesarr') && !$val['value']) {
                $val['value'] = array();
            }

			if (!empty($val['values']) && $val['input'] == 'checkboxes')  {
				$val['length'] = count($val['values']);
			}
            
			$this->elArr[$val['name']] = $val;
            
            if ($val['type'] == 'fieldset' && !empty($val['elements'])) {
                $fieldset_tmp[$val['name']] = $val['elements'];
            }
			if (!empty($val['make_array'])) {
				$this->elArr[$val['name']]['name'] .= '[]';
			}
		}

		/** Сделаем элементы fieldset-а и уберем их из элементов формы. */
        if (!empty($fieldset_tmp) /*&& empty($_POST)*/) {
            foreach($fieldset_tmp as $k => $tmp){
                foreach($tmp as $v){
                    $this->elArr[$k]['elements'][$v] = $this->elArr[$v];
                    unset($this->elArr[$v]);
                }
                
            }
        }
        
		$this->elArrCount          = count($this->elArr);
		$this->elArrKeys           = array_keys($this->elArr);

		foreach ($this->groups as $groupName => $group) {
			if ($group['complete']) continue;
			foreach ($group['elements'] as $elementName) {
				$this->elArr[$elementName]['group'] = $groupName;
			}
		}
	}

	/**
	 * Returns elements' names loaded to form
	 *
	 * @return array
	 */
	public function getElNames()
	{
		return array_keys($this->elArr);
	}

	/**
	 * Converts attributes array into its string representation
	 *
	 * @param array $attrArr
	 * @return string
	 */
	private function convertAttrs($attrArr)
	{
		$ret = array();
		foreach ($attrArr as $key => $val) {
			if (is_array($val)) {
				$tmp_val = '';
				foreach ($val as $v) {
					if (is_numeric($v)) {
						$tmp_val += $v;
					} else {
						$tmp_val .= $v.' ';
					}
				}
				$val = $tmp_val;
			}
			$ret[] = "$key=\"$val\"";
		}
		return implode(" ", $ret);
	}

	public function getData()
	{
		$ret = array();
		if (empty($this->elArr)) return $ret;
		foreach ($this->elArr as $key => $val) {
			switch ($val['type']) {
				case 'date_boxes':
                    $ret[$key] = "{$val['value']['year']}-{$val['value']['month']}-{$val['value']['day']}".(empty($val['only_date']) ? " {$val['value']['hours']}:{$val['value']['mins']}:{$val['value']['secs']}": "");
                    break;
                case 'mobile_phone':
                    $ret[$key] = '+'.$val['value']['code'].$val['value']['number'];
                    break;
                case 'pass':
					$ret[$key] = md5($this->arr[$key]);
					break;
				case 'flash':
				case 'image':
				case 'file':
				case 'video':
				case 'audio':
					$ret[$key] = array(
						'name' => $val['file']['name'],
						'tmp_name' => $val['file']['tmp_name'],
						'type' => $val['file']['type']
					);
					break;
                case 'mfiles':
				case 'files':
				case 'images':
					if (is_array($val['file']['name'])) {
						for ($i = 0; $i < count($val['file']['name']); $i++) {
							$ret[$key][] = array(
                            'name' => $val['file']['name'][$i],
                            'tmp_name' => $val['file']['tmp_name'][$i],
                            'type' => $val['file']['type'][$i]
							);
						}
					}
					break;
				case 'arraystr':
					if (!trim($val['value'])) {
						$ret[$key] = array();
					} else {
						$tmp = explode(isset($val['delim']) ? $val['delim'] : ',', strip_tags($val['value']));
						$tmp_ret = array();
						foreach($tmp as $tmp_item) {
							$tmp_2 = trim($tmp_item);
							if (isset($val['add_trim'])) { $tmp_2 = trim($tmp_2, $val['add_trim']); }
							$tmp_ret[] = $tmp_2;
						}
						$ret[$key] = $tmp_ret;
						unset($tmp, $tmp_ret , $tmp_2, $tmp_item);
					}
					break;
                case 'checkboxesarr':
                    if (empty($val['value'])) {
                        $ret[$key] = '';
                    } else {
                        $tmp = implode(isset($val['delim']) ? $val['delim'] : ', ', $val['value']);
                        $ret[$key] = $tmp;
                        unset($tmp);
                    }
                    break;
				case 'placeholder':
                case 'separator':
                case 'fieldset':
					break;
				default:
					$ret[$key] = isset($this->arr[$key]) ? $this->convert($val, $this->arr[$key]) : $val['value'];
					break;
			}
			if (!empty($this->elArr[$key]['spchars'])) {
				$ret[$key] = misc::htmlspecialchars_deep($ret[$key]);
			}
		}//debug::dump($ret);
		return $ret;
	}

	public function getRetForGroup($inpName = null, $last = 0)
	{
		if ($inpName === null) {
			$inpName = $this->inpName;
		}

		$inpGroup = empty($this->elArr[$inpName]['group']) ? '' : $this->elArr[$inpName]['group'];

		if ($inpGroup && !$this->currGroup) {
			$this->currGroup = $this->elArr[$inpName]['group'];
			$ret             = str_replace(array('{title}', '{id}'), array($this->groups[$this->currGroup]['title'], $this->currGroup), $this->conf['group']['start']);
		} elseif ($inpGroup && $this->currGroup && ($inpGroup != $this->currGroup)) {
			$ret             = str_replace(array('{title}', '{id}'), array($this->groups[$this->currGroup]['title'], $this->currGroup), $this->conf['group']['end']);
			$this->currGroup = $inpGroup;
			$ret            .= str_replace(array('{title}', '{id}'), array($this->groups[$this->currGroup]['title'], $this->currGroup), $this->conf['group']['start']);
		} elseif ((!$inpGroup || $last) && $this->currGroup) {
			$ret             = str_replace(array('{title}', '{id}'), array($this->groups[$this->currGroup]['title'], $this->currGroup), $this->conf['group']['end']);
			$this->currGroup = '';
		} else {
			$ret             = '';
		}
		return $ret;
	}

	/**
	 * Returns html code of form input element according to its type
	 *
	 * @param string $inpName
	 * @param array $attrs
	 * @return string
	 */
	public function getInput($inpName, $attrs = array(), $force_skeep = 0, $simple = 0, $num = null)
	{
		if (in_array($inpName, $this->skeep) && !$force_skeep) return '';
		if ($this->elArr[$inpName]['input'] == 'hidden') {
			$attrs   = array_merge(
			isset($this->elArr[$inpName]['attrs']) ? $this->elArr[$inpName]['attrs'] : array(),
			$attrs);
			$attrStr = $attrs ? $this->convertAttrs($attrs) : '';
			return call_user_func(array($this, 'get_hidden_input'), $this->elArr[$inpName], $attrStr);
		}
		$this->num = $num;

		if($this->elArr[$inpName]['type'] == 'arraystr' and is_array($this->elArr[$inpName]['value'])) {
			$this->elArr[$inpName]['value'] = implode((!empty($this->elArr[$inpName]['delim'])? ($this->elArr[$inpName]['delim'].' ') : ', '), misc::array_extract_field($this->elArr[$inpName]['value'], $this->elArr[$inpName]['field_name']));
		}

        if($this->elArr[$inpName]['type'] == 'checkboxesarr') {
            $this->elArr[$inpName]['value'] = explode((!empty($this->elArr[$inpName]['delim'])? ($this->elArr[$inpName]['delim'].' ') : ', '), $this->elArr[$inpName]['value']);
        }

		$ret = $this->getRetForGroup($inpName);

		$method  = "get_{$this->elArr[$inpName]['input']}_input";
		$attrs   = array_merge(
		isset($this->elArr[$inpName]['attrs']) ? $this->elArr[$inpName]['attrs'] : array(),
		$attrs);
		$attrStr = $attrs ? $this->convertAttrs($attrs) : '';

		if ($this->use_ids && empty($this->elArr[$inpName]['attrs']['id']) && !in_array(misc::get($this->elArr[$inpName], 'type'), $this->dont_use_id)) {
			$attrStr = ' id="'.$this->getId($inpName).'" '.$attrStr;
		}
        
        $ret .= !empty($this->conf['input']) && !$simple
		    ? str_replace(
                '{input}',
                call_user_func(array($this, $method), $this->elArr[$inpName], $attrStr),
		        $this->conf[!empty($this->elArr[$inpName]['hide']) ? 'input_hidden' : 'input']
            )
		    : call_user_func(array($this, $method), $this->elArr[$inpName], $attrStr);

        $this->inpName = $inpName;
		if ($this->num !== null) $this->num = null;
		return  $ret;
	}

	/**
	 * Validates entered data. Returns true if validation passed and false otherwise
	 *
	 * @param mixed $stop_on_first_error 0 - don't stop, 1 - 1 error for each checked field, 2 - stop on first error
	 * @return boolean
	 */
	public function validate($model = null, $stop_on_first_error = 1)
	{
		foreach ($this->elArr as $key => &$val) {
			if (!isset($val['validate']) || empty($val['title'])) continue;
			if (empty($val['validate']['not_empty'])  && empty($val['value'])) continue;

			foreach ($val['validate'] as $validator => $body) {
				if (!is_array($body)) {
					$message = $body;
					$param   = null;
				} else {
					list($param, $message) = $body;
				}
				if (function_exists($validator)) {
					$ret = call_user_func($validator, $val['value']);
				} elseif (method_exists($this, 'validator'.ucfirst($validator))) {
					$ret = call_user_func(array($this, 'validator'.ucfirst($validator)), $key, $val['value'], $param);
				} elseif (method_exists($model, 'validator'.ucfirst($validator))) {
					$ret = call_user_func(array($model, 'validator'.ucfirst($validator)), $key, $val['value'], $param, $this->getData());
					if (is_array($ret)) {
						list($ret, $message) = $ret;
					}
				} else {
					continue;
				}
				if (!$ret) {
					$this->fail = 1;
					$val['error'] = $this->last_error = $this->errors[$key] = lang::has($message)
						? lang::p($message, '{title}', defined('USE_LOCALIZATION') ? gettext($val['title']) : $val['title'])
						: str_replace('{title}', defined('USE_LOCALIZATION') ? gettext($val['title']) : $val['title'], $message);

					if ($stop_on_first_error == 2) return 0;
					if ($stop_on_first_error == 1) break;
				}
			}
		}
		return 1 - $this->fail;
	}

	/**
	 * Returns errors occured
	 *
	 * @return array
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * Validates regexp
	 *
	 * @param mixed $field
	 * @param mixed $value
	 * @param string $reg
	 * @return boolean
	 */
	private function validatorRegexp($field, $value, $reg)
	{
		$ret = preg_match($reg, $value);
		debug::add('validating '.$field.' = '.$value.' with regexp '.$reg.' result: '.var_export($ret, true), 'validator');
		return $ret;
	}

    /** Validates int for min and max values
     *
     * @param $field
     * @param $value
     * @param $param
     * @return bool
     */
    public function validatorIntCheck($field, $value, $param) {
        $ret = true;
        if (isset($param['less'])) $ret = $ret && (intval($value) < $param['less']);
        if (isset($param['not_bigger'])) $ret = $ret && (intval($value) <= $param['not_bigger']);
        if (isset($param['bigger'])) $ret = $ret && (intval($value) > $param['bigger']);
        if (isset($param['not_less'])) $ret = $ret && (intval($value) >= $param['not_less']);
        return $ret;
    }

	/** Validates string for min and max length
     *
     * @param $field
     * @param $value
     * @param $param
     * @return bool
     */
    public function validatorStringlen($field, $value, $param) {
        $ret = true;
	    $length = mb_strlen($value);
	    if (isset($param['equal'])) {
		    $ret = $length == $param['equal'];
		    debug::add('validating '.$field.' for mb_strlen: '.$length.' : '.var_export($ret, true), 'validator');
		    return $ret;
	    }
        if (isset($param['less'])) $ret = $ret && ($length < $param['less']);
        if (isset($param['not_bigger'])) $ret = $ret && ($length <= $param['not_bigger']);
        if (isset($param['bigger'])) $ret = $ret && ($length > $param['bigger']);
        if (isset($param['not_less'])) $ret = $ret && ($length >= $param['not_less']);
	    debug::add('validating '.$field.' for mb_strlen: '.$length.' : '.var_export($ret, true), 'validator');
        return $ret;
    }

	public function validatorFile_size($field, $value, $param) {
		$ret = true;
		if (!empty($_FILES[$field])) {
			$val = $_FILES[$field]['size'];
			$ret = $this->validatorIntCheck($field, $val, $param);
		}
		return $ret;
	}

	/**
	 *
	 */
	private function validatorIs_path($key, $value, $param)
	{
		return !(preg_match("~[^a-z0-9_-]~", $value));
	}

    private function validatorTrimNE($key, $value, $param)
    {
        if(is_array($value)) {
            $not_empty = false;
            foreach($value as $k=>$v) {
                if(!empty($v)) {
                    $not_empty = true;
                }
            }
            return $not_empty;
        } else {
            return trim($value);
        }
    }

	/**
	 * Validates unique
	 *
	 * @param mixed $value
	 * @param string $field Field name
	 * @return boolean
	 */
	private function validatorUnique_old($value, $field)
	{
		return $this->caller->checkUnique($this->model, $field, $value);
	}

	/**
	 * Validates Is_image
	 *
	 * @param mixed $value
	 * @param string $field Field name
	 * @return boolean
	 */
	private function validatorIs_image($value, $field)
	{
		$img = zf::gi()->files[$field];
		if (misc::get(explode('/', $img['type']), 0) != 'image') return 0;
		return 1;
	}

	/**
	 * Validates mail
	 *
	 * @param string $value
	 * @return boolean
	 */
	private function validatorIs_mail($key, $value, $param)
	{
		return (preg_match(')^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$)', $value));
	}

	private function getByType($type, $fld = null)
	{
		$element = array();
		foreach ($this->elArr as $el) {
			if ($el['type'] == $type) {
				$element = $el;
				break;
			}
		}
		if (!$element) return null;
		if ($fld !== null) return $element[$fld];
		return $element;
	}

	/**
	 * Validates mail
	 *
	 * @param string $value
	 * @return boolean
	 */
	private function validatorIs_re_mail($key, $value)
	{
		return $value == $this->getByType('mail', 'value');
	}

	/**
	 * Validates password
	 *
	 * @param string $value
	 * @return boolean
	 */
	private function validatorRe_pass($key, $value)
	{
		return $value == $this->getByType('pass', 'value');
	}

	private function validatorCaptcha($field, $value)
	{
		return $value == misc::get($_SESSION, 'zf_kcaptcha_key') ? 1 : 0;
	}

	private function validatorNot_empty($elementName, $value)
	{
		$element = $this->elArr[$elementName];
		if (($element['type'] == 'file' || $element['type'] == 'image' || $element['type'] == 'images' || $element['type'] == 'flash' || $element['type'] == 'video' || $element['type'] == 'audio') && zf::gi()->app->request->id) return 1;
		if ($value === 'null') return 0;
		return $value === '0' ? 1 : (1 && $value);
	}

	private function validatorDatetime($elementName, $value)
	{
		return preg_match(zf::gi()->app->conf['formats']['datetime'], $value);
	}

	private function validatorDate($elementName, $value)
	{
		return preg_match(zf::gi()->app->conf['formats']['date'], $value);
	}
    private function validatorIs_date_box($elementName, $value)
	{
		if ((empty($value['year']) && empty($value['month']) && empty($value['day'])) || !($value['year'] || $value['month'] || $value['day'])) return true;
        if (empty($value['year']) || empty($value['month']) || empty($value['day'])) return false;
        $tmp = "{$value['year']}-{$value['month']}-{$value['day']}";
		$ret = strtotime($tmp);
		debug::add('validating '.$elementName.' for date: '.$tmp.' : '.var_export((boolean)$ret ? date('Y.m.d', $ret) : $ret, true), 'validator');
		return (boolean)$ret;
	}
    private function validatorIs_in_future($elementName, $value) {
        // Если это дата (не дата/время) то нужно завтра
        if ($this->elArr[$elementName]['type'] == 'date') {
            return strtotime($value) > strtotime(date('Y-m-d', time())) + 24*3600;
        } else {
            return strtotime($value) > time();
        }
    }

	/**
	 * Returns html code of label element
	 *
	 * @param mixed $inp
	 * @param integer $num
	 * @return string
	 */
	public function getLabel($inp, $attrs=false, $num = null, $force_skeep = 0) {
		if (in_array($inp, $this->skeep) && !$force_skeep) return '';

		$inpName = is_array($inp) ? $inp['name'] : $inp;
		if ($this->elArr[$inpName]['input'] == 'hidden') return '';
		$ret = $this->getRetForGroup($inpName);
		if (!is_array($inp)) $inp = $this->elArr[$inp];
		if (empty($inp['id'])) {
			$id = $this->getId($inp, $num);
		} else {
			$id = $inp['id'];
		}
		
		$attrStr = $attrs ? $this->convertAttrs($attrs) : '';

		if ($inp['input'] == 'link2smth') return '';
		if ($this->conf) {
			$ret .= str_replace(
			array('{id}', '{title}'),
			array($id, defined('USE_LOCALIZATION') ? gettext($inp['title']) : $inp['title']),
			$this->conf[!empty($inp['hide']) ? 'label_hidden' : 'label']
			);
		}
		if (!empty($attrStr)) {
			$ret = preg_replace('/">/', '" '.$attrStr.'>', $ret);
		}
		$this->inpName = $inpName;
		return $ret;
	}

	/**
	 * Returns whether input is hidden
	 *
	 * @param mixed $inp
	 * @return boolean
	 */
	public function isHidden($inp)
	{
		if (!is_array($inp)) $inp = $this->elArr[$inp];
		return $inp['input'] == 'hidden' ? 1 : 0;
	}

	/**
	 * Returns error of the field specified
	 *
	 * @param mixed $inp
	 * @return boolean
	 */
	public function getError($inp)
	{
		if (!is_array($inp)) $inp = $this->elArr[$inp];
		return $inp['error'];
	}

	/**
	 * Returns whether field has an error
	 *
	 * @param mixed $inp
	 * @return boolean
	 */
	public function hasError($inp)
	{
		if (!is_array($inp)) $inp = $this->elArr[$inp];
		return isset($inp['error']) ? 1 : 0;
	}

	/**
	 * Returns html code of text form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_text_input($inp, $attrStr)
	{
		if ($inp['type']=='float') {
			$inp['value'] = empty($inp['value'])?'':floatval($inp['value']);
			$inp['value'] = empty($inp['value'])?'':floatval($inp['value']);
		}
        $value = ($inp['value']) ? $inp['value'] : (!empty($inp['default']) ? $inp['default'] : $inp['value']);
		$ret = "<input type=\"text\" name=\"{$inp['name']}\" value=\"{$value}\" {$attrStr}/>";
		return $ret;
	}

	/**
	 * Returns html code of color form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_color_input($inp, $attrStr)
	{
		$ret = "<input type=\"color\" name=\"{$inp['name']}\" value=\"{$inp['value']}\" {$attrStr}/>";
		return $ret;
	}

	/**
	 * Returns html code of link2smth form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_link2smth_input($inp, $attrStr)
	{
		$ret = "<a href=\"{$inp['value']}\">{$inp['title']}</a>";
		if (!empty($inp['br'])) $ret .= $inp['br'];
		return $ret;
	}

	/**
	 * Returns html code of password form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_pass_input($inp, $attrStr)
	{
		//by Borro $ret = "<input type=\"password\" name=\"{$inp['name']}\" value=\"{$inp['value']}\" {$attrStr}/>";
		$ret = "<input type=\"password\" name=\"{$inp['name']}\" {$attrStr}/>";
		return $ret;
	}

	/**
	 * Returns html code of num form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_num_input($inp, $attrStr)
	{
		return $this->get_text_input($inp, $attrStr);
	}

	/**
	 * Returns html code of link form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_link_input($inp, $attrStr)
	{
		return $this->get_text_input($inp, $attrStr);
	}

	/**
	 * Returns html code of mail form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_mail_input($inp, $attrStr)
	{

		return $this->get_text_input($inp, $attrStr);
	}

	/**
	 * Returns html code of re-mail form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_re_mail_input($inp, $attrStr)
	{
		return $this->get_text_input($inp, $attrStr);
	}

	/**
	 * Returns html code of hidden form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_hidden_input($inp, $attrStr)
	{
		$ret = "<input type=\"hidden\" name=\"{$inp['name']}\" value=\"{$inp['value']}\" {$attrStr}/>";
		return $ret;
	}

	public function get_arraystr_input($inp, $attrStr)
	{
		if( is_array($inp['value'])) {
			$inp['value'] = implode((!empty($inp['delim'])? ($inp['delim'].' ') : ', '), misc::array_extract_field($inp['value'], $inp['field_name']));
		}
		if (!empty($inp['hide'])) return $this->get_hidden_input($inp, $attrStr);
		elseif (!empty($inp['textarea'])) return $this->get_textarea_input($inp, $attrStr);
		else return $this->get_text_input($inp, $attrStr);
	}

    public function get_checkboxesarr_input($inp, $attrStr)
    {
        if( !is_array($inp['value'])) {
            $inp['value'] = explode((!empty($inp['delim'])? ($inp['delim'].' ') : ', '), $inp['value']);
        }
        // Потомки могут добавить другие способы вывода поля
        return $this->get_checkboxes_input($inp, $attrStr);
    }

	/**
	 * Returns html code of image form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_image_input($inp, $attrStr)
	{
        if ($inp['crop']) {
            zf::addJS('image_cropper_select', '/public/zf/js/jquery.imgareaselect.js');
            zf::addJS('image_cropper', '/public/zf/js/form.image_cropper.js');
            zf::addCSS('image_cropper', '/public/zf/imagearea/imgareaselect-animated.css');
            $dirs = ' rel="'.urlencode(json_encode($inp['dirs'])).'"';
        } else {
            $dirs = '';
        }
		if ($inp['value']) {
            $ret = "<div class=\"zf_image\"".($inp['req']?' rel="no_delete"':'')."><a href=\"".str_replace('[dir]', $inp['cropdir'], $inp['value'])."\"{$dirs} target=\"_blank\"><img id=\"{$inp['name']}_image\" src=\"".str_replace('[dir]', 'icon', $inp['value'])."\" /></a></div>";
        } else {
			$ret = '';
		}
		$ret .= "<input type=\"file\" name=\"{$inp['name']}\" value=\"{$inp['value']}\" {$attrStr}/>";
		if ($inp['value'] && 0) {
			$checked = isset($this->arr["delete_{$inp['name']}"]) ? ' checked' : '';
			$ret .= "<input type=\"checkbox\" name=\"delete_{$inp['name']}\" value=\"1\"$checked>";
		}
		return $ret;
	}

	/**
	 * Returns html code of images form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_images_input($inp, $attrStr)
	{
		if (isset($inp['link'])) {
			$ret = "<a href=\"{$inp['link']}\" >".lang::p('form_upload_images')."</a>";
		}
		else {
			$ret = '';
			zf::addJS('zf_images', '/public/zf/js/files.js');
			if (!empty($inp['value'])) {
				foreach ($inp['value'] as $img) {
					$image = is_array($img) ? $img['image'] : $img;
					if (!empty($inp['del_by_id']) && $inp['del_by_id'] && is_array($img)) {
						$ret .= '<div class="" style="float:left; margin: 2px 5px;">
                            <a href="'.str_replace('[dir]', 'original', $image).'" target="_blank"><img src="'.str_replace('[dir]', 'icon', $image).'" /></a>
                            <br><a class="delete_image" href="'.zf::$root_url.$this->ctrl->ctrlName.'/delete_image/id/'.$img['id'].'/" title="без подтверждения">удалить</a></div>';
					} elseif ($image) {
						$ret .= '<div class="" style="float:left; margin: 2px 5px;">
                            <a href="'.str_replace('[dir]', 'original', $image).'" target="_blank"><img src="'.str_replace('[dir]', 'icon', $image).'" /></a>
                            <br><a href="'.zf::$root_url.$this->ctrl->ctrlName.'/delete_image/'.trim(base64_encode(basename($image)), '==').'/ret_url/'.trim(base64_encode($_SERVER['REQUEST_URI']), '==').'/" title="без подтверждения">удалить</a></div>';
					}
				}
				$ret .= '<br clear="all">';
			} else {
				$ret = '';
			}
			$ret .= "<input class=\"images_input\" type=\"file\" name=\"{$inp['name']}[]\" {$attrStr}/>";
			$ret .= "<input type=\"button\" class=\"zf_plus_file\" style=\"width: 30px;\" value=\" + \"/>";
		}
		return $ret;
	}

	/**
	 * Returns html code of file form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_file_input($inp, $attrStr)
	{
		if (!is_array($inp['value']) && $inp['value'] && strrpos($inp['value'], '.tmp') != strlen($inp['value']) - 4) {
            $ret = "<br><a href=\"{$inp['value']}\" />".lang::p('open')."</a>";
			$ret .= '&nbsp;<a href="'.zf::$root_url.(str_replace('modify', 'delete_file', $this->ctrl->app->request->uri)).'" title="без подтверждения">удалить</a>';
		} else {
			$ret = '';
		}
		$ret = "<input type=\"file\" name=\"{$inp['name']}\" value=\"{$inp['value']}\" {$attrStr}/>{$ret}";
		return $ret;
	}
	
	public function get_ckfile_input($inp, $attrStr)
	{
		zf::addJS('ckfinder', '/public/zf/ckfinder/ckfinder.js');
		return '<input type="text" name="'.$inp['name'].'" value="'.$inp['value'].'" style="padding-right: 18px;">'
		.'<img src="/public/cms/img/icons/delete.png" style="margin-left: -26px; margin-right: 10px; vertical-align: middle;" '
		.'onclick="$(this).prev().val(\'\');">'
		.(!empty($inp['value']) ? '<a href="'.$inp['value'].'" target="_blank">скачать</a>':'')
		.'<script>
			var finder_'.$inp['name'].' = new CKFinder();
			finder_'.$inp['name'].'.selectActionFunction = function (fileUrl) {
				$(\'input[name='.$inp['name'].']\').val(fileUrl);
			};
			$(\'input[name='.$inp['name'].']\').click(function () {
				finder_'.$inp['name'].'.popup();
			});
		</script>';
	}
	
	/**
	 * Returns html code of files form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_files_input($inp, $attrStr)
	{
		$ret = '';
		zf::addJS('zf_images', '/public/zf/js/files.js');
		if (!empty($inp['value'])) {
			foreach ($inp['value'] as $img) {
				$image = is_array($img) ? $img['file'] : $img;
				if (!empty($inp['del_by_id']) && $inp['del_by_id'] && is_array($img)) {
                    if(!empty($inp['show_name_list']) && $inp['show_name_list']) {
                        $ret .= '<div class="" style="float:left; clear:both; margin: 2px 5px;">';
                        $path_file = pathinfo($img['file']);
                        $file_name = $path_file["basename"];
                        $ret .= "<a href=\"{$img['file']}\" /title=".lang::p('open').">{$file_name}</a>";//".lang::p('open')."
                        $ret .= '&nbsp;<a href="'.zf::$root_url.$this->ctrl->ctrlName.'/delete_file/id/'.$img['id'].'/" title="без подтверждения">удалить</a></div><br>';
                    } else {
                        $ret .= '<div class="" style="float:left; margin: 2px 5px;">';
                        $ret .= "<br><a href=\"{$img['file']}\" />".lang::p('open')."</a>";
                        $ret .= '&nbsp;<a href="'.zf::$root_url.$this->ctrl->ctrlName.'/delete_file/id/'.$img['id'].'/" title="без подтверждения">удалить</a></div>';
                                /*<a href="'.str_replace('[dir]', 'original', $image).'" target="_blank"><img src="'.str_replace('[dir]', 'icon', $image).'" /></a>
                                <br><a class="delete_image" href="'.zf::$root_url.$this->ctrl->ctrlName.'/delete_image/id/'.$img['id'].'/" title="без подтверждения">удалить</a></div>';*/
                    }
                } elseif ($image) {
                    $ret .= '<div class="" style="float:left; margin: 2px 5px;">';
                    $ret .= "<br><a href=\"{$img['file']}\" />".lang::p('open')."</a>";
                    $ret .= '&nbsp;<a href="'.zf::$root_url.$this->ctrl->ctrlName.'/delete_file/'.trim(base64_encode(basename($image)), '==').'/ret_url/'.trim(base64_encode($_SERVER['REQUEST_URI']), '==').'/" title="без подтверждения">удалить</a></div>';
					/*$ret .= '<div class="" style="float:left; margin: 2px 5px;">
                            <a href="'.str_replace('[dir]', 'original', $image).'" target="_blank"><img src="'.str_replace('[dir]', 'icon', $image).'" /></a>
                            <br><a href="'.zf::$root_url.$this->ctrl->ctrlName.'/delete_image/'.trim(base64_encode(basename($image)), '==').'/ret_url/'.trim(base64_encode($_SERVER['REQUEST_URI']), '==').'/" title="без подтверждения">удалить</a></div>';*/
				}
			}
			$ret .= '<br clear="all">';
		} else {
			$ret = '';
		}
		$ret .= "<input class=\"images_input\" type=\"file\" name=\"{$inp['name']}[]\" {$attrStr}/>";
		$ret .= "<input type=\"button\" class=\"zf_plus_file\" style=\"width: 30px;\" value=\" + \"/>";
		return $ret;
	}

    public function get_mfiles_input($inp, $attrStr)
    {
        $ret = '';
        zf::addJS('zf_form', '/public/zf/js/jquery.form.js');
        zf::addJS('zf_MultiFile', '/public/zf/js/jquery.MultiFile.js');
        zf::addJS('zf_blockUI', '/public/zf/js/jquery.blockUI.js');
        if (!empty($inp['value'])) {
            zf::addJS('lytebox_js', '/public/zf/js/lytebox_322cmod1.3.js');
            zf::addCSS('lytebox_css', '/public/zf/css/lytebox_322cmod1.3.css');
            foreach ($inp['value'] as $f) {
                $file = is_array($f) ? $f['file'] : $f;
                if (!empty($inp['del_by_id']) && $inp['del_by_id'] && is_array($f)) {
                    $ret .= '<div class="" style="float:left; margin: 2px 5px;">';
                    $ret .= "<br><a href=\"{$f['file']}\" />".lang::p('open')."</a>";
                    $ret .= '&nbsp;<a href="'.zf::$root_url.$this->ctrl->ctrlName.'/delete_file/id/'.$f['id'].'/" title="без подтверждения">удалить</a></div>';
                } elseif ($file) {
                    $ret .= '<div class="" style="float:left; margin: 2px 5px;">';
                    $ret .= "<br><a href=\"{$f['file']}\" />".lang::p('open')."</a>";
                    $ret .= '&nbsp;<a href="'.zf::$root_url.$this->ctrl->ctrlName.'/delete_file/'.trim(base64_encode(basename($file)), '==').'/ret_url/'.trim(base64_encode($_SERVER['REQUEST_URI']), '==').'/" title="без подтверждения">удалить</a></div>';
                }
            }
            $ret .= '<br clear="all">';
        } else {
            $ret = '';
        }
        $ret .= "<input class=\"multi\" type=\"file\" name=\"{$inp['name']}[]\" {$attrStr}/>";
        //$ret .= "<input type=\"button\" class=\"zf_plus_file\" style=\"width: 30px;\" value=\" + \"/>";
        return $ret;
    }

	/**
	 * Returns html code of file form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_video_input($inp, $attrStr)
	{
		$repl = array();
		foreach ($inp['dirs'] as $k=>$v) {
			if (in_array($v['ext'], array('jpeg', 'jpg', 'gif', 'png', 'bmp'))) {
				$repl['p']['dir'] = $k;
				$repl['p']['ext'] = $v['ext'];
			} else if (in_array($v['ext'], array('flv'))) {
				$repl['l']['dir'] = $k;
				$repl['l']['ext'] = $v['ext'];
			} else {
				$repl['h']['dir'] = $k;
				$repl['h']['ext'] = $v['ext'];
			}
		}
		if ($inp['value'] && strrpos($inp['value'], '.tmp') != strlen($inp['value']) - 4) {
			zf::addJS('swfobject', '/public/zf/js/swfobject.js');

			$inp['value'] = str_replace(
				'.'.pathinfo($inp['value'], PATHINFO_EXTENSION),
				'.[ext]',
			$inp['value']
			);
			$p = str_replace(
			array('[dir]', '[ext]'),
			array($repl['p']['dir'], $repl['p']['ext']),
			$inp['value']
			);
			$l = str_replace(
			array('[dir]', '[ext]'),
			array($repl['l']['dir'], $repl['l']['ext']),
			$inp['value']
			);
			$h = str_replace(
			array('[dir]', '[ext]'),
			array($repl['h']['dir'], $repl['h']['ext']),
			$inp['value']
			);
			$id = $this->getId($inp);
			$ret = "<div id=\"mediaspace_$id\">".lang::p('open')."</div>"
			. "<script type=\"text/javascript\">
				var so = new SWFObject('/public/zf/mediaplayer/player.swf','mpl','470','320','9');
					  so.addParam('allowfullscreen','true');
					  so.addParam('allowscriptaccess','always');
					  so.addParam('wmode','opaque');
					  so.addVariable('file','$l');
					  so.addVariable('image', '$p');
					  so.addVariable('plugins','hd-1,viral-2');
					  so.addVariable('hd.file', '$h');
					  so.addVariable('viral.allowmenu', 'true');
					  so.addVariable('viral.onpause', 'false');
					  so.addVariable('viral.oncomplete', 'true');
					  so.write('mediaspace_$id');</script>";
		} else {
			$ret = '';
		}
		$ret .= "<input type=\"file\" name=\"{$inp['name']}\" value=\"{$inp['value']}\" {$attrStr}/>";
		return $ret;
	}

	public function get_audio_input($inp, $attrStr)
	{
		$repl = array();
		if ($inp['value'] && strrpos($inp['value'], '.tmp') != strlen($inp['value']) - 4) {
			zf::addJS('swfobject_ap', '/public/zf/audioplayer/swfobject_ap.js');
			zf::addJS('audio-player', '/public/zf/audioplayer/audio-player.js');

			$inp['value'] = str_replace(
				'.'.pathinfo($inp['value'], PATHINFO_EXTENSION),
				'.[ext]',
			$inp['value']
			);
			$dir = current($inp['dirs']);
			$ext = $dir['ext'];
			$dir = key($inp['dirs']);
			$p = str_replace(
			array('[dir]', '[ext]'),
			array($dir, $ext),
			$inp['value']
			);
			$id = $this->getId($inp);
			$ret = "<div id=\"audioplayer_$id\">".lang::p('open')."</div>"
			. "<script type=\"text/javascript\">
				AudioPlayer.embed('audioplayer_$id', {soundFile: '$p'});  
				</script>";
		} else {
			$ret = '';
		}
		$ret .= "<input type=\"file\" name=\"{$inp['name']}\" value=\"{$inp['value']}\" {$attrStr}/>";
		return $ret;
	}

	/**
	 * Returns html code of select form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_select_input($inp, $attrStr)
	{
		$ret = "<select name=\"{$inp['name']}\" {$attrStr}>";
		if (isset($inp['null'])) {
            $default = isset($inp['default']) ? $inp['default'] : '';
			$ret .= "<option value=\"$default\">" . (defined('USE_LOCALIZATION') && $inp['null'] ? gettext($inp['null']) : $inp['null']) . "</option>";
		}
		if (!empty($inp['values'])) {
			if (!empty($inp['values']['by_groups'])) {
				unset($inp['values']['by_groups']);
				foreach ($inp['values'] as $optGroup) {
					$ret .= "<optgroup label=\"{$optGroup['title']}\">";
					foreach ($optGroup['items'] as $value => $title) {
						$selected = !strcmp($value, $inp['value']) ? ' selected' : '';
						$ret .= "<option$selected value=\"$value\">".($title ? gettext($title) : $title)."</option>";
					}
					$ret .= "</optgroup>";
				}
			} else {
				foreach ($inp['values'] as $value => $title) {
					$selected = !strcmp($value, $inp['value']) ? ' selected' : '';
					$ret .= "<option$selected value=\"$value\">".($title ? gettext($title) : $title)."</option>";
				}
			}
		}
		$ret .= '</select>';
		return $ret;
	}

	public function get_tselect_input($inp, $attrStr)
	{
		zf::addJS('form.tselect', '/public/zf/js/form.tselect.js');

		$id = $this->getId($inp);
		$url = ( isset($inp['url']) and !empty($inp['url']) ) ? $inp['url'] : '/';
		$functions = array();
		if (!empty($inp['click'])) {
			$functions[] = 'click: '.$inp['click'];
		}
		if (!empty($functions)) {
			$functions = '{'.implode(', ', $functions).'}';
		}
		else {
			$functions = '{click: function(){}}';
		}

		$l2sr = 0;
		if (!empty($inp['l2sr'])) {
			$l2sr = intval($inp['l2sr']);
		}
		//debug::dump($inp);
		$add_query = '';
		if (!empty($inp['add_query'])) {
			$add_query = $inp['add_query'];
		}
		$ret = "<input type=\"text\" id=\"{$id}_text\" autocomplete=\"off\" $attrStr value=\"".(empty($inp['value']) ? '' : current($inp['value']))."\">\n"
		."<input type=\"hidden\" name=\"{$inp['name']}\" id=\"{$id}_hidden\" $attrStr value=\"".(empty($inp['value']) ? '' : key($inp['value']))."\">\n"
		."<div id=\"{$id}_div\" $attrStr></div>"
		."<script>var ".str_replace(array('[', ']'), array('_', ''), $inp['name'])." = new tSelect('{$id}', '{$url}', '{$add_query}', {$functions}, {$l2sr});</script>";
		return $ret;
	}

	/**
	 * Returns html code of select form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_mselect_input($inp, $attrStr)
	{
		$ret = "<select name=\"{$inp['name']}[]\" {$attrStr}>";
        if (isset($inp['null'])) {
            $ret .= "<option value=\"\">" . (defined('USE_LOCALIZATION') && $inp['null'] ? gettext($inp['null']) : $inp['null']) . "</option>";
        }
		
		if (is_array($inp['value'])) array_walk($inp['value'], array($this, 'converCheckboxesValues'), !empty($inp['key']) ? $inp['key'] : 'id');

		if (!empty($inp['values'])) {
			if (!empty($inp['values']['by_groups'])) {
				unset($inp['values']['by_groups']);
				foreach ($inp['values'] as $optGroup) {
					$ret .= "<optgroup label=\"{$optGroup['title']}\">";
					foreach ($optGroup['items'] as $value => $title) {
						$selected = (is_array($inp['value']) && in_array($value, $inp['value'])) ? ' selected' : '';
						$ret .= "<option$selected value=\"$value\">".($title ? gettext($title) : $title)."</option>";
					}
					$ret .= "</optgroup>";
				}
			} else {
				foreach ($inp['values'] as $value => $title) {
					if ($inp['htmltype'] == 'mselect' && is_array($title)) {
						if (isset($title['title'])) {
							$title = $title['title'];
						}
					}
					$selected = (is_array($inp['value']) && in_array($value, $inp['value'])) ? ' selected' : '';
					$ret .= "<option$selected value=\"$value\">".($title ? gettext($title) : $title)."</option>";
				}
			}
		}
		$ret .= '</select>';
		return $ret;
	}

	public function get_multitext_input($inp, $attrStr)
	{
		zf::addJS('form.multitext', '/public/zf/js/form.multitext.js');
        if (!empty($inp['value'])) {
			$first=true;
			foreach ($inp['value'] as $v)	{
                $val = (is_array($v) && array_key_exists($inp['key_field'], $v)) ? $v[$inp['key_field']] : $v;
				$ret .= "<input type=\"text\" class=\"multi\" name=\"{$inp['name']}[]\" value=\"{$val}\" {$attrStr}/>";
				$ret .= "<input type=\"button\" class=\"addinput\" value=\"+\"/>";
				if (!$first) {
					$ret .= "<input type=\"button\" class=\"delinput\" value=\"-\"/>";
				}
				$ret .= '</br>';
				$first=false;
			}
		} else {
			$ret = "<input type=\"text\" class=\"multi\" name=\"{$inp['name']}[]\" value=\"{$v[$inp['a_data']['val_field']]}\" {$attrStr}/>";
			$ret .= "<input type=\"button\" class=\"addinput\" value=\"+\"/>";
		}
		return $ret;
	}

	public function get_doublemultitext_input($inp, $attrStr)
	{
		zf::addJS('form.doublemultitext', '/public/zf/js/form.doublemultitext.js');
		$ret='
		<table width="90%">
			<tr>
				<td style="width:45%" align="center">
				Тип
				</td>
				<td style="width:45%" align="center">
				Значение
				</td>
			</tr>
		</table>
		';
		if (!empty($inp['value'])) {
			$first=true;
			for ($i=0; $i<count($inp['value']); $i=$i+2)	{
				$ret .= "<input type=\"text\" class=\"multi\" name=\"{$inp['name']}[]\" value=\"{$inp['value'][$i]}\" {$attrStr}/>";
				$ret .= "<input type=\"text\" class=\"multi\" name=\"{$inp['name']}[]\" value=\"{$inp['value'][$i+1]}\" {$attrStr}/>";
				$ret .= "<input type=\"button\" class=\"addinput\" value=\"+\"/>";
				if (!$first) {
					$ret .= "<input type=\"button\" class=\"delinput\" value=\"-\"/>";
				}
				$ret .= '</br>';
				$first=false;
			}
		} else {
			$val1 = !(empty($v[$inp['key_field']]))?$v[$inp['key_field']]:'';
			$val2 = !(empty($v[$inp['key_field']]))?$v[$inp['key_field2']]:'';
			$ret .= "<input type=\"text\" class=\"multi type\" name=\"{$inp['name']}[]\" value=\"$val1\" {$attrStr}/>";
			$ret .= "<input type=\"text\" class=\"multi value\" name=\"{$inp['name']}[]\" value=\"$val2\" {$attrStr}/>";
			$ret .= "<input type=\"button\" class=\"addinput\" value=\"+\"/>";
		}
		return $ret;
	}

	public function get_multimail_input($inp, $attrStr)
	{
		return $this->get_multitext_input($inp, $attrStr);
	}

	public function get_multiphone_input($inp, $attrStr)
	{
		return $this->get_multitext_input($inp, $attrStr);
	}

	public function get_placeholder_input($inp, $attrStr) {
		return '<div class="placeholder"'.(!empty($inp['id']) ? " id=\"{$inp['id']}\"" : '').(!empty($inp['hide']) ? " style='display: none;'" : '').'></div>';
	}
	public function get_metroselect_input($inp, $attrStr)
	{
		$id = $this->getId($inp);
		$ret = "<div id=\"$id\">";

		$ret .= "<select style=\"display: none;\" name=\"{$inp['name']}".(empty($inp['one'])?"[]\" multiple=\"true\"":"\" ")." {$attrStr}>";
		if (isset($inp['null'])) {
			$ret .= "<option value=\"\">" . (defined('USE_LOCALIZATION') ? gettext($inp['null']) : $inp['null']). "</option>";
		} else {
			$ret .= "<option></option>";
		}

		if (!empty($inp['values'])) {
			foreach ($inp['values'] as $value => $arr) {
				$selected = ((is_array($inp['value']) && in_array($value, $inp['value'])) or $value == $inp['value']) ? ' selected' : '';
				$ret .= "<option$selected value=\"$value\">{$arr['title']}</option>";
			}
		}

		$ret .= '</select>';

		$ret .= '<a href="" class="openmap">'.lang::p('map_open').'</a>';

		$ret .= '<div class="metromap" style="display: none; position: relative;">
			<a href="" class="closemap">'.lang::p('map_close').'</a><br>
			<img src="'.(!empty($inp['map_img'])? $inp['map_img'] : '/public/zf/img/metro_moscow.gif').'">
			<a href="#" class="station" style="display: none;">
				<img wigth="11" height="12" class="placeholder" src="/public/zf/img/null.gif" alt="Станция метро" title="Станция метро">
				<img wigth="11" height="12" class="marker" style="display: none;" src="/public/zf/img/pointer.gif" alt="Станция метро" title="Станция метро">
			</a>
		</div>';

		$ret .= '</div>';
		zf::addJS('form.metroselect', '/public/zf/js/form.metroselect.js');
		$stations = array();
		foreach ($inp['values'] as $k => $v) {
			$stations[] = "{id: $k, title: '{$v['title']}', top: {$v['top']}, left: {$v['left']}}";
		}
		$stations = implode(',', $stations);

		if (!empty($inp['lines'])){
			$lines = array();
			foreach ($inp['lines'] as $k => $v) {
				$lines[] = "{id: $k, title: '{$v['title']}', color: '{$v['color']}', stations: ".json_encode($v['stations'])."}";
			}
			$lines = implode(',', $lines);
		}

		if (!empty($inp['districts'])){
			$districts = array();
			foreach ($inp['districts'] as $k => $v) {
				$districts[] = "{id: $k, title: '{$v['title']}', stations: ".json_encode($v['stations'])."}";
			}
			$districts = implode(',', $districts);
		}

		$ret .= "<script>var $id = new metroSelect('{$id}', [$stations], ".(empty($inp['one'])?"false":"true")."".(!empty($lines) ? ", [$lines]" : '').(!empty($districts) ? ", [$districts]" : '').");</script>";
		return $ret;
	}
	/**
	 * Returns html code of radio form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_radio_input($inp, $attrStr)
	{
		$del = misc::get($inp, 'del', ' &mdash; ');
		$ret = array();
		$i   = 1;
		foreach ($inp['values'] as $value => $title) {
			$id = $this->getId($inp, $i);
			$title = gettext($title);
			if (empty($inp['dont_use_label'])) {
				$title = $this->getLabel(array('title' => $del.$title, 'id' => $id));
			} else {
				$title = $del.$title;
			}
			$checked = ($value == $inp['value']) ? ' checked' : '';
			$ret[] = "<input id=\"$id\" type=\"radio\" name=\"{$inp['name']}\" {$attrStr}$checked value=\"$value\" />$title";
			$i++;
		}
		return implode(misc::get($inp, 'br', '<br />'), $ret);
	}

	/**
	 * Returns html code of checkbox form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_checkbox_input($inp, $attrStr)
	{
		$ret = "<input type=\"hidden\" name=\"{$inp['name']}\" value=\"" . misc::get($inp, 'unchecked', $inp['default']) . "\" />";
		$checked = $inp['value'] == $inp['checked'] ? ' checked' : '';
		$id = $this->getId($inp, null);
		$ret .= "<input type=\"checkbox\" id=\"$id\" name=\"{$inp['name']}\" {$attrStr}value=\"{$inp['checked']}\"$checked />";
		if (empty($inp['otitle'])) return $ret;
		$inp['otitle'] = defined('USE_LOCALIZATION') ? gettext($inp['otitle']) : $inp['otitle'];
		$title = $this->getLabel(array('title' => (!empty($inp['del']) ? $inp['del'] : ' &nbsp; ').$inp['otitle'], 'id' => $id));
		return $ret.$title;
	}

	public function converCheckboxesValues(&$item, $key, $keyField = 'id')
	{
        if (is_array($item) && isset($item[$keyField])) $item = $item[$keyField];
	}

	/**
	 * Returns html code of checkboxes form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_checkboxes_input($inp, $attrStr)
	{
        
		if ($this->num === 'all') {
			return "<input class=\"all_checker\" type=\"checkbox\" id=\"{$inp['name']}_all\">".
            "<label for=\"{$inp['name']}_all\"> ".lang::p('check_all').'</label>';
		}
		if (!is_array($inp['values'])) return !empty($inp['no_values']) ? $inp['no_values'] : '';
		if (is_array($inp['value'])) array_walk($inp['value'], array($this, 'converCheckboxesValues'), !empty($inp['key']) ? $inp['key'] : 'id');
		$del = misc::get($inp, 'del', ' &mdash; ');
		$ret = array();
        $ret[] = "<div id='{$inp['name']}'>";
		if (!empty($inp['all'])) {
			$ret[] = "<input class=\"all_checker\" type=\"checkbox\" id=\"{$inp['name']}_all\">".
            "<label for=\"{$inp['name']}_all\"> ".lang::p('check_all').'</label>';
		}
		$i   = 0;
		//debug::dump($inp);
		foreach ($inp['values'] as $value => $title) {
			$i++;
			if ($this->num !== null && $i != $this->num + 1) {
				continue;
			}
			$title = gettext($title);
			$id = $this->getId($inp, $i);
			if (empty($inp['dont_use_label'])) {
				$title = $this->getLabel(array('title' => $del.$title, 'id' => $id));
			} else {
				$title = $del.$title;
			}
			$checked = in_array($value, is_array($inp['value']) ? $inp['value'] : array()) ? ' checked' : '';
			//debug::dump($checked);
			$ret[] = "<input id=\"$id\" type=\"checkbox\" name=\"{$inp['name']}[]\" {$attrStr}$checked value=\"$value\" />$title";
		}
        $ret[] = "</div>";
		return implode(misc::get($inp, 'br', ''), $ret);
	}

    /**
     * Returns html code for mobile phone input
     *
     * @param array $inp
     * @param string $attrStr
     * @return string
     */
    public function get_mobilephone_input($inp, $attrStr) {
        $id = $this->getId($inp['name']);
        if (is_array($inp['value'])) {
            $inp['value'] = '+'.$inp['value']['code'].$inp['value']['number'];
        } elseif ($inp['value'][0] != '+') {
            $inp['value'] = '+'.$inp['value'];
        }
        if (!empty($inp['exclude'])) {
            $exclude = is_array($inp['exclude']) ? $inp['exclude'] : array($inp['exclude']);
            foreach ($exclude as $ex_country) {
                if (!empty($inp['countries'][$ex_country])) unset($inp['countries'][$ex_country]);
            }
        }
        unset($ex_country, $exclude);
        if (!empty($inp['extra']) && is_array($inp['extra'])) {
            foreach ($inp['extra'] as $key => $extra) {
                if (empty($inp['countries'][$key])) {
                    $inp['countries'][$key] = $extra;
                }
            }

        }
        $ret = "<div {$attrStr}>+<select id=\"{$id}_code\" name=\"{$inp['name']}[code]\" ".(!empty($inp['selectAttrStr'])?$inp['selectAttrStr']:'').">";
        $otherdigits = '';
	    if (isset($inp['new_codes'])) {
		    $inp['codes'] = $inp['new_codes'];
	    }
        foreach($inp['codes'] as $key => $code) {
            $selected = (strpos($inp['value'], '+'.$code) === 0) ? ' selected' : '';
            if ($selected) $otherdigits = substr($inp['value'], strlen($code)+1);

            $ret .= "<option$selected value=\"$code\">$code</option>";
        }
        $ret .= "</select><input id=\"{$id}_digits\" value=\"{$otherdigits}\" type=\"text\" name=\"{$inp['name']}[number]\" ".(!empty($inp['inputAttrStr'])?$inp['inputAttrStr']:'')."></div>";

        return $ret;
    }
    
    public function get_separator_input($inp, $attrStr) {
        return "<b>".$inp['text']."</b>";
    }

    public function get_fieldset_input($inp, $attrStr) {//debug::dump($inp);
        $ret = '<fieldset>';
        $ret .= '<legend><b>'.$inp['title'].'</b></legend>';
	    foreach($inp['elements'] as $key => $code) {
		    $this->elArr[$key] = $code;

            if (empty($inp['dont_use_label'])) {
                $ret .= $this->getLabel(array('title' => $code['title']));
            } else {
                $ret .= $code['title'];
            }
            $ret .= $this->getInput($key);

        }
        $ret .= '</fieldset>';
        return $ret;
    }

	/**
	 * Quotes string
	 *
	 * @param string $str
	 */
	protected function quote($str)
	{
		return "'$str'";
	}

	/**
	 * Returns html code of shtml form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_shtml_input($inp, $attrStr)
	{
		$is  = "is{$inp['name']}";
		$ret = "<textarea name=\"{$inp['name']}\" {$attrStr}>{$inp['value']}</textarea>
			<script type=\"text/javascript\">
				var $is = new InnovaEditor('$is');
				$is.useTab = false;
				$is.features = [".implode(',', array_map(array($this, 'quote'), $inp['features']))."];
				$is.width = '".(!empty($inp['width']) ? $inp['width'] : '100%')."';
				$is.height = 200;
				//$is.css='/public/zsms/css/main.css';
				$is.mode = 'XHTMLBody';
				$is.REPLACE('".$this->getId($inp)."');
			</script>
		";
        zf::addJS('wysiwyg', '/public/zf/wysiwyg/innovaeditor.js', false, true);
		return $ret;
	}

	/**
	 * Returns html code of text form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_textarea_input($inp, $attrStr)
	{
		$ret = "<textarea name=\"{$inp['name']}\" {$attrStr}>{$inp['value']}</textarea>";
		return $ret;
	}

	public function get_captcha_input($inp, $attrStr)
	{
		zf::addJS('refreshcaptcha', '/public/zf/js/form.captcharefresh.js');
		$ret  = "<div style='position:relative;'><img style='cursor: pointer;' src=\"/captcha/".$inp['conf']['background_color']."/?".rand()."\" $attrStr /><img style='display:none; position:absolute; top:0; left:0;' src='/public/zf/img/loading.gif' alt=''/></div><br />";
		unset($inp['value']);
		$ret .= $this->get_text_input($inp, $attrStr);
		return $ret;
	}

	/**
	 * Returns html code of html form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_html_input($inp, $attrStr)
	{
		$forms = array();
		$is = "is{$inp['name']}";        
        $is = str_replace('[', '', $is);
        $is = str_replace(']', '', $is);
		$ret = "<textarea name=\"{$inp['name']}\" {$attrStr}>{$inp['value']}</textarea>
			<script type=\"text/javascript\">
			$is = new InnovaEditor('$is');
				";
			if ($forms = misc::get($inp, 'forms')) {
				$inp['custom_buttons'][] = array('formsButton',"insertForm()", 'Forms', 'btnForm.gif');
			}

			if (!empty($inp['custom_buttons'])) {
				$ret .= "$is.arrCustomButtons=".json_encode($inp['custom_buttons']);
			}
			$ret .= "
			$is.useTab = false;
			$is.features = [".implode(',', array_map(array($this, 'quote'), isset($inp['features']) ? $inp['features'] : array()))."];
			$is.width = '".(!empty($inp['width']) ? $inp['width'] : '100%')."';
			$is.height = '".(!empty($inp['height']) ? $inp['height'] : '400')."';
			$is.mode = 'XHTMLBody';
				";
			if (isset($inp['addons'])) {
				$app = zf::gi()->app;
				foreach ($inp['addons'] as $key => $val) {
					$val  = str_replace(array('{app_path}', '{app_name}'), array(urlencode(str_replace(ROOT_PATH, '', $app->app_path)), $app->appName), $val);
					$ret .= "$is.cmd$key = \"$val\";\r\n";
				}
			}
			if (!empty($inp['attrs'])) {
				foreach ($inp['attrs'] as $key => $val) {
					$ret .= "$is.$key = '$val';\r\n";
				}
			}
			$ret .= "
			$is.REPLACE('".$this->getId($inp)."');
			</script>
		";
        zf::addJS('wysiwyg', '/public/zf/wysiwyg/innovaeditor.js', false, true);
		return $ret;
	}

	public function get_ckhtml_input($inp, $attrStr)
	{
		include_once 'public/zf/ckeditor/ckeditor.php';
		require_once 'public/zf/ckfinder/ckfinder.php';
		zf::addJS('ckedito', '/public/zf/ckeditor/ckeditor.js');
		zf::addJS('ckfinder', '/public/zf/ckfinder/ckfinder.js');
		$id = $this->getId($inp);
		$ck = 'ck'.$inp['name'];
        $ck = str_replace('[', '', $ck);
        $ck = str_replace(']', '', $ck);
        

		$conf = array('skin' => 'office2003');
        if (!empty($inp['width'])) $conf['width'] = $inp['width'];
        if (!empty($inp['height'])) $conf['height'] = $inp['height'];
		if (!empty($inp['removePlugins'])) $conf['removePlugins'] = implode(',',$inp['removePlugins']);
		if (!empty($inp['extraPlugins'])) $conf['extraPlugins'] = $inp['extraPlugins'];
        if (!empty($inp['no_merge_toolbar'])) $conf['toolbar'] = $inp['no_merge_toolbar'];
		elseif (!empty($inp['toolbar'])) $conf['toolbar'] = $inp['toolbar'];
        $value = ($inp['value']) ? $inp['value'] : (!empty($inp['default']) ? $inp['default'] : '');
		$ret = "<textarea name=\"{$inp['name']}\" {$attrStr}>{$value}</textarea>
		<script type=\"text/javascript\">
		var $ck = CKEDITOR.replace('$id', ".json_encode($conf).");
		CKFinder.setupCKEditor( $ck, '".(!empty($inp['ckfinder']) ? $inp['ckfinder'] : '/public/zf/ckfinder/')."' );
		</script>";

		return $ret;
	}

	/**
	 * Returns html code of datetime form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
     protected function get_date_js($params) {
        $ret = "<script type=\"text/javascript\">
                $(document).ready(function(){
                    $('input[name=\"{$params['name']}\"]').dynDateTime({"
                        .((isset($params['showsTime'])) ?"\r\nshowsTime: ".$params['showsTime']."," : "")
                        ."\r\ntimeFormat: 24,"
                        .((isset($params['ifFormat'])) ?"\r\nifFormat: '".$params['ifFormat']."'," : "")
                        .((isset($params['daFormat'])) ?"\r\ndaFormat: '".$params['daFormat']."'," : "")
                        ."\r\nsingleClick: true,
                        align: 'T'"
                        .((isset($params['onSelect'])) ?",\r\nonSelect: ".$params['onSelect']."" : "")
                        .((isset($params['onClose'])) ?",\r\nonClose: ".$params['onClose']."" : "")
                        .((isset($params['onUpdate'])) ?",\r\nonUpdate: ".$params['onUpdate']."" : "")
                    ."});
                });
            </script>";
            return $ret;
    }
     
    public function get_datetime_input($inp, $attrStr)
    {
        $inp['showsTime'] = 'true';
        $inp['ifFormat'] = '%d.%m.%Y %H:%M';
        $inp['daFormat'] = '%d.%m.%Y %H:%M';
        $ret = "<input type=\"text\" name=\"{$inp['name']}\" value=\"".($inp['value'] ? date('d.m.Y H:i', strtotime($inp['value'])) : '')."\" {$attrStr}/>".$this->get_date_js($inp);
        $langFile = zf::gi()->app->conf['charset'] == 'utf-8' ? 'calendar-ru.js' : 'calendar-ru-cp1251.js';
        zf::addJS('dynDateTime', '/public/zf/js/jquery.dynDateTime.js');
        zf::addJS('dynDateTime_lang', "/public/zf/js/dyndatetime/$langFile");
        zf::addCSS('dynDateTime', '/public/zf/css/calendar-blue.css');
        return $ret;
    }

	public function get_time_input($inp, $attrStr)
	{
		$ret = "<input type=\"text\" name=\"{$inp['name']}\" value=\"".($inp['value'] ? date('H:i', strtotime($inp['value'])) : '')."\" {$attrStr}/>
			<script type=\"text/javascript\">
                $(document).ready(function() {
                    $('input[name=\"{$inp['name']}\"]').timepicker({
                        hourText: 'Часы',
                        minuteText: 'Минуты',
                        amPmText: ['AM', 'PM']
                    });
                });
            </script>
		";
        zf::addJS('ui', '/public/zf/js/jquery-ui-1.7.1.custom.min.js');
		zf::addJS('timepicker', '/public/zf/js/jquery.ui.timepicker.js');
        zf::addCSS('ui', '/public/zf/css/jquery-ui-1.8.14.custom.css');
		zf::addCSS('timepicker', '/public/zf/css/jquery.ui.timepicker.css');
		return $ret;
	}

	/**
	 * Returns html code of date form element
	 *
	 * @param array $inp
	 * @param string $attrStr
	 * @return string
	 */
	public function get_date_input($inp, $attrStr)
	{
		$ret = "<input type=\"text\" name=\"{$inp['name']}\" value=\"".
            (($inp['value'] &&  $inp['value'] != '0000-00-00')
                ? date('d.m.Y', strtotime($inp['value']))
                : (($inp['default'] == 'now') ? date('d.m.Y') : (!empty($inp['default']) ? $inp['default'] : ''))
            ).
            "\" {$attrStr}/>".$this->get_date_js($inp);;
			/*<script type=\"text/javascript\">
				$(document).ready(function(){
					$('input[name=\"{$inp['name']}\"]').dynDateTime({
						showsTime: false,
						timeFormat: 24,
						ifFormat: '%d.%m.%Y',
						daFormat: '%d.%m.%Y',
						singleClick: true,
						align: 'T'
					});
				});
			</script>
		";*/
		$langFile = zf::gi()->app->conf['charset'] == 'utf-8' ? 'calendar-ru.js' : 'calendar-ru-cp1251.js';
		zf::addJS('dynDateTime', '/public/zf/js/jquery.dynDateTime.js');
		zf::addJS('dynDateTime_lang', "/public/zf/js/dyndatetime/$langFile");
		zf::addCSS('dynDateTime', '/public/zf/css/calendar-blue.css');
		return $ret;
	}

	public function get_year_input($inp, $attrStr)
	{
		$cur_year = date('Y');
        if (isset($inp['start'])) {
		    $start_year = in_array($inp['start']{0}, array('+', '-')) ? $cur_year + $inp['start'] : $inp['start'];
        } else {
            $start_year = $cur_year - 10;
            $inp['start'] = '-10';
        }
        if (isset($inp['end'])) {
		    $end_year = in_array($inp['end']{0}, array('+', '-')) ? $cur_year + $inp['end'] : $inp['end'];
        } else {
            $end_year = $cur_year + 10;
            $inp['end'] = '+10';
        }

		if (in_array($inp['start']{0}, array('+', '-')) || !empty($inp['start'])) {
			for ($i = $start_year; $i <= $cur_year and $i <= $end_year; $i++) {
				$inp['values'][$i] = $i;
			}
		} else {
			$inp['values'][$cur_year] = $cur_year;
		}

		if (in_array($inp['end']{0}, array('+', '-')) || !empty($inp['end'])) {
			for ($i = $cur_year; $i <= $end_year; $i++) {
				$inp['values'][$i] = $i;
			}
		}
		// Я немного поправил. Так вроде логичнее и понятнее код. Еще добавил по умолчанию +/- 10 лет. Forgon

        if (!empty($inp['reverse']) && $inp['reverse']) {
            $inp['values'] = array_reverse($inp['values'], true);
        }
        return $this->get_select_input($inp, $attrStr);
	}
    public function get_date_boxes_input($inp, $attrStr)
	{
		$inp['value_array'] = array('year' => '', 'month' => '', 'day' => '', 'hours' => '', 'mins' => '', 'secs' => '');
        if (!$inp['value']) {
            if (!$inp['default'] || $inp['default'] == 'now') {
                $inp['value'] = date('Y-m-d H:i:s');
            } else {
                $inp['value'] = $inp['default'];
            }
        }
        if ($inp['value'] && !is_array($inp['value'])) {
            list(
	            $inp['value_array']['year'],
                $inp['value_array']['month'],
                $inp['value_array']['day'],
                $inp['value_array']['hours'],
                $inp['value_array']['mins'],
                $inp['value_array']['secs']
            ) = explode('-', date('Y-m-d-H-i-s', strtotime($inp['value'])));
        } elseif (is_array($inp['value'])) {
            $inp['value_array'] = $inp['value'];
        }
        $cur_year = date('Y');

        $months = array('1' => 'Январь','2' => 'Февраль','3' => 'Март','4' => 'Апрель','5' => 'Май','6' => 'Июнь','7' => 'Июль','8' => 'Август','9' => 'Сентябрь','10' => 'Октябрь','11' => 'Ноябрь','12' => 'Декабрь');

        if (empty($inp['from'])) $inp['from'] = $cur_year - 10;
        if (empty($inp['to']))   $inp['to']   = $cur_year + 10;

        $start_year = in_array($inp['from']{0}, array('+', '-')) ? $cur_year + $inp['from']: $inp['from'];
		$end_year   = in_array($inp['to']{0},   array('+', '-')) ? $cur_year + $inp['to']  : $inp['to'];

        if ($end_year < $start_year) {
            $start_year = $end_year - 20;
        }

        $ret = "<select name=\"{$inp['name']}[day]\" style='width: 50px;' {$attrStr}>";
        for ($i = 1; $i <= 31; $i++) {
            $ret .= '<option '.($i == $inp['value_array']['day'] ? 'selected ':'').'value="'.$i.'">'.$i."</option>";
        }
        $ret .= '</select>';

        $ret .= "<select name=\"{$inp['name']}[month]\" style='width: 100px;' {$attrStr}>";
        for ($i = 1; $i <= 12; $i++) {
            $ret .= '<option '.($i == $inp['value_array']['month'] ? 'selected ':'').'value="'.$i.'">'.gettext($months[$i])."</option>";
        }
        $ret .= '</select>';

        $ret .= "<select name=\"{$inp['name']}[year]\" style='width: 75px;' {$attrStr}>";
        for ($i = $start_year; $i <= $end_year; $i++) {
            $ret .= '<option '.($i == $inp['value_array']['year'] ? 'selected ':'').'value="'.$i.'">'.$i."</option>";
        }
        $ret .= '</select>';

		if (empty($inp['only_date'])) {
	        $ret .= "<select name=\"{$inp['name']}[hours]\" style='width: 50px;' {$attrStr}>";
	        for ($i = 0; $i <= 23; $i++) {
	            $ret .= '<option '.($i == $inp['value_array']['hours'] ? 'selected ':'').'value="'.$i.'">'.$i."</option>";
	        }
	        $ret .= '</select>:';

	        $ret .= "<select name=\"{$inp['name']}[mins]\" style='width: 50px;' {$attrStr}>";
	        for ($i = 0; $i <= 59; $i++) {
	            $ret .= '<option '.($i == $inp['value_array']['mins'] ? 'selected ':'').'value="'.$i.'">'.$i."</option>";
	        }
	        $ret .= '</select>:';

	        $ret .= "<select name=\"{$inp['name']}[secs]\" style='width: 50px;' {$attrStr}>";
	        for ($i = 0; $i <= 59; $i++) {
	            $ret .= '<option '.($i == $inp['value_array']['secs'] ? 'selected ':'').'value="'.$i.'">'.$i."</option>";
	        }
	        $ret .= '</select>';
		}

		return $ret;
	}

	public function get_geo_input($inp, $attrStr)
	{
		if ($inp['transport'] == 'google') {
			$key = zf::gi()->app->conf['googlemap'];
			$transport = 'google';
		} else {
			$key = zf::gi()->app->conf['yandexmap'];
			$transport = 'yandex';
		}
		if (!empty($key['key'])) {
			$key = $key['key'];
		}
		if ($transport == 'google') {
			zf::addJS('google.map', 'http://maps.google.com/maps/api/js?sensor=false');
		} else {
			zf::addJS('yandex.map', 'http://api-maps.yandex.ru/1.1/index.xml?key='.$key);
		}
		zf::addJS('form.geo', '/public/zf/js/form.geo.js');
		$id = $this->getId($inp);
		$strname = '';
		if (!empty($inp['strname'])) {
			$strname .= 'name="'.$inp['strname'].'"';
		}
		if (!empty($inp['strval'])) {
			$strname .= ' value="'.$inp['strval'].'"';
		}

		$ret1=<<<GEOINPUTSTRING
		<input type="text" $attrStr $strname autocomplete="off">
		<div id="{$id}_div"></div>
		<input type="hidden" name="{$inp['name']}" value="{$inp['value']}" id="{$id}_hidden">
		<script type="text/javascript">
			var geo_input_$id = new geoInput('$id', '$transport');
		</script>
GEOINPUTSTRING;
		$ret2=<<<GEOINPUTSTRING
		<input type="text" $attrStr name="{$inp['name']}" autocomplete="off">
		<div id="{$id}_div"></div>
		<input type="hidden" $strname value="{$inp['value']}" id="{$id}_hidden">
		<script type="text/javascript">
			var geo_input_$id = new geoInput('$id', '$transport');
		</script>
GEOINPUTSTRING;
		return !isset($inp['replacevals']) ? $ret1 : $ret2;
	}

    /**
     * Нередактируемое "поле" в форму
     *
     * @param $inp
     * @param $attrStr
     * @return string
     */
    public function get_label_input($inp, $attrStr) {
        return "<span>".$inp['value'].'</span>';
    }

	/**
	 * Returns id of input element
	 *
	 * @param mixed $inp
	 * @param mixed $num
	 * @return string
	 */
	private function getId($inp, $num = null)
	{
		if (!is_array($inp)) $inp = $this->elArr[$inp];
		if (!empty($inp['attrs']['id'])) {
			return $num === null ? $inp['attrs']['id'] : $inp['attrs']['id'].'_';
		}
		$inp['name'] = str_replace(array('[', ']'), array('_', ''), $inp['name']);
		return $num == null ? $this->name.'_'.$inp['name'] : $this->name.'_'.$inp['name'].'_'.$num;
	}

	static public function convertDataArray($data)
	{
		$ret = array();
		foreach ($data as $key => $value) {
			if (!is_array($value)) {
				$ret[$key] = $value;
			} else {
				foreach ($value as $iKey => $iValue) {
					$ret["{$key}[{$iKey}]"] = $iValue;
				}
			}
		}
		return $ret;
	}

	protected function convert($element, $value)
	{
		if (!empty($element['strip_tags'])) {
            if (is_array($value)) {
				$newValue = array();
				foreach ($value as $key => $val) {
					$newValue[$key] = strip_tags($val, misc::get($element, 'allowed_tags', ''));
				}
				$value = $newValue;
			} else {
				$value = strip_tags($value, misc::get($element, 'allowed_tags', ''));
			}
		}
		if (!empty($element['html_safe'])) {
			set_include_path(get_include_path() . PATH_SEPARATOR . 'zf/third-party/pear/');
			include_once 'HTML/Safe.php';
			$parser = new HTML_Safe();
			$value = $parser->parse($value);
		}
		return $value;
	}
}
?>
