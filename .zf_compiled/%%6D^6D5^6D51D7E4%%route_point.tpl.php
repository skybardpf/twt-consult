<?php /* Smarty version 2.6.25, created on 2013-08-22 14:01:26
         compiled from /home/leadert/webserver/twt-consult/www/site/views/calc/route_point.tpl */ ?>
<table>
    <tr>
        <td style="width: 85px;"><label>Страна</label></td>
        <td>
            <select name="order[route][<?php echo $this->_tpl_vars['field']; ?>
]<?php if ($this->_tpl_vars['iteration']): ?>[<?php echo $this->_tpl_vars['iteration']; ?>
]<?php endif; ?>[Country]" data-route_input="1" data-country_input="1"<?php if ($this->_tpl_vars['iteration'] == '__iteration__'): ?> disabled="disabled"<?php endif; ?>>
                <option value="">Не выбрана</option>
                <?php $_from = $this->_tpl_vars['countries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cr']):
?>
                    <option value="<?php echo $this->_tpl_vars['cr']->id; ?>
"<?php if ($this->_tpl_vars['point']['Country'] == $this->_tpl_vars['cr']->id): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['cr']->name; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><label>Город</label></td>
        <td>
            <select name="order[route][<?php echo $this->_tpl_vars['field']; ?>
]<?php if ($this->_tpl_vars['iteration']): ?>[<?php echo $this->_tpl_vars['iteration']; ?>
]<?php endif; ?>[City]" data-route_input="1" data-city_input="1"<?php if ($this->_tpl_vars['iteration'] == '__iteration__'): ?> disabled="disabled"<?php endif; ?>>
                <option value="">Не выбрана</option>
                <?php $_from = $this->_tpl_vars['cities']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['c']):
?>
                    <option value="<?php echo $this->_tpl_vars['k']; ?>
"<?php if ($this->_tpl_vars['point']['City'] == $this->_tpl_vars['k']): ?> selected="selected" <?php endif; ?>><?php echo $this->_tpl_vars['c']; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><label>Транспорт</label></td>
        <td>
            <select name="order[route][<?php echo $this->_tpl_vars['field']; ?>
]<?php if ($this->_tpl_vars['iteration']): ?>[<?php echo $this->_tpl_vars['iteration']; ?>
]<?php endif; ?>[Transport]" data-route_input="1"<?php if ($this->_tpl_vars['iteration'] == '__iteration__'): ?> disabled="disabled"<?php endif; ?>>
                <?php $_from = $this->_tpl_vars['transport']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                    <option value="<?php echo $this->_tpl_vars['k']; ?>
"<?php if ($this->_tpl_vars['point']['Transport'] == $this->_tpl_vars['k']): ?> selected="selected" <?php endif; ?>><?php echo $this->_tpl_vars['v']; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><label>Номер транспорт. средства</label></td>
        <td><input type="text" name="order[route][<?php echo $this->_tpl_vars['field']; ?>
]<?php if ($this->_tpl_vars['iteration']): ?>[<?php echo $this->_tpl_vars['iteration']; ?>
]<?php endif; ?>[RegistrationNumber]" data-route_input="1" value="<?php if ($this->_tpl_vars['point']['RegistrationNumber']): ?><?php echo $this->_tpl_vars['point']['RegistrationNumber']; ?>
<?php endif; ?>"<?php if ($this->_tpl_vars['iteration'] == '__iteration__'): ?> disabled="disabled"<?php endif; ?>/></td>
    </tr>
</table>