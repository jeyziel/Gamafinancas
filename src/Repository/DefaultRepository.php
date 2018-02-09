<?php declare(strict_types=1);


namespace GAMAFin\Repository;

use Illuminate\Database\Eloquent\Model;

class DefaultRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * DefaultRepository constructor.
     * @param string $model
     */
    public function __construct(string $model)
    {
        $this->model = new $model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find((int)$id);
    }

    public function findByField($field, $value)
    {
        return $this->model->where($field, '=', $value)->get();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    {
        $this->model->fill($data);
        $this->model->save();
        return $this->model;
    }

    /**
     * @param $id
     * @param array $data
     * @return Model
     */
    public function update($id, array $data)
    {
        /**
         * @var $model Model
         */
        $model = $this->find($id);
        $model->fill($data);
        $model->save();
        return $model;
    }

    public function delete($id)
    {
        /**
        * @var $model Model
        */
        $model = $this->find($id);
        $model->delete();

    }
}