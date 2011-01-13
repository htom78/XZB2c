<?php

    /**
     * This is the model class for table "{{category_entity}}".
     *
     * The followings are the available columns in table '{{category_entity}}':
     * @property integer $category_ID
     * @property string $category_name
     * @property string $category_SEF
     * @property string $category_description
     * @property integer $category_active
     * @property string $category_path
     * @property integer $category_level
     * @property integer $category_parent_ID
     * @property integer $category_SEO_ID
     * @property integer $category_order
     * @property string $category_create
     * @property string $category_update
     */
    class category_entity extends CActiveRecord
    {

        /**
         * Returns the static model of the specified AR class.
         * @return category_entity the static model class
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
            return '{{category_entity}}';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('category_name, category_SEF, category_description, category_active, category_path, category_level, category_parent_ID, category_SEO_ID', 'required'),
                array('category_active, category_level, category_parent_ID, category_SEO_ID, category_order', 'numerical', 'integerOnly' => true),
                array('category_name', 'length', 'max' => 200),
                array('category_SEF', 'length', 'max' => 100),
                array('category_path', 'length', 'max' => 255),
                array('category_update', 'safe'),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('category_ID, category_name, category_SEF, category_description, category_active, category_path, category_level, category_parent_ID, category_SEO_ID, category_order,category_update', 'safe', 'on' => 'search'),
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
                'seo' => array(self::BELONGS_TO, 'seo', 'category_SEO_ID'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
            return array(
                'category_ID' => 'Category',
                'category_name' => 'Category Name',
                'category_SEF' => 'Category Sef',
                'category_description' => 'Category Description',
                'category_active' => 'Category Active',
                'category_path' => 'Category Path',
                'category_level' => 'Category Level',
                'category_parent_ID' => 'Category Parent',
                'category_SEO_ID' => 'Category Seo',
                'category_order' => 'Category Order',
                'category_create' => 'Category Create',
                'category_update' => 'Category Update',
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

            $criteria->compare('category_name', $this->category_name, true);

            $criteria->compare('category_SEF', $this->category_SEF, true);

            $criteria->compare('category_description', $this->category_description, true);

            $criteria->compare('category_active', $this->category_active);

            $criteria->compare('category_path', $this->category_path, true);

            $criteria->compare('category_level', $this->category_level);

            $criteria->compare('category_parent_ID', $this->category_parent_ID);

            $criteria->compare('category_SEO_ID', $this->category_SEO_ID);

            $criteria->compare('category_order', $this->category_order);

            return new CActiveDataProvider('category_entity', array(
                'criteria' => $criteria,
            ));
        }

        protected function beforeValidate()
        {
            $this->category_update = date('Y-m-d H:i:s');
            return true;
        }

        public function getSibling()
        {

            $req = Yii::app()->db->createCommand(
                    "SELECT m1.* "
                    . " FROM {{category_entity}} AS m1 "
                    . " WHERE m1.category_parent_ID='{$this->category_parent_ID}' AND m1.category_active=1 AND m1.category_ID!={$this->category_ID}"
                    . " ORDER BY m1.category_order ASC,m1.category_ID DESC "
            );
            return $req->queryAll();
        }

        public function getFamliyTree()
        {
         
            if ($this->category_level ==1)
            {
                return NULL;
            }
            $IN = substr($this->category_path, 2);
            $req = Yii::app()->db->createCommand(
                    "SELECT m1.* "
                    . " FROM {{category_entity}} AS m1 "
                    . " WHERE m1.category_ID IN ({$IN}) AND category_active=1"
                    . " ORDER BY m1.category_level ASC,m1.category_ID ASC "
            );
          
            return $req->queryAll();
        }

        public function scopes()
        {
            return array(
                'chirdren'
            );
        }

        public function chirdren($parent_ID)
        {
            $this->getDbCriteria()->mergeWith(array(
                'condition' => "category_parent_ID='{$parent_ID}' AND category_active=1",
                'order' => ' category_order ASC',
            ));
            return $this;
        }

        public static function rootCategory()
        {
            $req = Yii::app()->db->createCommand(
                    "SELECT m1.* "
                    . " FROM {{category_entity}} AS m1 "
                    . " WHERE m1.category_level =1 "
                    . " ORDER BY m1.category_order ASC,m1.category_ID DESC "
            );
            return $req->queryAll();
        }

        public static function getChirdren($category_PK)
        {
            if (!$category_PK)
            {
                return;
            }
            $req = Yii::app()->db->createCommand(
                    "SELECT m1.* "
                    . " FROM {{category_entity}} AS m1 "
                    . " WHERE m1.category_parent_ID={$category_PK} "
                    . " ORDER BY m1.category_order ASC,m1.category_ID DESC "
            );
            return $req->queryAll();
        }

        public static function categoryOptionData()
        {
            $req = Yii::app()->db->createCommand(
                    "SELECT m1.category_ID as id ,m1.category_name as name "
                    . " FROM {{category_entity}} AS m1 "
                    . " ORDER BY m1.category_level ASC,m1.category_order ASC "
            );
            $option = array();
            foreach ($req->queryAll() as $row)
            {
                $option[$row['id']] = $row['name'];
            }
            return $option;
        }

        public static function resolveDefCategory($categoryIDS)
        {

            if (!$categoryIDS)
            {
                return;
            }

            $IN = implode(",", $categoryIDS);

            $req = Yii::app()->db->createCommand(
                    "SELECT m1.category_ID as id"
                    . " FROM {{category_entity}} AS m1 "
                    . " WHERE m1.category_ID IN ({$IN})"
                    . " ORDER BY m1.category_level ASC,m1.category_order ASC "
            );
            $res = $req->queryRow();
            if ($res)
            {
                return $res['id'];
            }
            return;
        }

    }