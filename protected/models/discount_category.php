<?php

/**
 * This is the model class for table "{{discount_category}}".
 *
 * The followings are the available columns in table '{{discount_category}}':
 * @property integer $category_ID
 * @property integer $discount_ID
 */
class discount_category extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return discount_category the static model class
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
		return '{{discount_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_ID, discount_ID', 'required'),
			array('category_ID, discount_ID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('category_ID, discount_ID', 'safe', 'on'=>'search'),
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
			'category_ID' => 'Category',
			'discount_ID' => 'Discount',
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

		$criteria->compare('category_ID',$this->category_ID);

		$criteria->compare('discount_ID',$this->discount_ID);

		return new CActiveDataProvider('discount_category', array(
			'criteria'=>$criteria,
		));
	}
       public static function AddItem($discount_ID, $categoryIDS)
        {
            if ($discount_ID == NULL || $categoryIDS == NULL)
            {
                return;
            }
            foreach ($categoryIDS as $row)
            {
                $insert.="('{$discount_ID}','{$row}'),";
            }
            $insert = trim($insert, ',');
            $req = Yii::app()->db->createCommand(
                            "INSERT INTO {{discount_category}} "
                            . " (`discount_ID`,`category_ID`) VALUES " . $insert
            );

            return $req->query();
        }

         public static function updateItem($discount_ID, $categoryIDS)
        {
            if (!$categoryIDS)
            {
                return;
            }
              $oldIDS = self::items($discount_ID);
            if ($oldIDS)
            {
                $del = array_diff($oldIDS, $categoryIDS);
                $add = array_diff($categoryIDS, $oldIDS);
            }
            else
            {
                $add = $categoryIDS;
            }
            self::deleteItem($discount_ID, $del);
            self::addItem($discount_ID, $add);

        }

        public static function deleteItem($discount_ID,$categoryIDS)
        {
             if ($discount_ID == NULL || $categoryIDS == NULL)
            {
                return;
            }
            $IN=trim(implode(',', $categoryIDS),',');
               $req = Yii::app()->db->createCommand(
                            "DELETE FROM {{discount_category}} "
                            . " WHERE category_ID IN ({$IN}) and discount_ID={$discount_ID} "
            );
           $req->query();
        }

        public static function items($discount_ID)
        {
            $res = array();
            if (!$discount_ID)
            {
                return $res;
            }
            $req = Yii::app()->db->createCommand(
                            "SELECT category_ID as id FROM {{discount_category}} where discount_ID={$discount_ID}"
            );
            $res = $req->queryColumn();
            return $res;
        }
}