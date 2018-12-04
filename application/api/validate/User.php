<?php
namespace app\api\Validate;
/**
 * 注册用户验证器.
 * User: whp
 * Date: 2018/10/19
 * Time: 16:28
 */
use think\Validate;

class User extends Validate
{
    protected $rule =   [
        'phone'  => 'require|mobile|max:11|length:11',
        'code'   => 'require|number|max:4|length:4',
        'type'   => 'require|number|length:1',
    ];

    protected $message  =   [
        'phone.require' => '请输入手机号',
        'phone.mobile'     => '请输入正确手机号',
        'phone.max'     => '请输入正确手机号',
        'phone.length'     => '请输入正确手机号',
        'code.require'   => '请输入验证码',
        'code.number'   => '请输入正确验证码',
        'code.max'   => '请输入正确验证码',
        'code.length'     => '请输入正确验证码',
        'type.require'   => '请选择注册身份',
        'type.number'   => '请选择注册身份',
        'type.length'     => '请选择注册身份',
    ];

}