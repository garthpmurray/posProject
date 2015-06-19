<?php

/**
 * This is the model base class for the table "sys_log".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "LogCore".
 *
 * Columns in table "sys_log" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $error_set
 * @property string $level
 * @property string $category
 * @property integer $logtime
 * @property string $message
 * @property string $logRealTime
 * @property string $ip_user
 * @property string $request_url
 *
 */
abstract class BaseLogCore extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'sys_log';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Log|Logs', $n);
	}

	public static function representingColumn() {
		return 'error_set';
	}

	public function behaviors(){
		return array( 'CAdvancedArFindBehavior' => array(
		'class' => 'common.extensions.CAdvancedArFindBehavior')); 
	}

	public function rules() {
		return array(
			array('error_set, message, logRealTime, ip_user, request_url', 'required'),
			array('logtime', 'numerical', 'integerOnly'=>true),
			array('error_set, request_url', 'length', 'max'=>256),
			array('level, category', 'length', 'max'=>128),
			array('ip_user', 'length', 'max'=>64),
			array('level, category, logtime', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, error_set, level, category, logtime, message, logRealTime, ip_user, request_url', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'error_set' => Yii::t('app', 'Error Set'),
			'level' => Yii::t('app', 'Level'),
			'category' => Yii::t('app', 'Category'),
			'logtime' => Yii::t('app', 'Logtime'),
			'message' => Yii::t('app', 'Message'),
			'logRealTime' => Yii::t('app', 'Log Real Time'),
			'ip_user' => Yii::t('app', 'Ip User'),
			'request_url' => Yii::t('app', 'Request Url'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('error_set', $this->error_set, true);
		$criteria->compare('level', $this->level, true);
		$criteria->compare('category', $this->category, true);
		$criteria->compare('logtime', $this->logtime);
		$criteria->compare('message', $this->message, true);
		$criteria->compare('logRealTime', $this->logRealTime, true);
		$criteria->compare('ip_user', $this->ip_user, true);
		$criteria->compare('request_url', $this->request_url, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

}