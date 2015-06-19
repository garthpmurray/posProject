<?php

/**
 * This is the model base class for the table "provision_config".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ConfigCore".
 *
 * Columns in table "provision_config" available as properties of the model,
 * followed by relations of table "provision_config" available as properties of the model.
 *
 * @property integer $id
 * @property string $content
 * @property string $name
 * @property string $assigned_system_software
 * @property string $assigned_data_software
 *
 * @property Screen[] $screens
 * @property Software $assignedSystemSoftware
 * @property Software $assignedDataSoftware
 * @property ScreenGroup[] $screenGroups
 */
abstract class BaseConfigCore extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'provision_config';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Config|Configs', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function behaviors(){
		return array( 'CAdvancedArFindBehavior' => array(
		'class' => 'common.extensions.CAdvancedArFindBehavior')); 
	}

	public function rules() {
		return array(
			array('content, name, assigned_system_software, assigned_data_software', 'safe'),
			array('content, name, assigned_system_software, assigned_data_software', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, content, name, assigned_system_software, assigned_data_software', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'screens' => array(self::HAS_MANY, 'Screen', 'assigned_config'),
			'assignedSystemSoftware' => array(self::BELONGS_TO, 'Software', 'assigned_system_software'),
			'assignedDataSoftware' => array(self::BELONGS_TO, 'Software', 'assigned_data_software'),
			'screenGroups' => array(self::HAS_MANY, 'ScreenGroup', 'assigned_config'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'content' => Yii::t('app', 'Content'),
			'name' => Yii::t('app', 'Name'),
			'assigned_system_software' => Yii::t('app', 'System Software'),
			'assigned_data_software' => Yii::t('app', 'Data Software'),
			'screens' => null,
			'assignedSystemSoftware' => Yii::t('app', 'System Software'),
			'assignedDataSoftware' => Yii::t('app', 'Data Software'),
			'screenGroups' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('content', $this->content, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('assigned_system_software', $this->assigned_system_software);
		$criteria->compare('assigned_data_software', $this->assigned_data_software);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}