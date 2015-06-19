<?php

class m150513_201455_initial_sys extends CDbMigration
{

    public function safeUp()
    {
        $check = Yii::app()->db->schema->getTable('sys_users');
//         if(!is_null($check)){
            $this->createTable('sys_user_limited_model', array(
                'id'=>'serial NOT NULL',
                'user_id'=>'integer NOT NULL',
                'table_name'=>'character varying NOT NULL',
                'model_name'=>'character varying NOT NULL',
                'limited'=>'int NOT NULL DEFAULT 1',
                'PRIMARY KEY ("id")',
            ), '');
            $this->createIndex('idx_user_id_model', 'sys_user_limited_model', 'user_id', FALSE);
        
            $this->createTable('sys_user_limited_data', array(
                'id'=>'serial NOT NULL',
                'user_id'=>'integer NOT NULL',
                'table_name'=>'character varying NOT NULL',
                'model_name'=>'character varying NOT NULL',
                'data_id'=>'character varying(256) NOT NULL',
                'PRIMARY KEY ("id")',
            ), '');
            $this->createIndex('idx_user_id_data', 'sys_user_limited_data', 'user_id', FALSE);
        
            $this->addForeignKey('fk_sys_user_limited_model_sys_users_user_id', 'sys_user_limited_model', 'user_id', 'sys_users', 'id', 'NO ACTION', 'NO ACTION');
            $this->addForeignKey('fk_sys_user_limited_data_sys_users_user_id', 'sys_user_limited_data', 'user_id', 'sys_users', 'id', 'NO ACTION', 'NO ACTION');
/*
        }else{
            throw new Exception("Sys_users doesn't exist.");
        }
*/
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_sys_user_limited_model_sys_users_user_id', 'sys_user_limited_model');
        $this->dropForeignKey('fk_sys_user_limited_data_sys_users_user_id', 'sys_user_limited_data');
    
        $this->dropTable('sys_user_limited_model');
        $this->dropTable('sys_user_limited_data');
        
    }
}