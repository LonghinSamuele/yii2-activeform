<?php


namespace samuelelonghin\form;


class BaseActiveForm extends \yii\bootstrap5\ActiveForm
{
	public $fieldClass = ActiveField::class;

	/**
	 * {@inheritdoc}
	 * @param $model
	 * @param $attribute
	 * @param array $options
	 * @return ActiveField
	 */
	public function field($model, $attribute, $options = []): ActiveField
	{
		return parent::field($model, $attribute, $options);
	}
}