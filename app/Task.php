<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webmozart\Assert\Assert;

class Task extends Model
{
    use SoftDeletes;

    /**
     * task is done
     */
    public const DONE = 1;

    /**
     * task in progress
     */
    public const ACTIVE = 0;

    /**
     * array for orders
     *
     * @var array
     */
    private array $orders = ['project' => 0, 'date' => 0, 'free' => 0];

    protected  $fillable = ['title', 'body', 'user_id', 'project_id', 'done', 'date', 'every', 'orders'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getOrdersAttribute($value)
    {
        return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * set value for order field
     *
     * @param string $field
     * @param int $number
     * @return $this
     * @throw InvalidArgumentException
     */
    public function setOrder(string $field, int $number): self
    {
        Assert::keyExists($this->orders, $field, 'Order field "' . $field . '" is not found');
        $this->orders[$field] = $number;

        return $this;
    }

    /**
     * get order field's value
     *
     * @param string $field
     * @return int
     * @throw InvalidArgumentException
     */
    public function getOrder(string $field): int
    {
        Assert::keyExists($this->orders, $field, 'Order field "' . $field . '" is not found');

        return $this->orders[$field];
    }


}
