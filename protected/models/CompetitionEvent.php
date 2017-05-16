<?php

/**
 * This is the model class for table "competition_event".
 *
 * The followings are the available columns in table 'competition_event':
 * @property string $id
 * @property string $competition_id
 * @property string $event
 * @property integer $round
 * @property integer $fee
 * @property integer $fee_second
 * @property integer $fee_third
 * @property integer $qualifying_best
 * @property integer $qualifying_average
 * @property string $create_time
 * @property string $update_time
 */
class CompetitionEvent extends ActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'competition_event';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			array('competition_id', 'required'),
			array('round, fee, fee_second, fee_third, qualifying_best, qualifying_average', 'numerical', 'integerOnly'=>true),
			array('competition_id, create_time, update_time', 'length', 'max'=>11),
			array('event', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, competition_id, event, round, fee, fee_second, fee_third, qualifying_best, qualifying_average, create_time, update_time', 'safe', 'on'=>'search'),
		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'competition'=>[self::BELONGS_TO, 'Competition', 'competition_id'],
			'wcaEvent'=>[self::BELONGS_TO, 'Events', 'event'],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return [
			'id'=>'ID',
			'competition_id'=>'Competition',
			'event'=>'Event',
			'round'=>'Round',
			'fee'=>'Fee',
			'fee_second'=>'Fee Second',
			'fee_third'=>'Fee Third',
			'qualifying_best'=>'Qualifying Best',
			'qualifying_average'=>'Qualifying Average',
			'create_time'=>'Create Time',
			'update_time'=>'Update Time',
		];
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
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id,true);
		$criteria->compare('competition_id', $this->competition_id,true);
		$criteria->compare('event', $this->event,true);
		$criteria->compare('round', $this->round);
		$criteria->compare('fee', $this->fee);
		$criteria->compare('fee_second', $this->fee_second);
		$criteria->compare('fee_third', $this->fee_third);
		$criteria->compare('qualifying_best', $this->qualifying_best);
		$criteria->compare('qualifying_average', $this->qualifying_average);
		$criteria->compare('create_time', $this->create_time,true);
		$criteria->compare('update_time', $this->update_time,true);

		return new CActiveDataProvider($this, [
			'criteria'=>$criteria,
		]);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CompetitionEvent the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
