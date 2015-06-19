<?php
//generate the content of the class file
Yii::import('common.extensions.wsdl2php.gii.wsdl2php.vendors.EasyWsdl2PHP');
echo EasyWsdl2PHP::generate(trim($this->wsdlUrl),trim($this->serviceClassName),trim($this->clientClassExtends),trim($this->paramClassExtends));

?>