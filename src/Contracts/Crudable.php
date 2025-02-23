<?php
namespace Sosupp\SlimDashboard\Contracts;

interface Crudable
{
    public function make(int|null $id, array $data);
    public function one(int|string $id);
    public function list(int|null $limit = null, array $cols = ['*']);
    public function paginate(int|null $limit = null, array $cols = ['*']);
    public function remove(int|string $id);
}
