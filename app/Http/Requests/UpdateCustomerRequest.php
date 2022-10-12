<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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
        // dd($this->customerId);
        return [
            'name' => 'required|min:5',
            // 'email' => 'sometimes|required|email|unique:customers,email,'.$this->customerId,
            'email' => [
                'sometimes',
                'required',
                'email' => Rule::unique('customers','email')->ignore($this->customerId, 'customer_id'),
            ],
            'phone' => 'required|regex:/^(0)([1-9\s\-\+\(\)]*)$/|min:10',
            'address' => 'required'
        ];
    }
    public function messages(){
        return [
            'name.required' => 'Vui lòng nhập tên khách hàng',
            'name.min' => 'Tên khách hàng phải lớn hơn 5 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được đăng ký',
            'phone.required' => 'Điện thoại không được để trống',
            'phone.regex' => 'Nhập không đúng định dạng điện thoại',
            'phone.min' => 'Vui lòng nhập tối thiểu 10 số',
            'address.required' => 'Địa chỉ không được để trống'
        ];
    }
}
