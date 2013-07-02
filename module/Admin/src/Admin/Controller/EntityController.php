<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Admin\Controller;


use Admin\Entities\Entity;
use Admin\Service\EntityService;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\ClassMethods;

class EntityController extends AbstractActionController
{

    /**
     * @var EntityService
     */
    protected $entityService;

    /**
     * @return array
     */
    public function indexAction()
    {
        $entityName = $this->params()->fromRoute('entity');
        $entity = $this->getEntityService()->getEntity($entityName);

        $list = $entity->getService()->getList();
        $list->setCurrentPageNumber($this->params()->fromQuery('page'));

        $hydrator = new ClassMethods();
        $table = array();
        $head = $entity->getOptions()->getFields();

        foreach ($list as $entityModel) {
            $row = array_combine($head, array_fill(1, count($head), null));

            foreach ($hydrator->extract($entityModel) as $name => $value) {
                if (in_array($name, $head)) {
                    $row[$name] = $value;
                }
            }
            $table[] = $row;
        }

        return array(
            'entity' => $entity,
            'paginator' => $list,
            'table' => $table,
            'head' => $head
        );
    }

    public function createAction()
    {
        $entityName = $this->params()->fromRoute('entity');
        $entity = $this->getEntityService()->getEntity($entityName);

        $form = $this->editModel($entity, $entity->getService()->factory());

        return array(
            'entity' => $entity,
            'form' => $form
        );
    }

    public function editAction()
    {
        $entityName = $this->params()->fromRoute('entity');
        $entity = $this->getEntityService()->getEntity($entityName);
        $model = $entity->getService()->loadById($this->params()->fromRoute('id'));

        $form = $this->editModel($entity, $model);

        return array(
            'entity' => $entity,
            'form' => $form
        );
    }

    /**
     * @param Entity $entity
     * @param $model
     * @return array
     */
    protected function editModel($entity, $model)
    {
        $form = $entity->getService()->getForm();
        $form->bind($model);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {
                $entity->getService()->save($model);
                $this->getEntityManager()->flush();
                $this->flashMessenger()->addSuccessMessage('Saved');
                $this->redirect()->toRoute('admin/entity', ['entity' => $entity->getName()]);
            }
        }

        return $form;
    }


    /**
     * Return value of EntityService
     *
     * @return \Admin\Service\EntityService
     */
    public function getEntityService()
    {
        if (null === $this->entityService) {
            $this->entityService = $this->getServiceLocator()->get('Admin/Service/EntityService');
        }
        return $this->entityService;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('entity_manager');
    }

}