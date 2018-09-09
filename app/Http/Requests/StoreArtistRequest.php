<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

class StoreArtistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_id' => 'nullable|string|max:50',
            'region_id' => 'required|exists:region,id',
            'en_name' => 'required|string|max:50',
            'screen_name' => 'nullable|string|max:50',
            'gender' => 'required|boolean',
            'is_fav' => 'required|boolean',
            'grade' => 'required|integer|between:1,5',
            'force_cat' => ['required',
                function($attribute, $value, $fail) {
                    if (!array_key_exists($value, config('cfg.artist.forceCatArray'))) {
                        return $fail($attribute.' is invalid force_cat');
                    }
                }
            ],
            'need_focus' => ['required',
                function($attribute, $value, $fail) {
                    if (!array_key_exists($value, config('cfg.artist.needFocusArray'))) {
                        return $fail($attribute.' is invalid need_focus');
                    }
                }
            ],
            'birth_date' => 'nullable|date_format:"Y-m-d"',
            'death_date' => 'nullable|date_format:"Y-m-d"|after:birth_date',
            'avatar_image' => 'sometimes|file|image|mimes:jpeg|dimensions:width=230,height=230',
            'wiki' => 'nullable|string|max:255|url',
            'description' => 'nullable|string',
            'found_at' => 'nullable|date_format:"Y-m-d"',
            'aka_names' => 'nullable|string',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $names = [
                'en_name' => $this->input('en_name'),
                'screen_name' => $this->input('screen_name') ?? '',
            ];

            $tempNames = array_filter($names);
            $akaNames = is_null($this->input('aka_names')) ? [] : string_to_array_filter($this->input('aka_names'));
            $filteredNames['name'] = array_collapse([$tempNames, $akaNames]);

            $v = Validator::make($filteredNames, [
                'name.*' => 'distinct|string|max:50'
            ]);

            if ($v->fails()) {
                $validator->errors()->add('field', '(英文名稱，顯示名稱，別名欄位)當中出現了重複的名稱，或最少一個別名超出 50 個字元。');
            }
        });
    }
}
