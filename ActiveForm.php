<?php


namespace samuelelonghin\form;


class ActiveForm extends \yii\bootstrap4\ActiveForm
{
    public $layout = self::LAYOUT_HORIZONTAL;
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