<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Forms\IEditRightsFormFactory;
use App\Model\Role;
use Nette\ComponentModel\IComponent;

class RightsPresenter extends BaseAppPresenter {

    public Role $editRole;

    /** @inject */
    public IEditRightsFormFactory $editRightsFormFactory;

    public function beforeRender()
    {
        parent::beforeRender();
        $this->getTemplate()->roles = $this->orm->roles->findAll();
    }


    public function actionDefault(): void
    {

    }

    public function renderDefault(): void
    {

    }

    public function actionEdit(int $id): void
    {
        /** @var Role|null $role */
        $role = $this->orm->roles->getById($id);
        if ($role == null) {
            $this->flashMessage($this->translator->translate("common.roleNotFound"));
            $this->redirect("default");
        }
        $this->editRole = $role;
    }

    public function renderEdit(): void
    {
        $this->getTemplate()->editRole = $this->editRole;
    }

    public function createComponentEditRightsForm(string $name): ?IComponent
    {
        return $this->editRightsFormFactory->create($this->editRole);
    }

}