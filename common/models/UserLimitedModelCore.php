<?php

Yii::import('common.models._base.BaseUserLimitedModelCore');

class UserLimitedModelCore extends BaseUserLimitedModelCore
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}