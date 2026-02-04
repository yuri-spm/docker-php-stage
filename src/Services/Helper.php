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
            return $item['company']['department'] == $departament;
        });
    }


}