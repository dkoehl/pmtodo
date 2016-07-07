<?php
namespace Pmtodo\Pmtodo\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 dkoehl@pm-newmedia.com <dkoehl@pm-newmedia.com>, pm-newmedia.com
 *  			
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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

/**
 * Test case for class Pmtodo\Pmtodo\Controller\TaskController.
 *
 * @author dkoehl@pm-newmedia.com <dkoehl@pm-newmedia.com>
 */
class TaskControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Pmtodo\Pmtodo\Controller\TaskController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('Pmtodo\\Pmtodo\\Controller\\TaskController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllTasksFromRepositoryAndAssignsThemToView() {

		$allTasks = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$taskRepository = $this->getMock('Pmtodo\\Pmtodo\\Domain\\Repository\\TaskRepository', array('findAll'), array(), '', FALSE);
		$taskRepository->expects($this->once())->method('findAll')->will($this->returnValue($allTasks));
		$this->inject($this->subject, 'taskRepository', $taskRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('tasks', $allTasks);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenTaskToView() {
		$task = new \Pmtodo\Pmtodo\Domain\Model\Task();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('task', $task);

		$this->subject->showAction($task);
	}

	/**
	 * @test
	 */
	public function newActionAssignsTheGivenTaskToView() {
		$task = new \Pmtodo\Pmtodo\Domain\Model\Task();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('newTask', $task);
		$this->inject($this->subject, 'view', $view);

		$this->subject->newAction($task);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenTaskToTaskRepository() {
		$task = new \Pmtodo\Pmtodo\Domain\Model\Task();

		$taskRepository = $this->getMock('Pmtodo\\Pmtodo\\Domain\\Repository\\TaskRepository', array('add'), array(), '', FALSE);
		$taskRepository->expects($this->once())->method('add')->with($task);
		$this->inject($this->subject, 'taskRepository', $taskRepository);

		$this->subject->createAction($task);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenTaskToView() {
		$task = new \Pmtodo\Pmtodo\Domain\Model\Task();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('task', $task);

		$this->subject->editAction($task);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenTaskInTaskRepository() {
		$task = new \Pmtodo\Pmtodo\Domain\Model\Task();

		$taskRepository = $this->getMock('Pmtodo\\Pmtodo\\Domain\\Repository\\TaskRepository', array('update'), array(), '', FALSE);
		$taskRepository->expects($this->once())->method('update')->with($task);
		$this->inject($this->subject, 'taskRepository', $taskRepository);

		$this->subject->updateAction($task);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenTaskFromTaskRepository() {
		$task = new \Pmtodo\Pmtodo\Domain\Model\Task();

		$taskRepository = $this->getMock('Pmtodo\\Pmtodo\\Domain\\Repository\\TaskRepository', array('remove'), array(), '', FALSE);
		$taskRepository->expects($this->once())->method('remove')->with($task);
		$this->inject($this->subject, 'taskRepository', $taskRepository);

		$this->subject->deleteAction($task);
	}
}
