<?php


namespace samuelelonghin\form;


use Exception;
use kartik\select2\Select2;
use samuelelonghin\form\inputs\RoundSwitchInput;
use Yii;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

class ActiveField extends \kartik\form\ActiveField
{

	public $dateOptions = [];

	public function init()
	{
		parent::init();
	}

	public function placeholder($value)
	{
		$this->inputOptions['placeholder'] = $value;
		return $this;
	}

	public function autocomplete($value)
	{
		$this->inputOptions['autocomplete'] = $value;
		return $this;
	}

	public function numberInput(): ActiveField
	{
		return $this->input('number');
	}

	/**
	 * @param array $options
	 * @return ActiveField
	 */
	public function dateTimeInput(array $options = []): ActiveField
	{
		if (!array_key_exists('value', $options)) {
			$options['value'] = Yii::$app->formatter->asFormDateTime(date_create($this->model->{$this->attribute}));
		}
		return $this->input('datetime-local', ArrayHelper::merge($this->dateOptions, $options));
	}

	/**
	 * @param array $options
	 * @return ActiveField
	 */
	public function dateInput(array $options = []): ActiveField
	{
		if (!array_key_exists('value', $options)) {
			$options['value'] = Yii::$app->formatter->asFormDate(date_create($this->model->{$this->attribute}));
		}
		return $this->input('date', ArrayHelper::merge($this->dateOptions, $options));
	}

	/**
	 * @param array $options
	 * @return ActiveField
	 */
	public function timeInput(array $options = []): ActiveField
	{
		if (!array_key_exists('value', $options)) {
			$options['value'] = Yii::$app->formatter->asFormTime(date_create($this->model->{$this->attribute}));
		}
		return $this->input('time', ArrayHelper::merge($this->dateOptions, $options));
	}

	/**
	 * @throws Exception
	 */
	public function select2Input($items, $options = []): ActiveField
	{
		return $this->widget(Select2::class, array_merge_recursive(['data' => $items], $options));
	}

	/**
	 * @param array $options
	 * @return ActiveField
	 * @throws Exception
	 */
	public function switchInput(array $options = []): ActiveField
	{
		return $this->widget(RoundSwitchInput::class, $options);
	}

	/**
	 * @param array|false[] $options
	 * @return ActiveField
	 */
	public function hiddenInput($options = ['label' => false])
	{
		$this->options['class'] = 'd-none';
		return parent::hiddenInput($options);
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function visible($value): ActiveField
	{
		if (!$value) {
			$this->template = '';
		}
		return $this;
	}

	public function checkboxList($items, $options = [])
	{
		if (!isset($options['item'])) {
			$this->template = str_replace("\n{error}", '', $this->template);
			$itemOptions = isset($options['itemOptions']) ? $options['itemOptions'] : [];
			$encode = ArrayHelper::getValue($options, 'encode', true);
			$itemCount = count($items) - 1;
			$error = $this->error()->parts['{error}'];
			$options['item'] = function ($i, $label, $name, $checked, $value) use (
				$itemOptions,
				$encode,
				$itemCount,
				$error
			) {
				$options = array_merge($this->checkOptions, [
					'label' => $encode ? Html::encode($label) : $label,
					'value' => $value
				], $itemOptions);
				$wrapperOptions = ArrayHelper::remove($options, 'wrapperOptions', ['class' => ['custom-control', 'custom-checkbox']]);
				if ($this->inline) {
					Html::addCssClass($wrapperOptions, 'custom-control-inline');
				}

				//                $this->addErrorClassIfNeeded($options);
				$html = Html::beginTag('div', $wrapperOptions) . "\n" .
					Html::checkbox($name, $checked, $options) . "\n";
				if ($itemCount === $i) {
					$html .= $error . "\n";
				}
				$html .= Html::endTag('div') . "\n";

				return $html;
			};
		}
		return parent::checkboxList($items, $options);
	}

	public function setOption($option, $value)
	{
		$this->options[$option] = $value;
	}

	public function setOptions($options)
	{
		$this->options = ArrayHelper::merge($this->options, $options);
	}
}
