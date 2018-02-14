Lumen doesn't have form request validator seperatly. This package helps developers to segregate the validation layer from the controller to a separate dedicated class.

## Installation

   `composer require pearl/lumen-request-validate`

- Add the service provider in bootstrap/app.php

`$app->register(Pearl\RequestValidate\RequestServiceProvider::class);`

Next step is create your validator class using below comend

`php artisan make:request {class_name}`

 Request validator class will be create under **app/Http/Requests** folder.
 
 #### Example:
 
 Login validation class
 ```php
<?php
namespace App\Http\Requests;

use Pearl\RequestValidate\RequestAbstract;

class Login extends RequestAbstract
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			"username" => "required",
			"password" => "required"
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}

```
 
 
 ## How to use?
 Now you can use your Request class in method injections
```php
...
use App\Http\Requests\Login;

class ExampleController extends Controller
{
    public function auth(Login $request)
    {
	//Login logic goes here
    }
...
```
