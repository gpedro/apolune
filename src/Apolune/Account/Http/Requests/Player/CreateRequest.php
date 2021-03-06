<?php

namespace Apolune\Account\Http\Requests\Player;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->container['auth']->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'player'    => ['required', 'min:2', 'max:29', 'alpha_space', 'no_initial_space', 'no_final_space', 'no_multiple_spaces', 
                            'max_words:3', 'short_words', 'long_words', 'no_vowelless_words', 'no_repeated_characters', 'unique:players,name'],
            'sex'       => ['gender'],
            'vocation'  => ['vocation:starter'],
            'town'      => ['town:starter'],
            'world'     => ['world'],
        ];
    }
}
