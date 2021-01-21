<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class api2Request extends FormRequest
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
            'ews_token'=>'required',
            'ews_llave'=>'required',
            'ews_no_solicitud'=>'required',
            'ews_id_electronico'=>'required',
            'ews_referencia_pago'=>'required',
            'ews_fecha_pago'=>'required',
            'ews_hora_pago'=>'required',
            'ews_stripe_orden_id'=>'required',
            'ews_stripe_creado'=>'required',
            'ews_stripe_mensaje'=>'required',
            'ews_stripe_tipo'=>'required',
            'ews_stripe_digitos'=>'required',
            'ews_stripe_estado'=>'required',
            'ews_stripe_red'=>'required'
        ];

    }
    public function messages()
    {
        return [
            'ews_token.required'=>'Complete el campo TOKEN',
            'ews_llave.required'=>'Complete el campo llave',
            'ews_id_electronico.required'=>'Complete el campo id electronico',
            'ews_no_solicitud.required'=>'Complete el campo número de solicitud',
            'ews_referencia_pago.required'=>'Complete el campo referencia de pago',
            'ews_fecha_pago.required'=>'Complete el campo fecha de pago',
            'ews_hora_pago.required'=>'Complete el campo hora de pago',
            'ews_stripe_orden_id.required' => 'Complete el campo orden id',
            'ews_stripe_creado.required' => 'Complete el campo creado',
            'ews_stripe_mensaje.required' => 'Complete el campo mensaje',
            'ews_stripe_tipo.required' => 'Complete el campo tipo',
            'ews_stripe_digitos.required' => 'Complete el campo digito',
            'ews_stripe_estado.required' => 'Complete el campo estado',
            'ews_stripe_red.required' => 'Complete el campo red',
            ];
    }
}
