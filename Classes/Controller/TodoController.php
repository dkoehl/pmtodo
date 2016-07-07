<?php
namespace Pmtodo\Pmtodo\Controller;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 dkoehl@pm-newmedia.com <dkoehl@pm-newmedia.com>, pm-newmedia.com
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * TodoController
 */
class TodoController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * todoRepository
	 *
	 * @var \Pmtodo\Pmtodo\Domain\Repository\TodoRepository
	 * @inject
	 */
	protected $todoRepository = NULL;
	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$todos = $this->todoRepository->findAll();
DebuggerUtility::var_dump($_GET,'fff');
        if($this->request->hasArgument('task')){
            $this->view->assign('taskIt', $this->request->getArgument('task'));

        }

        $this->view->assign('todos', $todos);
	}

	/**
	 * action show
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Todo $todo
	 * @return void
	 */
	public function showAction(\Pmtodo\Pmtodo\Domain\Model\Todo $todo) {
		$this->view->assign('todo', $todo);
	}

	/**
	 * action new
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Todo $newTodo
	 * @ignorevalidation $newTodo
	 * @return void
	 */
	public function newAction(\Pmtodo\Pmtodo\Domain\Model\Todo $newTodo = NULL) {
        $this->view->assign('selectedTaskID', $this->request->getArgument('task'));
        $this->view->assign('selectedProjectID', $this->request->getArgument('project'));
		$this->view->assign('newTodo', $newTodo);
	}

	/**
	 * action create
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Todo $newTodo
	 * @return void
	 */
	public function createAction(\Pmtodo\Pmtodo\Domain\Model\Todo $newTodo) {
//		$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        if($this->request->hasArgument('file')){
            $newTodo->setFiles(str_replace('uploads/tx_pmtodo/', '',$this->request->getArgument('file')));
        }
        $this->todoRepository->add($newTodo);
        $persistenceManager = $this->objectManager->get('Tx_Extbase_Persistence_Manager');
        $persistenceManager->persistAll();
        $todoUid = $newTodo->getUid();
        if($this->request->hasArgument('project')){
            $projectUid = $this->request->getArgument('project');
            $taskUid = $this->request->getArgument('task');
        }

        $this->todoRepository->setRelationToProject($todoUid, $taskUid);
        $this->redirect('list','Project',NULL, array('project'=>$projectUid,'task'=>$taskUid));
	}

	/**
	 * action edit
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Todo $todo
	 * @ignorevalidation $todo
	 * @return void
	 */
	public function editAction(\Pmtodo\Pmtodo\Domain\Model\Todo $todo) {
        $this->view->assign('selectedTaskID', $this->request->getArgument('task'));
        $this->view->assign('selectedProjectID', $this->request->getArgument('project'));
		$this->view->assign('todo', $todo);
	}

	/**
	 * action update
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Todo $todo
	 * @return void
	 */
	public function updateAction(\Pmtodo\Pmtodo\Domain\Model\Todo $todo) {
//		$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        if($this->request->hasArgument('file')){
            $todo->setFiles(str_replace('uploads/tx_pmtodo/', '',$this->request->getArgument('file')));
        }
        $this->todoRepository->update($todo);
        if($this->request->hasArgument('project')){
            $projectUid = $this->request->getArgument('project');
            $tasktUid = $this->request->getArgument('task');
        }
        $this->redirect('list','Project',NULL, array('project'=>$projectUid, 'task'=>$tasktUid));
	}

	/**
	 * action delete
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Todo $todo
	 * @return void
	 */
	public function deleteAction(\Pmtodo\Pmtodo\Domain\Model\Todo $todo) {
		$this->todoRepository->remove($todo);
		$this->redirect('list');
	}


    /**
     * @param \Pmtodo\Pmtodo\Domain\Model\Todo $todo
     */
    public function resolvedAction(\Pmtodo\Pmtodo\Domain\Model\Todo $todo){
        $newToDo = $this->todoRepository->findByUid($todo->getUid());
        $status = $newToDo->getStatus();
        if($status == '0' || $status == '' || $status == NULL){
            $newToDo->setStatus('1');
        }else{
            $newToDo->setStatus('0');
        }
        if(true === $this->todoRepository->resolveTodo($newToDo)){
            $this->view->assign('toDo', $this->todoRepository->findByUid($todo->getUid()));
        }
    }
    /**
     * Upload Files
     * ToDo: Use Framework
     */
    public function uploadFilesAction(){
        $allowed = array('png', 'jpg', 'gif','zip','doc', 'xls', 'csv', 'docx', 'xlsx', 'psd', 'rar', 'indd', 'ind', 'pdf');
        if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
            $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
            if(!in_array(strtolower($extension), $allowed)){
                echo '{"status":"error"}';
                exit;
            }
            $filePath = PATH_site . 'uploads/tx_pmtodo/';
            if(file_exists(($filePath . $_FILES['upl']['name']))){
                $timestamp = time();
                if(\TYPO3\CMS\Core\Utility\GeneralUtility::upload_copy_move($_FILES['upl']['tmp_name'], $filePath.$timestamp.'_'.$_FILES['upl']['name'])){
                    echo 'uploads/tx_pmtodo/'.$timestamp.'_'.$_FILES['upl']['name'];
                    exit;
                }
            }else{
                if(\TYPO3\CMS\Core\Utility\GeneralUtility::upload_copy_move($_FILES['upl']['tmp_name'], $filePath.$_FILES['upl']['name'])){
                    echo 'uploads/tx_pmtodo/'.$_FILES['upl']['name'];
                    exit;
                }
            }
        }
    }

}