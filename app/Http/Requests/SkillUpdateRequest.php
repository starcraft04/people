<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SkillUpdateRequest extends Request
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
    $id = $this->id;
    $domain = $this->domain;
    $subdomain = $this->subdomain;
    $technology = $this->technology;
    $skill = $this->skill;
    $certification = $this->certification;

    /**
    *          Forcing A Unique Rule To Ignore A Given ID:
    *
    *          Sometimes, you may wish to ignore a given ID during the unique check. For example, consider an "update profile" screen that includes the activity's name, e-mail address, and location. Of course, you will want to verify that the e-mail address is unique. However, if the activity only changes the name field and not the e-mail field, you do not want a validation error to be thrown because the activity is already the owner of the e-mail address. You only want to throw a validation error if the activity provides an e-mail address that is already used by a different activity. To tell the unique rule to ignore the activity's ID, you may pass the ID as the third parameter:
    *
    *          'email' => 'unique:activities,email_address,'.$activity->id
    *
    *          If your table uses a primary key column name other than id, you may specify it as the fourth parameter:
    *
    *          'email' => 'unique:activities,email_address,'.$activity->id.',activity_id'
    **/


    return [
      'domain' => 'unique:skills,domain,' . $id . ',id,subdomain,'.$subdomain.',technology,'.$technology.',skill,'.$skill.',certification,'.$certification,
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
