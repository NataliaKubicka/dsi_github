<?php


namespace App\Utils;

use Symfony\Component\Ldap\Ldap;

class LdapDsi
{
    private $ldapUser;
    private $ldapUserPassword;
    private $ldapHost;
    private $ldapPort;
    private $ldap;

    public function __construct($ldapUser, $ldapUserPassword, $ldapHost, $ldapPort)
    {

        $this->ldapUser = $ldapUser;
        $this->ldapUserPassword = $ldapUserPassword;
        $this->ldapHost = $ldapHost;
        $this->ldapPort = $ldapPort;

        $this->connection();
    }


    private function connection()
    {
        $this->ldap = Ldap::create('ext_ldap', ['connection_string' => 'ldap://'.$this->ldapHost.':'.$this->ldapPort]);
        $this->ldap->bind($this->ldapUser, $this->ldapUserPassword);
    }

    /**
     * @return Ldap
     */
    public function getLdap(): Ldap
    {
        return $this->ldap;
    }


}
