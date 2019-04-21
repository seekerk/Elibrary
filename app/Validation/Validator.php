<?php

namespace App\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    protected $errors,
    $messages = [
        'noWhitespace' => '{{name}} не должен содержать пробелов!',
        'length' => ' Длинна {{name}} должна быть между {{minValue}} и {{maxValue}}!',
        'email' => 'Некоректный формат почтового адреса!'
    ],
    $fields = [
        'name' => 'Логин',
        'password' => 'Пароль',
        'email' => 'Email'
    ];
    
	public function validate($req, array $rules)
	{

		foreach ($rules as $field => $rule) {
			try {
				$rule->setName($this->fields[$field])->assert($req->getParam($field));
			} catch (NestedValidationException $e) {
				$this->errors[$field] = array_filter($e->findMessages($this->messages));
			}
        }
		$_SESSION['errors'] = $this->errors;
		return $this;
    }
    
	public function failed()
	{
		return !empty($this->errors);
	}
}