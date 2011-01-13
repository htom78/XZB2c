<?php

    /**
     * This is the model class for table "{{category_product}}".
     *
     * The followings are the available columns in table '{{category_product}}':
     * @property integer $category_ID
     * @property integer $product_ID
     */
    class category_product extends CActiveRecord
    {

        /**
         * Returns the static model of the specified AR class.
         * @return category_product the static model class
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
            return '{{category_product}}';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('category_ID, product_ID', 'required'),
                array('category_ID, product_ID', 'numerical', 'integerOnly' => true),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('category_ID, product_ID', 'safe', 'on' => 'search'),
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
                'product_ID' => 'Product',
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

            $criteria = new CDbCriteria;

            $criteria->compare('category_ID', $this->category_ID);

            $criteria->compare('product_ID', $this->product_ID);

            return new CActiveDataProvider('category_product', array(
                'criteria' => $criteria,
            ));
        }

        public static function productAddment($product_ID, $categoryIDS)
        {
            if ($product_ID == NULL || $categoryIDS == NULL)
            {
                return;
            }
            foreach ($categoryIDS as $row)
            {
                $insert.="('{$product_ID}','{$row}'),";
            }
            $insert = trim($insert, ',');
            $req = Yii::app()->db->createCommand(
                            "INSERT INTO {{category_product}} "
                            . " (`product_ID`,`category_ID`) VALUES " . $insert
            );

            return $req->query();
        }

        public static function productAlert($product_ID, $categoryIDS)
        {
            if (!$categoryIDS)
            {
                return;
            }
              $oldIDS = self::getCategoryIDS($product_ID);
            if ($oldIDS)
            {
                $del = array_diff($oldIDS, $categoryIDS);
                $add = array_diff($categoryIDS, $oldIDS);
            }
            else
            {
                $add = $categoryIDS;
            }
            self::productDelete($product_ID, $del);
            self::productAddment($product_ID, $add);
         
        }

        public static function productDelete($product_ID,$categoryIDS)
        {
             if ($product_ID == NULL || $categoryIDS == NULL)
            {
                return;
            }
            $IN=trim(implode(',', $categoryIDS),',');
               $req = Yii::app()->db->createCommand(
                            "DELETE FROM {{category_product}} "
                            . " WHERE category_ID IN ({$IN}) and product_ID={$product_ID} "
            );
           $req->query();
        }

        public static function getCategoryIDS($product_ID)
        {
            $res = array();
            if (!$product_ID)
            {
                return $res;
            }
            $req = Yii::app()->db->createCommand(
                            "SELECT category_ID as id FROM {{category_product}} where product_ID={$product_ID}"
            );
            $res = $req->queryColumn();
            return $res;
        }

    }