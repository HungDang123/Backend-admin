<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, OrderItem> $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @property-read mixed $total_price
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $guarded = ['id'];
    protected $fillable = ['first_name', 'last_name', 'email'];
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function getTotalPriceAttribute()
    {
        return $this->items->sum('total_price');
    }
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
