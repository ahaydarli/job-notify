<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SmsVerification extends Model
{
    const PENDING = 'pending';
    const VERIFIED = 'verified';

    protected $fillable = [
        'phone', 'code', 'status'
    ];

    public function store($request)
    {
        $this->fill($request->all());
        $sms = $this->save();
        return $sms;
    }
    public function updateModel($request)
    {
        $this->update($request->all());
        return $this;
    }
}
