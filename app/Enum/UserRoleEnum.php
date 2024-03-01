<?php 
namespace App\Enum;

enum UserRoleEnum: string
{
    case SUPER_ADMIN = 'Super Admin';
    case SYSTEM_ADMIN = 'admin';
    case SYSTEM_EMP = 'Sys Employee';
    case COMPNANY_ADMIN = 'Admin Company';
    case COMPNANY_EMP = 'Company Employee';
    case CANDIDATE = 'Candidate';
}