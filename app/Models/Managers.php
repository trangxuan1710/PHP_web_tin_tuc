<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
class Managers extends Model
{
    use HasFactory;

    protected $table = 'managers';
    protected $primaryKey = 'id';
    public $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'fullName',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'isActive' => 'boolean',
    ];

    /**
     * Tự động hash mật khẩu khi được thiết lập.
     *
     * @param string $value
     * @return void
     */
    public function setPassword($value)
    {

        if (! empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Kiểm tra xem mật khẩu thô có khớp với mật khẩu đã hash của người quản lý này không.
     *
     * @param string $plainTextPassword
     * @return bool
     */
    public function checkPassword(string $plainTextPassword): bool
    {
        $hashedPassword = $this->password;
        return Hash::check($plainTextPassword, $hashedPassword);
    }
}
