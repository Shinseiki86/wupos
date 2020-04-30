<?php

namespace Wupos\Http\Controllers;

use Illuminate\Http\Request;

use Wupos\Http\Requests;

class ZabbixController extends Controller
{
    /**
     * The ZabbixApi instance.
     *
     * @var \Becker\Zabbix\ZabbixApi
     */
    protected $zabbix;
    
    /**
     * Create a new Zabbix API instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->zabbix = app('zabbix');
    }

    /**
     * Get all the Zabbix host groups.
     *
     * @return array
     */
    public function indexServers()
    {
        $diskSpace = $this->zabbix->itemGet([
            'output' => ['hostid','key_', 'lastvalue'],
            //'hostids' => '10562',
            'sort' => 'hostid',
            'search' => [
                'key_' => 'vfs.fs.size',
            ],
            'filter' => [
                //'name' => 'Free disk space on $1',
            ],
        ]);

        $hosts = $this->zabbix->hostGet([
            //'output' => ['host'],
            //'hostids' => ['10583','10691' ],
            'sort' => 'hostid',
            'filter' => [ //Se excluyen los equipos de red.
                'status' => 0,
                'available' => 1,
            ],
        ]);
 //dd($hosts);
        $maxCountColumns = 0;
        foreach($hosts as $key=>$host){
            $countColumns = 0;
            $arrInfoDisk = [];
            $diskUpEightyPercent = false;
            foreach($diskSpace as $itemDisk){
                if($itemDisk->hostid == $host->hostid){
                    $slug = strpos($itemDisk->key_,',');
                    $letter = substr($itemDisk->key_,12,$slug-12);

                    $nameKey = substr($itemDisk->key_,$slug+1,-1);

                    if($nameKey == 'pfree'){
                        $nameKey = 'pused';
                        $value = round(100-$itemDisk->lastvalue,2);
                        if($value > 80)
                            $diskUpEightyPercent = true;
                        $countColumns++;
                    } else {
                        $value = round($itemDisk->lastvalue/pow(2,30),2).' GB';
                    }

                    $arrInfoDisk[$letter][$nameKey] = $value;
                }
            }
            $hosts[$key]->infoDisk = $arrInfoDisk;
            $hosts[$key]->diskUpEightyPercent = $diskUpEightyPercent;
            
            if($maxCountColumns < $countColumns)
                $maxCountColumns = $countColumns;
        }

        //Se ordenan hosts, colocando de primero los que tienen hdd con mas del 80% utilizado.        
        $hosts = array_sort($hosts, function ($value) {
            return !$value->diskUpEightyPercent;
        });

        //Se carga la vista y se pasan los registros
        return view('zabbix/index-servers', compact('hosts', 'maxCountColumns'));
    }

    /**
     * Get all the Zabbix host groups.
     *
     * @return array
     */
    public function indexRedes()
    {
       /* $diskSpace = $this->zabbix->itemGet([
            'output' => ['hostid','key_', 'lastvalue'],
            //'hostids' => '10562',
            'sort' => 'hostid',
            'search' => [
                'key_' => 'vfs.fs.size',
            ],
            'filter' => [
                //'name' => 'Free disk space on $1',
            ],
        ]);
dd($diskSpace);*/
        $hosts = $this->zabbix->hostGet([
            //'output' => ['host'],
            //'hostids' => ['10583','10691' ],
            'sort' => 'hostid',
            'filter' => [ 
                'status' => 0, //activos
                'available' => 0,//Se excluyen los equipos de red.
                //'snmp_available' => 2,//Se excluyen los equipos de red.
            ],
        ]);
        $columns = array_keys((array)$hosts[0]);

        //Se ordenan hosts, colocando de primero los que tienen hdd con mas del 80% utilizado.        
        //$hosts = array_sort($hosts, 'snmp_available');

        //Se carga la vista y se pasan los registros
        return view('zabbix/index-redes', compact('hosts', 'columns'));
    }
}