<?php
declare(strict_types=1);

namespace Real\Validator\Gtin\Specification;

use Real\Validator\Gtin;

/**
 * @link http://www.gs1.org/barcodes/support/prefix_list
 */
final class Prefix implements Gtin\Specification
{
    private const GS1_MEMBER_ORGANIZATION_PREFIXES = [
        # @formatter:off
        ['300', '379'],     # GS1 France
        ['380', '380'],     # GS1 Bulgaria
        ['383', '383'],     # GS1 Slovenija
        ['385', '385'],     # GS1 Croatia
        ['387', '387'],     # GS1 Bosnia-Herzegovina
        ['389', '389'],     # GS1 Montenegro
        ['400', '440'],     # GS1 Germany
        ['450', '459'],     # GS1 Japan
        ['460', '469'],     # GS1 Russia
        ['470', '470'],     # GS1 Kyrgyzstan
        ['471', '471'],     # GS1 Chinese Taipei
        ['474', '474'],     # GS1 Estonia
        ['475', '475'],     # GS1 Latvia
        ['476', '476'],     # GS1 Azerbaijan
        ['477', '477'],     # GS1 Lithuania
        ['478', '478'],     # GS1 Uzbekistan
        ['479', '479'],     # GS1 Sri Lanka
        ['480', '480'],     # GS1 Philippines
        ['481', '481'],     # GS1 Belarus
        ['482', '482'],     # GS1 Ukraine
        ['483', '483'],     # GS1 Turkmenistan
        ['484', '484'],     # GS1 Moldova
        ['485', '485'],     # GS1 Armenia
        ['486', '486'],     # GS1 Georgia
        ['487', '487'],     # GS1 Kazakstan
        ['488', '488'],     # GS1 Tajikistan
        ['489', '489'],     # GS1 Hong Kong, China
        ['490', '499'],     # GS1 Japan
        ['500', '509'],     # GS1 UK
        ['520', '521'],     # GS1 Association Greece
        ['528', '528'],     # GS1 Lebanon
        ['529', '529'],     # GS1 Cyprus
        ['530', '530'],     # GS1 Albania
        ['531', '531'],     # GS1 Macedonia
        ['535', '535'],     # GS1 Malta
        ['539', '539'],     # GS1 Ireland
        ['540', '549'],     # GS1 Belgium & Luxembourg
        ['560', '560'],     # GS1 Portugal
        ['569', '569'],     # GS1 Iceland
        ['570', '579'],     # GS1 Denmark
        ['590', '590'],     # GS1 Poland
        ['594', '594'],     # GS1 Romania
        ['599', '599'],     # GS1 Hungary
        ['600', '601'],     # GS1 South Africa
        ['603', '603'],     # GS1 Ghana
        ['604', '604'],     # GS1 Senegal
        ['608', '608'],     # GS1 Bahrain
        ['609', '609'],     # GS1 Mauritius
        ['611', '611'],     # GS1 Morocco
        ['613', '613'],     # GS1 Algeria
        ['615', '615'],     # GS1 Nigeria
        ['616', '616'],     # GS1 Kenya
        ['618', '618'],     # GS1 Ivory Coast
        ['619', '619'],     # GS1 Tunisia
        ['620', '620'],     # GS1 Tanzania
        ['621', '621'],     # GS1 Syria
        ['622', '622'],     # GS1 Egypt
        ['623', '623'],     # GS1 Brunei
        ['624', '624'],     # GS1 Libya
        ['625', '625'],     # GS1 Jordan
        ['626', '626'],     # GS1 Iran
        ['627', '627'],     # GS1 Kuwait
        ['628', '628'],     # GS1 Saudi Arabia
        ['629', '629'],     # GS1 Emirates
        ['640', '649'],     # GS1 Finland
        ['690', '699'],     # GS1 China
        ['700', '709'],     # GS1 Norway
        ['729', '729'],     # GS1 Israel
        ['730', '739'],     # GS1 Sweden
        ['740', '740'],     # GS1 Guatemala
        ['741', '741'],     # GS1 El Salvador
        ['742', '742'],     # GS1 Honduras
        ['743', '743'],     # GS1 Nicaragua
        ['744', '744'],     # GS1 Costa Rica
        ['745', '745'],     # GS1 Panama
        ['746', '746'],     # GS1 Republica Dominicana
        ['750', '750'],     # GS1 Mexico
        ['754', '755'],     # GS1 Canada
        ['759', '759'],     # GS1 Venezuela
        ['760', '769'],     # GS1 Schweiz, Suisse, Svizzera
        ['770', '771'],     # GS1 Colombia
        ['773', '773'],     # GS1 Uruguay
        ['775', '775'],     # GS1 Peru
        ['777', '777'],     # GS1 Bolivia
        ['778', '779'],     # GS1 Argentina
        ['780', '780'],     # GS1 Chile
        ['784', '784'],     # GS1 Paraguay
        ['786', '786'],     # GS1 Ecuador
        ['789', '790'],     # GS1 Brasil  
        ['800', '839'],     # GS1 Italy  
        ['840', '849'],     # GS1 Spain  
        ['850', '850'],     # GS1 Cuba
        ['858', '858'],     # GS1 Slovakia
        ['859', '859'],     # GS1 Czech
        ['860', '860'],     # GS1 Serbia
        ['865', '865'],     # GS1 Mongolia
        ['867', '867'],     # GS1 North Korea
        ['868', '869'],     # GS1 Turkey
        ['870', '879'],     # GS1 Netherlands
        ['880', '880'],     # GS1 South Korea
        ['884', '884'],     # GS1 Cambodia
        ['885', '885'],     # GS1 Thailand
        ['888', '888'],     # GS1 Singapore
        ['890', '890'],     # GS1 India
        ['893', '893'],     # GS1 Vietnam
        ['896', '896'],     # GS1 Pakistan
        ['899', '899'],     # GS1 Indonesia
        ['900', '919'],     # GS1 Austria
        ['930', '939'],     # GS1 Australia
        ['940', '949'],     # GS1 New Zealand
        ['950', '951'],     # GS1 Global Office
        ['955', '955'],     # GS1 Malaysia
        ['958', '958'],     # GS1 Macau, China
        # @formatter:on
    ];

