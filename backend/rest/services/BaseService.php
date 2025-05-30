<?php

class BaseService {
    protected $dao;

    public function __construct($dao) {
        $this->dao = $dao;
    }

    public function getAll() {
        if (method_exists($this->dao, 'getAll')) {
            return $this->dao->getAll();
        }
    }

    public function getById($id) {
        if (method_exists($this->dao, 'getById')) {
            return $this->dao->getById($id);
        }
    }

    public function add($data) {
        if (method_exists($this->dao, 'add')) {
            return $this->dao->add($data);
        }
    }

    public function update($data) {
        if (method_exists($this->dao, 'update')) {
            return $this->dao->update($data);
        }
    }

    public function delete($id) {
        if (method_exists($this->dao, 'delete')) {
            return $this->dao->delete($id);
        }
    }
}
