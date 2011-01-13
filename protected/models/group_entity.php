<?php

/**
 * This is the model class for table "{{group_entity}}".
 *
 * The followings are the available columns in table '{{group_entity}}':
 * @property integer $group_ID
 * @property string $group_name
 * @property string $group_reduction
 * @property string $group_create
 * @property string $group_update
 */
class group_entity extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return group_entity the static model class
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
		return '{{group_entity}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_name, group_reduction,group_update', 'required'),
			array('group_name', 'length', 'max'=>32),
			array('group_reduction', 'length', 'max'=>17),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('group_ID, group_name, group_reduction, group_create, group_update', 'safe', 'on'=>'search'),
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
            'member'=>array(self::STAT,'customer_group','group_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'group_ID' => 'Group',
			'group_name' => 'Group Name',
			'group_reduction' => 'Group Reduction',
			'group_create' => 'Group Create',
			'group_update' => 'Group Update',
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

		$criteria->compare('group_ID',$this->group_ID);

		$criteria->compare('group_name',$this->group_name,true);

		$criteria->compare('group_reduction',$this->group_reduction,true);


		return new CActiveDataProvider('group_entity', array(
			'criteria'=>$criteria,
		));
	}

     protected function beforeValidate()
        {
            $this->group_update = date('Y-m-d H:i:s');
            return true;
        }

     public static function items()
	{
      
          $req = Yii::app()->db->createCommand(
                "SELECT m1.group_ID as id ,m1.group_name as name "
                . " FROM {{group_entity}} AS m1 "
                . " ORDER BY m1.group_ID ASC "
        );

        $out=array();
        $res=$req->queryAll();
        foreach ($res as $row)
        {
           $out[$row['id']]=$row['name'];
        }
        return $out;

	}


    public static function item($ID)
	{
         $req = Yii::app()->db->createCommand(
               "SELECT m1.group_name as name "
                . " FROM {{group_entity}} AS m1 "
                . " WHERE m1.group_ID={$ID}"
                . " ORDER BY m1.group_ID ASC "
        );
         $res=$req->queryRow();
         if(!$res)
         {
             return ;
         }
         return $res['name'];
	}
}