<?php
/**
 * Created by PhpStorm.
 * User: Petr Šebela
 * Date: 21. 9. 2020
 * Time: 23:32
 */

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\Model\Role;
use App\Model\SupplierProduct;
use Nextras\Orm\Collection\ICollection;

class StockChangesPresenter extends BaseAppPresenter
{
    public SupplierProduct $supplierProduct;

    public function actionDetail(int $id): void
    {
        $supplierProduct = $this->orm->supplierProducts->getById($id);
        if ($supplierProduct == null) {
            throw new \Exception("Supplier product with id " . $id . " not found");
        }
        $this->supplierProduct = $supplierProduct;
    }

    public function renderDetail(): void
    {
        $this->getTemplate()->supplierProduct = $this->supplierProduct;
        $this->getTemplate()->stockChangesData = $this->getStockChangesChartData($this->supplierProduct->id);
    }

    private function getStockChangesChartData(int $id): array
    {
        $stockChangesData = [];
        $stockChanges = $this->orm->supplierProducts->getStockChanges($id);
        foreach ($stockChanges as $stockChange) {
            /** @var \DateTimeImmutable $createdAt */
            $createdAt = $stockChange->created_at;
            $stockChangesData[$createdAt->format('d.m.Y H:i:s')] = $stockChange->actual_quantity;
        }
        return $stockChangesData;
    }
}