    private const GS1_PREFIXES = [
        # @formatter:off
        ['000', '019'],     # GS1 US
#       ['020', '029'],     # Restricted distribution  
        ['030', '039'],     # GS1 US
#       ['040', '049'],     # Restricted distribution
#       ['050', '059'],     # Coupons
        ['060', '139'],     # GS1 US
#       ['140', '199'],     # Reserved for future use
#       ['200', '299'],     # Restricted distribution
#       ['952', '954'],     # Reserved for future use
#       ['956', '957'],     # Reserved for future use
#       ['959', '959'],     # Reserved for future use
#       ['960', '969'],     # Never used for GTIN-12, -13, or -14, but are used for GTIN-8s
#       ['970', '976'],     # Reserved for future use
        ['977', '977'],     # Valid prefix for ISSN
        ['978', '979'],     # Valid prefix for ISBN
#       ['980', '999'],     # Coupons and other special uses
        # @formatter:on
    ];

    private const GS1_8_PREFIXES = [
        # @formatter:off
#       ['000', '099'],     # Restricted distribution
        ['100', '139'],     # GS1 US
#       ['140', '199'],     # Reserved for future use
#       ['200', '299'],     # Restricted distribution
#       ['952', '954'],     # Reserved for future use
#       ['956', '957'],     # Reserved for future use
#       ['959', '959'],     # Reserved for future use
        ['960', '969'],     # Never used for GTIN-12, -13, or -14, but are used for GTIN-8s
#       ['970', '999'],     # Reserved for future use
        # @formatter:on
    ];

    private $customPrefixes = [];

    /**
     * @param array $customPrefixes
     */
    public function __construct(array $customPrefixes = [])
    {
        $this->customPrefixes = $this->normalizePrefixes($customPrefixes);
    }

    /**
     * @inheritdoc
     */
    public function isSatisfied(Gtin $gtin): bool
    {
        $prefix = $gtin->prefix();

        foreach ($this->listRanges($gtin) as [$lower, $upper]) {
            if ($lower <= $prefix && $prefix <= $upper) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function reasonCode(): int
    {
        return Gtin\NonNormalizable::CODE_PREFIX;
    }

    public function listRanges(Gtin $gtin): array
    {
        if ($gtin->length() === 8) {
            $list = self::GS1_8_PREFIXES;
        } else {
            $list = self::GS1_PREFIXES;
        }

        return array_merge($list, self::GS1_MEMBER_ORGANIZATION_PREFIXES, $this->customPrefixes);
    }

    /**
     * @param array $prefixes
     *
     * @return array
     */
    private function normalizePrefixes(array $prefixes): array
    {
        $prefixRanges = [];

        foreach ($prefixes as $prefix) {
            if (is_array($prefix)) {
                $prefixRanges[] = $prefix;
            } else {
                $prefixRanges[] = [$prefix, $prefix];
            }
        }

        return $prefixRanges;
    }
}
