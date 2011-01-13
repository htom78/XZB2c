<?php

/**
 * This is the model class for table "{{seo}}".
 *
 * The followings are the available columns in table '{{seo}}':
 * @property integer $SEO_ID
 * @property string $SEO_title
 * @property string $SEO_keyword
 * @property string $SEO_description
 */
class seo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return seo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{seo}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('SEO_title, SEO_keyword, SEO_description', 'required'),
			array('SEO_title', 'length', 'max'=>100),
			array('SEO_keyword, SEO_description', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('SEO_ID, SEO_title, SEO_keyword, SEO_description', 'safe', 'on'=>'search'),
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
			'SEO_ID' => 'Seo',
			'SEO_title' => 'Seo Title',
			'SEO_keyword' => 'Seo Keyword',
			'SEO_description' => 'Seo Description',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('SEO_ID',$this->SEO_ID);

		$criteria->compare('SEO_title',$this->SEO_title,true);

		$criteria->compare('SEO_keyword',$this->SEO_keyword,true);

		$criteria->compare('SEO_description',$this->SEO_description,true);

		return new CActiveDataProvider('seo', array(
			'criteria'=>$criteria,
		));
	}
}