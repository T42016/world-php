<?php

class orderBy
{
    public static function GetOrderBy(string $in) {
        switch ($in) {
            case 'Name':
            case 'Code':
            case 'Continent':
            case 'Region':
            case 'Capital':
            case 'CountryName':
            case 'District':
            case 'Language':
            case 'IsOfficial':
                return 'ORDER BY '.$in.' ASC';
                break;
            case 'SurfaceArea':
            case 'Population':
            case 'Percentage':
                return 'ORDER BY '.$in.' DESC';
                break;
            default:
                return '';
        }
    }
}
?>