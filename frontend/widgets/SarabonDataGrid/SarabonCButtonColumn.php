<?php

class SarabonCButtonColumn extends CButtonColumn
{

	public $sColumns;
	public $type = 'dropdown';

	public function init()
	{
		$permission = '';
		$module = isset(Yii::app()->controller->module->id) ? ucfirst(Yii::app()->controller->module->id) : null;
		$controller = ucfirst(Yii::app()->controller->id);
		if ($module != null) {
			$module .= '.';
		}
		$permission = $module . $controller . '.';
		$this->buttons['delete']['click'] = "function() {return false;}";
/*
		$this->buttons['delete']['visible'] = 'Yii::app()->user->checkAccess(\'' . $permission . 'Delete\', array("id"=>$data->primaryKey))';
		$this->buttons['view']['visible'] = 'Yii::app()->user->checkAccess(\'' . $permission . 'View\', array("id"=>$data->primaryKey))';
		$this->buttons['update']['visible'] = 'Yii::app()->user->checkAccess(\'' . $permission . 'Update\', array("id"=>$data->primaryKey))';
*/
		
		
		parent::init();
	}
	/**
	 * Renders the data cell content.
	 * This method renders the view, update and delete buttons in the data cell.
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data associated with the row
	 */
	protected function renderDataCellContent($row, $data)
	{
		$tr = array();
		ob_start();

		$dataFound = false;
		foreach ($this->buttons as $id => $button) {
			$this->renderButton($id, $button, $row, $data);
			$item = ob_get_contents();
			if ($item != null) {
				$dataFound = true;
			}

			$tr['{' . $id . '}'] = $item;
			ob_clean();
		}
		ob_end_clean();
		
		if ($dataFound) {

			echo CHtml::openTag('div', array('class' => 'btn-group pull-right', 'style' => 'float:none;')) . "\n";
			echo CHtml::openTag('button', array('class' => 'btn dropdown-toggle', 'data-toggle' => 'dropdown')) . "\n";
			echo CHtml::openTag('i', array('class' => 'icon-cog')) . "\n";
			echo CHtml::closeTag('i');
			echo CHtml::openTag('span', array('class' => 'caret')) . "\n";
			echo CHtml::closeTag('span');
			echo CHtml::closeTag('button');
			echo CHtml::openTag('ul', array('class' => 'dropdown-menu', 'style' => 'text-align: left;')) . "\n";
			echo strtr($this->template, $tr);
			echo CHtml::closeTag('ul');
			echo CHtml::closeTag('div');
		}
	}

	public function getDataCellContent($row) {
        
/*
        if (method_exists(get_parent_class($this), 'getDataCellContent'))
            return parent::getDataCellContent($row);
        return 'hi';
*/
		ob_start();
		$this->renderDataCellContent($row,$this->grid->dataProvider->data[$row]);
		return ob_get_clean();
	}

	/**
	 * Renders a link button.
	 * @param string $id the ID of the button
	 * @param array $button the button configuration which may contain 'label', 'url', 'imageUrl' and 'options' elements.
	 * See {@link buttons} for more details.
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data object associated with the row
	 */
	protected function renderButton($id, $button, $row, $data)
	{
		if (!is_object($data)) {
			$data = (object)$data;
		}
		if (!isset($data->primaryKey) && isset($data->id)) {
			$data->primaryKey = $data->id;
		}
		
/*
		if (isset($button['visible']) && !$this->evaluateExpression($button['visible'], array('row' => $row, 'data' => $data)))
			return;
*/
			
		$label = isset($button['label']) ? $button['label'] : $id;
		$url = isset($button['url']) ? $this->evaluateExpression($button['url'], array('data' => $data, 'row' => $row)) : '#';
		$options = isset($button['options']) ? $button['options'] : array();
		if (!isset($options['title'])) {
			$options['title'] = $label;
		}

		foreach (Yii::app()->params['standardOperations'] as $standardOps) {
			$check = stristr($label, $standardOps['name']);
			if ($check !== FALSE) {
				$labelIcon = $standardOps['icon'];
			}
		}

		$label = isset($labelIcon) ? "<i class=\"{$labelIcon}\"></i>   {$label}" : "{$label}";

		if (isset($button['imageUrl']) && is_string($button['imageUrl'])) {
			if (!isset($labelIcon)) {
				$buttonItem = CHtml::link(CHtml::image($button['imageUrl'], $label), $url, $options);
			} else {
				$buttonItem = CHtml::link($label, $url, $options);
			}
		} else {
			$buttonItem = CHtml::link($label, $url, $options);
		}

		echo '<li>' . $buttonItem . '</li>';
	}
}

?>
