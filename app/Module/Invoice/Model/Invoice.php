<?php
declare(strict_types=1);

namespace App\Module\Invoice\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    const NEW_INVOICE = 'NEW';
    const COMPLETE_INVOICE = 'COMPLETE';
    const FAIL_INVOICE = 'FAIL';

    protected $fillable = [
        'attempt',
        'changed_time',
        'date',
        'created_at',
        'last_attempt',
        'status',
        'tariff',
        'user_id',
        'phone',
        'price',
        'uuid',
        'updated_at'
    ];

    protected $table = 'invoices';

}
