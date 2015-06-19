<?php

Yii::import('common.models._base.BaseUserLimitedDataCore');

class UserLimitedDataCore extends BaseUserLimitedDataCore
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}