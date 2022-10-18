<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestProduct extends FormRequest
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
            //
            'name' => 'required|min:5',
            'price' => 'required|numeric|gt:0',
            'fileImage' => 'image|mimes:jpeg,png,jpg|max:2048|dimensions:max_width=1024,max_height=1024'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'name.min' => 'Tên phải lớn hơn 5 ký tự',
            'price.required' => 'Giá bán không được để trống',
            'price.numeric' => 'Giá bán chỉ được nhập số',
            'price.gt' => 'Giá bán không được nhỏ hơn 0',
            'fileImage.image' => 'Chỉ cho upload các file hình *.png, *.jpg, *.jpeg',
            'fileImage.mimes' => 'Chỉ cho upload các file hình *.png, *.jpg, *.jpeg',
            'fileImage.max' => 'Dung lượng không quá 2Mb',
            'fileImage.dimensions' => 'Tệp có kích thước hình ảnh lớn hơn 1024px.'
        ];
    }
}
