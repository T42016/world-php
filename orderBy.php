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
            case 'Speakers':
                return 'ORDER BY '.$in.' DESC';
                break;
            case 'TotalSpeakers':
                return 'ORDER BY SUM(population*(Percentage/100)) DESC';
                break;
            default:
                return '';
        }
    }
}
?>