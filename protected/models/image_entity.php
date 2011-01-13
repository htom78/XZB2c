<?php

/**
 * This is the model class for table "{{image_entity}}".
 *
 * The followings are the available columns in table '{{image_entity}}':
 * @property integer $image_ID
 * @property integer $image_product_ID
 * @property string $image_name
 * @property string $image_legend
 * @property integer $image_cover
 * @property integer $image_position
 */
class image_entity extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return image_entity the static model class
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
		return '{{image_entity}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('image_product_ID, image_name, image_cover, image_position', 'required'),
			array('image_product_ID, image_cover, image_position', 'numerical', 'integerOnly'=>true),
			array('image_name, image_legend', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('image_ID, image_product_ID, image_name, image_legend, image_cover, image_position', 'safe', 'on'=>'search'),
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
			'image_ID' => 'Image',
			'image_product_ID' => 'Image Product',
			'image_name' => 'Image Name',
			'image_legend' => 'Image Legend',
			'image_cover' => 'Image Cover',
			'image_position' => 'Image Position',
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

		$criteria->compare('image_ID',$this->image_ID);

		$criteria->compare('image_product_ID',$this->image_product_ID);

		$criteria->compare('image_name',$this->image_name,true);

		$criteria->compare('image_legend',$this->image_legend,true);

		$criteria->compare('image_cover',$this->image_cover);

		$criteria->compare('image_position',$this->image_position);

		return new CActiveDataProvider('image_entity', array(
			'criteria'=>$criteria,
		));
	}

    public function getLargeImage()
    {
        $path='/media/products/';
        return $path .$this->image_name;
    }

    public function getMiddleImage()
    {
         $path='/media/products/middle/';
        return $path .$this->image_name;
    }

    public function getSmallImage()
    {
         $path='/media/products/small/';
        return $path .$this->image_name;
    }

    public static function productCover($product_ID)
    {
        if(!$product_ID)
        {
            return;
        }

          $req = Yii::app()->db->createCommand(
                "SELECT image_ID as id"
                . " FROM {{image_entity}} "
                . " WHERE image_product_ID={$product_ID} AND image_cover=1"
        );
        $res=$req->queryRow();
        if($res)
        {
            return $res['id'];
        }
        
    }

    public static function updateProductCover($old_cover,$new_cover)
    {
        if(!$old_cover || !$new_cover)
        {
           return ;
        }
         $req = Yii::app()->db->createCommand(
                "UPDATE {{image_entity}}"
                . " SET image_cover=0 "
                . " WHERE image_ID={$old_cover}"
        );
        $req->query();
        $req = Yii::app()->db->createCommand(
                "UPDATE {{image_entity}}"
                . " SET image_cover=1 "
                . " WHERE image_ID={$new_cover}"
        );
        $req->query();

    }
}