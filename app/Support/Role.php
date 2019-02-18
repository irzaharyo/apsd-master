<?php
/**
 * Created by PhpStorm.
 * User: fiqy_
 * Date: 5/28/2018
 * Time: 12:20 AM
 */

namespace App\Support;

class Role
{
    /**
     *
     * Role untuk table admin
     * (user admin)
     */
    const ROOT = 'root';
    const ADMIN = 'admin';

    /**
     *
     * Role untuk table user
     * (user non-admin)
     */
    const PENGOLAH = 'pengolah';
    const KADIN = 'kadin';
    const TU = 'tata_usaha';
    const PEGAWAI = 'pegawai';

    const ALL = [
        Role::PEGAWAI,
        Role::TU,
        Role::KADIN,
        Role::PENGOLAH,
        Role::ADMIN,
        Role::ROOT
    ];

    /**
     * check whether the role is exist or not
     * @param $role_name
     * @param null $delimitter
     * @return bool
     */
    public static function check($role_name, $delimitter = null)
    {
        if (is_null($delimitter)) {
            if (in_array($role_name, Role::ALL)) {
                return true;
            }
        }

        return false;
    }
}