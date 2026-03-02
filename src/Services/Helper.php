<?php

namespace Bevith\DockerPhp\Services;



class Helper
{
    public static function filterRole(array $data, string $role): array
    {
        return array_filter($data, function ($item) use ($role){
            return $item['role'] === $role;
        });
    }

    public static function filterDepartament(array $data, string $departament): array
    {
        return array_filter($data, function ($item) use ($departament){
            if(isset($item['company']) && isset($item['company']['department'])){
                return $item['company']['department'] === $departament;
            }
             return false;
        });
    }

    public static function employees(array $data, string $company): array
    {
        $data =  self::filterDepartament($data, $company);

        return array_map(function ($item){
            $employee = [];
            $employee['name'] = $item['firstName'] . ' ' . $item['lastName'];
            $employee['email'] = $item['email'];
            $employee['phone'] = $item['phone'];
            $employee['company'] = $item['company']['name'];
            $employee['department'] = $item['company']['department'];
            return $employee;
        }, $data);
    }

    public static function countByDepartament(array $data, $company): array
    {
        $departaments = self::filterDepartament($data, $company);
        return array_reduce($departaments, function($item, $value){
            $dept = $value['company']['department'];
            if(!isset($item[$dept])){
                $item[$dept] = 0;
            }
            $item[$dept]++;
            return $item;
        });
    }

    public static function resumeDepartament($data, $departament)
    {
        $items = self::filterDepartament($data, $departament);
        
        $result = array_reduce($items, function($dataItens, $employee){
            $dataItens['total'] ++;
            $dataItens['sum_ages'] += $employee['age'];
            $dataItens['employees'][]= $employee['firstName'] .' '. $employee['lastName'];

            return $dataItens;

        }, [
              'total' => 0,
              'sum_ages' => 0,
              'employees' => []  
           ]
        );

        if($result['total'] >0){
            $result['average_age'] = $result['sum_ages'] / $result['total'];
        }

        return $result;
       
    }

    public static function resumeAllDepartament()
    {
       
    }


}