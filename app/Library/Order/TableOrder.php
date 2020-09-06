<?php


namespace App\Library\Order;

use Carbon\CarbonInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class TableOrder
 * @package App\Library\Order
 */
final class TableOrder extends Order
{
    public const PROJECT = 'weight_project';
    public const ACTIVE  = 'weight_active';
    public const NEW     = 'weight_new';

    /**
     * weight field
     * @var string
     */
    private string $type;

    /**
     * data for where
     *
     * @var string
     */
    private string $data;

    /**
     * target position
     *
     * @var int
     */
    private int $position;

    /**
     * {@inheritDoc}
     */
    public function setProject(int $position, int $project): void
    {
        $this->type = self::PROJECT;
        $this->data = $project;
        $this->position = $position;

        $this->run();
    }

    /**
     * {@inheritDoc}
     */
    public function setActive(int $position, CarbonInterface $date): void
    {
        $this->type = self::ACTIVE;
        $this->data = $date->toDateString();
        $this->position = $position;

        $this->run();
    }

    /**
     * {@inheritDoc}
     */
    public function setNew(int $position): void
    {
        $this->type = self::NEW;
        $this->position = $position;

        $this->run();
    }

    /**
     * change position
     */
    private function run(): void
    {
        $results = $this->getResults();
        $position = $this->position > count($results) ? count($results) : $this->position;
        $target = $results[$position - 1];

        $items = [];
        foreach ($results as $key => $item) {
            $items[$item->weight] = $item;

            if ($item->id === $this->model->id) {
                $current = $item;
            }
        }

        if (empty($current)) { // если задачи не существует
            $current = $this->model;
            $weight = $this->position > count($results) ? min(array_keys($items)) - 5 : $target->weight + 5;
            $current->weight = $weight;
        } else {
            unset($items[$current->weight]);
            $weight = $current->weight > $target->weight ? $target->weight - 5 : $target->weight + 5;
        }

        $items[$weight] = $current;

        ksort($items);

        $this->update($items);
    }

    /**
     * update weights
     *
     * @param array $items
     */
    private function update(array $items): void
    {
        switch ($this->type) {
            case self::PROJECT:
                $query = "UPDATE tasks SET weight_project = :weight, project_id = :data WHERE id = :id";
                break;
            case self::ACTIVE:
                $query = "UPDATE tasks SET weight_active = :weight, date = :data WHERE id = :id";
                break;
            default:
                $query = "UPDATE tasks SET weight_new = :weight WHERE id = :id";
        }

        $weight = 10;
        foreach ($items as $item) {
            $bind = [
                'weight' => $weight,
                'id'     => $item->id,
            ];

            if(isset($this->data)) {
                $bind['data'] = $this->data;
            }

            DB::update($query, $bind);
            $weight += 10;
        }
    }

    /**
     * return where for getResults.
     *
     * @return string
     */
    private function where(): string
    {
        switch ($this->type) {
            case self::PROJECT:
                return "WHERE project_id = " . (int)$this->data;
            case self::ACTIVE:
                return "WHERE date = '$this->data'";
            default:
                return '';
        }
    }

    /**
     * return result with correct weights and positions
     *
     * @return array
     */
    private function getResults(): array
    {
        $where = $this->where();

        $query = "SELECT id,
                        title,
                        project_id,
                        $this->type,
                        ROW_NUMBER() OVER (
                           ORDER BY $this->type IS NULL DESC, $this->type DESC, id DESC
                           ) position,
                        ROW_NUMBER() OVER (
                           ORDER BY $this->type IS NULL ASC, $this->type ASC, id ASC
                           ) * 10 weight
                FROM tasks
                $where
                ORDER BY $this->type IS NULL DESC, $this->type DESC, id DESC";

        return DB::select($query);
    }

}
