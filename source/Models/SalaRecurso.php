<?php

namespace Source\Models;

use Labex\BasicPdo\Dao;
use Labex\BasicPdo\Functions;

class SalaRecurso extends Dao implements Functions
{
    // constantes
    const ENTIDADE = 'sala_recurso';

    const ID = self::ENTIDADE . '_id';
    const QTD = 'qtd_recurso';
    const SALA_ID = self::ENTIDADE . '_sala_id';
    const RECURSO_ID = self::ENTIDADE . '_recurso_id';

    const RECURSO_A_K_N_N = array(SalaRecurso::QTD, SalaRecurso::SALA_ID, SalaRecurso::RECURSO_ID);

    // atributos 
    private $sala_recurso_id;
    private $qtd_recurso;
    private $sala_recurso_sala_id;
    private $sala_recurso_recurso_id;

    // getters and setters
    public function getSala_recurso_id()
    {
        return $this->sala_recurso_id;
    }

    public function setSala_recurso_id($sala_recurso_id)
    {
        $this->sala_recurso_id = $sala_recurso_id;
    }

    public function getQtd_recurso()
    {
        return $this->qtd_recurso;
    }

    public function setQtd_recurso($qtd_recurso)
    {
        $this->qtd_recurso = $qtd_recurso;
    }

    public function getSala_recurso_sala_id()
    {
        return $this->sala_recurso_sala_id;
    }

    public function setSala_recurso_sala_id($sala_recurso_sala_id)
    {
        $this->sala_recurso_sala_id = $sala_recurso_sala_id;
    }

    public function getSala_recurso_recurso_id()
    {
        return $this->sala_recurso_recurso_id;
    }

    public function setSala_recurso_recurso_id($sala_recurso_recurso_id)
    {
        $this->sala_recurso_recurso_id = $sala_recurso_recurso_id;
    }

    // functions of class
    public function transform_array_to_object(array $data)
    {
        $obj = new SalaRecurso();
        isset($data[self::ID]) ? $obj->setSala_recurso_id($data[self::ID]) : null;
        isset($data[self::QTD]) ? $obj->setQtd_recurso($data[self::QTD]) : null;
        isset($data[self::SALA_ID]) ? $obj->setSala_recurso_sala_id($data[self::SALA_ID]) : null;
        isset($data[self::RECURSO_ID]) ? $obj->setSala_recurso_recurso_id($data[self::RECURSO_ID]) : null;

        // retorna null para o a atributo result
        $obj->setResult();
        return $obj;
    }

    /**
     * @lacy_
     * adiciona um ou mais recursos em uma sala
     * $data -> array de objetos de uma rede
     */
    public function add_room_resources(array $data)
    {
        //contagem de recursos adicionados
        $count_success = 0;
        if (!empty($data)) {
            foreach ($data as $key) {
                $sala_recurso = new SalaRecurso();
                $obj = $sala_recurso->transform_array_to_object($key);
                $sala_recurso->create(SalaRecurso::ENTIDADE, $obj);
                $db_result = $this->database_result($sala_recurso);

                if ($db_result == TAG_SUCCESS) {
                    $count_success += 1;
                }
            }

            if ($count_success == count($data)) {
                return TAG_SUCCESS;
            } else {
                return TAG_ERROR;
            }
        } else {
            return null;
        }
    }

    /**
     * @lacy_
     * remove um ou mais recursos em uma sala
     * $list -> array de objetos de uma rede
     */
    public function remove_room_resources(array $list)
    {
        //contagem de recursos adicionados
        $count_success = 0;
        if (!empty($list)) {
            foreach ($list as $id) {
                $sala_recurso = new SalaRecurso();
                $sala_recurso->delete(self::ENTIDADE, $id);
                $db_result = $this->database_result($sala_recurso);

                if ($db_result == TAG_SUCCESS) {
                    $count_success += 1;
                }
            }

            if ($count_success == count($list)) {
                return TAG_SUCCESS;
            } else {
                return TAG_ERROR;
            }
        } else {
            return TAG_MESSAGE . '1';
        }
    }

    /**
     * @lacy_
     * atualiza um ou mais recursos de uma sala
     * $list -> array de objetos de uma rede
     */
    public function update_room_resources(array $list)
    {
        //contagem de recursos adicionados
        $count_success = 0;
        if (!empty($list)) {
            foreach ($list as $key) {
                $sala_recurso = new SalaRecurso();
                $obj = $sala_recurso->transform_array_to_object($key);
                $sala_recurso->update(self::ENTIDADE, $obj);
                $db_result = $this->database_result($sala_recurso);

                if ($db_result == TAG_SUCCESS) {
                    $count_success += 1;
                }
            }

            if ($count_success == count($list)) {
                return TAG_SUCCESS;
            } else {
                return TAG_ERROR;
            }
        } else {
            return TAG_MESSAGE . '1';
        }
    }
}
