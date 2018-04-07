<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SkillCreateRequest extends Request
{
  /**
  * Determine if the activity is authorized to make this request.
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
    $domain = $this->domain;
    $subdomain = $this->subdomain;
    $technology = $this->technology;
    $skill = $this->skill;

    return [
      'domain' => 'unique:skills,domain,NULL,id,subdomain,'.$subdomain.',technology,'.$technology.',skill,'.$skill,
      'subdomain' => 'required',
      'technology' => 'required',
      'skill' => 'required',
    ];
  }

  public function messages()
  {
    return [
      'domain.unique' => 'This record needs to have a unique domain, subdomain, technology and skill.'
    ];
  }
}
