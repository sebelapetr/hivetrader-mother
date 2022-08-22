<?php
/**
 * Created by PhpStorm.
 * User: Petr Šebela
 * Date: 21. 9. 2020
 * Time: 23:48
 */

declare(strict_types=1);

namespace App\AdminModule\Components;

use App\Model\Utils\StringUtils;
use Tracy\Debugger;

interface IMenuComponentFactory
{
	function create(): MenuComponent;
}

class MenuComponent extends BaseComponent {

	public function render(): void
	{
        $dashboard = [
            [
                'presenter' => 'Dashboard',
                'presenterClean' => StringUtils::clean('Dashboard'),
                'icon' => 'fa-solid fa-gauge',
            ]
        ];

        $mother = [
            [
                'presenter' => 'StockChanges',
                'presenterClean' => StringUtils::clean('StockChanges'),
                'icon' => 'fas fa-chart-bar',
            ]
        ];

        $stock = [
            [
                'presenter' => 'StockItems',
                'presenterClean' => StringUtils::clean('StockItems'),
                'icon' => 'fas fa-warehouse',
            ],
            [
                'presenter' => 'StockItemMovements',
                'presenterClean' => StringUtils::clean('StockItemMovements'),
                'icon' => 'fas fa-exchange-alt',
            ]
        ];

        $market = [
            [
                'presenter' => 'Orders',
                'presenterClean' => StringUtils::clean('Orders'),
                'icon' => 'fas fa-shopping-cart'
            ]
        ];

        $settings = [
            [
                'presenter' => 'Users',
                'presenterClean' => StringUtils::clean('Users'),
                'icon' => 'fas fa-users',
                'children' => [
                    [
                        'presenter' => 'Users',
                        'presenterClean' => StringUtils::clean('Users'),
                        'icon' => 'fas fa-users',
                    ],
                    [
                        'presenter' => 'Rights',
                        'presenterClean' => StringUtils::clean('Rights'),
                        'icon' => 'fas fa-ban',
                    ],
                ],
            ]
        ];

        $menu = [
            "dashboard" => $dashboard,
            "market" => $market,
            "stock" => $stock,
            "mother" => $mother,
            "settings" => $settings
        ];

		$this->getTemplate()->menuItems = $menu;
		$this->setTemplateFile();
		$this->getTemplate()->render();
	}

    /**
     * @param array<mixed> $itemData
     */
    public function getLinksRecursiveString(array $itemData): string
    {
        $links = $this->getLinksRecursive($itemData);
        return implode('|', $links);
    }

    /**
     * @param array $itemData
     * @param array<int, string> $links
     * @return array<string>
     */
    protected function getLinksRecursive(array $itemData, array $links = []): array /** @phpstan-ignore-line */
    {
        $links[] = $itemData['presenter'] . ':*';
        if(isset($itemData['children'])){
            foreach($itemData['children'] as $childData){
                $links = $this->getLinksRecursive($childData, $links);
            }
        }
        return $links;
    }

}