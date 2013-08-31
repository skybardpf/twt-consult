<?php

/**
 * This is the model class for table "countries".
 *
 * The followings are the available columns in table 'countries':
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $text
 * @property string $price
 * @property string $price_final
 * @property string $flag
 * @property string $pos
 * @property string $code
 * @property string $receiver
 * @property string $source
 * @property string $in_list
 * @property string $active
 * @property string $quotation
 */
class Country extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'countries';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, url, pos, code', 'required'),
			array('pos', 'length', 'max'=>10),
			array('code', 'length', 'max'=>255),
			array('receiver, source, in_list, active', 'length', 'max'=>3),
			array('quotation', 'length', 'max'=>5),
			array('text, price, price_final, flag', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, url, text, price, price_final, flag, pos, code, receiver, source, in_list, active, quotation', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'url' => 'Url',
			'text' => 'Text',
			'price' => 'Price',
			'price_final' => 'Price Final',
			'flag' => 'Flag',
			'pos' => 'Pos',
			'code' => 'Code',
			'receiver' => 'Receiver',
			'source' => 'Source',
			'in_list' => 'In List',
			'active' => 'Active',
			'quotation' => 'Quotation',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('price_final',$this->price_final,true);
		$criteria->compare('flag',$this->flag,true);
		$criteria->compare('pos',$this->pos,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('receiver',$this->receiver,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('in_list',$this->in_list,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('quotation',$this->quotation,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Country the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @return string
     */
    public function getUrlFlag()
    {
        return '/img/countries/small/'.$this->flag;
    }
}
