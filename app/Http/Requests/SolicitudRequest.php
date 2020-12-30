<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudRequest extends FormRequest
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
            'ews_curp_sw'=>'required',
            'ews_nombre_sw'=>'required',
            'ews_apellido_paterno_sw'=>'required',
            'ews_apellido_materno_sw'=>'required',
            'ews_no_contrato'=>'required',
            'ews_municipio_capa'=>'required',
            'ews_id_tramite'=>function ($attribute, $value, $fail) {
                if ($value != 17) {
                    $fail('El número del trámite no coincide');
                }
            }
        ];
    }
    public function messages()
{
    return [
        'ews_curp_sw.required' => 'Complete el campo CURP',
        'ews_nombre_sw.required' => 'Complete el campo Nombre',
        'ews_apellido_paterno_sw.required' => 'Complete el campo Apellido Paterno',
        'ews_apellido_materno_sw.required' => 'Complete el campo Apellido Materno',
        'ews_no_contrato.required' => 'Complete el campo número de contrato',
        'ews_municipio_capa.required' => 'Complete el campo número de municipio',
        ];
}
}
