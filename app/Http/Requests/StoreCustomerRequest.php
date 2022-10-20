<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:customers',
            'phone' => 'required|regex:/^(0)([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'address' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên khách hàng',
            'name.min' => 'Tên khách hàng phải lớn hơn 5 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được đăng ký',
            'phone.required' => 'Điện thoại không được để trống',
            'phone.regex' => 'Nhập không đúng định dạng điện thoại',
            'phone.min' => 'Vui lòng nhập tối thiểu 10 số',
            'phone.max' => 'Vui lòng nhập tối đa 10 số',
            'address.required' => 'Địa chỉ không được để trống'
        ];
    }
}
