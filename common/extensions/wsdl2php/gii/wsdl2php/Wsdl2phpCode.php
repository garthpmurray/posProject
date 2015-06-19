<?php

/**
 * Wsdl2phpCode.php
 *
 * gii codemodel for extension wsdl2php
 *
 * PHP version 5.2+
 *
 * @author Joe Blocher <yii@myticket.at>
 * @copyright 2011 myticket it-solutions gmbh
 * @license New BSD License
 * @package wsdl2php
 * @version 0.5
 */
class Wsdl2phpCode extends CCodeModel
{
	/**
	 * @var string the wsdl url
	 */
	public $wsdlUrl;

	/**
	 * @var string the name of the generated class
	 */
	public $serviceClassName;

	/**
	 * @var string the classname if the main class extends a class
	 */
	public $clientClassExtends;

	/**
	 * @var string the classname if the param classes extends a class
	 */
	public $paramClassExtends;

	/**
	 * @var string the directory, where the classfiles should be generated
	 */
	public $classDirectory;

	/**
	 * The model rules
	 *
	 * @return array
	 */
	public function rules()
	{
		return array_merge(parent::rules(), array(
		    array('wsdlUrl,serviceClassName', 'required'),
		    array('wsdlUrl', 'url'),
		    array('clientClassExtends,paramClassExtends, classDirectory', 'sticky'),
		    array('serviceClassName', 'length', 'max'=>255),
		));
	}

	/**
	 * The attributeLabels of the model
	 *
	 * @return array
	 */
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
		    'wsdlUrl'=>'WSDL Service Url',
		    'serviceClassName'=>'Service classname',
		    'clientClassExtends'=>'Client classes extends',
		    'paramClassExtends'=>'Param classes extend',
		    'classDirectory'=>'Class directory',
		));
	}

	/**
	 * Render the wsdl2php.php to generate the code
	 */
	public function prepare()
	{
		$dirAlias = empty($this->classDirectory) ? 'application.components' : $this->classDirectory;

		//generate the wsdl classes
		$path=Yii::getPathOfAlias($dirAlias . '.' . $this->serviceClassName) . '.php';
		$code=$this->render($this->templatepath.'/wsdl2php.php');
		$this->files[]=new CCodeFile($path, $code);
	}
}