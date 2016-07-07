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
 * ProjectController
 */
class ProjectController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * projectRepository
	 *
	 * @var \Pmtodo\Pmtodo\Domain\Repository\ProjectRepository
	 * @inject
	 */
	protected $projectRepository = NULL;

    /**
     * @var \Pmtodo\Pmtodo\Domain\Repository\TaskRepository
     */
    protected $taskRepository;

    /**
     * todoRepository
     *
     * @var \Pmtodo\Pmtodo\Domain\Repository\TodoRepository
     * @inject
     */
    protected $todoRepository = NULL;


    /**
     * injectTaskRepository
     *
     * @param \Pmtodo\Pmtodo\Domain\Repository\TaskRepository $taskRepository
     * @return void
     */
    public function injectTaskRepository(\Pmtodo\Pmtodo\Domain\Repository\TaskRepository $taskRepository) {
        $this->taskRepository = $taskRepository;
    }

    /**
     * injectTodoRepository
     *
     * @param \Pmtodo\Pmtodo\Domain\Repository\TodoRepository $todoRepository
     * @return void
     */
    public function injectTodoRepository(\Pmtodo\Pmtodo\Domain\Repository\TodoRepository $todoRepository) {
        $this->todoRepository = $todoRepository;
    }


    /**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
        $projects = $this->projectRepository->findByUsername($GLOBALS['TSFE']->fe_user->user['uid']);
        $this->view->assign('projects', $projects);
        $this->view->assign('userid', $GLOBALS['TSFE']->fe_user->user['uid']);
	}

	/**
	 * action show
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Project $project
	 * @return void
	 */
	public function showAction(\Pmtodo\Pmtodo\Domain\Model\Project $project) {
		$this->view->assign('project', $project);
	}

	/**
	 * action new
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Project $newProject
	 * @ignorevalidation $newProject
	 * @return void
	 */
	public function newAction(\Pmtodo\Pmtodo\Domain\Model\Project $newProject = NULL) {
		$this->view->assign('newProject', $newProject);
	}

	/**
	 * action create
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Project $newProject
	 * @return void
	 */
	public function createAction(\Pmtodo\Pmtodo\Domain\Model\Project $newProject) {
//		$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $newProject->setUsername($GLOBALS['TSFE']->fe_user->user['uid']);
        $this->projectRepository->add($newProject);
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Project $project
	 * @ignorevalidation $project
	 * @return void
	 */
	public function editAction(\Pmtodo\Pmtodo\Domain\Model\Project $project) {
		$this->view->assign('project', $project);
	}

	/**
	 * action update
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Project $project
     * @ignorevalidation $newProject
	 * @return void
	 */
	public function updateAction(\Pmtodo\Pmtodo\Domain\Model\Project $project) {
//		$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->projectRepository->update($project);
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \Pmtodo\Pmtodo\Domain\Model\Project $project
	 * @return void
	 */
	public function deleteAction(\Pmtodo\Pmtodo\Domain\Model\Project $project) {
//		$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->projectRepository->remove($project);
		$this->redirect('list');
	}

}