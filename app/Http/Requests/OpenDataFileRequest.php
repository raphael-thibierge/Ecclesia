<?php

namespace App\Http\Requests;

use App\OpenDataFile;
use Illuminate\Foundation\Http\FormRequest;

class OpenDataFileRequest extends FormRequest
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

        $in = OpenDataFile::importJobList()->keys()->implode(',');

        return [
            'name'          => 'required|string',
            'description'   => 'required|string',
            'url'           => 'required|url',
            'import_script' => 'required|in:' . $in
        ];
    }

    public function getAttributes(){
        return [
            'name'          => $this->get('name'),
            'url'           => $this->get('url'),
            'description'   => $this->get('description'),
            'import_script' => $this->get('import_script')
        ];
    }
}
