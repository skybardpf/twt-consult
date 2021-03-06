<?php

/**
 * This is the model class for table "banners".
 *
 * The followings are the available columns in table 'banners':
 * @property integer $id
 * @property string $pos
 * @property string $created
 * @property string $title
 * @property string $image
 * @property string $url
 * @property string $type
 * @property string $active
 */
class Banner extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'banners';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pos, created, title, image', 'required'),
			array('pos', 'length', 'max'=>10),
			array('title', 'length', 'max'=>200),
			array('type', 'length', 'max'=>6),
			array('active', 'length', 'max'=>3),
			array('url', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pos, created, title, image, url, type, active', 'safe', 'on'=>'search'),
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
			'pos' => 'Pos',
			'created' => 'Created',
			'title' => 'Title',
			'image' => 'Image',
			'url' => 'Url',
			'type' => 'Type',
			'active' => 'Active',
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
		$criteria->compare('pos',$this->pos,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Banner the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @return Banner[]
     */
    public function gerRandomBanners()
    {
        $crt = new CDbCriteria();
        $crt->order = 'rand()';
        $crt->limit = '3';
        $crt->condition = 'active=:active AND type=:type';
        $crt->params = array(':active' => 'yes', ':type' => 'banner');
        return $this->findAll($crt);
    }

    /**
     * @return Banner
     */
    public function gerRandomPromo()
    {
        $crt = new CDbCriteria();
        $crt->order = 'rand()';
        $crt->limit = '1';
        $crt->condition = 'active=:active AND type=:type';
        $crt->params = array(':active' => 'yes', ':type' => 'promo');
        return $this->find($crt);
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return '/img/announcies/original/'.$this->image;
    }
}
