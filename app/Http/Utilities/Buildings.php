<?php


namespace App\Http\Utilities;


class Buildings
{
    protected static $buildings = [
        'A1' => 'A1',
        'AM' => 'Americká 42',
        'AV' => 'AVALON Business center, Poděbradova 1',
        'B1' => 'B1',
        'B2' => 'B2',
        'B3' => 'B3',
        'CB' => 'Skuherského',
        'CD' => 'Hradební 22, Cheb',
        'CH' => 'Chodské nám. 1',
        'CK' => 'CK',
        'DP' => 'DP',
        'EC' => 'Univerzitní 26, Elektrofakulta – RICE',
        'EH' => 'Univerzitní 26, Elektrofakulta – RICE',
        'EK' => 'Univerzitní 26, areál Bory, katedry elektro',
        'EL' => 'Univerzitní 26, areál Bory, laboratoře elektro',
        'EP' => 'Univerzitní 26, areál Bory, posluchárny elektro',
        'ES' => 'Univerzitní 26, areál Bory, spojovací elektro',
        'ET' => 'Univerzitní 26, areál Bory, trafo elektro',
        'EU' => 'Univerzitní 26, areál Bory, učebny elektro',
        'EZ' => 'Univerzitní 26, Elektrofakulta – RICE',
        'FN' => 'Alej Svobody',
        'HJ' => 'Husova 11',
        'JJ' => 'Jungmannova 1',
        'K1' => 'K1',
        'KC' => 'Komenského 42',
        'KL' => 'Klatovská 51',
        'KO' => 'Kollárova 19, tělocvična',
        'KV' => 'Lidická 455/40',
        'L1' => 'Bolevecká 30',
        'L2' => 'L2',
        'LE' => 'Ledecká 35',
        'LO' => 'Areál Lochotín, Bolevecká ul.',
        'LS' => 'Univerzitní 28, areál Bory, Ústav umění a design',
        'MN' => 'Mikulášské nám. 15 (vchod Jablonského 4)',
        'NC' => 'NC',
        'NO' => 'Náměstí odboje 18',
        'NT' => 'NT',
        'PC' => 'Sady Pětatřicátníků 14',
        'PD' => 'Sady Pětatřicátníků 27',
        'PN' => 'Rückertstrasse 35',
        'PR' => 'Přeštice, rozvodna',
        'PS' => 'Sady Pětatřicátníků 16',
        'RJ' => 'Riegrova 11',
        'RS' => 'Riegrova 17',
        'SD' => 'Sedláčkova 19',
        'SE' => 'Želivského – Strakonice',
        'SK' => 'Sokolovská 46',
        'SL' => 'SLAVIE sportovní areál, U Borského parku',
        'SO' => 'Sedláčkova 38',
        'SP' => 'Sedláčkova 15',
        'ST' => 'Sedláčkova 31',
        'SV' => 'Slovany – bazén',
        'TC' => 'Teslova',
        'TF' => 'Teslova',
        'TG' => 'TG',
        'TH' => 'TH',
        'TP' => 'Tylova 15',
        'TS' => 'Tylova 59',
        'TY' => 'Tylova 18',
        'UB' => 'Univerzitní 18, areál Bory, knihovna',
        'UC' => 'Technická 8, areál Bory – katedry FAV',
        'UD' => 'Univerzitní 22, areál Bory, halové laboratoře',
        'UF' => 'Univerzitní 22, areál Bory, objekt KFY a KMM',
        'UH' => 'Univerzitní 22, areál Bory, objekt RTI',
        'UI' => 'Univerzitní 20, areál Bory, objekt CIVu',
        'UK' => 'Univerzitní 22, areál Bory, katedrový objekt',
        'UL' => 'Univerzitní 22, areál Bory, laboratorní objekt',
        'UM' => 'UM',
        'UN' => 'Technická 8, areál Bory – NTIS',
        'UP' => 'Univerzitní 22, areál Bory, objekt poslucháren',
        'UR' => 'Univerzitní 8, areál Bory, rektorát',
        'US' => 'Technická 8, areál Bory – společné prostory FAV',
        'UT' => 'Univerzitní 22, areál Bory, objekt KTS',
        'UU' => 'Univerzitní 22, areál Bory, objekt učeben',
        'UV' => 'Univerzitní 22, areál Bory, vstupní objekt',
        'UX' => 'Univerzitní 22, areál Bory, halové laboratoře',
        'VC' => 'Veleslavínova 42',
        'VK' => 'Vejprnická 52 – krček (spojovací chodba)',
        'VP' => 'Vejprnická 52',
    ];

    public static function all()
    {
        return array_keys(static::$buildings);
    }

    public static function allWithFullName()
    {
        return static::$buildings;
    }
}
