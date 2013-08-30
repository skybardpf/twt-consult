<?php
/**
 * Created by JetBrains PhpStorm.
 * User: semen
 * Date: 19.07.13
 * Time: 12:19
 * To change this template use File | Settings | File Templates.
 */

class CalcController extends Site_Controller {
    public $transport = array(
        '' => 'Не выбран',
        '30' => 'Автодорожный транспорт, за исключением транспортных средств, указанных под кодами 31, 32',
        '80' => 'Внутренний водный транспорт',
        '40' => 'Воздушный транспорт',
        '20' => 'Железнодорожный транспорт',
        '10' => 'Морской/речной транспорт',
        '50' => 'Почтовое отправление',
    );
    /*
     * Страховой калькулятор
     */

	/**
	 * Обновление сессий шагов
	 */
	private function updateStep($step_number, $post, $add_data = array()) {
		if (!empty($post)) {
			$data = array(
				'post' => $post,
				'add_data' => $add_data
			);
			$step_name = 'step'.$step_number;
			$this->app->session->$step_name = $data;
		}
	}

	private function clearStep($step_number) {
		$step_name = 'step'.$step_number;
		$this->app->session->$step_name = null;
	}

	public function actionDefault() {
		// перез заполнением первого шага очищаем сессии шагов
		$this->clearStep(1);
		$this->clearStep(2);
		$this->clearStep(3);
		// переходим к шагу 1
		$this->actionStep1();
	}

