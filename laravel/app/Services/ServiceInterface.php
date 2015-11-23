<?php
/**
 * interface of all services
 */
namespace App\Services;
interface ServiceInterface
{
    /**
     * service 应明确为单例
     * @return mixed
     */
    static public function instance();
}