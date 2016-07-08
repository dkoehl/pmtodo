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
 * TaskController
 */
class TaskController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * taskRepository
	 *
	 * @var \Pmtodo\Pmtodo\Domain\Repository\TaskRepository
	 * @inject
	 */
	protected $taskRepository = NULL;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
//		$tasks = $this->taskRepository->findAll();
		$tasks = $this->taskRepository->findByUsername($GLOBALS['TSFE']->fe_user->user['uid']);

        die(DebuggerUtility::var_dump($tasks,'tasss'));

		$this->view->assign('tasks', $tasks);
	}

	/**
	 * action show
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Task $task
	 * @return void
	 */
	public function showAction(\Pmtodo\Pmtodo\Domain\Model\Task $task) {
		$this->view->assign('task', $task);
	}

	/**
	 * action new
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Task $newTask
	 * @ignorevalidation $newTask
	 * @return void
	 */
	public function newAction(\Pmtodo\Pmtodo\Domain\Model\Task $newTask = NULL) {
		$this->view->assign('selectedID', $this->request->getArgument('project'));
		$this->view->assign('newTask', $newTask);
	}

	/**
	 * action create
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Task $newTask
	 * @return void
	 */
	public function createAction(\Pmtodo\Pmtodo\Domain\Model\Task $newTask) {
//		$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $newTask->setUsername($GLOBALS['TSFE']->fe_user->user['uid']);
        if($this->request->hasArgument('file')){
            $newTask->setFiles(str_replace('uploads/tx_pmtodo/', '',$this->request->getArgument('file')));
        }
        $this->taskRepository->add($newTask);
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $persistenceManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
        $taskUid = $newTask->getUid();
        if($this->request->hasArgument('project')){
            $projectUid = $this->request->getArgument('project');
        }
        $this->taskRepository->setRelationToProject($taskUid, $projectUid);
		$this->redirect('list','Project',NULL, array('project'=>$projectUid, 'task'=>$taskUid, 'userid'=>$GLOBALS['TSFE']->fe_user->user['uid']));
	}

	/**
	 * action edit
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Task $task
	 * @ignorevalidation $task
	 * @return void
	 */
	public function editAction(\Pmtodo\Pmtodo\Domain\Model\Task $task) {
        if($this->request->hasArgument('project')){
            $projectUid = $this->request->getArgument('project');
        }
		$this->view->assign('selectedID', $projectUid);
		$this->view->assign('task', $task);
	}



    /**
     * @param \Pmtodo\Pmtodo\Domain\Model\Task $task
     * @ignorevalidation $task
     */
    public function resolvedAction(\Pmtodo\Pmtodo\Domain\Model\Task $task) {
        $newTask = $this->taskRepository->findByUid($task->getUid());
        $status = $newTask->getStatus();
        if($status == '0' || $status == '' || $status == NULL){
            $newTask->setStatus('1');
            $this->taskRepository->resolveTask($newTask);
        }else{
            $newTask->setStatus('0');
            $this->taskRepository->resolveTask($newTask);
        }
        return true;
    }





	/**
	 * action update
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Task $task
	 * @return void
	 */
	public function updateAction(\Pmtodo\Pmtodo\Domain\Model\Task $task) {
//		$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        if($this->request->hasArgument('file')){
            $task->setFiles(str_replace('uploads/tx_pmtodo/', '',$this->request->getArgument('file')));
        }
        $this->taskRepository->update($task);
        if($this->request->hasArgument('project')){
            $projectUid = $this->request->getArgument('project');
        }
        $this->redirect('list','Project',NULL, array('project'=>$projectUid));
	}

	/**
	 * action delete
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Task $task
	 * @return void
	 */
	public function deleteAction(\Pmtodo\Pmtodo\Domain\Model\Task $task) {
//		$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->taskRepository->remove($task);
		$this->redirect('list');
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