	public function actionStep1() {
		zf::addCSS('select2', '/public/site/css/select2.css');
		zf::addJS('select2', '/public/site/js/calc/select2.js');
		zf::addJS('calc', '/public/site/js/calc/calc.js');
		zf::addJS('postmessage', '/public/site/js/postmessage.js');
		zf::addJS('FrameManager', '/public/site/js/FrameManager.js');
		// при возврате на первый шаг, очищаем сессии второго и третьего шага
		$this->clearStep(2);
		$this->clearStep(3);
		// новые данные поста
		$post = (!empty($_POST)) ? $_POST : array();
		// сохраненные данные поста
		$post_step1 = ($this->app->session->step1 !== null && !empty($this->app->session->step1['post'])) ? $this->app->session->step1['post']: array();
		// данные в форму
		$form_data = (!empty($post)) ? $post : $post_step1;

		$this->model('calculator_req')->initValues(array('currency'), array('currency' => array('keyField' => 'code', 'cond' => array('order' => array('pos' => 'ASC')))));
		$fields = $this->model('calculator_req')->getFields('calculator_req', 'site_form');
		$this->loadForm('calculator_req', $fields, $form_data, '/calc/step1');
		$cur_currency = (isset($form_data['currency'])) ? $this->model('calculator_req')->GetByCond('currencies', array('id', 'title'), array('code' => $form_data['currency'])): array();
		$this->page->cur_currency_title = (!empty($cur_currency) && isset($cur_currency['title'])) ? $cur_currency['title'] : '';

		$user = $this->app->session->siteuser;

		$error = '';
		$ret = array();
		try {
			if (!empty($post) && isset($post['calculator_form'])) {
				if (isset($post['data'])) {
					// todo Авторизованный пользователь. пока передается пустой.
					$data = array('UserID' => (!empty($user['email'])) ? $user['email'] : '', 'Strings' => array());
					$values = array();
					$val_sum_error = false;
					// Нажали кнопку расчитать
					if (!empty($post['data'])) {
						foreach($post['data'] as $k => $val){
							if (!empty($val['code'])) {
								$val['summ'] = $this->parseNumbers($val['summ']);
								$values[] = $val;
								$needed_length = (isset($post['tnved']) && $post['tnved'] == 'yes') ? 10 : 9;
								$code_length = strlen($val['code']);
								$code = ($code_length == $needed_length) ? $val['code'] : str_repeat('0', $needed_length-$code_length).$val['code'];
								$data['Strings'][] = array('Kod' => $code, 'Summ' => (isset($val['summ']) ? $val['summ'] : 0));
								if (empty($val['summ'])) {
									$val_sum_error = true;
								}
							} else {
								unset($post['data'][$k]);
							}
						}
					}
					$this->page->values = $values;
					if ($val_sum_error) {
						throw new Exception('Выберите стоимость всех товаров.');
					}
					if (isset($post['tnved'])) {
						$data['ItIsCategory'] = $post['tnved'] == 'yes' ? 'false' : 'true';
					} else {
						throw new Exception('Укажите способ выбора типов товаров.');
					}

					if (empty($data['Strings'])){
						throw new Exception('Выберите товар и его стоимость.');
					}
					//2 параметра date и number, если они не будут заполнены - создаем соответсвующий документ, заполнены - изменяем существующий
					$data['Date'] = $data['Number'] = '';
					$currencies = $this->model('calculator_req')->getValues('code', 'title', 'currencies', array());
					$this->currencies = $currencies;
					if (isset($post['currency']) && $post['currency'] && isset($currencies[$post['currency']])) {
						$data['Currency'] = $post['currency'];
					} else {
						throw new Exception('Укажите валюту');
					}

					$ret = $this->soap('GetSumm', array('Data' => $data));

					if (empty($ret->return)) {
						throw new Exception('Не предвиденная ошибка. Попробуйте ещё раз через несколько минут.');
					}
					$ret = (array)$this->model('calculator_req')->parseReturn($ret);
					//$this->app->session->calc = $post;
				}
			} elseif (!empty($post) && !isset($post['calculator_form'])) {
				throw new Exception('Вы не нажали на кнопку Рассчитать.');
			} elseif (!empty($form_data)) {
				$values = array();
				// Нажали кнопку расчитать
				if (!empty($form_data['data'])) {
					foreach($form_data['data'] as $k => $val){
						if (!empty($val['code']) && !empty($val['summ'])) {
							$val['summ'] = $this->parseNumbers($val['summ']);
							$values[] = $val;
							$needed_length = (isset($form_data['tnved']) && $form_data['tnved'] == 'yes') ? 10 : 9;
							$code_length = strlen($val['code']);
							$code = ($code_length == $needed_length) ? $val['code'] : str_repeat('0', $needed_length-$code_length).$val['code'];
							$data['Strings'][] = array('Kod' => $code, 'Summ' => $val['summ']);
						} else {
							unset($form_data['data'][$k]);
						}
					}
				}
				$this->page->values = $values;
			}
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
		if (!empty($error) || empty($post)) {
			$this->page->errors_calculator = $error;
			$this->page->content = $this->renderView('calc');
			$this->setMeta('Страховой калькулятор. Шаг 1');
		} else {
			$this->updateStep(1, $post, $ret);
			header('Location: /calc/step2');
		}
		$this->loadView('main', null);
	}

	public function actionStep2() {
		// если пользователь выпал из сессии, то перебрасываем его на начало рассчета
		$user = $this->app->session->siteuser;
		if (empty($user)) {
			header("Location: /calc");
		}

		// при возврате на второй шаг, очищаем сессию третьего шага
		$this->clearStep(3);
		// новые данные поста
		$post = (!empty($_POST)) ? $_POST : array();
		// сохраненные данные поста
		$post_step2 = ($this->app->session->step2 !== null && !empty($this->app->session->step2['post'])) ? $this->app->session->step2['post']: array();
		// данные в форму
		$form_data = (!empty($post)) ? $post : $post_step2;

		$error = '';
		$ret = array();
		$data = array();

		try {
			if (empty($post)) {
				$ret_step1 = ($this->app->session->step1 !== null && !empty($this->app->session->step1['add_data'])) ? $this->app->session->step1['add_data']: array();
				if (isset($ret_step1['variants'])) {
					$i = 1;
					foreach ($ret_step1['variants'] as &$variant) {
						$variant = (array)$variant;
						$variant['number'] = $i++;
					}
					if ($form_data && !empty($form_data['variant'])) {
						if (!empty($ret_step1['variants'])) {
							foreach ($ret_step1['variants'] as $key => $var) {
								if ($var['number'] == $form_data['variant']) {
									$ret_step1['variants'][$key]['selected'] = 1;
								}
							}
						}
					}
				}
				$this->page->insurance = $ret_step1;
			} elseif (!empty($post)) {
				$user = $this->app->session->siteuser;
				if (
					!isset($post['variants']) || !$post['variants']
					|| !isset($post['order_number']) || !$post['order_number']
					|| !isset($post['order_date']) || !$post['order_date']
				) {
					header("Location: /calc");
				} else {
					$data = array(
						'NumberOfPreOrder' => $post['order_number'],
						'DateOfPreOrder' => $post['order_date'],
						'variants' =>  $post['variants']
					);
				}
				if (!isset($post['variant']) || !$post['variant']) {
					$this->page->insurance = $data;
					throw new Exception('Выберите вариант страхования');
				} else {
					$data['variants'][$post['variant']]['selected'] = 1;

					$selected_var = $data['variants'][$post['variant']];
					$ret = $this->soap('ApplyMethod', array('Data' => array(
						'NumberOfPreOrder'  => $post['order_number'],
						'DateOfPreOrder'    => $post['order_date'],
						'Company'           => $selected_var['company'],
						'UserID'            => (!empty($user['email'])) ? $user['email'] : '',
						'InsuranceType'     => $selected_var['ins_type']
					)));
					if (empty($ret->return)) {
						throw new Exception('Не предвиденная ошибка. Попробуйте ещё раз через несколько минут.');
					}
					$ret = $this->model('calculator_req')->parseReturn($ret);
				}
			}
		} catch (Exception $e) {
			$this->page->insurance = $data;
			$error = $e->getMessage();
		}

		if (!empty($error) || empty($post)) {
			$this->page->errors_calculator = $error;
			$this->page->content = $this->renderView('step2');
			$this->setMeta('Страховой калькулятор. Шаг 2');
		} else {
			$this->updateStep(2, $post, $ret);
			header('Location: /calc/step3');
		}
		$this->loadView('main', null);
	}

	public function actionStep3() {
		// если пользователь выпал из сессии, то перебрасываем его на начало рассчета
		$user = $this->app->session->siteuser;
		if (empty($user)) {
			header("Location: /calc");
		}

		// новые данные поста
		$post = (!empty($_POST)) ? $_POST : array();
		// сохраненный пост второго шага
		$post_step2 = ($this->app->session->step2 !== null && !empty($this->app->session->step2['post'])) ? $this->app->session->step2['post']: array();
		// сохраненные данные поста
		$post_step3 = ($this->app->session->step3 !== null && !empty($this->app->session->step3['post'])) ? $this->app->session->step3['post']: array();
		// данные в форму
		$form_data = (!empty($post)) ? $post : $post_step3;
		$error = '';
		try {
			if (empty($post)) {
				$ret_step2 = ($this->app->session->step2 !== null && !empty($this->app->session->step2['add_data'])) ? $this->app->session->step2['add_data']: array();
				if ($ret_step2) {
					if ($form_data && !empty($form_data['order'])) {
						$order = $form_data['order'];
					} else {
						$order = array(
							'NumberOfPreOrder'  => $post_step2['order_number'],
							'DateOfPreOrder'    => $post_step2['order_date'],
						);
					}
					// достаём из сессии коды категорий
					$session_calc = ($this->app->session->step1 !== null && !empty($this->app->session->step1['post'])) ? $this->app->session->step1['post']: array();
					if ($session_calc['tnved'] == 'no') {
						$values = '';
						$arr = $this->getCategories();

						if (!empty($session_calc['data'])) {
							foreach($session_calc['data'] as $kode){
								if (!empty($arr)) {
									foreach($arr as $key => $val) {
										$q = mb_convert_case($kode['code'], MB_CASE_LOWER, "UTF-8");
										if (mb_strpos(mb_convert_case($val, MB_CASE_LOWER, "UTF-8"), $q) !== false || mb_stripos($key, $q) !== false) {
											$values .= trim($val).":\n";
										}
									}
								}
							}
						}

						$order['Consignment'] = $values;
					}
					zf::addJS('order', '/public/site/js/calc/order.js');
					$langFile = zf::gi()->app->conf['charset'] == 'utf-8' ? 'calendar-ru.js' : 'calendar-ru-cp1251.js';
					zf::addJS('dynDateTime', '/public/zf/js/jquery.dynDateTime.js');
					zf::addJS('dynDateTime_lang', "/public/zf/js/dyndatetime/$langFile");
					zf::addCSS('dynDateTime', '/public/zf/css/calendar-blue.css');
					$this->setMeta('Страховой калькулятор. Шаг 3');
					$this->page->countries = $this->model('siteusers')->getCountries($this->page->settings);
					$this->page->transport = $this->transport;
					$this->page->order = $order;
					$this->page->NumberOfSeatMeasure = $this->model('siteusers')->getSeatMeasures($this->page->settings);
					$this->page->content = $this->renderView('order');
				}
			} elseif (!empty($post)) {
				zf::addJS('order', '/public/site/js/calc/order.js');
				$langFile = zf::gi()->app->conf['charset'] == 'utf-8' ? 'calendar-ru.js' : 'calendar-ru-cp1251.js';
				zf::addJS('dynDateTime', '/public/zf/js/jquery.dynDateTime.js');
				zf::addJS('dynDateTime_lang', "/public/zf/js/dyndatetime/$langFile");
				zf::addCSS('dynDateTime', '/public/zf/css/calendar-blue.css');
				$this->setMeta('Страховой калькулятор. Шаг 3');
				$this->page->countries = $this->model('siteusers')->getCountries($this->page->settings);
				$this->page->transport = $this->transport;
				$this->page->NumberOfSeatMeasure = $this->model('siteusers')->getSeatMeasures($this->page->settings);
				$order_id = '';
				$order_date = '';
				$user = $this->app->session->siteuser;
				$send_order = ($order_id && $order_date)
					? array('NumberOfPreOrder'  => $order_id, 'DateOfPreOrder'    => $order_date)
					: array();

				//debug::dump($this->app->session->calc);
				if (isset($post['order'])) {

					$order = $post['order'];
					$this->page->order = $order;

					if (empty($user)) {
						throw new Exception('Вы должны авторизоваться.');
					}

                    if (!isset($post['order']['NumberOfSeat']) || empty($post['order']['NumberOfSeat']))
                        throw new Exception('Не задано поле {Количество мест}.');
                    if (!is_numeric($post['order']['NumberOfSeat']))
                        throw new Exception('Поле {Количество мест} должно быть числом.');

					$send_order['UserID'] = $user['email'];

					$send_order['DateOfPreOrder'] = (!empty($post['order']['DateOfPreOrder'])) ? $post['order']['DateOfPreOrder'] : '';
					$send_order['NumberOfPreOrder'] = (!empty($post['order']['NumberOfPreOrder'])) ? $post['order']['NumberOfPreOrder'] : '';
					$send_order['CompanyName'] = (!empty($post['order']['CompanyName'])) ? $post['order']['CompanyName'] : '';
					$send_order['Beneficiary'] = (!empty($post['order']['Beneficiary'])) ? $post['order']['Beneficiary'] : '';
					$send_order['NumberOfSeat'] = (!empty($post['order']['NumberOfSeat'])) ? $post['order']['NumberOfSeat'] : '';

                    var_dump($post['order']['Consignment']);
                    var_dump($post['order']['NumberOfSeat']);

                    $send_order['Consignment'] = (!empty($post['order']['Consignment'])) ? $this->parseNumbers($post['order']['Consignment']) : '';

                    var_dump($send_order['Consignment']);die;

                    $send_order['NumberOfSeatMeasure'] = (!empty($post['order']['NumberOfSeatMeasure'])) ? $post['order']['NumberOfSeatMeasure'] : '';
					$send_order['Weight'] = (!empty($post['order']['Weight'])) ? $this->parseNumbers($post['order']['Weight']) : '';
					$send_order['WeightMeasure'] = (!empty($post['order']['WeightMeasure'])) ? $post['order']['WeightMeasure'] : '';
					$send_order['Documents'] = (!empty($post['order']['Documents'])) ? $post['order']['Documents'] : '';

					if (empty($post['order']['StartDate'])){
						throw new Exception("Нужно указать дату начала страхования.");
					} elseif (strtotime($post['order']['StartDate']) === false){
						throw new Exception("Неправильный формат даты начала страхования.");
					}
					$send_order['StartDate'] = $post['order']['StartDate'];

					if (empty($post['order']['EndDate'])){
						throw new Exception("Нужно указать дату окончания страхования.");
					} elseif (strtotime($post['order']['EndDate']) === false){
						throw new Exception("Неправильный формат даты окончания страхования.");
					}
					$send_order['EndDate'] = $post['order']['EndDate'];

					if ($send_order['StartDate'] > $send_order['EndDate']) {
						throw new Exception("Дата начала страхования не может быть позже даты окончания страхования.");
					}

					$send_order['Date'] = '';
					$send_order['Number'] = '';
					// вычисляем разницу между датами

					if (!function_exists('diff')) {
						$diff = $this->date_diff($send_order['StartDate'], $send_order['EndDate']);
						$diff = $diff['days'];
					} else {
						$EndDate = new DateTime($send_order['EndDate']);
						$StartDate = new DateTime($send_order['StartDate']);
						$diff = $EndDate->diff($StartDate, 1);
						$diff = $diff->days;
					}
					if ($diff > 60) {
						throw new Exception("Разница между датой начала и датой окончания страхования не может превышать более 60 дней.");
					}

					if (!empty($post['order']['route']['begin']['Country'])) {
						$this->page->begin_cities = $this->model('siteusers')->getCitiesList($post['order']['route']['begin']['Country'], $this->page->settings);
					}
					if (!empty($post['order']['route']['end']['Country'])) {
						$this->page->end_cities = $this->model('siteusers')->getCitiesList($post['order']['route']['end']['Country'], $this->page->settings);
					}
					$send_order['Transports'] = array();
					if (isset($post['order']['route']) && isset($post['order']['route']['begin'])
						&& !empty($post['order']['route']['begin']['Country'])
						&& !empty($post['order']['route']['begin']['City'])
						&& !empty($post['order']['route']['begin']['Transport'])
						&& !empty($post['order']['route']['begin']['RegistrationNumber'])
					) {
						$send_order['Transports'][] = $post['order']['route']['begin'];
					} else {
						throw new Exception("Нужно указать начальную точку маршрута.");
					}
					//debug::dump($order);

					if (isset($order['route']) && isset($order['route']['middle'])) {
						foreach($order['route']['middle'] as &$route_point) {
							$send_order['Transports'][] = $route_point;
							$route_point['cities'] = $this->model('siteusers')->getCitiesList($route_point['Country'], $this->page->settings);
						}
						unset($route_point);

					}

					if (isset($post['order']['route']) && isset($post['order']['route']['end'])
						&& !empty($post['order']['route']['end']['Country'])
						&& !empty($post['order']['route']['end']['City'])
						&& !empty($post['order']['route']['end']['Transport'])
						&& !empty($post['order']['route']['end']['RegistrationNumber'])
					) {
						$send_order['Transports'][] = $post['order']['route']['end'];
					} else {
						throw new Exception("Нужно указать конечную точку маршрута.");
					}
					if (!empty($post['order']['verifyCode']) && $post['order']['verifyCode'] == misc::get($_SESSION, 'zf_kcaptcha_key')) {
                        var_dump($send_order);die;
                        $ret = $this->soap('CreateOrder', array('Data' => $send_order));
//
						/*debug::dump($send_order);
						debug::dump(json_encode(array('Data' => $send_order)));*/
//                        var_dump($ret->return);die;
						if (empty($ret->return)) {
							throw new Exception('Непредвиденная ошибка. Попробуйте ещё раз через несколько минут.');
						} else {
							$this->page->success = 1;
						}
						$ret = $this->model('calculator_req')->parseReturn($ret, false);
						if (!empty($ret)) {
							$order_id = json_decode($ret, 1);
							$this->page->order_id = (int)$order_id['number_of_order'];
						}
						debug::add_log($ret, 'return soap:');
					} else {
						throw new Exception('Введите код с картинки.');
					}
				}
			}
		} catch(Exception $e) {
			$error = $e->getMessage();
		}
		if (!empty($error) || empty($post)) {
			$this->page->errors_calculator = $error;
			$this->page->content = $this->renderView('order');
			$this->setMeta('Страховой калькулятор. Шаг 3');
		} else {
			$this->updateStep(3, $post, $ret);
			$this->page->content = $this->renderView('order');
			$this->setMeta('Страховой калькулятор. Шаг 3');
		}
		$this->loadView('main', null);
	}

    /*
     *
     */
    public function actionCities() {
        //if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' && !empty($_GET['country'])) {
            $this->app->contentType = 'application/json';
            $cities = $this->model('siteusers')->getCitiesList($_GET['country'], $this->page->settings);
            die(json_encode(array('values' => $cities)));
        /*} else {
            header('Location: /');
            exit;
        }*/
    }

    /**
     * AJAX функция автодополнения кодов ТНВЭД
     * @param string $q
     * @param bool $page_limit
     */
    public function actionTnved() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $this->app->contentType = 'application/json';
            $q = isset($_GET['q']) ? $_GET['q'] : '';
            $page_limit = isset($_GET['page_limit']) ? $_GET['page_limit'] : 500;
            $tnved = isset($_GET['tnved']) ? $_GET['tnved'] : 'yes';
            $values = array();
            $total = 0;
            // Инициализация селекта
            if (isset($_GET['id']) && $_GET['id']) {
                if ($tnved == 'yes') {
	                $tmp = $this->model('calculator_req')->GetByCond('tnved', array('code', 'title'), array('code' => $_GET['id']));

                    $values = array(
                        'id' => $tmp['code'],
                        'text' => $tmp['code'].' - '.$tmp['title']
                    );
                } else {
                    $arr = $this->getCategories();
                    if (isset($arr[strtolower($_GET['id'])])) {
                        $values = array(
                            'id' => $_GET['id'],
                            'text' => $_GET['id'].' - '.$arr[$_GET['id']]
                        );
                    }
                }
                // Автодополнение селекта
            } elseif ($q && mb_strlen($q) >= 4) {
                if ($tnved == 'yes') {
                    $tmp = $this->model('calculator_req')->getPage('tnved', array('code', 'title'), $total, 0, $page_limit, array('!raw1' => "`code` LIKE '{$q}%' OR `title` LIKE '%{$q}%'"));
                    if ($tmp) { foreach($tmp as $t) {
                        $values[] = array(
                            'id' => $t['code'],
                            'text' => $t['code'].' - '.$t['title']
                        );
                    } }

                    /*$values = array(
                        array(
                            'id' => 101210000,
                            'text' => '101210000 - 101210000'
                        )
                    );*/
                } else {
                    $arr = $this->getCategories();
                    $q = mb_convert_case($q, MB_CASE_LOWER, "UTF-8");
                    if (!empty($arr)) {
                        foreach($arr as $key => $val) {
                            if (mb_strpos(mb_convert_case($val, MB_CASE_LOWER, "UTF-8"), $q) !== false || mb_stripos($key, $q) !== false) {
                                $values[] = array(
                                    'id' => $key,
                                    'text' => $key.' - '.$val
                                );
                            }
                        }
                    }
                }

            }
            echo json_encode(array('values' => $values));
        } else {
            header('Location: /');
            exit;
        }
    }

    /**
     * Список категорий грузов, используемых калькулятором
     * @return array|mixed Массив идентификатор => название
     */
    public function getCategories() {
        $cacher = $this->app->getCacher('.zf_cache/categories_values', 5400);
        $soap = $cacher->get('categories_values');
        if ($soap == cacher::EXPIRED || $soap == cacher::NO_DATA) {
            $soap = null;
            debug::add('Последний журнал для кеша. ($soap)', 'cache');
            $tmp = $this->soap('GetCategory', array());
            $tmp = $this->model('calculator_req')->parseReturn($tmp);
            if ($tmp) foreach ($tmp as $sub_tmp) {
                // Т.к. sub_tmp = array('key' => 'title');
                $soap[strtolower(key($sub_tmp))] = current($sub_tmp);
            }
            $cacher->put('categories_values', $soap, 5400);
        } else {
            debug::add('Последний журнал для шапки из кеша. ($soap)', 'cache');
        }

        return $soap;
    }

    
    public function soap($func_name, $data, $erp = false) {
        $config = $this->page->settings;//debug::dump($func_name);
        return $this->model('siteusers')->soap($func_name, $data, $erp, $config);
    }

    public function setMeta($title) {
        if(count($this->page->meta) < 2) {
            $text = $title;
            $meta_tags['title'] = $meta_tags['keywords'] = $meta_tags['description'] = $text;
            $this->page->meta = $meta_tags;
        }
    }

    public function parseNumbers($number) {
        return str_replace(array(' ', ','), array('', '.'), $number);
    }

    function date_diff($date1, $date2) {
        $d1 = new DateTime($date1);
        $d2 = new DateTime($date2);
        $td = $d1->format('U') - $d2->format('U');
        $y = floor($td / 31557600);
        $m = floor(($td - $y * 31557600) / 2629800);
        $d = floor(($td - $y * 31557600 - $m * 2629800) / 86400);
        $h = floor(($td - $y * 31557600 - $m * 2629800 - $d * 86400) / 3600);
        $min = floor(($td - $y * 31557600 - $m * 2629800 - $d * 86400 - $h * 3600) / 60);
        return array(
            'years' => $y,
            'months' => $m,
            'days' => $d,
            'hours' => $h,
            'minutes' => $min,
            'seconds' => $td - $y * 31557600 - $m * 2629800 - $d * 86400 - $h * 3600 - $min * 60
        );
    }
}