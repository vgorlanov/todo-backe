<?php


namespace App\Library\Order;

use Carbon\CarbonInterface;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;

/**
 * Ordering tasks
 *
 * Class Order
 * @package App\Library\Order
 */
abstract class Order
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * set model for order
     *
     * @param Model $model
     * @return $this
     */
    public function setModel(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * set place for project
     *
     * @param int $position new position
     * @param int $project Project ID
     * @return void
     */
    abstract public function setProject(int $position, int $project): void;

    /**
     * set place for current date
     *
     * @param int $position new position
     * @param CarbonInterface $date
     * @return void
     */
    abstract public function setActive(int $position, CarbonInterface $date): void;

    /**
     * set place for new tasks
     *
     * @param int $position new position
     * @return void
     */
    abstract public function setNew(int $position): void;
}
