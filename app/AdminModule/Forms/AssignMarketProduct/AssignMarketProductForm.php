<?php
declare(strict_types=1);

namespace App\AdminModule\Forms;

use App\AdminModule\Components\BaseComponent;
use App\Model\Enum\FlashMessages;
use App\Model\MarketProduct;
use App\Model\Orm;
use App\Model\Product;
use App\Model\Role;
use App\Model\User;
use Contributte\Translation\Translator;
use Nette;

class AssignMarketProductForm extends BaseComponent
{
    public Product $product;

    public function __construct(Orm $orm, Product $product, Translator $translator)
    {
        $this->product = $product;
        parent::__construct($orm, $translator);
    }

    public function render(): void
    {
        $this->getTemplate()->setFile(__DIR__ . '/AssignMarketProductForm.latte');
        $this->getTemplate()->product = $this->product;
        $this->getTemplate()->render();
    }

    protected function createComponentForm(): Nette\Application\UI\Form
    {
        $form = new Nette\Application\UI\Form();

        $excludedMarketIds = [];
        foreach ($this->product->stockItem->marketProducts as $marketProduct) {
            $excludedMarketIds[] = $marketProduct->market->id;
        }

        $form->addSelect('market', $this->translator->translate($this->langDomain.'.market'), $this->orm->markets->findBy(["id!=" => $excludedMarketIds])->fetchPairs("id", "name")) //todo only not assigned
            ->setHtmlAttribute('class', 'form-control')
            ->setRequired();

        $form->addText('name', $this->translator->translate($this->langDomain.'.name'))
            ->setHtmlAttribute('class', 'form-control')
            ->setDefaultValue($this->product->name)
            ->setRequired();

        $form->addText('priceWithVat', $this->translator->translate($this->langDomain.'.priceWithVat'))
            ->setHtmlAttribute('class', 'form-control')
            ->setDefaultValue(round(floatval($this->product->priceWithVatMax), 2))
            ->setRequired();

        $form->addText('number', $this->translator->translate($this->langDomain.'.number'))
            ->setHtmlAttribute('class', 'form-control')
            ->setRequired();

        $form->addSubmit('send', $this->translator->translate($this->langDomain.'.assign'))
            ->setHtmlAttribute('class', 'btn btn-success btn-sm');

        $form->onSuccess[] = [$this, 'onSuccess'];

        return $form;
    }

    public function onSuccess(Nette\Application\UI\Form $form): void
    {
        $values = $form->getValues();

        if ($this->product->stockItem === null) {
            $form->addError("Product has not stock item.");
            return;
        }

        $marketProduct = new MarketProduct();
        $marketProduct->market = $this->orm->markets->getById($values->market);
        $marketProduct->stockItem = $this->product->stockItem;
        $marketProduct->priceWithVat = $values->priceWithVat;
        $marketProduct->vat = 21;
        $marketProduct->priceWithoutVat = round( $marketProduct->priceWithVat / ((100 + $marketProduct->vat) / 100), 2);
        $marketProduct->name = $values->name;
        $marketProduct->number = $values->number;
        $marketProduct->createdAt = new \DateTimeImmutable();
        $marketProduct->updatedAt = new \DateTimeImmutable();
        $marketProduct->active = true;
        $marketProduct->deleted = false;

        $this->orm->persistAndFlush($marketProduct);

        $this->getPresenter()->flashMessage($this->langDomain.'.productAssigned', FlashMessages::SUCCESS);

        $this->getPresenter()->redirect('this');
    }
}