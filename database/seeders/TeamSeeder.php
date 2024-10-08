<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Esegui il seeder.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            // Serie A (Italy) - League ID: 135
            ['team_id' => 487, 'league_id' => 135, 'name' => 'Lazio'],
            ['team_id' => 488, 'league_id' => 135, 'name' => 'Sassuolo'],
            ['team_id' => 489, 'league_id' => 135, 'name' => 'AC Milan'],
            ['team_id' => 490, 'league_id' => 135, 'name' => 'Cagliari'],
            ['team_id' => 491, 'league_id' => 135, 'name' => 'Chievo'],
            ['team_id' => 492, 'league_id' => 135, 'name' => 'Napoli'],
            ['team_id' => 493, 'league_id' => 135, 'name' => 'Spal'],
            ['team_id' => 494, 'league_id' => 135, 'name' => 'Udinese'],
            ['team_id' => 495, 'league_id' => 135, 'name' => 'Genoa'],
            ['team_id' => 496, 'league_id' => 135, 'name' => 'Juventus'],
            ['team_id' => 497, 'league_id' => 135, 'name' => 'AS Roma'],
            ['team_id' => 498, 'league_id' => 135, 'name' => 'Sampdoria'],
            ['team_id' => 499, 'league_id' => 135, 'name' => 'Atalanta'],
            ['team_id' => 500, 'league_id' => 135, 'name' => 'Bologna'],
            ['team_id' => 501, 'league_id' => 135, 'name' => 'Crotone'],
            ['team_id' => 502, 'league_id' => 135, 'name' => 'Fiorentina'],
            ['team_id' => 503, 'league_id' => 135, 'name' => 'Torino'],
            ['team_id' => 504, 'league_id' => 135, 'name' => 'Verona'],
            ['team_id' => 505, 'league_id' => 135, 'name' => 'Inter'],
            ['team_id' => 506, 'league_id' => 135, 'name' => 'Benevento'],
            ['team_id' => 507, 'league_id' => 135, 'name' => 'Ascoli'],
            ['team_id' => 508, 'league_id' => 135, 'name' => 'Bari'],
            ['team_id' => 509, 'league_id' => 135, 'name' => 'Cesena'],
            ['team_id' => 510, 'league_id' => 135, 'name' => 'Cittadella'],
            ['team_id' => 511, 'league_id' => 135, 'name' => 'Empoli'],
            ['team_id' => 512, 'league_id' => 135, 'name' => 'Frosinone'],
            ['team_id' => 513, 'league_id' => 135, 'name' => 'Novara'],
            ['team_id' => 514, 'league_id' => 135, 'name' => 'Salernitana'],
            ['team_id' => 515, 'league_id' => 135, 'name' => 'Spezia'],
            ['team_id' => 516, 'league_id' => 135, 'name' => 'Ternana'],
            ['team_id' => 517, 'league_id' => 135, 'name' => 'Venezia'],
            ['team_id' => 518, 'league_id' => 135, 'name' => 'Brescia'],
            ['team_id' => 519, 'league_id' => 135, 'name' => 'Carpi'],
            ['team_id' => 520, 'league_id' => 135, 'name' => 'Cremonese'],
            ['team_id' => 521, 'league_id' => 135, 'name' => 'Foggia'],
            ['team_id' => 522, 'league_id' => 135, 'name' => 'Palermo'],
            ['team_id' => 523, 'league_id' => 135, 'name' => 'Parma'],
            ['team_id' => 524, 'league_id' => 135, 'name' => 'Perugia'],
            ['team_id' => 525, 'league_id' => 135, 'name' => 'Pescara'],
            ['team_id' => 526, 'league_id' => 135, 'name' => 'PRO Vercelli'],
            ['team_id' => 527, 'league_id' => 135, 'name' => 'Virtus Entella'],
            ['team_id' => 528, 'league_id' => 135, 'name' => 'Avellino'],
            ['team_id' => 768, 'league_id' => 135, 'name' => 'Italy'],
            ['team_id' => 801, 'league_id' => 135, 'name' => 'Pisa'],
            ['team_id' => 803, 'league_id' => 135, 'name' => 'Trapani'],
            ['team_id' => 804, 'league_id' => 135, 'name' => 'Latina'],
            ['team_id' => 862, 'league_id' => 135, 'name' => 'Pordenone'],
            ['team_id' => 863, 'league_id' => 135, 'name' => 'Juve Stabia'],
            ['team_id' => 864, 'league_id' => 135, 'name' => 'Cosenza'],
            ['team_id' => 865, 'league_id' => 135, 'name' => 'Giana Erminio'],
            ['team_id' => 866, 'league_id' => 135, 'name' => 'Gubbio'],
            ['team_id' => 867, 'league_id' => 135, 'name' => 'Lecce'],
            ['team_id' => 868, 'league_id' => 135, 'name' => 'Livorno'],
            ['team_id' => 869, 'league_id' => 135, 'name' => 'Matera'],
            ['team_id' => 870, 'league_id' => 135, 'name' => 'Padova'],
            ['team_id' => 871, 'league_id' => 135, 'name' => 'Sambenedettese'],
            ['team_id' => 872, 'league_id' => 135, 'name' => 'Piacenza'],
            ['team_id' => 873, 'league_id' => 135, 'name' => 'Virtus Francavilla'],
            ['team_id' => 874, 'league_id' => 135, 'name' => 'Trastevere'],
            ['team_id' => 875, 'league_id' => 135, 'name' => 'Renate'],
            ['team_id' => 876, 'league_id' => 135, 'name' => 'Arezzo'],
            ['team_id' => 877, 'league_id' => 135, 'name' => 'Triestina'],
            ['team_id' => 878, 'league_id' => 135, 'name' => 'Alessandria'],
            ['team_id' => 879, 'league_id' => 135, 'name' => 'Albinoleffe'],
            ['team_id' => 880, 'league_id' => 135, 'name' => 'Reggiana'],
            ['team_id' => 881, 'league_id' => 135, 'name' => 'Bassano Virtus'],
            ['team_id' => 882, 'league_id' => 135, 'name' => 'Guidonia Montecelio 1937'],
            ['team_id' => 883, 'league_id' => 135, 'name' => 'Ciliverghe'],
            ['team_id' => 884, 'league_id' => 135, 'name' => 'Feralpisalo'],
            ['team_id' => 885, 'league_id' => 135, 'name' => 'Casertana'],
            ['team_id' => 886, 'league_id' => 135, 'name' => 'Rende'],
            ['team_id' => 887, 'league_id' => 135, 'name' => 'Varese'],
            ['team_id' => 888, 'league_id' => 135, 'name' => 'Matelica'],
            ['team_id' => 889, 'league_id' => 135, 'name' => 'Lucchese'],
            ['team_id' => 890, 'league_id' => 135, 'name' => 'Paganese'],
            ['team_id' => 891, 'league_id' => 135, 'name' => 'Massese'],
            ['team_id' => 892, 'league_id' => 135, 'name' => 'PRO Piacenza'],
            ['team_id' => 893, 'league_id' => 135, 'name' => 'Imolese'],
            ['team_id' => 894, 'league_id' => 135, 'name' => 'Siracusa'],
            ['team_id' => 895, 'league_id' => 135, 'name' => 'Como'],
            ['team_id' => 896, 'league_id' => 135, 'name' => 'Seregno'],
            ['team_id' => 897, 'league_id' => 135, 'name' => 'Ancona'],
            ['team_id' => 898, 'league_id' => 135, 'name' => 'Messina'],
            ['team_id' => 899, 'league_id' => 135, 'name' => 'Modena'],
            ['team_id' => 900, 'league_id' => 135, 'name' => 'Maceratese'],
            ['team_id' => 1578, 'league_id' => 135, 'name' => 'Sudtirol'],
            ['team_id' => 1579, 'league_id' => 135, 'name' => 'Monza'],
            ['team_id' => 1580, 'league_id' => 135, 'name' => 'Catania'],
            ['team_id' => 1581, 'league_id' => 135, 'name' => 'Carrarese'],
            ['team_id' => 1582, 'league_id' => 135, 'name' => 'Monopoli'],
            ['team_id' => 1583, 'league_id' => 135, 'name' => 'Robur Siena'],
            ['team_id' => 1584, 'league_id' => 135, 'name' => 'Vicenza Virtus'],
            ['team_id' => 1585, 'league_id' => 135, 'name' => 'Viterbese'],
            ['team_id' => 1586, 'league_id' => 135, 'name' => 'Albalonga'],
            ['team_id' => 1587, 'league_id' => 135, 'name' => 'AZ Picerno'],
            ['team_id' => 1588, 'league_id' => 135, 'name' => 'Rezzato'],
            ['team_id' => 1589, 'league_id' => 135, 'name' => 'Pistoiese'],
            ['team_id' => 1590, 'league_id' => 135, 'name' => 'Sicula Leonzio'],
            ['team_id' => 1591, 'league_id' => 135, 'name' => 'Pontedera'],
            ['team_id' => 1592, 'league_id' => 135, 'name' => 'Campodarsego'],
            // Aggiungi tutte le altre squadre di Serie A qui...

            ['team_id' => 10, 'league_id' => 39, 'name' => 'England '],
            ['team_id' => 33, 'league_id' => 39, 'name' => 'Manchester United '],
            ['team_id' => 34, 'league_id' => 39, 'name' => 'Newcastle '],
            ['team_id' => 35, 'league_id' => 39, 'name' => 'Bournemouth '],
            ['team_id' => 36, 'league_id' => 39, 'name' => 'Fulham '],
            ['team_id' => 37, 'league_id' => 39, 'name' => 'Huddersfield '],
            ['team_id' => 38, 'league_id' => 39, 'name' => 'Watford '],
            ['team_id' => 39, 'league_id' => 39, 'name' => 'Wolves '],
            ['team_id' => 40, 'league_id' => 39, 'name' => 'Liverpool '],
            ['team_id' => 41, 'league_id' => 39, 'name' => 'Southampton '],
            ['team_id' => 42, 'league_id' => 39, 'name' => 'Arsenal '],
            ['team_id' => 44, 'league_id' => 39, 'name' => 'Burnley '],
            ['team_id' => 45, 'league_id' => 39, 'name' => 'Everton '],
            ['team_id' => 46, 'league_id' => 39, 'name' => 'Leicester '],
            ['team_id' => 47, 'league_id' => 39, 'name' => 'Tottenham '],
            ['team_id' => 48, 'league_id' => 39, 'name' => 'West Ham '],
            ['team_id' => 49, 'league_id' => 39, 'name' => 'Chelsea '],
            ['team_id' => 50, 'league_id' => 39, 'name' => 'Manchester City '],
            ['team_id' => 51, 'league_id' => 39, 'name' => 'Brighton '],
            ['team_id' => 52, 'league_id' => 39, 'name' => 'Crystal Palace '],
            ['team_id' => 53, 'league_id' => 39, 'name' => 'Reading '],
            ['team_id' => 54, 'league_id' => 39, 'name' => 'Birmingham '],
            ['team_id' => 55, 'league_id' => 39, 'name' => 'Brentford '],
            ['team_id' => 56, 'league_id' => 39, 'name' => 'Bristol City '],
            ['team_id' => 57, 'league_id' => 39, 'name' => 'Ipswich '],
            ['team_id' => 58, 'league_id' => 39, 'name' => 'Millwall '],
            ['team_id' => 59, 'league_id' => 39, 'name' => 'Preston '],
            ['team_id' => 60, 'league_id' => 39, 'name' => 'West Brom '],
            ['team_id' => 61, 'league_id' => 39, 'name' => 'Wigan '],
            ['team_id' => 62, 'league_id' => 39, 'name' => 'Sheffield Utd '],
            ['team_id' => 63, 'league_id' => 39, 'name' => 'Leeds '],
            ['team_id' => 64, 'league_id' => 39, 'name' => 'Hull City '],
            ['team_id' => 65, 'league_id' => 39, 'name' => 'Nottingham Forest '],
            ['team_id' => 66, 'league_id' => 39, 'name' => 'Aston Villa '],
            ['team_id' => 67, 'league_id' => 39, 'name' => 'Blackburn '],
            ['team_id' => 68, 'league_id' => 39, 'name' => 'Bolton '],
            ['team_id' => 69, 'league_id' => 39, 'name' => 'Derby '],
            ['team_id' => 70, 'league_id' => 39, 'name' => 'Middlesbrough '],
            ['team_id' => 71, 'league_id' => 39, 'name' => 'Norwich '],
            ['team_id' => 72, 'league_id' => 39, 'name' => 'QPR '],
            ['team_id' => 73, 'league_id' => 39, 'name' => 'Rotherham '],
            ['team_id' => 74, 'league_id' => 39, 'name' => 'Sheffield Wednesday '],
            ['team_id' => 75, 'league_id' => 39, 'name' => 'Stoke City '],
            ['team_id' => 746, 'league_id' => 39, 'name' => 'Sunderland '],
            ['team_id' => 747, 'league_id' => 39, 'name' => 'Barnsley '],
            ['team_id' => 748, 'league_id' => 39, 'name' => 'Burton Albion '],
            ['team_id' => 1333, 'league_id' => 39, 'name' => 'AFC Wimbledon '],
            ['team_id' => 1334, 'league_id' => 39, 'name' => 'Bristol Rovers '],
            ['team_id' => 1335, 'league_id' => 39, 'name' => 'Charlton '],
            ['team_id' => 1336, 'league_id' => 39, 'name' => 'Fleetwood Town '],
            ['team_id' => 1337, 'league_id' => 39, 'name' => 'Northampton '],
            ['team_id' => 1338, 'league_id' => 39, 'name' => 'Oxford United '],
            ['team_id' => 1339, 'league_id' => 39, 'name' => 'Rochdale '],
            ['team_id' => 1340, 'league_id' => 39, 'name' => 'Scunthorpe '],
            ['team_id' => 1341, 'league_id' => 39, 'name' => 'Southend '],
            ['team_id' => 1342, 'league_id' => 39, 'name' => 'Walsall '],
            ['team_id' => 1343, 'league_id' => 39, 'name' => 'Bradford '],
            ['team_id' => 1344, 'league_id' => 39, 'name' => 'Bury '],
            ['team_id' => 1345, 'league_id' => 39, 'name' => 'Chesterfield '],
            ['team_id' => 1346, 'league_id' => 39, 'name' => 'Coventry '],
            ['team_id' => 1347, 'league_id' => 39, 'name' => 'Gillingham '],
            ['team_id' => 1348, 'league_id' => 39, 'name' => 'Milton Keynes Dons '],
            ['team_id' => 1349, 'league_id' => 39, 'name' => 'Oldham '],
            ['team_id' => 1350, 'league_id' => 39, 'name' => 'Peterborough '],
            ['team_id' => 1351, 'league_id' => 39, 'name' => 'Port Vale '],
            ['team_id' => 1352, 'league_id' => 39, 'name' => 'Shrewsbury '],
            ['team_id' => 1353, 'league_id' => 39, 'name' => 'Swindon Town '],
            ['team_id' => 1354, 'league_id' => 39, 'name' => 'Doncaster '],
            ['team_id' => 1355, 'league_id' => 39, 'name' => 'Portsmouth '],
            ['team_id' => 1356, 'league_id' => 39, 'name' => 'Blackpool '],
            ['team_id' => 1357, 'league_id' => 39, 'name' => 'Plymouth '],
            ['team_id' => 1358, 'league_id' => 39, 'name' => 'Wycombe '],
            ['team_id' => 1359, 'league_id' => 39, 'name' => 'Luton '],
            ['team_id' => 1360, 'league_id' => 39, 'name' => 'Accrington ST '],
            ['team_id' => 1361, 'league_id' => 39, 'name' => 'Colchester '],
            ['team_id' => 1362, 'league_id' => 39, 'name' => 'Crawley Town '],
            ['team_id' => 1363, 'league_id' => 39, 'name' => 'Crewe '],
            ['team_id' => 1364, 'league_id' => 39, 'name' => 'Exeter City '],
            ['team_id' => 1365, 'league_id' => 39, 'name' => 'Grimsby '],
            ['team_id' => 1366, 'league_id' => 39, 'name' => 'Hartlepool '],
            ['team_id' => 1368, 'league_id' => 39, 'name' => 'Stevenage '],
            ['team_id' => 1369, 'league_id' => 39, 'name' => 'Barnet '],
            ['team_id' => 1370, 'league_id' => 39, 'name' => 'Cambridge United '],
            ['team_id' => 1371, 'league_id' => 39, 'name' => 'Carlisle '],
            ['team_id' => 1372, 'league_id' => 39, 'name' => 'Cheltenham '],
            ['team_id' => 1373, 'league_id' => 39, 'name' => 'Leyton Orient '],
            ['team_id' => 1374, 'league_id' => 39, 'name' => 'Mansfield Town '],
            ['team_id' => 1375, 'league_id' => 39, 'name' => 'Morecambe '],
            ['team_id' => 1376, 'league_id' => 39, 'name' => 'Notts County '],
            ['team_id' => 1377, 'league_id' => 39, 'name' => 'Yeovil Town '],
            ['team_id' => 1378, 'league_id' => 39, 'name' => 'Forest Green '],
            ['team_id' => 1379, 'league_id' => 39, 'name' => 'Lincoln '],
            ['team_id' => 1380, 'league_id' => 39, 'name' => 'Macclesfield '],
            ['team_id' => 1381, 'league_id' => 39, 'name' => 'Tranmere '],
            ['team_id' => 1721, 'league_id' => 39, 'name' => 'England W '],
            ['team_id' => 1818, 'league_id' => 39, 'name' => 'Aldershot Town '],
            ['team_id' => 1819, 'league_id' => 39, 'name' => 'Barrow '],
            ['team_id' => 1820, 'league_id' => 39, 'name' => 'Chester '],
            ['team_id' => 1821, 'league_id' => 39, 'name' => 'Dagenham & Redbridge '],
            ['team_id' => 1822, 'league_id' => 39, 'name' => 'Eastleigh '],

            // Aggiungi eventuali altri team mancanti dal file di dati fornito

            // La Liga (Spain) - League ID: 140
            ['team_id' => 9, 'league_id' => 140, 'name' => 'Spain '],
            ['team_id' => 529, 'league_id' => 140, 'name' => 'Barcelona '],
            ['team_id' => 530, 'league_id' => 140, 'name' => 'Atletico Madrid '],
            ['team_id' => 531, 'league_id' => 140, 'name' => 'Athletic Club '],
            ['team_id' => 532, 'league_id' => 140, 'name' => 'Valencia '],
            ['team_id' => 533, 'league_id' => 140, 'name' => 'Villarreal '],
            ['team_id' => 534, 'league_id' => 140, 'name' => 'Las Palmas '],
            ['team_id' => 535, 'league_id' => 140, 'name' => 'Malaga '],
            ['team_id' => 536, 'league_id' => 140, 'name' => 'Sevilla '],
            ['team_id' => 537, 'league_id' => 140, 'name' => 'Leganes '],
            ['team_id' => 538, 'league_id' => 140, 'name' => 'Celta Vigo '],
            ['team_id' => 539, 'league_id' => 140, 'name' => 'Levante '],
            ['team_id' => 540, 'league_id' => 140, 'name' => 'Espanyol '],
            ['team_id' => 541, 'league_id' => 140, 'name' => 'Real Madrid '],
            ['team_id' => 542, 'league_id' => 140, 'name' => 'Alaves '],
            ['team_id' => 543, 'league_id' => 140, 'name' => 'Real Betis '],
            ['team_id' => 544, 'league_id' => 140, 'name' => 'Deportivo La Coruna '],
            ['team_id' => 545, 'league_id' => 140, 'name' => 'Eibar '],
            ['team_id' => 546, 'league_id' => 140, 'name' => 'Getafe '],
            ['team_id' => 547, 'league_id' => 140, 'name' => 'Girona '],
            ['team_id' => 548, 'league_id' => 140, 'name' => 'Real Sociedad '],
            ['team_id' => 593, 'league_id' => 140, 'name' => 'Europa Fc '],
            ['team_id' => 711, 'league_id' => 140, 'name' => 'Alcorcon '],
            ['team_id' => 712, 'league_id' => 140, 'name' => 'Barcelona B '],
            ['team_id' => 713, 'league_id' => 140, 'name' => 'Cordoba '],
            ['team_id' => 714, 'league_id' => 140, 'name' => 'Gimnastic '],
            ['team_id' => 715, 'league_id' => 140, 'name' => 'Granada CF '],
            ['team_id' => 716, 'league_id' => 140, 'name' => 'Lugo '],
            ['team_id' => 717, 'league_id' => 140, 'name' => 'Numancia '],
            ['team_id' => 718, 'league_id' => 140, 'name' => 'Oviedo '],
            ['team_id' => 719, 'league_id' => 140, 'name' => 'Tenerife '],
            ['team_id' => 720, 'league_id' => 140, 'name' => 'Valladolid '],
            ['team_id' => 721, 'league_id' => 140, 'name' => 'Lorca FC '],
            ['team_id' => 722, 'league_id' => 140, 'name' => 'Albacete '],
            ['team_id' => 723, 'league_id' => 140, 'name' => 'Almeria '],
            ['team_id' => 724, 'league_id' => 140, 'name' => 'Cadiz '],
            ['team_id' => 725, 'league_id' => 140, 'name' => 'Cultural Leonesa '],
            ['team_id' => 726, 'league_id' => 140, 'name' => 'Huesca '],
            ['team_id' => 727, 'league_id' => 140, 'name' => 'Osasuna '],
            ['team_id' => 728, 'league_id' => 140, 'name' => 'Rayo Vallecano '],
            ['team_id' => 729, 'league_id' => 140, 'name' => 'Reus '],
            ['team_id' => 730, 'league_id' => 140, 'name' => 'Sevilla Atletico '],
            ['team_id' => 731, 'league_id' => 140, 'name' => 'Sporting Gijon '],
            ['team_id' => 732, 'league_id' => 140, 'name' => 'Zaragoza '],
            ['team_id' => 797, 'league_id' => 140, 'name' => 'Elche '],
            ['team_id' => 798, 'league_id' => 140, 'name' => 'Mallorca '],
            ['team_id' => 799, 'league_id' => 140, 'name' => 'Mirandes '],
            ['team_id' => 800, 'league_id' => 140, 'name' => 'Ucam Murcia '],
            ['team_id' => 860, 'league_id' => 140, 'name' => 'Extremadura '],
            ['team_id' => 861, 'league_id' => 140, 'name' => 'Rayo Majadahonda '],
            ['team_id' => 1736, 'league_id' => 140, 'name' => 'Spain W '],
            ['team_id' => 1904, 'league_id' => 140, 'name' => 'Ud Tacuense W '],
            ['team_id' => 1905, 'league_id' => 140, 'name' => 'Athletic Club W '],
            ['team_id' => 1906, 'league_id' => 140, 'name' => 'Oiartzun Ke W '],
            ['team_id' => 1907, 'league_id' => 140, 'name' => 'Real Betis W '],
            ['team_id' => 1908, 'league_id' => 140, 'name' => 'Santa Teresa W '],
            ['team_id' => 1909, 'league_id' => 140, 'name' => 'Valencia W '],
            ['team_id' => 1910, 'league_id' => 140, 'name' => 'Atletico Madrid W '],
            ['team_id' => 1911, 'league_id' => 140, 'name' => 'Levante W '],
            ['team_id' => 1912, 'league_id' => 140, 'name' => 'Real Sociedad W '],
            ['team_id' => 1913, 'league_id' => 140, 'name' => 'Granad. Tenerife W '],
            ['team_id' => 1914, 'league_id' => 140, 'name' => 'Rayo Vallecano W '],
            ['team_id' => 1915, 'league_id' => 140, 'name' => 'Fundacion Albacete W '],
            ['team_id' => 1916, 'league_id' => 140, 'name' => 'Sporting Huelva W '],
            ['team_id' => 1917, 'league_id' => 140, 'name' => 'Zaragoza W '],
            ['team_id' => 1918, 'league_id' => 140, 'name' => 'Barcelona W '],
            ['team_id' => 1919, 'league_id' => 140, 'name' => 'Espanyol W '],
            ['team_id' => 1920, 'league_id' => 140, 'name' => 'Sevilla W '],
            ['team_id' => 1921, 'league_id' => 140, 'name' => 'Madrid CFF W '],
            ['team_id' => 1922, 'league_id' => 140, 'name' => 'Malaga W '],
            ['team_id' => 1923, 'league_id' => 140, 'name' => 'Edf Logrono W '],
            ['team_id' => 4665, 'league_id' => 140, 'name' => 'Racing Santander '],
            ['team_id' => 4666, 'league_id' => 140, 'name' => 'Hércules '],
            ['team_id' => 4890, 'league_id' => 140, 'name' => 'Santa Eulália '],
            ['team_id' => 4906, 'league_id' => 140, 'name' => 'Fuenlabrada '],
            ['team_id' => 4907, 'league_id' => 140, 'name' => 'Ponferradina '],
            ['team_id' => 5250, 'league_id' => 140, 'name' => 'Badalona '],
            ['team_id' => 5251, 'league_id' => 140, 'name' => 'Barakaldo '],
            ['team_id' => 5252, 'league_id' => 140, 'name' => 'CD Calahorra '],
            ['team_id' => 5253, 'league_id' => 140, 'name' => 'CF Talavera '],
            ['team_id' => 5254, 'league_id' => 140, 'name' => 'Castellón '],
            ['team_id' => 5255, 'league_id' => 140, 'name' => 'Ceuta '],
            ['team_id' => 5256, 'league_id' => 140, 'name' => 'Compostela '],
            ['team_id' => 5257, 'league_id' => 140, 'name' => 'Conquense '],
            ['team_id' => 5258, 'league_id' => 140, 'name' => 'Cornellà '],
            ['team_id' => 5259, 'league_id' => 140, 'name' => 'Don Benito '],
            ['team_id' => 5260, 'league_id' => 140, 'name' => 'Durango '],
            ['team_id' => 5261, 'league_id' => 140, 'name' => 'Ebro '],
            ['team_id' => 5262, 'league_id' => 140, 'name' => 'FC Cartagena '],
            ['team_id' => 5263, 'league_id' => 140, 'name' => 'Gernika '],
            ['team_id' => 5264, 'league_id' => 140, 'name' => 'Gimnástica Torrelavega '],
            ['team_id' => 5265, 'league_id' => 140, 'name' => 'Langreo '],
            ['team_id' => 5266, 'league_id' => 140, 'name' => 'Lleida Esportiu '],
            ['team_id' => 5267, 'league_id' => 140, 'name' => 'Marbella '],
            ['team_id' => 5268, 'league_id' => 140, 'name' => 'Melilla '],
            ['team_id' => 5269, 'league_id' => 140, 'name' => 'Mensajero '],
            ['team_id' => 5270, 'league_id' => 140, 'name' => 'Mutilvera '],
            ['team_id' => 5271, 'league_id' => 140, 'name' => 'Navalcarnero '],
            ['team_id' => 5272, 'league_id' => 140, 'name' => 'Ontinyent '],
            ['team_id' => 5273, 'league_id' => 140, 'name' => 'Poblense '],
            // Aggiungi tutte le altre squadre della La Liga qui...

            // Bundesliga (Germany) - League ID: 78
            ['team_id' => 25, 'league_id' => 78, 'name' => 'Germany '],
            ['team_id' => 157, 'league_id' => 78, 'name' => 'Bayern München '],
            ['team_id' => 158, 'league_id' => 78, 'name' => 'Fortuna Düsseldorf '],
            ['team_id' => 159, 'league_id' => 78, 'name' => 'Hertha BSC '],
            ['team_id' => 160, 'league_id' => 78, 'name' => 'SC Freiburg '],
            ['team_id' => 161, 'league_id' => 78, 'name' => 'VfL Wolfsburg '],
            ['team_id' => 162, 'league_id' => 78, 'name' => 'Werder Bremen '],
            ['team_id' => 163, 'league_id' => 78, 'name' => 'Borussia Mönchengladbach '],
            ['team_id' => 164, 'league_id' => 78, 'name' => 'FSV Mainz 05 '],
            ['team_id' => 165, 'league_id' => 78, 'name' => 'Borussia Dortmund '],
            ['team_id' => 166, 'league_id' => 78, 'name' => 'Hannover 96 '],
            ['team_id' => 167, 'league_id' => 78, 'name' => '1899 Hoffenheim '],
            ['team_id' => 168, 'league_id' => 78, 'name' => 'Bayer Leverkusen '],
            ['team_id' => 169, 'league_id' => 78, 'name' => 'Eintracht Frankfurt '],
            ['team_id' => 170, 'league_id' => 78, 'name' => 'FC Augsburg '],
            ['team_id' => 171, 'league_id' => 78, 'name' => '1. FC Nürnberg '],
            ['team_id' => 172, 'league_id' => 78, 'name' => 'VfB Stuttgart '],
            ['team_id' => 173, 'league_id' => 78, 'name' => 'RB Leipzig '],
            ['team_id' => 174, 'league_id' => 78, 'name' => 'FC Schalke 04 '],
            ['team_id' => 175, 'league_id' => 78, 'name' => 'Hamburger SV '],
            ['team_id' => 176, 'league_id' => 78, 'name' => 'VfL Bochum '],
            ['team_id' => 177, 'league_id' => 78, 'name' => 'SSV Jahn Regensburg '],
            ['team_id' => 178, 'league_id' => 78, 'name' => 'SpVgg Greuther Fürth '],
            ['team_id' => 179, 'league_id' => 78, 'name' => '1. FC Magdeburg '],
            ['team_id' => 180, 'league_id' => 78, 'name' => '1. FC Heidenheim '],
            ['team_id' => 181, 'league_id' => 78, 'name' => 'SV Darmstadt 98 '],
            ['team_id' => 182, 'league_id' => 78, 'name' => 'Union Berlin '],
            ['team_id' => 183, 'league_id' => 78, 'name' => 'Dynamo Dresden '],
            ['team_id' => 184, 'league_id' => 78, 'name' => 'FC Ingolstadt 04 '],
            ['team_id' => 185, 'league_id' => 78, 'name' => 'SC Paderborn 07 '],
            ['team_id' => 186, 'league_id' => 78, 'name' => 'FC St. Pauli '],
            ['team_id' => 187, 'league_id' => 78, 'name' => 'MSV Duisburg '],
            ['team_id' => 188, 'league_id' => 78, 'name' => 'Arminia Bielefeld '],
            ['team_id' => 189, 'league_id' => 78, 'name' => 'SV Sandhausen '],
            ['team_id' => 190, 'league_id' => 78, 'name' => 'Erzgebirge Aue '],
            ['team_id' => 191, 'league_id' => 78, 'name' => 'Holstein Kiel '],
            ['team_id' => 192, 'league_id' => 78, 'name' => '1.FC Köln '],
            ['team_id' => 744, 'league_id' => 78, 'name' => 'Eintracht Braunschweig '],
            ['team_id' => 745, 'league_id' => 78, 'name' => '1. FC Kaiserslautern '],
            ['team_id' => 784, 'league_id' => 78, 'name' => 'Würzburger Kickers '],
            ['team_id' => 785, 'league_id' => 78, 'name' => 'Karlsruher SC '],
            ['team_id' => 786, 'league_id' => 78, 'name' => 'TSV 1860 München '],
            ['team_id' => 1313, 'league_id' => 78, 'name' => 'Preußen Münster '],
            ['team_id' => 1314, 'league_id' => 78, 'name' => 'SpVgg Unterhaching '],
            ['team_id' => 1315, 'league_id' => 78, 'name' => 'FSV Zwickau '],
            ['team_id' => 1316, 'league_id' => 78, 'name' => 'Hallescher FC '],
            ['team_id' => 1317, 'league_id' => 78, 'name' => 'SG Sonnenhof Grossaspach '],
            ['team_id' => 1318, 'league_id' => 78, 'name' => 'SV Meppen '],
            ['team_id' => 1319, 'league_id' => 78, 'name' => 'SV Wehen '],
            ['team_id' => 1320, 'league_id' => 78, 'name' => 'Energie Cottbus '],
            ['team_id' => 1321, 'league_id' => 78, 'name' => 'Hansa Rostock '],
            ['team_id' => 1322, 'league_id' => 78, 'name' => 'KFC Uerdingen 05 '],
            ['team_id' => 1323, 'league_id' => 78, 'name' => 'Sportfreunde Lotte '],
            ['team_id' => 1324, 'league_id' => 78, 'name' => 'VfL Osnabrück '],
            ['team_id' => 1325, 'league_id' => 78, 'name' => 'FC Carl Zeiss Jena '],
            ['team_id' => 1326, 'league_id' => 78, 'name' => 'Fortuna Köln '],
            ['team_id' => 1327, 'league_id' => 78, 'name' => 'VfR Aalen '],
            ['team_id' => 1328, 'league_id' => 78, 'name' => 'Chemnitzer FC '],
            ['team_id' => 1329, 'league_id' => 78, 'name' => 'FC Rot-Weiß Erfurt '],
            ['team_id' => 1330, 'league_id' => 78, 'name' => 'Werder Bremen II '],
            ['team_id' => 1331, 'league_id' => 78, 'name' => 'FSV Mainz 05 II '],
            ['team_id' => 1332, 'league_id' => 78, 'name' => 'FSV Frankfurt '],
            ['team_id' => 1618, 'league_id' => 78, 'name' => 'BFC Preussen '],
            ['team_id' => 1619, 'league_id' => 78, 'name' => 'FC 08 Villingen '],
            ['team_id' => 1620, 'league_id' => 78, 'name' => 'FC Viktoria Köln '],
            ['team_id' => 1621, 'league_id' => 78, 'name' => 'Rot-Weiß Essen '],
            ['team_id' => 1622, 'league_id' => 78, 'name' => 'SV Babelsberg 03 '],
            ['team_id' => 1623, 'league_id' => 78, 'name' => 'SV Drochtersen/Assel '],
            ['team_id' => 1624, 'league_id' => 78, 'name' => 'FV Ravensburg '],
            ['team_id' => 1625, 'league_id' => 78, 'name' => 'VfB Lübeck '],
            ['team_id' => 1626, 'league_id' => 78, 'name' => 'FC Astoria Walldorf '],
            ['team_id' => 1627, 'league_id' => 78, 'name' => 'Eintracht Trier '],
            ['team_id' => 1628, 'league_id' => 78, 'name' => 'Kickers Offenbach '],
            ['team_id' => 1629, 'league_id' => 78, 'name' => 'SG Wattenscheid 09 '],
            ['team_id' => 1630, 'league_id' => 78, 'name' => 'Bremer SV '],
            ['team_id' => 1631, 'league_id' => 78, 'name' => 'Eintracht Norderstedt '],
            ['team_id' => 1632, 'league_id' => 78, 'name' => 'Germania Egestorf '],
            ['team_id' => 1633, 'league_id' => 78, 'name' => 'SC Hauenstein '],
            ['team_id' => 1634, 'league_id' => 78, 'name' => 'FC 08 Homburg '],
            ['team_id' => 1635, 'league_id' => 78, 'name' => 'FC Schweinfurt 05 '],
            ['team_id' => 1636, 'league_id' => 78, 'name' => 'BFC Dynamo '],
            ['team_id' => 1637, 'league_id' => 78, 'name' => 'Bonner SC '],
            ['team_id' => 1638, 'league_id' => 78, 'name' => 'FC Nöttingen '],
            ['team_id' => 1639, 'league_id' => 78, 'name' => 'FC Saarbrücken '],
            ['team_id' => 1640, 'league_id' => 78, 'name' => 'Sportfreunde Dorfmerkingen '],
            ['team_id' => 1641, 'league_id' => 78, 'name' => 'SV Morlautern '],
            ['team_id' => 1642, 'league_id' => 78, 'name' => 'FC Rielasingen-Arlen '],
            ['team_id' => 1643, 'league_id' => 78, 'name' => 'Germania Halberstadt '],
            ['team_id' => 1644, 'league_id' => 78, 'name' => 'Leher TS '],
            ['team_id' => 1645, 'league_id' => 78, 'name' => 'Lüneburger SK Hansa '],
            ['team_id' => 1646, 'league_id' => 78, 'name' => 'SV Eichede '],
            ['team_id' => 1647, 'league_id' => 78, 'name' => 'TuS Erndtebrück '],
            ['team_id' => 1648, 'league_id' => 78, 'name' => 'TuS Koblenz '],
            ['team_id' => 1649, 'league_id' => 78, 'name' => 'Weiche Flensburg '],
            ['team_id' => 1650, 'league_id' => 78, 'name' => 'SV Rodinghausen '],
            ['team_id' => 1651, 'league_id' => 78, 'name' => 'BSG Chemie Leipzig '],
            ['team_id' => 1652, 'league_id' => 78, 'name' => 'SSV Ulm 1846 '],
            ['team_id' => 1653, 'league_id' => 78, 'name' => 'BSC Hastedt '],
            ['team_id' => 1654, 'league_id' => 78, 'name' => 'FC Lok Stendal '],
            ['team_id' => 1655, 'league_id' => 78, 'name' => 'SSV Jeddeloh '],
            // Aggiungi tutte le altre squadre della Bundesliga qui...

            // Ligue 1 (France) - League ID: 61
            ['team_id' => 2, 'league_id' => 61, 'name' => 'France '],
            ['team_id' => 77, 'league_id' => 61, 'name' => 'Angers '],
            ['team_id' => 78, 'league_id' => 61, 'name' => 'Bordeaux '],
            ['team_id' => 79, 'league_id' => 61, 'name' => 'Lille '],
            ['team_id' => 80, 'league_id' => 61, 'name' => 'Lyon '],
            ['team_id' => 81, 'league_id' => 61, 'name' => 'Marseille '],
            ['team_id' => 82, 'league_id' => 61, 'name' => 'Montpellier '],
            ['team_id' => 83, 'league_id' => 61, 'name' => 'Nantes '],
            ['team_id' => 84, 'league_id' => 61, 'name' => 'Nice '],
            ['team_id' => 85, 'league_id' => 61, 'name' => 'Paris Saint Germain '],
            ['team_id' => 87, 'league_id' => 61, 'name' => 'Amiens '],
            ['team_id' => 88, 'league_id' => 61, 'name' => 'Caen '],
            ['team_id' => 89, 'league_id' => 61, 'name' => 'Dijon '],
            ['team_id' => 90, 'league_id' => 61, 'name' => 'Guingamp '],
            ['team_id' => 91, 'league_id' => 61, 'name' => 'Monaco '],
            ['team_id' => 92, 'league_id' => 61, 'name' => 'Nimes '],
            ['team_id' => 93, 'league_id' => 61, 'name' => 'Reims '],
            ['team_id' => 94, 'league_id' => 61, 'name' => 'Rennes '],
            ['team_id' => 95, 'league_id' => 61, 'name' => 'Strasbourg '],
            ['team_id' => 96, 'league_id' => 61, 'name' => 'Toulouse '],
            ['team_id' => 97, 'league_id' => 61, 'name' => 'Lorient '],
            ['team_id' => 98, 'league_id' => 61, 'name' => 'Ajaccio '],
            ['team_id' => 99, 'league_id' => 61, 'name' => 'Clermont Foot '],
            ['team_id' => 100, 'league_id' => 61, 'name' => 'Gazelec FC Ajaccio '],
            ['team_id' => 101, 'league_id' => 61, 'name' => 'Grenoble '],
            ['team_id' => 102, 'league_id' => 61, 'name' => 'Nancy '],
            ['team_id' => 103, 'league_id' => 61, 'name' => 'Orleans '],
            ['team_id' => 104, 'league_id' => 61, 'name' => 'RED Star FC 93 '],
            ['team_id' => 105, 'league_id' => 61, 'name' => 'Valenciennes '],
            ['team_id' => 106, 'league_id' => 61, 'name' => 'Stade Brestois 29 '],
            ['team_id' => 107, 'league_id' => 61, 'name' => 'Chateauroux '],
            ['team_id' => 108, 'league_id' => 61, 'name' => 'Auxerre '],
            ['team_id' => 109, 'league_id' => 61, 'name' => 'Beziers '],
            ['team_id' => 110, 'league_id' => 61, 'name' => 'Estac Troyes '],
            ['team_id' => 111, 'league_id' => 61, 'name' => 'LE Havre '],
            ['team_id' => 112, 'league_id' => 61, 'name' => 'Metz '],
            ['team_id' => 113, 'league_id' => 61, 'name' => 'Niort '],
            ['team_id' => 114, 'league_id' => 61, 'name' => 'Paris FC '],
            ['team_id' => 115, 'league_id' => 61, 'name' => 'Sochaux '],
            ['team_id' => 116, 'league_id' => 61, 'name' => 'Lens '],
            ['team_id' => 430, 'league_id' => 61, 'name' => 'Bourg-en-bresse 01 '],
            ['team_id' => 431, 'league_id' => 61, 'name' => 'Quevilly '],
            ['team_id' => 432, 'league_id' => 61, 'name' => 'Tours '],
            ['team_id' => 433, 'league_id' => 61, 'name' => 'Laval '],
            ['team_id' => 1063, 'league_id' => 61, 'name' => 'Saint Etienne '],
            ['team_id' => 1291, 'league_id' => 61, 'name' => 'Chambly Thelle FC '],
            ['team_id' => 1292, 'league_id' => 61, 'name' => 'Cholet '],
            ['team_id' => 1293, 'league_id' => 61, 'name' => 'Drancy '],
            ['team_id' => 1294, 'league_id' => 61, 'name' => 'Entente S St Gratien '],
            ['team_id' => 1295, 'league_id' => 61, 'name' => 'Lyon Duchere '],
            ['team_id' => 1296, 'league_id' => 61, 'name' => 'Marignane '],
            ['team_id' => 1297, 'league_id' => 61, 'name' => 'PAU '],
            ['team_id' => 1298, 'league_id' => 61, 'name' => 'Le Mans '],
            ['team_id' => 1299, 'league_id' => 61, 'name' => 'Boulogne '],
            ['team_id' => 1300, 'league_id' => 61, 'name' => 'Concarneau '],
            ['team_id' => 1301, 'league_id' => 61, 'name' => 'Rodez '],
            ['team_id' => 1302, 'league_id' => 61, 'name' => 'Villefranche '],
            ['team_id' => 1303, 'league_id' => 61, 'name' => 'Avranches '],
            ['team_id' => 1304, 'league_id' => 61, 'name' => 'Dunkerque '],
            ['team_id' => 1305, 'league_id' => 61, 'name' => 'Bastia '],
            ['team_id' => 1306, 'league_id' => 61, 'name' => 'Athletico Marseille '],
            ['team_id' => 1307, 'league_id' => 61, 'name' => 'Creteil '],
            ['team_id' => 1308, 'league_id' => 61, 'name' => 'Les Herbiers '],
            ['team_id' => 1309, 'league_id' => 61, 'name' => 'Epinal '],
            ['team_id' => 1310, 'league_id' => 61, 'name' => 'Sedan '],
            ['team_id' => 1311, 'league_id' => 61, 'name' => 'Belfort '],
            ['team_id' => 1312, 'league_id' => 61, 'name' => 'CA Bastia '],
            ['team_id' => 1664, 'league_id' => 61, 'name' => 'Metz W '],
            ['team_id' => 1665, 'league_id' => 61, 'name' => 'AS Saint-Etienne W '],
            ['team_id' => 1666, 'league_id' => 61, 'name' => 'Juvisy Sur Orge W '],
            ['team_id' => 1667, 'league_id' => 61, 'name' => 'Paris Saint Germain W '],
            ['team_id' => 1668, 'league_id' => 61, 'name' => 'Rodez W '],
            ['team_id' => 1669, 'league_id' => 61, 'name' => 'Soyaux W '],
            ['team_id' => 1670, 'league_id' => 61, 'name' => 'Asptt Albi W '],
            ['team_id' => 1671, 'league_id' => 61, 'name' => 'Bordeaux W '],
            ['team_id' => 1672, 'league_id' => 61, 'name' => 'Guingamp W '],
            ['team_id' => 1673, 'league_id' => 61, 'name' => 'Marseille W '],
            ['team_id' => 1674, 'league_id' => 61, 'name' => 'Lyon W '],
            ['team_id' => 1675, 'league_id' => 61, 'name' => 'Montpellier W '],
            ['team_id' => 1676, 'league_id' => 61, 'name' => 'Paris FC W '],
            ['team_id' => 1677, 'league_id' => 61, 'name' => 'FC Fleury 91 W '],
            ['team_id' => 1678, 'league_id' => 61, 'name' => 'Lille W '],
            ['team_id' => 1679, 'league_id' => 61, 'name' => 'Dijon W '],
            ['team_id' => 1725, 'league_id' => 61, 'name' => 'France W '],
            ['team_id' => 3006, 'league_id' => 61, 'name' => 'Evian TG '],
            ['team_id' => 3007, 'league_id' => 61, 'name' => 'AG Caennaise '],
            ['team_id' => 3009, 'league_id' => 61, 'name' => 'Andrézieux '],
            ['team_id' => 3010, 'league_id' => 61, 'name' => 'Anglet Genets '],
            ['team_id' => 3011, 'league_id' => 61, 'name' => 'Angoulême '],
            ['team_id' => 3012, 'league_id' => 61, 'name' => 'Annecy '],
            ['team_id' => 3013, 'league_id' => 61, 'name' => 'Annecy-le-Vieux '],
            ['team_id' => 3014, 'league_id' => 61, 'name' => 'Auch '],
            ['team_id' => 3015, 'league_id' => 61, 'name' => 'Aurillac Arpajon '],
            ['team_id' => 3016, 'league_id' => 61, 'name' => 'Avenir Foot Lozère '],
            ['team_id' => 3017, 'league_id' => 61, 'name' => 'Avion '],
            ['team_id' => 3018, 'league_id' => 61, 'name' => 'Avize-Grauves '],
            ['team_id' => 3019, 'league_id' => 61, 'name' => 'Bastia-Borgo '],
            ['team_id' => 3020, 'league_id' => 61, 'name' => 'Beaune '],
            ['team_id' => 3021, 'league_id' => 61, 'name' => 'Bellevue Nantes '],
            ['team_id' => 3022, 'league_id' => 61, 'name' => 'Bergerac '],
            // Aggiungi tutte le altre squadre della Ligue 1 qui...
        ];

        foreach ($teams as $team) {
            Team::updateOrCreate(
                ['team_id' => $team['team_id']],
                ['league_id' => $team['league_id'], 'name' => $team['name']]
            );
        }
    }
}
