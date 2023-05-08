<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{

    protected $model;
    public function __construct(User $user)
    {
        $this->model = $user;
    }


    /**
     * Find a collection of models by conditions.
     *
     * @param array $conditions Array of conditions
     * @param array $relations  An array of relations
     *
     * @return Collection| A collection of model
     */
    public function findBy(array $conditions, array $relations = [])
    {
        $query = $this
            ->model
            ->with($relations)
            ->where($conditions);

        return $query->get();
    }
    /**
     * Find one collection of models by conditions.
     *
     * @param array $conditions Array of conditions
     * @param array $relations  An array of relations
     *
     * @return Collection| A collection of model
     */
    public function findOneBy(array $conditions, array $relations = []): ?User
    {
        return $this
            ->model
            ->with($relations)
            ->where($conditions)
            ->first();
    }

    /**
     * Joins one or many table by conditions.
     *
     * @param array $joins Array of join
     *  @param array $conditions Array of conditions
     *@param array select Array of selected element
     * @param array $relations  An array of relations
     *
     * @return Collection| A collection of model
     */
     public function joins(array $joins, array $conditions, array $relations = [],array $select)
    {
        foreach ($joins as $joinarray) {
           $query= $this->model->join($joinarray[0], $joinarray[1], $joinarray[2], $joinarray[3]);
        }
        $query->with($relations);
        $query->where($conditions)->select($select);

        return $query->get();
    }
    /**
     * Update rows.
     *
     * @param array $attributes Array of attributes to update
     *  @param array $conditions Array of conditions
     * @param array $relations  An array of relations
     *
     * @return User|
     */
    public function update(array $attributes, User $user): ?User
    {
        return $user->update($attributes) ? $user : null;
    }

    /**
     * Counts the number of records that match the specified conditions.
     *
     * @param array $conditions The conditions to filter the records.
     * @return int The number of records that match the conditions.
     */
    public function countBy(array $conditions): int
    {
        return $this->model->where($conditions)->count();
    }


    /**
     * Associates the given attributes with the provided User.
     *
     * @param User $user The User instance to associate the attributes with.
     * @param array $attributes The attributes of relations to associate with the User.
     * @return User|null The updated User instance if successful, or null otherwise.
     */
    public function associate(User $user, array $attributes): ?User
    {
        foreach ($attributes as $key => $value) {
            $user->$key()->associate($value);
        }
        return  $user->save() ? $user : null;
    }


    /**
     * Store a new User record with the given attributes.
     *
     * @param array $attributes The attributes for the new User record.
     * @return User The newly created User instance.
     */
    public function store(array $attributes): User
    {
        return $this->model->create($attributes);
    }
}
