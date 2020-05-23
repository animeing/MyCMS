<?php
use db\base\Connector;
use db\base\ISql;
use db\base\DtoBase;

abstract class SqlCreater extends Connector implements ISql{

    function select(){
        return $this->toDtoList(
            $this->execute($this->selectQuery())
        );
    }

    protected function selectQuery(){
        return isql::SELECT.ISql::ALL_COLUMN.ISql::FROM.$this::TABLE_NAME;
    }

    function countQuery(){
        return ISql::SELECT.ISql::COUNT_ASTER.ISql::FROM.$this::TABLE_NAME;
    }

    /**
     */
    function find($param){
        $paramArray = array();
        if(!is_array($param)){
            $paramArray[] = $param;
        } else {
            $paramArray = $param;
        }
        return $this->toDtoList(
            $this->execute($this->whereQuery($this::PRIMARY_KEY.ISql::EQUAL_PARAM), $paramArray));
    }
    
    /**
     * @param string $whereQuery
     */
    function whereQuery($whereQuery){
        return $this->selectQuery().ISql::WHERE.$whereQuery;
    }

    function countWhereQuery($whereQuery){
        return $this->countQuery().ISql::WHERE.$whereQuery;
    }

    function deleteQuery(){
        return ISql::DELETE.ISql::FROM.$this::TABLE_NAME.ISql::WHERE.$this::PRIMARY_KEY.ISql::EQUAL_PARAM;
    }

    protected function insertQuery($dto){
        $sql = ISql::INSERT.ISql::INTO.$this::TABLE_NAME.ISql::BRACKET_OPEN;
        $values = "";
        foreach (array_keys($dto->getDtoCache()) as $column){
            if(!StringUtil::isNullOrEmpty($values)) {
                $sql .= ",";
                $values .= ",";
            }
            $sql .= $column;
            $values .= ISql::VALUE;
        }
        if(StringUtil::isNullOrEmpty($values)){
            throw new Exception("undefined data");
        }
        $sql .= ISql::BRACKET_END.ISql::VALUES.ISql::BRACKET_OPEN.$values.ISql::BRACKET_END;
        return $sql;
    }

    function insert($dto){
        $this->commitExecute(
            $this->insertQuery($dto),
            array_values($dto->getDtoCache())
        );
    }

    protected function updateQuery($dto){
        $sql = ISql::UPDATE.$this::TABLE_NAME.ISql::SET;
        $columns = "";
        foreach(array_keys($dto->getDtoCache()) as $column){
            if($column == $this::PRIMARY_KEY){
                continue;
            }
            if(!StringUtil::isNullOrEmpty($columns)) {
                $columns .= ",";
            }
            $columns .= $column.ISql::EQUAL_PARAM;
        }
        if(StringUtil::isNullOrEmpty($columns)){
            throw new Exception("undefined data");
        }
        $sql .= $columns.ISql::WHERE.$this::PRIMARY_KEY.ISql::EQUAL_PARAM;
        return $sql;
    }

    function update($dto){
        $columnData = array();
        try{
            foreach(array_keys($dto->getDtoCache()) as $columnName){
                if($columnName == $this::PRIMARY_KEY){
                    continue;
                }
                $columnData[] = $dto->getDtoCache()[$columnName];
            }
            $columnData[] = $dto->getPrimaryKey();
            $this->commitExecute(
                $this->updateQuery($dto),
                $columnData
            );
        } catch (Exception $e) {
            return false;
        }
        return true;
    }


    /**
     * @return DtoBase
     */
    abstract function createDto();

    /**
     * @return DtoBase[]
     */
    function toDtoList($rs){
        $dtos = array();
        foreach($rs as $row){
            $dtos[] = $this->toDto($row);
        }
        return $dtos;
    }

    /**
     * 
     */
    function toDto($rs){
        $dto = $this->createDto();
        $dto->putAllDtoCache($rs);
        return $dto;
    }

}